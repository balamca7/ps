app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $localStorage, $interval) {
    //initially set those objects to null to avoid undefined error
	//alert("AuthCtrl");
	var userID = $routeParams.id;	
    $scope.login = {};
    
    $scope.doLogin = function (customer, callback) {
    	//alert(JSON.stringify(customer));
        Data.post('Account/login', 
            customer
        ).then(function (results) {
        	//alert(JSON.stringify(results));
            Data.toast(results);
            
        
            // login successful if there's a token in the response
            if (results.token) {
                // store username and token in local storage to keep user logged in between page refreshes
                $localStorage.currentUser = { 
                					uid :results.uid,
                					name : results.name,
            						email : results.email,
            						image : results.image, 
            						token: results.token 
            						};
//alert(JSON.stringify($localStorage));
                // add jwt token to auth header for all requests made by the $http service
                $http.defaults.headers.common.Authorization = 'Bearer ' + results.token;
                // execute callback with true to indicate successful login
                if (results.status == "success") {
                    $location.path('/home');
                }
                //callback(true);
            } else {
                // execute callback with false to indicate failed login
                
               // callback(false);
            }
            
        });
    };
    $scope.forgetPwd = {"userName" : "", "email" : ""};
    
    $scope.forgetPassword = function(forgetPwd){
    	alert(JSON.stringify(forgetPwd));
    	if((forgetPwd.userName != undefined && forgetPwd.userName != "") || (forgetPwd.email != undefined && forgetPwd.email != ""))
    	{
    		Data.post('Account/forgotPassword', 
    			forgetPwd
            ).then(function (results) {
            	alert(JSON.stringify(results));
               Data.toast(results);
                if (results.status == "success") {
                	$scope.forgetPwd = {"userName" : "", "email" : ""};
                }
            });
            	
    	}	
    	else
    		{
    		var results = new Array();
    		results["status"] = "error";
    		results["message"] = "Please enter username or email.";
    		 Data.toast(results);
    		//alert("Please enter username or email.");
    		}
    };
    
    
    //$scope.signup = {"email":"balamca7@gmail.com","password":"123","password2":"123","userName":"Bala","firstName":"bala","lastName":"bala","telephone":"123","mobile":"123","screenName":"Bala","middleName":"1"};
    //$scope.signup = {"email":"","password":"","password2":"","userName":"","firstName":"","middleName":"","lastName":"","telephone":"","mobile":"","screenName":"", "tutorType" : ""};
  //  $scope.signup = {"emailAddress":"bala@bmassociates.com","password":"123","password2":"123","userName":"Bala","firstName":"bala","lastName":"bala","telephone":"9003723111", "tutorType" : "Teacher","middleName":""};
    $scope.signup = {"emailAddress":"","password":"","password2":"","userName":"","firstName":"","middleName":"","lastName":"","telephone":"", "tutorType" : ""};
    $scope.signUp = function (data) {
//    	alert(JSON.stringify(data));
    	$http.put('api/v1/index.php/Account/register', data)
        .success(function (data, status, headers) {
        	Data.toast(data);
            if (data.status == "success") {
            	$scope.signup = {"emailAddress":"","password":"","password2":"","userName":"","firstName":"","middleName":"","lastName":"","telephone":"", "tutorType" : ""};
            }
        })
        .error(function (data, status, header, config) {
        	Data.toast(data);
        });
        
    };
  
    if($location.url() == "/login")
    {
        //$("body").addClass("sidebar-collapse");
    	
    	$("#mainHeader").addClass("hide");
    	$("#leftToggleNav").addClass("hide");
    	$("#leftSidebar").addClass("hide");
    	$("#mainNavbar").addClass("hide");
    
    /*	Data.get('logout').then(function (results) {
            //$location.path('login');
            $("body").addClass("sidebar-collapse");
        	
        	$("#mainHeader").addClass("hide");
        	$("#leftToggleNav").addClass("hide");
        	$("#leftSidebar").addClass("hide");
        	$("#mainNavbar").addClass("hide");
        });*/
    }
    
    $scope.logout = function() {
		
		Data.post('Profile/logout', {}).then(
				
				function(results) {
					// alert(JSON.stringify(results)+"~~~~~~~~~~~");
					Data.toast(results);
					if (results.status == "info") {
							
							delete $localStorage.currentUser;
							$http.defaults.headers.common.Authorization = '';
							$location.path('/login');
							$interval.cancel($rootScope.quesNotify);
							$interval.cancel($rootScope.groupMessages);					
					}
					
				});
		
	
		/*
		 * Data.get('logout').then(function (results) {
		 * Data.toast(results); $location.path('login');
		 * $scope.displayChat=false; if
		 * (angular.isDefined($scope.notifyInterval)) {
		 * $interval.cancel($scope.notifyInterval); }
		 * 
		 * if (angular.isDefined($scope.chatInterval)) {
		 * $interval.cancel($scope.chatInterval); } });
		 */}
    
});