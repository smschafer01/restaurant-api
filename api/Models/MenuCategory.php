<?php
namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model {
    protected $table = 'menu_categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    public $timestamps = false;

    // One-to-many: a menu category has many menu items
    public function menuItems() {
        return $this->hasMany(MenuItem::class, 'category_id', 'category_id');
    }

    public static function getMenuCategories() {
        return self::query();
    }


    public static function getMenuCategoryById($id) {
        return self::findOrFail($id);
    }
}
