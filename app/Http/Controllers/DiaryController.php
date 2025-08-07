<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DiaryController extends Controller
{
    public function index()
    {
        return view('diary.index');
    }
}
