<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemServicesController extends Controller
{
    public function index()
    {
        // For now, we'll just return the view.
        // In the future, this could fetch status from the MicroserviceController or other services.
        return view('system_services.index');
    }
}
