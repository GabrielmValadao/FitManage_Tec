<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        try {

            $request->validate([
                'description' => 'string|required|max:255'
            ]);

            $userId = Auth::user()->id;

            $exerciseRegistered = Exercise::where('user_id', $userId)->where('description', $request->input('description'))->first();

            if ($exerciseRegistered) {
                return response()->json(['error' => 'Exercício já cadastrado para este usuário!', Response::HTTP_CONFLICT]);
            }
            $exercise = Exercise::create([
                'description' => $request->input('description'),
                'user_id' => $userId,
            ]);

            return $exercise;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
