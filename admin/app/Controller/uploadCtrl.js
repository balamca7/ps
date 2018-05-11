app.controller('UploadController', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval, $localStorage) {
	
	var ID = $routeParams.id;
	var usergroup = $routeParams.usergroup;
	$scope.id = ID;
	$scope.usergroup = usergroup;
	
	
	 $scope.uploadFile = function(usergroupID, userGroup){  
			
         var form_data = new FormData();  
         angular.forEach($scope.files, function(file){  
              form_data.append('imagePath', file);
              //console.log("file"+file);
         });  



         form_data.append('usergroupID', usergroupID);
         form_data.append('userGroup', userGroup);
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
	         		//$scope.progress = 0;
	         		//alert($scope.Emp.profileInfo.image);
	         		if(userGroup == "user")
	         		{
	         			$rootScope.image = response.image;
	         			$localStorage.currentUser.image = response.image;
	         			$scope.Emp.profileInfo.image  = response.image;
	         		}
	         		else if(userGroup == "group")
	         		{
	         			$scope.groups.groupInfo.image = response.image;
	         		}
	         	}

             });

         
       
    };  

       $scope.uploadLogo = function(companyy){  
        //alert("haey");
      alert(JSON.stringify(companyy));
         var form_data = new FormData();  
         angular.forEach($scope.files, function(file){  
              form_data.append('imagePath', file);
              //console.log("file"+file);
         });  
         form_data.append('name', companyy);
         //form_data.append('userGroup', userGroup);
 

         $http.post('api/index.php/Uploadcontroller/uploadLogo', form_data,
          {  
                  transformRequest: angular.identity,  
                  headers: {'Content-Type': undefined,'Process-Data': false}  
          }).success(function(response){  
            alert(JSON.stringify(response));
                  Data.toast(response);
              if(response.status == "success")
            {

                var img_name = response.image;
                var comp_name = companyy.name;
                alert(comp_name);

                Data.post('Dashboard/addcompany', { name : comp_name,imagepath : img_name
                }).then(function (results) {
                 
                    alert(JSON.stringify(results));
                  
                    });

            }

             });

         
       
    };


  /*  $scope.uploadLogo = function(usergroupID, userGroup){  
      
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

    };  */
  
	
	
	
	
    //console.log(fileReader)
 //       $scope.Upload = {};
/*    $scope.getFile = function () {
        $scope.progress = 0;
        fileReader.readAsDataUrl($scope.file, $scope)
                      .then(function(result) {
                          $scope.imageSrc = result;
                      });
    };

    $scope.$on("fileProgress", function(e, progress) {
        $scope.progress = progress.loaded / progress.total;
    });

    $scope.uploadPhoto = function (imageSrc, usergroupID, userGroup){
    	alert(usergroupID+"---"+userGroup+"=="+imageSrc); return;
    	if(imageSrc != undefined)
    	{
   		     		 Data.post('uploadImage', {
   		     			imageSrc : imageSrc,
   		     			 usergroupID: usergroupID,
   		     			 userGroup:userGroup
    	         }).then(function (results) {
    	        	//alert(JSON.stringify(results));
    	        	 Data.toast(results);
    	         	if(results.status == "success")
    	         	{
    	         		$('.modal').modal('hide');
    	         		$scope.imageSrc = "";
    	         		//$("#formUpload").reset();
    	         		$("input[type='file']").val("");
    	         		$scope.progress = 0;
    	         		
    	         		if(userGroup == "user")
   	         			{
    	         			$rootScope.image = results.image;
    	         			$scope.Emp.userInfo.image = results.image;		
   	         			}
    	         	}
    	         });	
    	}
    	

    };*/

});