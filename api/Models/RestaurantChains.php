<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantChains extends Model{

    protected $table = 'restaurant_chains';

    protected $primaryKey = 'chain_id';

    public $incrementing = true;

    public $timestamps = false;

    //Retrieve all professors
    public static function getRestaurantChains() {

        //Retrieve all restaurant chains
        $restaurantChains = self::all();
        return $restaurantChains;
    }

    //View a specific restaurant chain by id
    public static function getRestaurantChainById(string $chain_id) {
        $restaurantChain = self::findOrFail($chain_id);
        return $restaurantChain;
    }
}