<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    public function index($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response('Estudante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $workoutOfDay = [
            'SEGUNDA' => [],
            'TERCA' => [],
            'QUARTA' => [],
            'QUINTA' => [],
            'SEXTA' => [],
            'SABADO' => [],
            'DOMINGO' => [],
        ];

        foreach ($student->workouts as $workout) {
            $workoutOfDay[$workout->day][] = [
                'exercise_id' => $workout->exercise_id,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'time' => $workout->time,
            ];
        };

        $workout = [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'workouts' => $workoutOfDay
        ];

        return $workout;
    }

    public function store(Request $request)
    {

        try {
            $data = $request->all();

            $request->validate([
                'student_id' => 'required|exists:students,id',
                'exercise_id' => 'required|exists:exercises,id',
                'repetitions' => 'required|integer',
                'weight' => 'required|numeric',
                'break_time' => 'required|integer',
                'day' => 'required|in:SEGUNDA,TERCA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
                'observations' => 'nullable|string',
                'time' => 'required|integer',
            ]);

            $existingWorkout = Workout::where('student_id', $request->student_id)->where('day', $request->day)->exists();
            if ($existingWorkout) {
                return response('Treino já cadastrado para este dia', Response::HTTP_CONFLICT);
            }

            $workout = Workout::create($data);
            return $workout;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
