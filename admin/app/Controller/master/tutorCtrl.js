app.controller('tutorCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getTutor();
      };
      
      
      $scope.addTutor = function(tutor){
        	Data.post('Master/addTutor', tutor).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
        		if(results.status == "success")
        		{
            	$scope.tutor.push(results.newTutor);
            	$scope.addNewClicked = false; 
            	$scope.newTutor = {name:'', isActive:true};
        		}
                });

    	  
      }
  	$scope.getTutor = function(){

      	Data.get('Master/getTutor', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.tutor = results;
              	$scope.tutor.selected = {name:'', isActive:''};;
                  });
      };

		    $scope.getTutorTemplate = function (contact) {
		    	
		        if (contact.id === $scope.tutor.selected.id) return 'editTutor';
		        else return 'displayTutor';
		    };

		    $scope.editTutor = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.tutor.selected = angular.copy(contact);
		    };

		    $scope.saveEditTutor = function (idx, editTutor) {
	        	Data.post('Master/updateTutor', editTutor).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	   
	        			$scope.tutor[idx] = angular.copy($scope.tutor.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.tutor.selected = {};
		    };

		      $scope.init();

});

