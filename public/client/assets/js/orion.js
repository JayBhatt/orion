/*  Module Config */
var SystemConfig = {
    algorithms: {
        firstFit : {
            title: 'First Fit',
            name: 'firstFit',
            desc: 'Find the first package that can fit the item and place the item in that package'
        },
        firstFitAscending  : {
            title: 'First Fit Ascending',
            name: 'firstFitAscending',
            desc: 'Arrange the items in Ascending order and then find the first package that can fit the item and place the item in that package'
        },
        firstFitDescending  : {
            title: 'First Fit Descending',
            name: 'firstFitDescending',
            desc: 'Arrange the items in Descending order and then find the first package that can fit the item and place the item in that package'
        }
    },
    api : {
        endPoint: 'http://localhost/orion/application/api.php'
    }
};

var orion = angular.module('application.orion',[]).service('Config', function () {
    var getConfig = function(){
        return SystemConfig;
    };
    return {
        getConfig: getConfig
    };
});

// Add lodash support
orion.constant('_', window._);

// Disable caching for $http
orion.config(['$httpProvider', function($httpProvider) {
 $httpProvider.interceptors.push('noCacheInterceptor');
}]).factory('noCacheInterceptor', function () {
    return {
        request: function (config) {
        	var separator = config.url.indexOf('?') === -1 ? '?' : '&';
            config.url = config.url+separator+'_request_id=' + new Date().getTime();
            return config;
       }
   };
});