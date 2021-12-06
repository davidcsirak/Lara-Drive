<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CustomUsernameResetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $user = auth()->user();
        $userEmail = $user->email;
        $userUsername = $user->username;

        return view('auth.forgot-username', [
            'email' => $userEmail,
            'username' => $userUsername,
        ]);
    }

    public function store(Request $request) {

        $user = auth()->user();

        $data = $request->validate([
            'email' => ['required', 'email'],
            'username' => 'required',
        ]);

        $userEmail = $data['email'];
        $newUsername = $data['username'];

        DB::table('users')->where('email', '=' , $userEmail)->update(array('username' => $newUsername));

        return Redirect::route('home');
    }
}
