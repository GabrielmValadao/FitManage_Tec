<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{

    public function index(Request $request)
    {


        $name = $request->query('name');
        $email = $request->query('email');
        $cpf = $request->query('cpf');

        $query = Student::query();

        if ($name || $email || $cpf) {
            $query->where(function ($search) use ($name, $email, $cpf) {
                if ($name) {
                    $search->where('name', 'ilike', "%$name%");
                }
                if ($email) {
                    $search->orWhere('email', 'ilike', "%$email%");
                }
                if ($cpf) {
                    $search->orWhere('cpf', 'ilike', "%$cpf%");
                }
            });
        }

        $students = $query->orderBy('name')->get();

        return $students;
    }
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'string|required|max:255|unique:students',
                'date_birth' => 'date_format:Y-m-d|required',
                'cpf' => 'string|required|size:14|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/|unique:students',
                'contact' => 'string|required|max:20',
                'cep' => 'string|nullable|max:20',
                'street' => 'string|nullable|max:30',
                'state' => 'string|nullable|max:2',
                'neighborhood' => 'string|nullable|max:50',
                'city' => 'string|nullable|max:50',
                'number' => 'string|nullable|max:30',
                'complement' => 'string|nullable|max:50',
                'user_id' => 'integer'
            ]);

            $userPlan = Auth::user()->plan;

            if (in_array($userPlan->description, ['OURO', 'PRATA', 'BRONZE'])) {
                $data['user_id'] = Auth::id();
                $student = Student::create($data);
                return $student;
            }
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->response('Estudante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $formatStudent = [
            'student' => $student->only(['id', 'name', 'email', 'date_birth', 'cpf', 'contact']),
            'address' => $student->only(['cep', 'street', 'state', 'neighborhood', 'city', 'number', 'complement'])
        ];
        return $formatStudent;
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $request->validate([
                'name' => 'string|max:255|nullable',
                'email' => 'string|max:255|nullable|unique:students',
                'date_birth' => 'date_format:Y-m-d|nullable',
                'contact' => 'string|max:20|nullable',
                'cpf' => 'string|max:255|nullable|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$|regex:/^\d{3}\d{3}\d{3}\d{2}$/|unique:students',
                'cep' => 'string|max:20|nullable',
                'street' => 'string|max:30|nullable',
                'state' => 'string|max:2|nullable',
                'neighborhood' => 'string|max:50|nullable',
                'city' => 'string|max:50|nullable',
                'number' => 'string|max:30|nullable',
                'complement' => 'string|max:50|nullable'
            ]);

            $student = Student::find($id);
            if (!$student) return $this->error('Cliente não encontrado', Response::HTTP_NOT_FOUND);
            $student->update($data);

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);

        if ($student->user_id !== Auth::id()) {
            return response('Usuário não autorizado a deletar este estudante', Response::HTTP_FORBIDDEN);
        }

        $student->delete();
        return $this->response('', Response::HTTP_NO_CONTENT);
    }

    public function exportStudent(Request $request)
    {
        $student_id = $request->input('id');

        $student = Student::with('workouts.exercise')
            ->find($student_id);

        if (!$student) {
            return response('Estudante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $workoutsDay = [];
        foreach ($student->workouts as $workout) {
            $workoutsDay[] = [
                'name' => $student->name,
                'exercise' => $workout->exercise->description,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'day' => $workout->day,
                'time' => $workout->time,
                'observation' => $workout->observation
            ];
        }


        $pdf = Pdf::loadView('pdfs.studentWorkoutPdf', ['workoutsDay' => $workoutsDay]);

        return $pdf->stream('treinoEstudante.pdf');
    }
}
