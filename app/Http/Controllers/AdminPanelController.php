<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function index()
    {
        // You can pass data to the view here if needed
        return view('admin.panel');
    }
}
