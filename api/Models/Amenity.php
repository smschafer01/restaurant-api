<?php
namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model {
    protected $table = 'amenities';
    protected $primaryKey = 'amenity_id';
    public $incrementing = true;
    public $timestamps = false;

    public static function getAmenities ($request) {
        return self::all();
    }

    public static function getAmenityById($id) {
        return self::findOrFail($id);
    }

    public function locationAmenities() {
        return $this->belongsToMany(Locations::class, 'location_amenities', 'amenity_id', 'location_id');
    }

    public static function getLocationAmenities(string $amenity_id) {
        return self::with('locationAmenities')->findOrFail($amenity_id);
    }

    //Insert a new amenity
    public static function createAmenity($request) {
        //Retrieve parameters from request body
        $params = $request->getParsedBody();
        //Create a new Amenity instance
        $amenity = new Amenity();
        //Set the amenity's attributes
        foreach($params as $field => $value) {
            $amenity->$field = $value;
        }
        //Insert the amenity into the database
        $amenity->save();
        return $amenity;
    }

    //Update an amenity
    public static function updateAmenity($request) {
        //Retrieve parameters from request body
        $params = $request->getParsedBody();
        //Retrieve id from the request url
        $id = $request->getAttribute('id');
        $amenity = self::findOrFail($id);
        if(!$amenity) {
            return false;
        }
        //update attributes of the amenity
        foreach($params as $field => $value) {
            $amenity->$field = $value;
        }
        //save the amenity into the database
        $amenity->save();
        return $amenity;
    }
    // Search amenities by keyword across multiple fields
    public static function searchAmenities($keywords) {
        return self::where(function($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('amenity_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhere('icon_name', 'LIKE', "%{$keyword}%");
        }
    })->get();
}


}
