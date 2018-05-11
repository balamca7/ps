app.controller('contentCtrl',	function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout) {
    //initially set those objects to null to avoid undefined error
    //alert("contentCtrl");
    var postid = $routeParams.postid;
//alert(postid);
    $scope.Content = getContent(postid);
    function getContent(postid) {
    	
        Data.post('Dashboard/Viewquestion', {
        	questionID : postid
        }).then(function (results) {
        	//alert(JSON.stringify(results.comments));
        	$scope.Content = results;
        	//$scope.Content = results.ContentInfo;
        	//$scope.Content.push({"commenttxt":""});
        });
    };
    
    $scope.replyComment = function (post_id, comment_id){
    	$scope.showReply = comment_id;
    }
    $scope.ratingComment = function(post_id, comment_id, rating, parent_comment_id){
    	if(rating != "")
   		{
        	Data.put('Dashboard/ratingComment', {
        		questionID : postid,
        		commentID : comment_id,
            	rating : rating
            }).then(function (results) {
            	//alert(JSON.stringify(results));
            	//Data.toast(results);
            });
   		}
    };
    
    
    $scope.addComment = function(postid, commenttxt, parent_comment_id){
    	
    	if(commenttxt != "" && commenttxt != undefined)
   		{
        	Data.put('Dashboard/addComment', {
        		questionID : postid,
            	//commenttxt : escape(commenttxt)
            	comment : commenttxt,
            	parent_comment_id : parent_comment_id
            }).then(function (results) {
            	//alert(JSON.stringify(results.comments));
            	$scope.showReply = "";
            	if(parent_comment_id == null)
            	{
            		$scope.Content.commenttxt = "";
            		$scope.Content.comments.unshift(results.comments);		
            	}
            	else 
            	{
            		
            		$scope.Content.recommenttxt = "";
	           		 angular.forEach($scope.Content.comments, function(data) {
	     		     
	     		        if (data.id == parent_comment_id) {
	     		       	data.recomments.unshift(results.comments);
     		        }
	     		        
	     		    });

            	}
            	
            	Data.toast(results);            	
            });
   		}
    };
    
});