<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use View;
use Session;

class UsersController extends Controller
{
	/*Code Needs To Be Place Here For Users Logic*/
	public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
