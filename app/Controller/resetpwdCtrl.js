app.controller('resetpwdCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
	//alert("AuthCtrl");
	var userID = $routeParams.id;	
    
	checkResetpassword(userID); 
    	
    function checkResetpassword(userID){
    	Data.post('Account/forgotpasswordlinkcheck', {
			username : userID
        }).then(function (results) {
        	//alert(JSON.stringify(results));
           //Data.toast(results);
            
            $scope.userResetActivation = results;            
        });
    	
    	
    };
    
    $scope.resetPassword = function(resetpwd){
    	
		Data.post('Account/resetPassword', {
			newpassword : resetpwd.newpassword,
			confirmpassword : resetpwd.confirmpassword,
			userId :userID
        }).then(function (results) {
           Data.toast(results);
            if (results.status == "success") {
            	$location.path('login');
            	//$scope.resetpwd = {};
            }
            
        });

    };

    
    
 
});