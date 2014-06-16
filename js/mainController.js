var ajaxFolder = "/ajax/";
function mainController ($scope, $timeout, $location) {
    $scope.public = {};
    $scope.public.loginFormIsShow = false;
    $scope.menu = [
        { name: "Свадьбы", link: "weddings" },
        { name: "Портреты", link: "portraits" },
        { name: "Репортажи", link: "reports" },
        { name: "Загрузить", link: "loadpic", isHide: function(){ return !$scope.public.isAdmin } }
    ]
    $scope.templates = [
        { name: 'about.html', url: '/templates/about.html'},
        { name: 'login.html', url: '/templates/login.html'} ];
    $scope.about = $scope.templates[0];
    $scope.login = $scope.templates[1];

    $scope.public.path = function(){
        return $location.url().replace(/^\/?([^\/].+[^\/])\/?$/, "$1");
    }
    $scope.isActive = function(link){
        return link == $scope.public.path();
    }
    $scope.initPlugin = function(imageStack) {
        $scope.public.imageStack = imageStack;
        $timeout(function(){
            $(document).ready( function () {
                $('.j_fotorama').fotorama({
                    width: "100%",
                    height: "100%",
                    fit: 'cover',
                    startindex : 1,
                    nav: 'thumbs',
                    keyboard: true,
                    thumbwidth: 84,
                    thumbheight: 56
                });
            })
        });
    }
    $scope.showLoginForm = function () {
        $scope.public.loginFormIsShow = true;
    }
    $scope.hideLoginForm = function () {
        $scope.public.loginFormIsShow = false;
    }
    $scope.public.isLogin = getCookie("PHPSESSID");
    $scope.public.userName = getCookie("userName");
    $scope.public.isAdmin = getCookie("isAdmin");
}

var ngView = angular.module('ngView', ['ngRoute'], function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            title: "Home",
            templateUrl: '/templates/home.html',
            controller: HomeController,
            resolve: {imageStack: getData}
        })
        .when('/weddings/', {
            title: "Weddings",
            templateUrl: '/templates/weddings.html',
            controller: WeddingsController,
            resolve: {imageStack: getData}
        })
        .when('/portraits/', {
            title: "Portraits",
            templateUrl: '/templates/portraits.html',
            controller: PortraitsController,
            resolve: {imageStack: getData}
        })
        .when('/reports/', {
            title: "Reports",
            templateUrl: '/templates/reports.html',
            controller: ReportsController,
            resolve: {imageStack: getData}
        })
        .when('/price/', {
            title: "Price",
            templateUrl: '/templates/price.html',
            controller: PriceController
        });
    // configure html5 to get links working on jsfiddle
    $locationProvider.html5Mode(true);
});

ngView.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
}]);

function HomeController($scope, imageStack) {
    $scope.initPlugin(imageStack);
    $scope.public.aboutIsVisible = true;
}
function WeddingsController($scope, imageStack) {
    $scope.initPlugin(imageStack);
}
function PortraitsController($scope, imageStack) {
    $scope.initPlugin(imageStack);
}
function ReportsController($scope, imageStack) {
    $scope.initPlugin(imageStack);
}
function PriceController() {
    console.log("price");
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
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