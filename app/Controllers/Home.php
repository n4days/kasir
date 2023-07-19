<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => ['Home', 'Dashboard'],
        ];
        return view('home', $data);
    }
}
