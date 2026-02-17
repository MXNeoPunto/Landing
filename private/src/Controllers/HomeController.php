<?php

namespace App\Controllers;

use App\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', [
            'isLoggedIn' => Auth::check(),
            'user' => (new Auth())->user()
        ]);
    }
}
