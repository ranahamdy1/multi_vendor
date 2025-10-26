<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    public function handle(Request $request, Closure $next,...$types): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->guest(route('login'));
        }
        if (! in_array($user->type,$types)) {
            abort(403);
        }
        return $next($request);
    }
}
