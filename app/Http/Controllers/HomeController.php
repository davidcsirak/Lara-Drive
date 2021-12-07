<?php

namespace App\Http\Controllers;

use App\Models\File;
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

        $products = File::sortable()->where('user_id', '=', $userid)->orderBy('name')->paginate(20);

        //return view('home', compact('user'));
        return view('home',[
            'user' => $user,
            'files' => $products
            //'files' => DB::table('files')->where('user_id', '=', $userid)->orderBy('name')->paginate(20)
        ]);
    }

    public function indexSearch(Request $request) {
        $search = $request->get('search');
        $user = auth()->user();
        $userid = $user->id;

        if (!empty($search)) {
            $files = File::sortable()
                ->where('user_id', '=', $userid)
                ->where('files.name', 'like', '%'.$search.'%')
                ->paginate(5);
        } else {
            $files = File::sortable()
                ->where('user_id', '=', $userid)
                ->paginate(20);
        }

        //return view('home')->with('products', $files)->with('filter', $search);
        return view('home', [
            'user' => $user,
            'files' => $files,
            'search' => $search
        ]);

    }
}
