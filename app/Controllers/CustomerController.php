<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        
        // Fetch records from MySQL instead of static array
        $data['customers'] = $customerModel->findAll();

        return view('customers/index', $data);
    }
}