orion.factory('Cart', function ($http) {

    var config = null;

    // Set config
    var setConfig = function(systemConfig){
        config = systemConfig;
    };

    // Get items in the cart
    var getCartItems = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };

    // Get a list of items
    var getItems = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };

    // Add an item to cart
    var addItemToCart = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };

    // Remove an item from cart
    var removeItemFromCart = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };
    
    // Empty cart
    var emptyCart = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };

    // Get the generated packages
    var getPackages = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };
    
    // Get algorithm
    var getAlgorithm = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };
    
    // Set algorithm
    var setAlgorithm = function(data){
        data = 'args='+JSON.stringify(data);
        var promise = $http({
            method: "POST",
            url: config.api.endPoint,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: data
        });
        return (promise.then(handleSuccess, handleError));
    };

    // Handle success response
    var handleSuccess = function(response) {
        return response.data;
    };

    // Handle error response
    var handleError = function(response) {
        var message = '';
        if (!angular.isObject(response.data) || !response.data) {
            message = 'An unknown error occurred while processing your request. Please try again after sometime.';
        } else {
            message = response.data;
        }
        console.log(message);
    };

    return {
        setConfig: setConfig,
        getCartItems: getCartItems,
        getItems: getItems,
        addItemToCart: addItemToCart,
        removeItemFromCart: removeItemFromCart,
        getPackages: getPackages,
        emptyCart: emptyCart,
        getAlgorithm: getAlgorithm,
        setAlgorithm: setAlgorithm
    };

}).$inject = ["$http"];