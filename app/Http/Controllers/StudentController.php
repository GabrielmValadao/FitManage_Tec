<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
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
                'user_id' => 'integer|required'
            ]);

            $student = Student::create($data);
            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
