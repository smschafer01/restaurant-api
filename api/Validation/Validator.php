<?php

namespace RestaurantAPI\Validation;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
class Validator {
    private static array $errors = [];
//Return the errors in an array
    public static function getErrors() : array {
        return self::$errors;
    }

    // A generic validation method. it returns true on success or false on failed validation.
    public static function validate($request, array $rules) : bool {
        foreach ($rules as $field => $rule) {
            //Retrieve parameters from URL or the request body
            $param = $request->getAttribute($field) ?? $request->getParsedBody()[$field];
            try{
                $rule->setName($field)->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getFullMessage();
            }
        }
        // Return true or false; "false" means a failed validation.
        return empty(self::$errors);
    }

    //Validate student data.
    public static function validateAmenity($request) : bool {
        //Define all the validation rules
        $rules = [
            'amenity_name' => v::alnum(' '),
            'description' => v::alnum(' '),
            'icon_name' => v::alnum(' ')
        ];

        return self::validate($request, $rules);
    }

    //Validate student data.
    public static function validateMenuCategory($request) : bool {
        //Define all the validation rules
        $rules = [
            'category_name' => v::alnum(' '),
            'description' => v::alnum(' ')
        ];

        return self::validate($request, $rules);
    }
}
