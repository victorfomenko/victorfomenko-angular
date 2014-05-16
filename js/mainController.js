var ajaxFolder = "/ajax/";
function mainController ($scope, $timeout, $location) {
    $scope.public = {};
    $scope.menu = [
        { name: "Свадьбы", link: "weddings" },
        { name: "Портреты", link: "portraits"},
        { name: "Репортажи", link: "reports" }
    ]
    $scope.path = function(){
        return $location.url().replace(/^\/?([^\/].+[^\/])\/?$/, "$1");
    }
    $scope.isActive = function(link){
        return link == $scope.path();
    }
    $scope.initPlugin = function() {
        $timeout(function(){
            $(document).ready( function () {
                $('.j_fotorama').fotorama({
                    width: "100%",
                    height: "100%",
                    fit: 'cover',
                    startindex : 1,
                    path: true,
                    nav: 'thumbs',
                    keyboard: true,
                    thumbwidth: 84,
                    thumbheight: 56
                });
            })
        })
    }
}

angular.module('ngView', ['ngRoute'], function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/templates/home.html',
            controller: HomeController,
            resolve: {imageStack: getData}
        })
        .when('/weddings/', {
            templateUrl: '/templates/weddings.html',
            controller: WeddingsController,
            resolve: {imageStack: getData}
        })
        .when('/portraits/', {
            templateUrl: '/templates/portraits.html',
            controller: PortraitsController,
            resolve: {imageStack: getData}
        })
        .when('/reports/', {
            templateUrl: '/templates/reports.html',
            controller: ReportsController,
            resolve: {imageStack: getData}
        });
    // configure html5 to get links working on jsfiddle
    $locationProvider.html5Mode(true);
});

function HomeController($scope, imageStack) {
    $scope.public.imageStack = imageStack;
    $scope.initPlugin();
}
function WeddingsController($scope, imageStack) {
    $scope.public.imageStack = imageStack;
    $scope.initPlugin();
}
function PortraitsController($scope, imageStack) {
    $scope.public.imageStack = imageStack;
    $scope.initPlugin();
}
function ReportsController($scope, imageStack) {
    $scope.public.imageStack = imageStack;
    $scope.initPlugin();
}
function getData ($q, $http, $location) {
    var defer = $q.defer();
    var url = ajaxFolder + "getPhotos.php" + "?url=" + $location.url().replace(/^\/?([^\/].+[^\/])\/?$/, "$1");

    $http({method: 'GET', url: url, cache: true}).
        success(function(data) {
            defer.resolve(data);
        });
    return defer.promise;
}