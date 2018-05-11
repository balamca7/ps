app.controller('stateCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getState();
      };
      
      
      $scope.addState = function(state){
    	  
        	Data.post('Master/addState', state).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
            	$scope.state.push(results.newState);
            	$scope.addNewClicked = false; 
            	$scope.newState = {name:'', country_id:'', isActive:true};
                });

    	  
      }
  	$scope.getState = function(){

      	Data.get('Master/getState', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.state = results.states;
              	$scope.Country = results.Country;
              	$scope.state.selected = {name:'', country_id: '', isActive:''};;
                  });
      };

		    $scope.getStateTemplate = function (contact) {
		    	
		        if (contact.id === $scope.state.selected.id) return 'editState';
		        else return 'displayState';
		    };

		    $scope.editState = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.state.selected = angular.copy(contact);
		    };

		    $scope.saveEditState = function (idx, editState) {
		    	//alert(JSON.stringify(editState));
	        	Data.post('Master/updateState', editState).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			$scope.state[idx] = angular.copy($scope.state.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.state.selected = {};
		    };

		      $scope.init();

});

