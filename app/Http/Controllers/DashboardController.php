<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Plan;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)

    {

        $user = $request->user();

        $students =  Student::where('user_id', $user->id)->count();
        $exercises =  Exercise::where('user_id', $user->id)->count();
        $userPlan = Plan::where('user_id', $user->id)->first();
        $limitPlan = $userPlan->limit;

        $remainingStudents = max(0, $limitPlan - $students);

        $data = [
            'registered_students' => $students,
            'registered_exercises' => $exercises,
            'current_user_plan' => $userPlan->description,
            'registered_students' => $remainingStudents,
        ];

        return response()->json($data, 200);
    }
}
