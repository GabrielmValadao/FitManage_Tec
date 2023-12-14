<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function store(Request $request) {
        try {
            $data = $request->only('email', 'password');

            $request->validate([
                'email'=> 'string|required',
                'password'=> 'string|required',

            ]);

            $authenticated = Auth::attempt($data);
            if(!$authenticated) {
                return $this->error('Não autorizado, credenciais incorretas', Response::HTTP_UNAUTHORIZED);
            }

            $request->user()->tokens()->delete();
            $token = $request->user()->createToken('simple');
            $name = $request->user()->name;

            return $this->response('Autorizado', 200, [
                'token' => $token->plainTextToken,
                'name' => $name
            ]);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
