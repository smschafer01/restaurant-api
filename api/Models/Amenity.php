<?php
namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model {
    protected $table = 'amenities';
    protected $primaryKey = 'amenity_id';
    public $incrementing = true;
    public $timestamps = false;

    public static function getAmenities() {
        return self::all();
    }

    public static function getAmenityById($id) {
        return self::findOrFail($id);
    }
}
