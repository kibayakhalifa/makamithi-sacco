<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        // Handle report generation logic here
        return back()->with('success', 'Report generated successfully!');
    }
}
