<?php
namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model {
    protected $table = 'amenities';
    protected $primaryKey = 'amenity_id';
    public $incrementing = true;
    public $timestamps = false;

    public static function getAmenities ($request) {
        //return self::all();

        /*********** code for pagination and sorting *************************/
        //get the total number of row count
        $count = self::count();

        //Get querystring variables from url
        $params = $request->getQueryParams();

        //do limit and offset exist?
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;   //items per page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;  //offset of the first item

        //pagination
        $links = self::getLinks($request, $limit, $offset);

        //build query
        $query = self::query();
        $query = $query->skip($offset)->take($limit);

        //code for sorting
        $sort_key_array = self::getSortKeys($request);
        //soft the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }



        //retrieve the courses
        $amenities = $query->get();  //Finally, run the query and get the results

        //construct the data for response
        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $amenities
        ];

        return $results;
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

    //Delete a Menu Category
    public static function deleteAmenity($request) {
        //Retrieve id from the request
        $id = $request->getAttribute('id');
        $amenity = self::findOrFail($id);
        return($amenity ? $amenity->delete() : $amenity);
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



    // Return an array of links for pagination. The array includes links for the current, first, next, and last pages.
    private static function getLinks($request, $limit, $offset) {
        $count = self::count();

        // Get request uri and parts
        $uri = $request->getUri();
        if($port = $uri->getPort()) {
            $port = ':' . $port;
        }
        $base_url = $uri->getScheme() . "://" . $uri->getHost() . $port . $uri->getPath();

        // Construct links for pagination
        $links = [];
        $links[] = ['rel' => 'self', 'href' => "$base_url?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => "$base_url?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => "$base_url?limit=$limit&offset=" . $offset - $limit];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => "$base_url?limit=$limit&offset=" . $offset + $limit];
        }
        $links[] = ['rel' => 'last', 'href' => "$base_url?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];

        return $links;
    }

    /*
     * Sort keys are optionally enclosed in [ ], separated with commas;
     * Sort directions can be optionally appended to each sort key, separated by :.
     * Sort directions can be 'asc' or 'desc' and defaults to 'asc'.
     * Examples: sort=[number:asc,title:desc], sort=[number, title:desc]
     * This function retrieves sorting keys from uri and returns an array.
    */
    private static function getSortKeys($request) {
        $sort_key_array = [];

        // Get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|]$|\s+/', '', $params['sort']);  // remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }


}
