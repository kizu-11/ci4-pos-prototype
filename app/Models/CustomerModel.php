<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // or 'object' depending on your views
    protected $allowedFields    = ['full_name', 'email', 'phone', 'created_at'];
}