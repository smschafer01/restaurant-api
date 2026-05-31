<?php
use DI\Container;
use RestaurantAPI\Controllers\RestaurantChainController;
use RestaurantAPI\Controllers\MenuCategoryController;
use RestaurantAPI\Controllers\AmenityController;

return function(Container $container) {

    $container->set('RestaurantChains', function() {
        return new RestaurantChainController();
    });

    $container->set('MenuCategory', function() {
        return new MenuCategoryController();
    });

    $container->set('Amenity', function() {
        return new AmenityController();
    });
};
