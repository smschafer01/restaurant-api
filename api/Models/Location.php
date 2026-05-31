<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    public $incrementing = true;
    public $timestamps = false;

    
    public function chain() {
        return $this->belongsTo(RestaurantChains::class, 'chain_id');
    }

    
    public function categories() {
        return $this->belongsToMany(Category::class, 'location_categories', 'location_id', 'category_id');
    }

    public static function getLocations() {
        return self::all();
    }

    public static function getLocationById($id) {
        return self::findOrFail($id);
    }
}
