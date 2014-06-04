function authController ($scope, $http) {
    $scope.auth = function() {
        var userName = $scope.userName;
        var userPass = $scope.userPass;
        getAuthData('ajax/auth.php', {
            'auth_name': userName,
            'auth_pass': userPass
        })

    }

    var getAuthData = function(url, data){
        $http.post(url, data)
        .success(function(data,status){
            console.log(data + status);
        }).error(function(data, status){
            console.log(status);
        });
    }
}