<?php

namespace RestaurantAPI\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    // Primary key
    protected $primaryKey = 'id';

    // Auto-incrementing ID
    public $incrementing = true;

    // Primary key type
    protected $keyType = 'int';

    // created_at and updated_at
    public $timestamps = true;

    // Get all users
    public function getUsers()
    {
        return self::all();
    }

    // Get user by ID
    public function getUserById($id)
    {
        return self::find($id);
    }

    // Create a new user
    public function createUser($data)
    {
        return self::create($data);
    }

    // Update an existing user
    public function updateUser($id, $data)
    {
        $user = self::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    // Delete a user
    public function deleteUser($id)
    {
        $user = self::find($id);
        if ($user) {
            $user->delete();
        }
        return $user;
    }

  public static function authenticateUser($username, $password)
  {
      $user = self::where('username', $username)->first();

      if (!$user) {
          return false;
      }

      //  password
      return password_verify($password, $user->password) ? $user : false;
  }
}
