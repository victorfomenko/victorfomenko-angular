function authController ($scope, $http) {
    $scope.auth = function() {
        var userName = $scope.userName;
        var userPass = $scope.userPass;
        var sendingData = {
            'auth_name': userName,
            'auth_pass': userPass
        };
        $http.post('/ajax/auth.php', sendingData)
            .success(function(data){
                $scope.public.isLogin = getCookie("PHPSESSID");
                $scope.public.userName = getCookie("userName");
                $scope.public.isAdmin = getCookie("isAdmin");
                $scope.menu[4].isHide = $scope.public.isAdmin;
                if(!data.login) {
                    $scope.public.isFormError = true;
                    return;
                }
                $scope.public.isFormError = false;
                $scope.hideLoginForm();
            })
            .error(function(){
                console.log("Something went wrong. AJAX ERROR.");
            });
    };
    $scope.public.logout = function(){
        $http.get('/ajax/auth.php?action=logout')
            .success(function(){
                $scope.public.isLogin = $scope.public.userName = $scope.public.isAdmin = false;
                $scope.menu[4].isHide = $scope.public.isAdmin;
            })
    };
}