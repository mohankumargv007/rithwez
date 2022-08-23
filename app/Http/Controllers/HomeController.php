<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::get();
        if(isset(Auth::user()->email_verified_at)) {
            if(Auth::user()->role == 'Admin') {
                return redirect('/hierarchy/add');
            } else {
                return redirect('/hierarchy/apply');
            }
        } else {
            return view('auth.verify');
        }
    }
}
