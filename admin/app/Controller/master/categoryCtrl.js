app.controller('categoryCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	$scope.dtOptions;
	  /*$scope.dtOptions = DTOptionsBuilder.newOptions()
	   // .withOption('order', [])
        .withOption('responsive', true);*/
 $scope.dtColumns = [
            DTColumnDefBuilder.newColumnDef(0).notSortable(),
           DTColumnDefBuilder.newColumnDef(1).notSortable(),
           DTColumnDefBuilder.newColumnDef(2).notSortable(),
            DTColumnDefBuilder.newColumnDef(3).notSortable()
        ];
      $scope.init = function()
      {
        $scope.getCategory();
      };
      
      
      $scope.addCategory = function(category){
        	Data.post('subjectMaster/addCategory', category).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
            	$scope.category.push(results.newCategory);
            	$scope.addNewClicked = false; 
            	$scope.newCategory = {name:'', isActive:true};
                });

    	  
      }
  	$scope.getCategory = function(){

      	Data.get('subjectMaster/getCategory', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.category = results;
              	$scope.category.selected = {name:'', isActive:''};;
                  });
      };

		    $scope.getCategoryTemplate = function (contact) {
		    	
		        if (contact.id === $scope.category.selected.id) return 'editCategory';
		        else return 'displayCategory';
		    };

		    $scope.editCategory = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.category.selected = angular.copy(contact);
		    };

		    $scope.saveEditCategory = function (idx, editCategory) {
	        	Data.post('subjectMaster/updateCategory', editCategory).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	   
	        			$scope.category[idx] = angular.copy($scope.category.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.category.selected = {};
		    };

		      $scope.init();

});

