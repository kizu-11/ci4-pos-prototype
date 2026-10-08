<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();
        
        // Fetch records directly from MySQL database table instead of static array
        $data['customers'] = $model->findAll();

        return view('customers/index', $data);
    }
}