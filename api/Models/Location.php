<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

use RestaurantAPI\Models\RestaurantChains;

use RestaurantAPI\Models\Category;

class Location extends Model {

    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    public $incrementing = true;
    public $timestamps = false;

    // ONE location has MANY restaurant chains
    public function chains() {
        return $this->hasMany(
            RestaurantChains::class,
            'location_id',   // foreign key in restaurant_chains table
            'location_id'    // local key in locations table
        );
    }

    public function categories() {
        return $this->belongsToMany(
            Category::class,
            'location_categories',
            'location_id',
            'category_id'
        );
    }

    public static function getLocations() {
        return self::all();
    }

    public static function getLocationById($id) {
        return self::findOrFail($id);
    }
}