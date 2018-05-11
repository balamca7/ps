app.controller('subcategoryCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);
$scope.dtColumns = [
            DTColumnDefBuilder.newColumnDef(0).notSortable(),
           DTColumnDefBuilder.newColumnDef(1).notSortable(),
           DTColumnDefBuilder.newColumnDef(2).notSortable(),
            DTColumnDefBuilder.newColumnDef(3).notSortable(),
            DTColumnDefBuilder.newColumnDef(4).notSortable()
        ];
      $scope.init = function()
      {
        $scope.getSubCategory();
      };
      
      
      $scope.addSubCategory = function(subcategory){
    	  
        	Data.post('subjectMaster/addSubCategory', subcategory).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
            	$scope.subcategory.push(results.newSubCategory);
            	$scope.addNewClicked = false; 
            	$scope.newSubCategory = {name:'', category_id:'', isActive:true};
                });

    	  
      }
  	$scope.getSubCategory = function(){

      	Data.get('subjectMaster/getSubCategory', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.subcategory = results.subCategories;
              	$scope.Category = results.Category;
              	$scope.subcategory.selected = {name:'', category_id: '', isActive:''};;
                  });
      };

		    $scope.getSubCategoryTemplate = function (contact) {
		    	
		        if (contact.id === $scope.subcategory.selected.id) return 'editSubCategory';
		        else return 'displaySubCategory';
		    };

		    $scope.editSubCategory = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.subcategory.selected = angular.copy(contact);
		    };

		    $scope.saveEditSubCategory = function (idx, editSubCategory) {
		    	//alert(JSON.stringify(editSubCategory));
	        	Data.post('subjectMaster/updateSubCategory', editSubCategory).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			$scope.subcategory[idx] = angular.copy($scope.subcategory.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.subcategory.selected = {};
		    };

		      $scope.init();

});

