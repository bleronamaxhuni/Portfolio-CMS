<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('client.index', [
            'appName' => config('app.name', 'Portfolio'),
        ]);
    }
}
