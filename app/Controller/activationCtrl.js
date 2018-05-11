app.controller('activationCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
	//alert("AuthCtrl");
	var userID = $routeParams.id;	
    $scope.init = function()
    {
	$scope.UserActivation(userID); 
    }	
    $scope.UserActivation = function(userID){
    	Data.post('Account/UserActivation', {
			userID : userID
        }).then(function (results) {
            $scope.userActivation = results;  
        });
    };
    
    $scope.init();
 
});