<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        // Fetch records from MySQL instead of static array
        $data['users'] = $userModel->findAll();

        return view('users/index', $data);
    }
}