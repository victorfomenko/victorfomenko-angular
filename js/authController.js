function authController ($scope, $http) {
    $scope.auth = function() {
        var userName = $scope.userName;
        var userPass = $scope.userPass;
        console.log(userName + "," + userPass);
        $http.post('/ajax/auth.php', {
            'auth_name': userName,
            'auth_pass': userPass
        })
        .then(function(result) {
            console.log(result.data);
        });
    }
}