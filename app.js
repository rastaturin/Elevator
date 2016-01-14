angular.module('app', [])

.controller('mainController', function ($scope, $rootScope, $http, $sce) {

    $scope.steps = [];

    $http.get('requests.txt').then(function (responce) {
        $scope.requests = angular.toJson(responce.data);
    });

    $scope.error = '';
    $scope.send = function (data) {
        $scope.error = '';
        $scope.steps = [];
        $http.post('index.php', data).then(function (response) {
            if (response.data.result == 'ok') {
                $scope.steps = response.data.data;
            } else {
                $scope.error = response.data.error;
            }
        }, function (data) {
            console.log(data);
        });
    }

});
