<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class CustomPasswordResetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $user = auth()->user();
        $userEmail = $user->email;

        return view('auth.forgot-password', [
            'email' => $userEmail
        ]);
    }

    public function store(Request $request) {

        $user = auth()->user();

        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        $userEmail = $data['email'];
        $newPassword = $data['password'];

        //dd($userEmail, $newPassword);
        DB::table('users')->where('email', '=' , $userEmail)->update(array('password' => Hash::make($newPassword)));

        return Redirect::route('home');
    }
}
