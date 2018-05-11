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
    	$scope.modelInculdeFile = "templates/admin/uploadPhoto.html";
		$('#myModal').modal('show');
    };

    $scope.ChangePassword = function(){
    	$scope.chgpwd = {};
    	$scope.modelInculdeFile = "templates/admin/changepassword.html";
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
        if (contact.id === $scope.Emp.selectedUser.id) return 'editProfile';
        else return 'displayProfile';
    };

   $scope.editProfile = function (contact) {
        $scope.Emp.selectedUser = angular.copy(contact);
    };


    $scope.profileReset = function () {
    	$scope.Emp.selectedUser = {};
    };

    $scope.saveUserInfo = function(userInfo)
    {
    	 Data.put('Profile/saveUserInfo',
    		  userInfo
         ).then(function (results) {
        	 Data.toast(results);
         	$scope.profileReset();
         });
    }

   $scope.getProfile = function(uid) {
        Data.post('Profile/profile', {
            user_id: uid
        }).then(function (results) {
			//alert(JSON.stringify(results));
        	$scope.Emp = results;
        	$scope.Emp.selectedUser = {};
        	$scope.Emp.selectedSchool = {};
        	$scope.selectedCategory = {}
        });
    };

       $scope.init();
});