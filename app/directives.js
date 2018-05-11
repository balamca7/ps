app.directive('focus', function() {
    return function(scope, element) {
        element[0].focus();
    }      
});

app.directive("fileInput", function($parse){  
    return{  
         link: function($scope, element, attrs){  
              element.on("change", function(event){  
                   var files = event.target.files;  
                   console.log(files[0]);  
                   $parse(attrs.fileInput).assign($scope, element[0].files);  
                   $scope.$apply();  
              });  
         }  
    }  
});  
/*
app.directive("ngFileSelect",function(){    
	  return {
		    link: function($scope,el){          
		      el.on("change", function(e){          
		        $scope.file = (e.srcElement || e.target).files[0];
		        $scope.getFile();
		      });          
		    }        
		  }
});
*/
app.directive('setFocus', function(){
	  return{
	      scope: {setFocus: '='},
	      link: function(scope, element){
	         if(scope.setFocus) element[0].focus();             
	      }
	  };
	});
app.directive('modal', function () {
    return {
      template: '<div class="modal fade">' + 
          '<div class="modal-dialog">' + 
            '<div class="modal-content">' + 
              '<div class="modal-header">' + 
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
                '<h4 class="modal-title">{{ title }}</h4>' + 
              '</div>' + 
              '<div class="modal-body" ng-transclude></div>' + 
            '</div>' + 
          '</div>' + 
        '</div>',
      restrict: 'E',
      transclude: true,
      replace:true,
      scope:true,
      link: function postLink(scope, element, attrs) {
        scope.title = attrs.title;

        scope.$watch(attrs.visible, function(value){
          if(value == true)
            $(element).modal('show');
          else
            $(element).modal('hide');
        });

        $(element).on('shown.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = true;
          });
        });

        $(element).on('hidden.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = false;
          });
        });
      }
    };
  });

app.directive('passwordMatch', [function () {
    return {
        restrict: 'A',
        scope:true,
        require: 'ngModel',
        link: function (scope, elem , attrs,control) {
            var checker = function () {
 
                //get the value of the first password
                var e1 = scope.$eval(attrs.ngModel); 
 
                //get the value of the other password  
                var e2 = scope.$eval(attrs.passwordMatch);
                if(e2!=null)
                return e1 == e2;
            };
            scope.$watch(checker, function (n) {
 
                //set the form control to valid if both 
                //passwords are the same, else invalid
                control.$setValidity("passwordNoMatch", n);
            });
        }
    };
}]);