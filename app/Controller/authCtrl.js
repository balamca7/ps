app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $localStorage, $interval) {
    //initially set those objects to null to avoid undefined error
	//alert("AuthCtrl");
	var userID = $routeParams.id;	
    $scope.login = {};
    $scope.signup = {};
	$scope.displayChat=false;
	
	$scope.init = function() {
		//$scope.getTutortype();

	};

    $scope.doLogin = function (customer) {
        Data.post('Account/login', 
            customer
        ).then(function (results) {
			//alert(JSON.stringify(results));
            Data.toast(results);
            // login successful if there's a token in the response
               if (results.status == "success") {
             
                if (results.token) {
                // store username and token in local storage to keep user logged in between page refreshes
                    $location.path('/home');
                
                $localStorage.currentUser = { 
                					uid :results.data.id,
                					name : results.data.fname,
            						email : results.data.email,
            						image : results.data.imagepath, 
            						token: results.token 
            						};
                // add jwt token to auth header for all requests made by the $http service
                $http.defaults.headers.common.Authorization = 'Bearer ' + results.token;
                // execute callback with true to indicate successful login
            			//window.location.reload(); 
                    //callback(true);
                } else {
                    // execute callback with false to indicate failed login
                    //callback(false);
                }
           }
        });
    };


    $scope.forgetPwd = {"userName" : "", "email" : ""};

    $scope.forgetPassword = function(forgetPwd){
    	
    	if((forgetPwd.userName != undefined && forgetPwd.userName != "") || (forgetPwd.email != undefined && forgetPwd.email != ""))
    	{
    		Data.post('Account/forgotPassword', 
    			forgetPwd
            ).then(function (results) {
            	//alert(JSON.stringify(results));
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
		}
    };
    
    
    //$scope.signup = {"email":"balamca7@gmail.com","password":"123","password2":"123","userName":"Bala","firstName":"bala","lastName":"bala","telephone":"123","mobile":"123","screenName":"Bala","middleName":"1"};
    //$scope.signup = {"email":"","password":"","password2":"","userName":"","firstName":"","middleName":"","lastName":"","telephone":"","mobile":"","screenName":"", "tutorType" : ""};
    //$scope.signup = {"emailAddress":"bala@bmassociates.com","password":"123","password2":"123","userName":"Bala","firstName":"bala","lastName":"bala","telephone":"9003723111", "tutorType" : "Teacher","middleName":""};
    $scope.signup = {"emailAddress":"","password":"","password2":"","userName":"","firstName":"","middleName":"","lastName":"","telephone":"", "tutorType" : ""};
    $scope.signUp = function (data) {
    	$http.put('api/v1/index.php/Account/register', data)
        .success(function (data, status, headers) {
        	Data.toast(data);
            if (data.status == "success") {
                	$location.path('/notificationlink');
            	$scope.signup = {"emailAddress":"","password":"","password2":"","userName":"","firstName":"","middleName":"","lastName":"","telephone":"", "tutorType" : ""};
            }
        })
        .error(function (data, status, header, config) {
        	Data.toast(data);
        });
        
    };
    
     $scope.getTutortype = function () {

    	Data.get('Account/getTutortype', {}).then(
				function(results) {
				 $scope.Tutortype = results;
				});
    };


    $scope.logout = function() {
		Data.post('Profile/logout', {}).then(
				function(results) {
					Data.toast(results);
					if (results.status == "info") {
					        $("#cometchat").css("display", "none");
							$interval.cancel($rootScope.quesNotify);
							$interval.cancel($rootScope.groupMessages);					

							delete $localStorage.currentUser;
							$http.defaults.headers.common.Authorization = '';
							$location.path('/login');
					}
				});	
    };


    $scope.init();


});