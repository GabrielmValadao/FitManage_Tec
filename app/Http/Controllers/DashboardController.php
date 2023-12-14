<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
       $student =  Student::where('user_id', $request->user()->id)->count();
    }
}
