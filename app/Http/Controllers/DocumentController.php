<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        // Shared documents view (using secretary view as a simple default)
        return view('secretary.documents');
    }
}
