app.controller('districtCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getDistrict();
      };
      
      
      $scope.addDistrict = function(district){
    	  //alert(JSON.stringify(district));return;
        	Data.post('Master/addDistrict', district).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
        		if(results.status == "success")
        		{
            	$scope.district.push(results.newDistrict);
            	$scope.addNewClicked = false; 
            	$scope.newDistrict = {name:'', country_id:'', state_id:'', isActive:true};
        		}
                });

    	  
      }
  	$scope.getDistrict = function(){

      	Data.get('Master/getDistrict', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.district = results.district;
              	$scope.Country = results.Country;
              	$scope.district.selected = {name:'', country_id: '', state_id:'', isActive:''};;
                  });
      };

		    $scope.getDistrictTemplate = function (contact) {
		    	
		        if (contact.id === $scope.district.selected.id) return 'editDistrict';
		        else return 'displayDistrict';
		    };

		    $scope.editDistrict = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.district.selected = angular.copy(contact);
		    };

		    $scope.saveEditDistrict = function (idx, editDistrict) {
		    	//alert(JSON.stringify(editDistrict));return;
	        	Data.post('Master/updateDistrict', editDistrict).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			//$scope.district[idx] = angular.copy($scope.district.selected);
	        			$scope.district[idx] = results.district;
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.district.selected = {};
		    };

		      $scope.init();

});

