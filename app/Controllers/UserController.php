<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        
        // Fetch records directly from MySQL database table
        $data['users'] = $model->findAll();

        return view('users/index', $data);
    }
}