app.controller('profileCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    //alert("profileCtrl");
     var userID = $routeParams.id;
    
    var usergroup = $routeParams.usergroup;
    $scope.Emp = {hideSave:false, selected :{}};
    $scope.modelInculdeFile = "";

  $scope.init = function() {
      $scope.getProfile(userID);
   };

  $scope.UplodPhoto = function(){
    	$scope.modelInculdeFile = "templates/home/uploadPhoto.html";
		$('#myModal').modal('show');
    };

  $scope.ChangePassword = function(){
    	$scope.chgpwd = {};
    	$scope.modelInculdeFile = "templates/home/changepassword.html";
		$('#myModal').modal('show');

    }

  $scope.saveChangePwd = function (chgpwd){
   	 Data.post('Profile/changePassword', chgpwd
        ).then(function (results) {

        	//alert(JSON.stringify(results));
       	 Data.toast(results);
       	if (results.status == "success") {
      	 $scope.chgpwd = {};
       	$('#myModal').modal('hide');
       	}
        });
    }

  $scope.getProfileTemplate = function (contact) {
		/*alert(JSON.stringify(contact))
        if (contact.id === $scope.Emp.selectedUser.id) return 'editProfile';
        else*/ 
			return 'displayProfile';
    };


  $scope.editProfile = function (contact) {
        $scope.Emp.selectedUser = angular.copy(contact);
    };


  $scope.profileReset = function () {
    	$scope.Emp.selectedUser = {};
    	$scope.Emp.selectedSchool = {};
    	$scope.selectedCategory = {};
    };

   
   

  $scope.getProfile = function(uid) {
        Data.post('Profile/profile', {
            id: uid
        }).then(function (results) {
           // alert(JSON.stringify(results))
        	$scope.Emp = results;
        	
        });
    };


  $scope.init();

  

});

