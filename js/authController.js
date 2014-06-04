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
                $scope.isLogin = getCookie("PHPSESSID");
                $scope.userName = getCookie("userName");
                $scope.isAdmin = getCookie("isAdmin");

                if(!data.login) {
                    $scope.isFormError = true;
                    return;
                }
                $scope.hideLoginForm();
            })
            .error(function(){
                console.log("Something went wrong. AJAX ERROR.");
            });

    };
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    }
}