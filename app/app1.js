'use strict';
var app = angular.module('myApp', [ 'ngRoute', 'ngAnimate', 'toaster', 'ngDialog', 'ui.bootstrap','ngStorage']);

app.config([ '$routeProvider', function($routeProvider) {
	$routeProvider.when('/login', {
		title : 'Login',
		templateUrl : 'partials/login.html',
		//controller : 'authCtrl'
	}).when('/forgetpassword', {
		title : 'Forget Password',
		templateUrl : 'partials/forgetpassword.html',
		//controller : 'authCtrl'
	}).when('/UserActivation/:id', {
		title : 'User Account Activation',
		templateUrl : 'partials/UserActivation.html',
		//controller : 'authCtrl'
	
	}).when('/resetpassword/:id', {
		title : 'Reset Password',
		templateUrl : 'partials/resetpassword.html',
		//controller : 'authCtrl'
	}).when('/logout', {
		title : 'Logout',
		templateUrl : 'partials/login.html',
		//controller : 'logoutCtrl'
	}).when('/signup', {
		title : 'Signup',
		templateUrl : 'partials/signup.html',
		//controller : 'authCtrl'
	}).when('/home', {
		title : 'Home',
		templateUrl : 'partials/home.html',
		//controller : 'homeCtrl'
	}).when('/dashboard', {
		title : 'Dashboard',
		templateUrl : 'partials/dashboard.html',
		//controller : 'dashboardCtrl'
	}).when('/content/:postid', {
		title : 'Content',
		templateUrl : 'partials/content.html',
		//controller : 'contentCtrl'
	
	}).when('/profile/:id/:usergroup', {
		title : 'Profile',
		templateUrl : 'partials/profile.html',
		//controller : 'profileCtrl'
	}).when('/groups/:id/:usergroup', {
		title : 'Profile',
		templateUrl : 'partials/groupChat.html'
		//controller : 'groupCtrl'
	}).when('/usergroups', {
		title : 'Profile',
		templateUrl : 'partials/usergroup.html',
		//controller : 'groupCtrl'
	}).when('/findtutors', {
		title : 'Profile',
		templateUrl : 'partials/findTutor.html',
		//controller : 'groupCtrl'
	
	}).when('/userSubjects/:id', {
		title : 'Profile',
		templateUrl : 'partials/userSubjects.html',
		//controller : 'groupCtrl'
	
	}).when('/postQuestion', {
		title : 'Ask Question',
		templateUrl : 'partials/postQuestion.html',
		//controller : 'questionCtrl'
			
	}).when('/', {
		title : 'Login',
		templateUrl : 'partials/login.html',
		//controller : 'authCtrl',
		role : '0'
	}).otherwise({
		redirectTo : '/login'
	});
} ]).config(function($locationProvider) {
	$locationProvider.html5Mode(false);
	    $locationProvider.hashPrefix('!');
}).run(function($rootScope, $location, $http,Data, $localStorage) {
	
	$rootScope.$on("$routeChangeStart", function(event, next, current) {
		
		$rootScope.authenticated = false;
		//alert(JSON.stringify($localStorage.currentUser))
		
		if($localStorage.currentUser != undefined)
		{
            $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.token;

			$rootScope.authenticated = true;
			$rootScope.uid = $localStorage.currentUser.uid;
			$rootScope.name = $localStorage.currentUser.name;
			$rootScope.email = $localStorage.currentUser.email;
			$rootScope.image = $localStorage.currentUser.image;
			
			$("body").removeClass("sidebar-collapse");

			$("#mainHeader").removeClass("hide");
			$("#leftToggleNav").removeClass("hide");
			$("#leftSidebar").removeClass("hide");
			$("#mainNavbar").removeClass("hide");

			
			$rootScope.headerURL = 'partials/header.html';
			$rootScope.rightSidebarURL = 'partials/rightsidebar.html';
			$rootScope.chatModleURL = 'partials/chatModel.html';
			$rootScope.leftSidebarURL = 'partials/leftsidebar.html';		

			
			
/*			getContacts();
			function getContacts(){
				 Data.post('getContacts', {
			        }).then(function (results) {
			        	//alert(JSON.stringify(results.groupContactsInfo));
			        	$rootScope.contacts = results.contactsInfo;
			        	$rootScope.groupcontacts = results.groupContactsInfo;
			        });
			
			}
*/			
		} else {
			var nextUrl = next.$$route.originalPath;
			
			if (nextUrl == '/signup' || nextUrl == '/login' || nextUrl == '/forgetpassword' || nextUrl == '/resetpassword/:id' || nextUrl == '/UserActivation/:id' || nextUrl == '/signup') {
				$("body").addClass("sidebar-collapse");
		    	$("body").removeClass("sidebar-mini");

				
			} else {
				$location.path("/login");
				$("body").removeClass("sidebar-collapse");
				
				$("#mainHeader").removeClass("hide");
				$("#leftToggleNav").removeClass("hide");
				$("#leftSidebar").removeClass("hide");
				$("#mainNavbar").removeClass("hide");
				
				$rootScope.headerURL = '';
				$rootScope.leftSidebarURL = '';
				$rootScope.rightSidebarURL = '';
				$rootScope.chatModleURL = '';
				
			}
		}

/*		Data.get('session').then(function(results) {
			alert(JSON.stringify(results));
			if (results.uid) {
				$rootScope.authenticated = true;
				$rootScope.uid = results.uid;
				$rootScope.name = results.name;
				$rootScope.email = results.email;
				$rootScope.image = results.image;
				$("body").removeClass("sidebar-collapse");
				
				$("#mainHeader").removeClass("hide");
				$("#leftToggleNav").removeClass("hide");
				$("#leftSidebar").removeClass("hide");
				$("#mainNavbar").removeClass("hide");
				
				$rootScope.headerURL = 'partials/header.html';
				$rootScope.leftSidebarURL = 'partials/leftsidebar.html';
				$rootScope.rightSidebarURL = 'partials/rightsidebar.html';
				$rootScope.chatModleURL = 'partials/chatModel.html';
				
				getContacts();
				
				
				function getContacts(){
					 Data.post('getContacts', {
				        }).then(function (results) {
				        	//alert(JSON.stringify(results.groupContactsInfo));
				        	$rootScope.contacts = results.contactsInfo;
				        	$rootScope.groupcontacts = results.groupContactsInfo;
				        });
				};
				$(".select2").select2();
			} else {
				var nextUrl = next.$$route.originalPath;
				
				if (nextUrl == '/signup' || nextUrl == '/login' || nextUrl == '/forgetpassword' || nextUrl == '/resetpassword/:id' || nextUrl == '/UserActivation/:id' || nextUrl == '/signup') {
					$("body").addClass("sidebar-collapse");
			    	$("body").removeClass("sidebar-mini");

					
				} else {
					$location.path("/login");
					$("body").removeClass("sidebar-collapse");
					
					$("#mainHeader").removeClass("hide");
					$("#leftToggleNav").removeClass("hide");
					$("#leftSidebar").removeClass("hide");
					$("#mainNavbar").removeClass("hide");
					
					$rootScope.headerURL = '';
					$rootScope.leftSidebarURL = '';
					$rootScope.rightSidebarURL = '';
					$rootScope.chatModleURL = '';
					
				}
			}
		});
		*/
	});
});

