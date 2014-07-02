function orderController ($scope, $http, $timeout) {
    $scope.order = function() {
        var orderName = $scope.orderName;
        var orderPhone = $scope.orderPhone;
        var orderTarif = $scope.orderTarif;

        var sendingData = {
            'name': orderName,
            'phone': orderPhone,
            'tarif': orderTarif
        };
        var hideModal = function () {
            $scope.orderModalIsShow = false;
            $timeout.cancel();
        }
        $scope.orderFormIsShow = false;
        $scope.orderLoading = true;
        $http.post('/ajax/order.php', sendingData)
            .success(function(data){
                if(data == "ok") {
                    $scope.orderLoading = false;
                    $scope.orderSuccess = true;
                    $timeout(hideModal, 2000);
                }

            })
            .error(function(){
                console.log("Something went wrong. AJAX ERROR.");
            });

    };
}