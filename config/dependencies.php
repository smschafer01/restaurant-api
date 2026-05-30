<?php

use DI\Container;
use RestaurantAPI\Controllers\RestaurantChainController;

return function(Container $container) {

    // Set a dependency called "RestaurantChains"
    $container->set('RestaurantChains', function() {
        return new RestaurantChainController();
    });
};
