app.controller('countyCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getCounty();
      };
      
      
      $scope.addCounty = function(county){
    	  //alert(JSON.stringify(county));return;
        	Data.post('Master/addCounty', county).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
            	$scope.county.push(results.newCounty);
            	$scope.addNewClicked = false; 
            	$scope.newCounty = {name:'', country_id:'', isActive:true};
                });

    	  
      }
  	$scope.getCounty = function(){

      	Data.get('Master/getCounty', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.county = results.county;
              	$scope.Country = results.Country;
              	$scope.county.selected = {name:'', country_id: '', isActive:''};;
                  });
      };

		    $scope.getCountyTemplate = function (contact) {
		    	
		        if (contact.id === $scope.county.selected.id) return 'editCounty';
		        else return 'displayCounty';
		    };

		    $scope.editCounty = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.county.selected = angular.copy(contact);
		    };

		    $scope.saveEditCounty = function (idx, editCounty) {
		    	//alert(JSON.stringify(editCounty));return;
	        	Data.post('Master/updateCounty', editCounty).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			//$scope.county[idx] = angular.copy($scope.county.selected);
	        			$scope.county[idx] = results.county;
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.county.selected = {};
		    };

		      $scope.init();

});

