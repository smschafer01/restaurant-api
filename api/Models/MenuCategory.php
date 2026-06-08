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

    public static function getMenuCategories($request) {
    return self::all();
    }

    public static function getMenuCategoryById($id) {
        return self::findOrFail($id);
    }

    //Insert a new menu category
    public static function createMenuCategory($request) {
        //Retrieve parameters from request body
        $params = $request->getParsedBody();
        //Create a new MenuCategory instance
        $menuCategory = new MenuCategory();
        //Set the MenuCategory's attributes
        foreach($params as $field => $value) {
            $menuCategory->$field = $value;
        }
        //Insert the MenuCategory into the database
        $menuCategory->save();
        return $menuCategory;
    }

    //Update a menu category
    public static function updateMenuCategory($request) {
        //Retrieve parameters from request body
        $params = $request->getParsedBody();
        //Retrieve id from the request url
        $id = $request->getAttribute('id');
        $menuCategory = self::findOrFail($id);
        if(!$menuCategory) {
            return false;
        }
        //update attributes of the menu category
        foreach($params as $field => $value) {
            $menuCategory->$field = $value;
        }
        //save the student into the database
        $menuCategory->save();
        return $menuCategory;
    }
   // Search menu categories by keyword across multiple fields
    public static function searchMenuCategories($keywords) {
        return self::where(function($query) use ($keywords) {
        foreach ($keywords as $keyword) {
            $query->orWhere('category_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
        }
    })->get();
}
}
