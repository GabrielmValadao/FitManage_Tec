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
        $search = $request->query('search');

        $students = Student::where('name', 'ilike', "%$search%")
            ->orWhere('cpf', 'ilike', "%$search%")
            ->orWhere('email', 'ilike', "%$search%")
            ->orderBy('name')
            ->get();

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
                'cpf' => 'string|required|max:255|unique:students',
                'contact' => 'string|required|max:20',
                'cep' => 'string|nullable',
                'street' => 'string|nullable',
                'state' => 'string|nullable',
                'neighborhood' => 'string|nullable',
                'city' => 'string|nullable',
                'number' => 'string|nullable',
                'complement' => 'string|nullable',
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
