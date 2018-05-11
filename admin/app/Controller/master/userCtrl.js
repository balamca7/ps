app.controller('userCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getUser();
      };
      
      
      $scope.addUser = function(user){
        	Data.post('userMaster/addUser', user).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
            	$scope.user.push(results.newUser);
            	$scope.addNewClicked = false; 
            	$scope.newUser = {name:'', isActive:true};
                });

    	  
      }
  	$scope.getUser = function(){

      	Data.get('userMaster/getUserdetails', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.user = results;
              	$scope.user.selected = {name:'', isActive:''};;
                  });
      };

		    $scope.getUserTemplate = function (contact) {
		    	
		        if (contact.id === $scope.user.selected.id) return 'editUser';
		        else return 'displayUser';
		    };

		    $scope.editUser = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.user.selected = angular.copy(contact);
		    };

		    $scope.saveEditUser = function (idx, editUser) {
	        	Data.post('userMaster/updateUserdetails', editUser).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			$scope.user[idx] = angular.copy($scope.user.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.user.selected = {};
		    };

		      $scope.init();

});

