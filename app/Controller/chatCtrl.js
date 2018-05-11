app.controller('chatCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,  $interval, $localStorage) {
    //initially set those objects to null to avoid undefined error
    //alert("chatCtrl");
	$scope.init = function() {
	
		//$scope.getContacts();
		//$scope.getGroupcontacts();
		$scope.displayChat=false;
	};
	 $scope.getContacts = function(){
	 Data.get('Chatcontroller/getContacts', {
	        }).then(function (results) {
	        	//alert(JSON.stringify(results));
	        	$scope.contacts = results;
	        	//$scope.groupcontacts = results.groupContactsInfo;
	        });
	};
	
	 $scope.getGroupcontacts = function(){
		 Data.get('Usergroup/getUserGroup', {
	         }).then(function (results) {
				 //alert(JSON.stringify(results));
	         	//Data.toast(results);
	         	$scope.groupcontacts = results; 
	         	
	         });	
	 };

		$scope.changeChatModel = function()
		{
			$scope.displayChat=false;
			$interval.cancel($scope.chatInterval);
		}
		

    $scope.init();
});