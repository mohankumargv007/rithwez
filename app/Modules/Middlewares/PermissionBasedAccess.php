<?php
namespace App\Modules\Middlewares;

use Auth;
use Closure;
use App;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;


class PermissionBasedAccess
{
    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next) {
        if(Auth::user()) {
            $response = $next($request);
            return $response;
        } else {
            return redirect()->intended('/logout/');
        }
    }
}
