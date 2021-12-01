<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
        $this->authorize('update', $file);

        return view('files.edit', compact('file'));
    }

    public function update(File $file) {

//        $file = File::findorfail($id);
        $this->authorize('update', $file); //egy masik bejelentkezett felhasznalo nem éri el a saját fileunk editjét a policynek koszonhetoen

        if (\request()->name) {

            $data = \request()->validate([
                'name' => 'required'
            ]);
            $file->update($data);

//            $content = Storage::disk('public')->get($file->file);
            return Redirect::route('home');
        }

        return Redirect::back();

    }

    public function delete(File $file) {

        $file->delete();

        return Redirect::route('home');
    }

    public function redirect() {

        Session::flash('download.in.the.next.request', route('files.download'));

        return Redirect::route('home');

    }

    public function download(File $file) {
        $fileName = $file->name;
        $filePath = 'storage/' . $file->file;

        return Response::download($filePath,$fileName);
    }

    private function convert_to_kb($bytes){
        return number_format($bytes / 1024, 1);
    }
}
