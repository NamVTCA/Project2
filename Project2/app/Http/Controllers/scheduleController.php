<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class scheduleController extends Controller
{
    function index()
    {
        return view('schedule');
    }
}
