<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        $exercises = Exercise::select('id', 'description')->where('user_id', $user->id)->orderBy(
            'description'
        )->get();

        return $exercises;
    }


    public function store(Request $request)
    {
        try {

            $request->validate([
                'description' => 'string|required|max:255'
            ]);

            $userId = Auth::user()->id;

            $exerciseRegistered = Exercise::where('user_id', $userId)->where('description', $request->description)->first();

            if ($exerciseRegistered) {
                return response('Exercício já cadastrado para este usuário!', Response::HTTP_CONFLICT);
            }


            $exercise = Exercise::create([
                'description' => $request->description,
                'user_id' => $userId,
            ]);

            return $exercise;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request, $id)
    {

        $user = $request->user();

        $exercise = Exercise::find($id);

        if (!$exercise) return $this->error('Exercício não encontrado', Response::HTTP_NOT_FOUND);

        if ($exercise->user_id !== $user->id) {
            return response('Usuário não autorizado a deletar este exercício', Response::HTTP_FORBIDDEN);
        }

        $exercise->delete();
        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
