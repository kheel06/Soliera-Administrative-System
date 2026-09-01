<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZonePolicyController extends Controller
{
    public function index()
    {
        return view('visitors.zones.index');
    }
}
