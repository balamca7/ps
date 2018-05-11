app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = 'api/v1/index.php/';

        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 1000, 'trustedHtml');
        }
        obj.get = function (q) {
        	//alert(serviceBase + q);
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
        	//alert(serviceBase + q);
            return $http.post(serviceBase + q, object).then(function (results) {
            	//alert(JSON.stringify(results))
                return results.data;
            });
        };
        obj.put = function (q, object) {
        	/*return $http.put(serviceBase + q, object)
            .success(function (data, status, headers) {
            	return data;
            })
            .error(function (data, status, header, config) {
            	return data;
            });
        	*/
        	
            return $http.put(serviceBase + q, object).then(function (results) {
            	
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);