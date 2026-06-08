<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

use RestaurantAPI\Models\Locations;

class RestaurantChains extends Model{

    protected $table = 'restaurant_chains';

    protected $primaryKey = 'chain_id';

    public $incrementing = true;

    public $timestamps = false;

    //Retrieve all professors
    public static function getRestaurantChains() {
        return self::with('locations');
    }


    //View a specific restaurant chain by id
    public static function getRestaurantChainById(string $chain_id) {
        $restaurantChain = self::findOrFail($chain_id);
        $restaurantChain->load('locations');
        return $restaurantChain;
    }

    //This defines the one-to-many relationships between restaurant chanins
    //and locations.
    public function locations(){
        return $this->hasMany(Locations::class, 'chain_id');
    }

    public static function getLocationsByRestaurantChain(string $chain_id) {
        $restaurantChain = self::findOrFail($chain_id)->locations;
        return $restaurantChain;

    }
}