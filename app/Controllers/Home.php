<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('users/index', ['users' => (new \App\Libraries\DemoStore('users'))->all()]);
    }

    public function about(): string
    {
        return view('about');
    }
}
