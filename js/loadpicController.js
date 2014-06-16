function LoadpicController ($scope, $timeout, $location) {
    $scope.public.aboutIsVisible = false;
    if(!$scope.public.isAdmin){
        alert("You do not have admin privileges");
        window.history.back();
    }

}