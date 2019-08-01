@extends('layouts.appPrev')

@section('content')
<div ng-app="mycPWA" ng-controller="pwaController" class="container-fluid pb-3"> 

    <div class="volunteer mt-5" style="max-width: 400px;">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Volunter at the Mexican pavilion</h1>
            </div>
        </div>
        <form class="volunterForm" ng-submit="setVolunteer(register)" autocomplete="off">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control form-control-lg mt-3" id="firstname" ng-model="register.firstname" placeholder="Firstname" autocomplete="off" required />
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-lg mt-3" id="lastname" ng-model="register.lastname" placeholder="Lastname" autocomplete="off" required />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="email" class="form-control form-control-lg mt-3" id="email" ng-model="register.email" placeholder="Email" autocomplete="off" required />

                    <input type="text" class="form-control form-control-lg mt-3" id="phone" ng-model="register.phone" placeholder="Mobile" autocomplete="off" />

                    <input type="number" class="form-control form-control-lg mt-3" id="age" ng-model="register.age" placeholder="Age" autocomplete="off" />
        
                    <select class="form-control form-control-lg mt-3" name="userArea" id="userArea" 
                                    ng-model="register.areaObj"
                                    ng-options="option.name for option in areas track by option.id"
                                    >
                    </select>

                    <input type="password" class="form-control form-control-lg mt-3" id="password" ng-model="register.password" autocomplete="off" placeholder="Password" required />

                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Register as a Volunteer</button>
                </div>
            </div>
        </form>

        <div class="row volunteerLoading mt-4 mb-4" style="display:none;">
            <div class="col">
                <p class="text-center">
                    <img src="/mexicanpavilionvolunteers/img/lg.vortex-spiral-spinner.gif" width="80" />
                </p>
            </div>
        </div>

        <div class="row volunteerThanks" style="display:none;">
            <div class="col">
                <h4 class="text-center">Thank you {[{ user.firstname }]}!</h4>
                <p>
                    In the following days we will contact you to provide important 
                    information regarding your vonlunteering, along with the names 
                    and Pavilion Coordinators contact information. 
                </p>
                <p>
                    If you have any additional questions, contact us at
                </p>
                <p class="text-center">
                    <strong>volunteers@mexycanmb.ca</strong>
                </p>
                <button class="btn btn-primary btn-lg btn-block mt-3" ng-click="resetRegister()">Finish</button>
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
    $scope.endPoint = 'https://www.mexycanmb.ca/mexicanpavilionvolunteers/api/clock';

    $scope.register = {};
    $scope.register.firstname = '';
    $scope.register.lastname = '';
    $scope.register.email = '';
    $scope.register.mobile = '';
    $scope.register.age = '';
    //$scope.register.area = '';

    $scope.areas = [
        <?php
        foreach($areas as $a){
            echo '{ "id":'.$a->id . ', "name":"' .$a->name . '"},';
        }
        ?>
    ];

    $scope.userArea = {};
    $scope.userArea.selected = {};
    $scope.currentUserArea = 10;

    $scope.setUserArea = function(){
        if($scope.currentUserArea == 0){
            $scope.currentUserArea = 10;
        }
        angular.forEach($scope.areas, function(value, key){
            if(value.id == $scope.currentUserArea){
                $scope.register.areaObj = value;
            }
        });
    }
    $scope.setUserArea();

    $scope.resetRegister =  function(){
        $scope.register = {};
        $scope.register.firstname = '';
        $scope.register.lastname = '';
        $scope.register.email = '';
        $scope.register.mobile = '';
        $scope.register.age = '';
        //$scope.register.area = '';
        $scope.currentUserArea = 10;
        $scope.setUserArea();
        $scope.user = {};
        
        $('.volunteerLoading').hide('fast');
        $('.volunteerThanks').hide('fast');
        $('.volunterForm').show('fast');
    }

    
    $scope.user = {};

    $scope.setVolunteer = function(register){
        console.log(register);
        $('.volunterForm').hide('fast');
        
        $('.volunteerLoading').show('fast');

        register.area_id = register.areaObj.id;
        register.action = 'setUser';
        console.log(register);

        
        $http.post($scope.endPoint, JSON.stringify(register)).then(function (response) {
                if (response.data){
                    console.log(response.data);
                    $scope.user = response.data;
                    $('.volunteerLoading').hide('fast');
                    $('.volunteerThanks').show('fast');
                    $scope.resetRegister
                }
            }, function (response) {
                console.log(response);
                $('.volunteerLoading').hide('fast');
                    $('.volunteerThanks').show('fast');
        });
        
        
    };

});
</script>

@endsection