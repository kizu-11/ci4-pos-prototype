<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // or 'object' depending on your views
    protected $allowedFields    = ['username', 'full_name', 'created_at'];
}