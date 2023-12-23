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
        $userPlan = $user->plan;
        $limitPlan = ($userPlan) ? $userPlan->limit : null;

        $remainingStudents = ($limitPlan !== null) ? max(0, $limitPlan - $students) : null;

        $data = [
            'registered_students' => $students,
            'registered_exercises' => $exercises,
            'current_user_plan' => $userPlan->description,
            'remaining_students' => ($remainingStudents !== null && $remainingStudents > 20) ? 'ilimitado' : $remainingStudents,
        ];

        return $data;
    }
}
