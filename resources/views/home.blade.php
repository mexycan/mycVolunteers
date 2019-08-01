@extends('layouts.app')

@section('content')

<div class="sectionHeader">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Volunteer Dashboard</h1>
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <div class="panel panel-default">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <h4 class="text-center">{{ Auth::user()->firstname }}, welcome back!</h4>
                    <p class="text-center">
                        The first 100 registered Volunteers get a Free T-Shirt!<br />
                        You are number <strong><?php echo $user->id; ?></strong>
                    </p>


<div ng-app="mycPWA" ng-controller="pwaController"> 
    <div class="row mt-3 pb-3">
        <div class="col text-center">
            <div class="row">
                <div class="col-md-4"></div>
                    <div class="col-md-4">
                    
                        <div ng-if="!activeClock.id"  >
                            <select class="form-control form-control-lg is-valid" name="userArea" id="userArea" 
                            ng-model="userArea.selected"
                            ng-options="option.name for option in areas track by option.id"
                            >
                            </select>
                            <button ng-click="setClock()" class="btn btn-lg btn-success clockin mt-2 btn-block"  >
                                Clock-In
                            </button>
                        </div><!-- clock in -->
                        <div ng-if="activeClock.id" >
                            <button class="btn btn-lg btn-warning clockout btn-block" ng-click="finishClock(activeClock.id)">
                                Clock-Out
                            </button>
                            <p class="small text-secondary mt-2">
                                You clocked-in for <b>{[{ userArea.selected.name }]}</b> on {[{ activeClock.clock_start }]}
                            </p>
                        </div><!-- clock out -->
                    <div class="col-md-4"></div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="card mt-3" ng-if="showPreviousHours">
        <div class="card-header">
            <h5 class="card-title">My Volunteered Time</h5>
        </div>
        <div class="card-body">
            <p class="card-text">Current and previously volunteered hours</p>

            <div class="table-responsive">
        <table class="table table-sm table-striped" ng-if="clocks.length > 0">
            <thead>
                <tr>
                    <th>
                        Status
                    </th>
                    <th>
                        Hours
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="clock in clocks | orderBy:'-id'">
                    <td>
                        <span class="badge badge-warning" ng-if="clock.status=='active'">
                            {[{ clock.status }]}
                        </span>
                        <span class="badge badge-success" ng-if="clock.status=='approved'">
                            {[{ clock.status }]}
                        </span>
                        <span class="badge badge-info" ng-if="clock.status=='pending approval'">
                            {[{ clock.status }]}
                        </span>
                    </td>
                    <td>
                        {[{ clock.hours }]}
                    </td>
                    <td>
                        <ng-if ng-if="clock.status == 'active'">
                            <button class="btn btn-sm btn-outline-warning " ng-click="finishClock(clock.id)">Clock Out</button>
                        </ng-if>
                    </td>
                </tr>
            </tbody>
        </table>
                    </div>
                    <div class="text-center">
                        <button ng-click="getClocks()" class="btn btn-sm btn-outline-secondary">Refresh Clocks</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" ng-if="!showPreviousHours">
            <div class="col">
                <div class="text-center">
                    <button ng-click="setShowPreviousHours()" class="btn btn-sm btn-outline-secondary">Show my Volunteered Time</button>
                </div>
            </div>
        </div>

        
                    <p class="text-center">
                        <img src="https://www.mexycanmb.ca/wp-content/uploads/2019/03/cropped-logo_transparentbackground.png" alt="Mex y Can" />
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js" integrity="sha256-23hi0Ag650tclABdGCdMNSjxvikytyQ44vYGo9HyOrU=" crossorigin="anonymous"></script>

<script>
var app = angular.module('mycPWA', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('{[{');
            $interpolateProvider.endSymbol('}]}');
  });
app.controller('pwaController', function($scope, $http) {

    $scope.hello = "jelow world";
    $scope.clocks = {};
    $scope.activeClock = {};

    $scope.showPreviousHours = true;

    $scope.setShowPreviousHours = function(){
        console.log($scope.showPreviousHours);
        if($scope.showPreviousHours){
            $scope.showPreviousHours = false;
        } else {
            $scope.showPreviousHours = true;
        }
    }

    $scope.areas = [
        <?php
        foreach($areas as $a){
            echo '{ "id":'.$a->id . ', "name":"' .$a->name . '"},';
        }
        ?>
    ];

    $scope.userArea = {};
    $scope.userArea.selected = {};
    $scope.currentUserArea = <?php echo $user->area_id; ?>;


    $scope.endPoint = '<?php echo url('/api/clock'); ?>';

    $scope.setUserArea = function(){
        console.log('current User Area');
        console.log($scope.currentUserArea);
        if($scope.currentUserArea == 0){
            $scope.currentUserArea = 1;
        }
        angular.forEach($scope.areas, function(value, key){
            if(value.id == $scope.currentUserArea){
                $scope.userArea.selected = value;
                console.log('current User Area Object');
                console.log(value);
            }
        });
    }
    $scope.setUserArea();

    $scope.getClocks = function(){
        $('.clockin, .clockout').hide();
        $scope.activeClock = {};
        var data = {
            action: 'getClock',
            userId: <?php echo $user->id; ?> 
        };
        $http.post($scope.endPoint, JSON.stringify(data)).then(function (response) {
                if (response.data){
                    //console.log(response.data);
                    $scope.clocks = response.data;

                    angular.forEach($scope.clocks, function(value, key){
                        if(value.status == "active"){
                            //console.log(value);
                            $scope.activeClock = value;
                            $('.clockin, .clockout').show();
                        }
                    });
                }
            }, function (response) {
                console.log(response);
            });
    };
    $scope.getClocks();

    $scope.finishClock = function(id){
        $('.clockin, .clockout').hide();
        var data = {
            action: 'setClock',
            clockId: id,
            clock_finish: 'now',
            status: 'pending approval'
        };
        $http.post($scope.endPoint, JSON.stringify(data)).then(function (response) {
                if (response.data){
                    console.log(response.data);
                    $scope.getClocks();
                    $('.clockin, .clockout').show();
                }
            }, function (response) {
                console.log(response);
            });
    };

    $scope.setClock = function(){
        $('.clockin, .clockout').hide();
        console.log(' User Area at clock');
        console.log($scope.userArea);
        var data = {
            action: 'setClock',
            user_id: <?php echo $user->id; ?>,
            clock_start: 'now',
            area_id: $scope.userArea.selected.id
        };
        console.log(data);

        $http.post($scope.endPoint, JSON.stringify(data)).then(function (response) {
                if (response.data){
                    console.log(response.data);
                    //$scope.currentUserArea = $scope.user_area.id;
                    $scope.getClocks();
                   // $('.clockin, .clockout').show();
                }
            }, function (response) {
                console.log(response);
        });
        
    };
});
</script>

@endsection