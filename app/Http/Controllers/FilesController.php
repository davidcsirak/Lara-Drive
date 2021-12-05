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

        if ($request->file('file')) {  // in case uploading from local storage
            $size = $request->file('file')->getSize();
            $size = $this->convert_to_kb($size);
            $name = $request->file('file')->getClientOriginalName();
            $type = $request->file('file')->getClientOriginalExtension();

            $request->request->add(['name' => $name, 'size' => $size, 'type' => $type]);

            $data = $request->validate([
                'name' => 'required',
                'size' => 'required',
                'type' => 'required',
                'file' => 'required'
            ]);

            $path = Storage::putFile('/uploads', $request->file('file'));

            //in case of uploading text file
            if (($path != null ) && $type == 'txt') {  //storing file in storage with the name and context from the request, can be added more extensions to work with
//                dd($path);
//                dd($content = Storage::path($path));
                $content = Storage::disk('local')->get($path);

                auth()->user()->files()->create([
                    'name' => $data['name'],
                    'size' => $data['size'],
                    'path' => $path,
                    'content' => $content,
                    'type' => $type
                ]);

                //in case of uploading a non text file content will be null

            } elseif (($path != null) && $type != 'txt') {

                auth()->user()->files()->create([
                    'name' => $data['name'],
                    'size' => $data['size'],
                    'path' => $path,
                    'type' => $type
                ]);
            }

            return Redirect::route('home');


        } elseif (!$request->file('file')) {  // in case creating text file on the page

            $fileContent = $request->get('content');
            $fileName = $request->get('name') . '.txt';
            $filePath = 'uploads/' . $fileName;
            Storage::put($filePath, $fileContent);  //storing file in storage with the name and context from the request
            $fileSize = Storage::size($filePath);
            $fileSize = $this->convert_to_kb($fileSize);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);

            $request->request->add(['size' => $fileSize, 'type' => $fileType]);

            $request->validate([
                'name' => 'required',
                'size' => 'required',
                'type' => 'required',
                'content' => '',   // a text files content can be null and later edited
            ]);

            auth()->user()->files()->create([
                'name' => $fileName,
                'size' => $fileSize,
                'path' => $filePath,
                'content' => $fileContent,
                'type' => $fileType
            ]);

            return Redirect::route('home');
        }

        return Redirect::back();


    }

    public function edit(File $file) {
        $this->authorize('update', $file);

        return view('files.edit', compact('file'));
    }

    public function update(File $file) {

        $this->authorize('update', $file); //egy masik bejelentkezett felhasznalo nem éri el a saját fileunk editjét a policynek koszonhetoen

        if (\request()->has('content')) {

            $data = \request()->validate([
                'name' => 'required',
                'content' => ''
            ]);

            $file->update($data);  //update data in DB

            $content = \request()->get('content');
            file_put_contents(storage_path('/app/' . $file->path), $content); //update data in local storage

            return Redirect::route('home');
        }
        else {

            $data = \request()->validate([
                'name' => 'required',
            ]);

            $file->update($data);

            return Redirect::route('home');
        }

    }

    public function delete(File $file) {

        $file->delete(); //deletinng from DB

        Storage::delete($file->path); //deleteing from local storage

        return Redirect::route('home');
    }

    public function redirect() {

        Session::flash('download.in.the.next.request', route('files.download'));

        return Redirect::route('home');

    }

    public function download(File $file) {
        $fileName = $file->name;

        $filePath = storage_path('/app/' . $file->path);

        return Response::download($filePath,$fileName);
    }

    private function convert_to_kb($bytes){
        return number_format($bytes / 1024, 1);
    }
}
