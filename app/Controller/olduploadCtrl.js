app.controller('UploadController', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval, fileReader) {
	
	var ID = $routeParams.id;
	var usergroup = $routeParams.usergroup;
	$scope.id = ID;
	$scope.usergroup = usergroup;
	
    console.log(fileReader)
        $scope.Upload = {};
    $scope.getFile = function () {
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
    	         });	    	}
    	

    };

});