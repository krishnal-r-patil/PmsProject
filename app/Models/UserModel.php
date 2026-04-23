<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'role', 'created_at'];

    // For real systems, you should use password_hash and password_verify
    // For now we keep it simple as per your previous logic
}
