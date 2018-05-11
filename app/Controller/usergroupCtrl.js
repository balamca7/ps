app.controller('usergroupCtrl', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval) {
    //initially set those objects to null to avoid undefined error
    //alert("usergroupCtrl");
    var groupID = $routeParams.id;
    var usergroup = $routeParams.usergroup;
    $scope.init = function() {
    	$scope.getGroupcontacts();
	};
    $scope.CreateNewGroup = function(group_name){
		//alert(group_name);
    	if(group_name != "" && group_name != undefined )
    	{
    		 Data.post('Usergroup/creatGroup', {
    			 groupName: group_name 

    	         }).then(function (results) {
					 //alert(JSON.stringify(results));
    	         	Data.toast(results);
    	         	if(results.status == "success")
    	         	{
    	         		$scope.group_name = "";
    	         		$scope.groupcontacts.push(results.newGroup); 
    	         	}
    	         });	
    	}
    };
    
    $scope.getGroupcontacts = function(){
    		 Data.get('Usergroup/getUserGroup', {
    	         }).then(function (results) {
					 //alert(JSON.stringify(results));
    	         	//Data.toast(results);
    	         	$scope.groupcontacts = results; 
    	         	
    	         });	
    };
    $scope.init();
});