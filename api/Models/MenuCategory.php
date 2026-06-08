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
    //Search for menu categories
    public static function searchMenuCategories($term) {
        if (is_numeric($term)) {
            $query = self::where('category_id', $term);
        } else {
            $query = self::where('category_name', 'like', "%$term%")
                ->orWhere('description', 'like', "%$term%");
        }
        return $query->get();
    }
}
