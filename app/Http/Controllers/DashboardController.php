<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Plan;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
       $registered_student =  Student::where('user_id', $request->user()->id)->count();
       $registered_exercises =  Exercise::where('user_id', $request->user()->id)->count();
       $current_user_plan = Plan::where('user_id', $request->user()->id)->count();
    }
}
