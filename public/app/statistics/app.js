var app = angular.module("Statistics", ['ui.router', 'flow','ui.bootstrap'], function ($interpolateProvider) {

    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

});

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");

    $stateProvider
        .state('home', {
            url: "/",
            templateUrl: "/app/statistics/_home.html",
            controller: "HomeController",
            resolve: {

            }
        })


});

app.controller("HomeController", function ($scope,$window, $http,$stateParams ) {
    console.log("HomeController.start");

    $scope.today = function() {
        $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function () {
        $scope.dt = null;
    };

    $scope.open_start = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened_start = true;
    };

    $scope.open_end = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened_end = true;
    };


    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];

    $scope.statistics = {};

    $scope.search_statistics = function(){

        search = "ต้องการบันทึกทะเบียร์ประวัตินี้ ใช่หรือ ไม่";
        console.log($scope.statistics);
        if (confirm(search)) {

            console.log($scope.person);

            $http({
                url : "/api/statistics/search",
                method : "post",
                data : $scope.statistics

            }).success(function(response){
                $scope.dataall = response;

                $scope.person_crime =  $scope.dataall[0];
                $scope.person_general =  $scope.dataall[1];
                $scope.datacase = $scope.dataall[2];
                console.log($scope.person_crime);
                console.log($scope.person_general);
                console.log($scope.datacase);

            })
        }
    }

    $scope.print_statistics = function(){

        $window.open('/api/statistics/pdf',{method : "post",data : $scope.statistics});
    }





});
