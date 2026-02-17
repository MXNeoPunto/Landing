<?php

namespace App\Controllers;

use function App\view;
use function App\redirect;

class Controller
{
    protected function view($name, $data = [])
    {
        view($name, $data);
    }

    protected function redirect($url)
    {
        redirect($url);
    }
}
