<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([]);
    }
}
