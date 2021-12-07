<?php

namespace App\Http\Controllers;

use App\Mail\FileSentMail;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class SendFilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create() {
        $user = auth()->user();

        $userid = $user->id;

        $files = DB::table('files')->where('user_id', '=', $userid)->orderBy('name')->get();

        //dd($files);
        return view('send-files.create', [
            'files' => $files
        ]);
    }

    public function store(Request $request) {

        $user = auth()->user();

        $data = $request->validate([
            'username' => 'required',
            'files' => 'required'
        ]);

        foreach ($data['files'] as $id) {  // megkapom a küldendő fileok id-ját egyenként

            if (count($toUserId = DB::table('users')->select('id')->where('username','=', $data['username'])->get()) != 0) {

                $toUserId = $toUserId[0]->id;

                $toUserMail = DB::table('users')->select('email')->where('username','=', $data['username'])->get();
                $toUserMail = $toUserMail[0]->email;

                $myUsername = $user->username;

                $fileData = File::select('name','size','path','content','type','created_at','updated_at')->where('id','=', $id)->get()->toArray()[0];

                // inserting new file for target user
                DB::table('files')->insertGetId(
                    array('user_id' => $toUserId,
                        'name' => $fileData['name'],
                        'size' => $fileData['size'],
                        'path' => $fileData['path'],
                        'content' => $fileData['content'],
                        'type' => $fileData['type'],
                        'from' => $myUsername,
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()));
            }
            else {
                return Redirect::back()->withErrors(['msg' => 'Invalid Username!']);
            }
        }

        Mail::to($toUserMail)->send(new FileSentMail());

        return Redirect::route('home');
    }
}
