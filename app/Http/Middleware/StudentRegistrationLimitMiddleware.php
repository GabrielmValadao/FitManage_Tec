<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentRegistrationLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();
        $plan = $user->plan;

        if ($plan->description !== 'OURO') {
            $maxStudentsCreate = $plan->limit;
            $numberStudents = $user->students()->count();

            if ($numberStudents >= $maxStudentsCreate) {
                return response()->json(['error' => 'Limite de cadastro de estudante atingido'], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
