<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailWelcomeToUser;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();



            $request->validate([
                'name' => 'string|required|max: 255',
                'email' => 'string|required|max:255|unique:users',
                'date_birth' => 'date_format:Y-m-d|nullable',
                'cpf' => 'string|required|max:255|unique:users',
                'password' => 'string|required|min:8|max:32',
                'plan_id' => 'integer|required'
            ]);



            $user = User::create($data);
            $plan = Plan::all();

            Mail::to($user->email, $user->name)->send(new SendEmailWelcomeToUser($user, $plan));
            return $user;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
