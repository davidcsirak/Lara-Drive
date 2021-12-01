<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create() {
        return view('files.create');
    }

    public function store(Request $request) {
        if ($request->file('file')) {

            $size = $request->file('file')->getSize();
            $size = $this->convert_to_kb($size);

            $name = $request->file('file')->getClientOriginalName();

            $request->request->add([ 'size' => $size, 'name' => $name]);

            $data = $request->validate([
                'size' => '',
                'name' => '',
                'file' => 'required'
            ]);

            if ($filePath = $request->file('file')->store('uploads/files', 'public')) {
                auth()->user()->files()->create([
                    'name' => $data['name'],
                    'size' => $data['size'],
                    'file' => $filePath,
                ]);

                return Redirect::route('home');
            }
        }
        return Redirect::back();
    }

    public function edit(File $file) {
        return view('files.edit', compact('file'));
    }

    public function update($id) {

        dd($id);

//        $file = File::find($id);

//        dd(\request()->all());
//        $data = \request()->validate([
//            'name' => 'required'
//        ]);

//        dd($data);

//        $file->update($data);
//
//        Redirect::route('home');

    }

    private function convert_to_kb($bytes){
        return number_format($bytes / 1024, 1);
    }
}
