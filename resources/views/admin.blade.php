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
            <div class="card">
                <div class="card-body">
                    {[{ assignedVolunteers  }]} <small> registered volunteers</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {[{ assignedVolunteers  }]} <small> clocks waiting approval</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {[{ assignedVolunteers  }]} <small> active clocks</small>
                </div>
            </div>
        </div>
    </div>

    <h3>Clocks</h3>
    <div class="row" ng-repeat="clock in clocks">
        <div class="col">
            {[{ clock.id  }]}
        </div>
        <div class="col">
        {[{ clock.userFirstname  }]}
        {[{ clock.userLastName  }]}
        <small>
        {[{ clock.userEmail  }]}
        </small>
        </div>
        <div class="col">
            {[{ clock.area_id  }]}
        </div>
        <div class="col">
            {[{ clock.hours  }]} hours
        </div>
        <div class="col">
            {[{ clock.status  }]}
        </div>
        <div class="col">
            <div class="approval{[{clock.id}]}" ng-if="clock.status == 'pending approval'">
                <button ng-click="clock = approveHours(clock)" class="btn btn-sm btn-outline-success ">
                    Aprrove
                </button>
                <button ng-click="clock = approveHours(clock, 'rejected')" class="btn btn-sm btn-outline-warning approval{[{clock.id}]}">
                    Reject
                </button>
            </div>
            <div class="active{[{clock.id}]}" ng-if="clock.status == 'active'">
                <button ng-click="clock = finishClock(clock)" class="btn btn-sm btn-outline-info ">
                    Clock-Out
                </button>
            </div>
        </div>
    </div>

    <h3>Registered volunteers</h3>
    <div class="row" ng-repeat="volunteer in volunteers">
        <div class="col">
            {[{ volunteer.id  }]}
        </div>
        <div class="col">
            {[{ volunteer.firstname  }]} {[{ volunteer.lastname  }]}
        </div>
        <div class="col">
            {[{ volunteer.email  }]}
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
    $scope.clocks = <?php echo json_encode($clocks) ?>;;
    $scope.assignedVolunteers  = <?php echo sizeof($volunteers); ?>;

    $scope.volunteers = <?php echo json_encode($volunteers) ?>;

    $scope.endPoint = '<?php echo url('/api/clock'); ?>';


    $scope.finishClock = function(clock){
        $('.active'+clock.id).hide('fast');
        var data = {
            action: 'setClock',
            clockId: clock.id,
            clock_finish: 'now',
            status: 'pending approval'
        };
        $http.post($scope.endPoint, JSON.stringify(data)).then(function (response) {
                if (response.data){
                    var returnedClock = response.data;
                    clock.status = returnedClock.status;
                    $('.active'+clock.id).show('fast');
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
                    $scope.getClocks();
                }
            }, function (response) {
                console.log(response);
        });
    };
    $scope.approveHours = function(clock, incomingStatus = 'approved'){
        var clockId = clock.id;
        $('.approval'+clock.id).hide('fast');
        var data = {
            action: 'setClock',
            clock_id: clock.id,
            status: incomingStatus,
            approved_at: 'now'
        };
        $http.post($scope.endPoint, JSON.stringify(data)).then(function (response) {
                if (response.data){
                    console.log(response.data);
                    var returnedClock = response.data;
                    clock.status = returnedClock.status;
                    $('.approval'+clock.id).show('fast');
                    return response.data;
                }
            }, function (response) {
                console.log(response);
        });
    }
});
</script>

@endsection