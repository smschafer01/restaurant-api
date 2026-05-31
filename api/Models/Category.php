<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    public $timestamps = false;

    public function locations() {
        return $this->belongsToMany(Location::class, 'location_categories', 'category_id', 'location_id');
    }

    public static function getCategories() {
        return self::all();
    }

    public static function getCategoryById($id) {
        return self::findOrFail($id);
    }
}
