<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(Request $request) {
        try {
            $data = $request->all();

            $user = User::create($data);

            $request->validate([
                'name' => 'string|required|max: 255',
                'email' => 'string|required|max:255|unique:users',
                'date_birth' => 'date_format:YYYY-mm-dd|string|required|unique:users',
                'cpf' => 'string|required|max:255|unique:users',
                'password' => 'string|required|min:8|max:32',
                'plan_id'=> 'integer|required'
            ]);

            return $user;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}