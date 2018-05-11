app.controller('groupMemberCtrl', function($scope, $rootScope, $routeParams,
		$location, $http, ngDialog, Data, $interval) {
	//alert("groupMemberCtrl");
	var groupID = $routeParams.id;
	$scope.GroupMember = getGroupMember(groupID);

	function getGroupMember(groupID) {

		Data.post('Usergroup/getGroupMember', {
			groupID : groupID
		}).then(function(results) {
			//alert(JSON.stringify(results));
			$scope.GroupMember = results;
		});
	}
	;

	$scope.viewuserProfile = function(user_id) {
		$('.modal').modal('hide');
		setTimeout(function() {
			$location.path('/home/profile/' + user_id + '/user');
		}, 1);

	};
	getAlluser(); // Load all countries with capitals
	function getAlluser() {
		Data.get('Dashboard/getAllUsersGroups', {}).then(function(results) {
			//$scope.Alluser = results.GroupMember;
			$scope.Alluser = results;
		});
	}
	;

	$scope.AddGroupMember = function(selectedUser, group_id) {
	
		Data.post('Usergroup/addGroupMember', {
			selectedUser : selectedUser,
			groupId : groupID
		}).then(function(results) {
			//alert(JSON.stringify(results));
			Data.toast(results);
			if(results.status == "success")
         	{
			$scope.GroupMember.push(results.newMember)
			//alert($rootScope.groups.memberCount);
			$scope.groups.memberCount = ($scope.groups.memberCount*1)+1; 
			$scope.selectedUser = "";
         	}
		});
	};
});
