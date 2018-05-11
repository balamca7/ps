app.controller('tutorCtrl', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval) {
    //initially set those objects to null to avoid undefined error
    //alert("tutorCtrl");
    $scope.message = "";
    $scope.init = function() {
    	//$scope.getGroupcontacts();
    	$scope.getTutortype();
    	$scope.findTutor = {"tutorType":"0","username":"","subjects":"","subsubjects":""};
    	$scope.getUserEducationDetails();
    	$scope.getCategoryList();
	};
	
	
	  $scope.getCategoryList = function(){
		   Data.get('Dashboard/getCategory', {
		       }).then(function (results) {			    	
		       	$scope.Category = results;
		       });
	   };

	   $scope.getSubCategoryList = function(categoryId){

		   Data.post('Dashboard/getSubCategory', {
			   categoryId : categoryId
		       }).then(function (results) {
		       	$scope.subCategory = results;
		       });

	   };
    $scope.searchTutors = function(findTutor){
    	// alert(JSON.stringify(findTutor))
		/*if(findTutor.tutorType == 'Student' && findTutor.subjects =='0')
		{
                         $scope.listTutors= {};
                  	 $scope.message = "Please select any one subjects.";
                             return;
                }*/
   		 Data.post('Dashboard/getTutoruser', findTutor).then(function (results) {
         		 $scope.listTutors = results;
			 $scope.message = "";
    	         });
    };
    
    $scope.getTutortype = function() {

	    Data.get('Dashboard/getTutortype', {
	        
	    }).then(function (results) {
	    	
	    	$scope.listTutortype = results;
	    });
    };
    
    
    $scope.getUserEducationDetails = function() {

	    Data.get('Profile/subjectGrades', {
	        
	    }).then(function (results) {
	    	
	    	$scope.listSubjects = results;
	    });
    };
    $scope.init();
});