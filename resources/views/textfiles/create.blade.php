@extends('layouts.app')

@section('content')

    <h1 class="text-4xl ml-10 pt-10 flex justify-center">Create Text File</h1>
    <div class="flex justify-center">
        <div class="w-full  py-12 ml-16 mr-16 ">
            <form class="bg-white shadow-md rounded" action="{{ route('files.store') }}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-72 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="name" id="name" type="text" required>
                    .txt
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                        Content
                    </label>
                    <input class="shadow appearance-none border rounded w-full h-48 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="content" id="content" type="text">
                </div>
                <div class="flex items-center justify-center space-x-5 pb-7">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Create
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


