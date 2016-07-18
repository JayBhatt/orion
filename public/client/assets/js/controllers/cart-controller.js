function CartCtrl($scope, $rootScope, _, Config, Cart) {

    $scope.config = Config.getConfig();
    $scope.cartItems = [];
    $scope.items = [];
    $scope.packages = [];
    $scope.algorithms = $scope.config.algorithms;
    $rootScope.requestLoaded = true;
    $scope.errorMessage = "";
    $scope.successMessage = "";
    $scope.totalWeight = 0;
    $scope.totalCost = 0;
    $scope.selected = {
        algorithm : '',
    }

    // Set cart config
    Cart.setConfig($scope.config);

    // Get cart items
    $scope.getCartItems = function() {
        $scope.showLoader();
        var data = {
            'action' : 'list-items-cart'
        };
        Cart.getCartItems(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200){
                $scope.cartItems = response.body;
                $scope.setCartTotals();
                // Get the packages
                $scope.getPackages();
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    };

    // Calculate the cart's total cost and total weight and store it in scope.
    $scope.setCartTotals = function () {
        $scope.totalWeight = 0;
        $scope.totalCost = 0;
        _($scope.cartItems).forEach(function(item) {
            $scope.totalWeight = _.parseInt($scope.totalWeight + item['weight']);
            $scope.totalCost = _.parseInt($scope.totalCost + item['cost']);
        });
    };
    
    // Get items
    $scope.getItems = function() {
        $scope.showLoader();
        var data = {
            'action' : 'list-items'
        };
        Cart.getItems(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200){
                $scope.items = response.body;
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    };

    // Add item to cart
    $scope.addItemToCart = function(id) {
        // Check if the item exists in the item list.
        if(!$scope.itemExistsInItemArray(id)){
            $scope.showErrorDialog("The item you are trying to add to cart doesn't exists in our database.");
            return false;
        }
        $scope.showLoader();
        var data = {
            'action' : 'add-item-to-cart',
            'id' : id
        };
        Cart.addItemToCart(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200 && response.body === true){
                // Reload item list
                $scope.getItems();
                // Reload the cart item list
                $scope.getCartItems();
                // Reload packages
                $scope.getPackages();
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    };

    // Change algorithm
    $scope.changeAlgorithm = function(algorithm) {
        $scope.selected.algorithm = algorithm;
        $scope.getPackages(algorithm);
    };

    // Remove item from cart
    $scope.removeItemFromCart = function(id) {
        // Check if the item exists in the item list.
        $scope.showLoader();
        var data = {
            'action' : 'remove-item-from-cart',
            'id' : id
        };
        Cart.removeItemFromCart(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200 && response.body === true){
                // Reload item list
                $scope.getItems();
                // Reload the cart item list
                $scope.getCartItems();
                // Reload packages
                $scope.getPackages();
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    };
    
    // Get the current selected algorithm
    $scope.getAlgorithm = function(){
    	$scope.showLoader();
        var data = {
            'action' : 'get-algorithm'
        };
        Cart.getAlgorithm(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200 && !_.isEmpty(response.body)){
            	$scope.selected.algorithm = response.body;
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    }
    
    // Set the algorithm
    $scope.setAlgorithm = function(algorithm){
    	$scope.showLoader();
        var data = {
            'action' : 'set-algorithm',
            'algorithm' : algorithm
        };
        Cart.setAlgorithm(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200 && response.body === true){
            	$scope.selected.algorithm = algorithm;
            	$scope.getPackages();
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    }

    // Get packages
    $scope.getPackages = function () {
    	$scope.showLoader();
        var data = {
            'action' : 'get-packages',
            'algorithm' : $scope.selected.algorithm
        };
        Cart.getPackages(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200){
                $scope.packages = response.body;
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    };
    
    // Empty cart
    $scope.emptyCart = function()
    {
    	$scope.showLoader();
        var data = {
            'action' : 'empty-cart'
        };
        Cart.emptyCart(data).then(function (response) {
            if(!_.isEmpty(response) && response.code === 200 && response.body === true){
                // Get the algorithm
            	$scope.getAlgorithm();
            	// Reload item list
                $scope.getItems();
                // Reload the cart item list
                $scope.getCartItems();
                // Reload packages
                $scope.getPackages();
            } else {
                $scope.showErrorDialog(response.body);
            }
        }).finally(function () {
            $scope.hideLoader();
        });
    }

    // Check if an item is already added to the cart
    $scope.itemAlreadyAdded = function (id) {
        return _.find($scope.cartItems, function(item) {
            return item.id === id;
        })
    };

    // Check if an item is already added to the cart
    $scope.itemExistsInItemArray = function (id) {
        return _.find($scope.items, function(item) {
            return item.id === id;
        })
    };

    // Show loader
    $scope.showLoader = function () {
        $rootScope.requestLoaded = false;
    };

    // Hide loader
    $scope.hideLoader = function () {
        $rootScope.requestLoaded = true;
    };

    // Show error dialog
    $scope.showErrorDialog = function(message) {
        $scope.errorMessage = message;
    };

    // Show success dialog
    $scope.showSuccessDialog = function(message) {
        $scope.successMessage = message;
    };

    // Hide alert messages
    $scope.closeAlertMessage = function() {
        $scope.errorMessage = false;
        $scope.successMessage = false;
    };

    // Load methods on controller load
    $scope.init = function () {
    	$scope.getAlgorithm();
        $scope.getItems();
        $scope.getCartItems();
    }

    $scope.init();

};

orion.controller('CartCtrl', CartCtrl);
CartCtrl.$inject = ["$scope", "$rootScope", "_", "Config", "Cart"];
