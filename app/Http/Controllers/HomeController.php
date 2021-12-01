<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index() {
        $user = auth()->user();

        $userid = $user->id;

        //return view('home', compact('user'));
        return view('home',[
            'user' => $user,
            'files' => DB::table('files')->where('user_id', '=', $userid)->orderBy('name')->paginate(20)
        ]);
    }
}
