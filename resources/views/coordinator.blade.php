@extends('layouts.app')

@section('content')

<div class="sectionHeader">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{ Auth::user()->firstname }}'s Dashboard</h1>
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
                                       

<div ng-app="mycPWA" ng-controller="pwaController"> 
    <div class="row">
        <div class="col">
            {[{ assignedVolunteers  }]} <small>assigned volunteers</small>
        </div>        
    </div>
    <div class="row">       
        <div class="col-6">
            <select class="form-control form-control-lg is-valid" name="volunteers" id="volunteers" 
                ng-model="volunteers.selected"
                ng-options="option.firstname for option in volunteers track by option.id">
            </select>
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
    $scope.assignedVolunteers  = <?php echo sizeof($volunteers); ?>;

    $scope.volunteers = <?php echo $volunteers; ?>;    

    $scope.endPoint = '<?php echo url('/api/clock'); ?>';


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