@extends('layouts.app')

@section('content')

    <h1 class="text-4xl ml-10 pt-10 flex justify-center">Upload File</h1>
    <div class="flex justify-center">
        <div class="max-w-full py-12 ml-10">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8" action="{{ route('files.store') }}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                        File
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="file" id="file" type="file" required>
                </div>
                <div class="flex items-center justify-center space-x-5">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Upload
                    </button>
                    <a href="{{ route('home') }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Cancel
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection


