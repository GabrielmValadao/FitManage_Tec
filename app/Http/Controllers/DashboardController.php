<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Plan;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
       $students =  Student::where('user_id', $request->user()->id)->count();
       $exercises =  Exercise::where('user_id', $request->user()->id)->count();
       $userPlan = Plan::where('user_id', $request->user()->plan->description);
       $limitPlan = Plan::where('user_id', $request->user()->plan->limit);

       $remainingStudents = max(0, $limitPlan - $students);

       $data = [
        'registered_students' => $students,
        'registered_exercises' => $exercises,
        'current_user_plan' => $userPlan,
        'registered_students' => $remainingStudents,
       ];

       return response('', 200)->json($data);
    }
}
