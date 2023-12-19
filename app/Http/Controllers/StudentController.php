<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
                'cpf' => 'string|required|size:11|regex:/^\d{3}\d{3}\d{3}\d{2}$|unique:students',
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

            $userId = Auth::user()->id;
            // mesclagem de dados
            $data['user_id'] = $userId;
            $student = Student::create($data);
            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
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
}
