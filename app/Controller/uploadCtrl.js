app.controller('UploadController', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval, $localStorage) {
	
	var ID = $routeParams.id;
	var usergroup = $routeParams.usergroup;
	$scope.id = ID;
	$scope.usergroup = usergroup;
	
	
	 $scope.uploadFile = function(usergroupID, userGroup){  
			
         var form_data = new FormData();  
         angular.forEach($scope.files, function(file){  
              form_data.append('imagePath', file);
         });  
         form_data.append('usergroupID', usergroupID);

         $http.post('api/v1/index.php/Uploadcontroller/uploadImage', form_data,
          {  
                  transformRequest: angular.identity,  
                  headers: {'Content-Type': undefined,'Process-Data': false}  
             }).success(function(response){  
                  Data.toast(response);
   	         	if(response.status == "success")
	         	{
	         		$('.modal').modal('hide');
	         		$("input[type='file']").val("");

	         			$rootScope.image = response.image;
	         			$localStorage.currentUser.image = response.image;
	         			$scope.Emp.imagepath  = response.image;

	         	}

             });

    };  
	
	


});