<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermitFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = \App\Models\Document::where('category', 'compliance')
            ->latest()
            ->paginate(12);

        return view('compliance.evidence.index', compact('documents'));
    }
}
