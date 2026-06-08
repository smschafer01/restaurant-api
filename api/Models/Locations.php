<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;





class Locations extends Model {

    protected $table = 'locations';
    protected $primaryKey = 'location_id';
    public $incrementing = true;
    public $timestamps = false;



    public static function getLocations() {
        return self::query();
    }


    public static function getLocationById($location_id) {
        $location = self::findOrFail($location_id);
        return $location;
    }

    public function amenities() {
        return $this->belongsToMany(Amenity::class, 'location_amenities', 'location_id', 'amenity_id');
    }

    public static function getAmenitiesByLocation($location_id) {
        return self::findOrFail($location_id)->amenities;
    }
}