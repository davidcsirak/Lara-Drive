@extends('layouts.app')

@section('content')

    <h1 class="text-4xl ml-10 pt-10 flex justify-center">Edit File</h1>
    <div class="flex justify-center">
        <div class="w-full max-w-xs py-12 ml-10">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8" action="/files/{{ $file->id }}" enctype="multipart/form-data" method="post">
                @method('PATCH')
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                           name="name"
                           id="name"
                           type="text"
                           required
                           value="{{ old('name') ?? $file->name }}">
                </div>
                <div class="flex items-center justify-center space-x-5">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Update
                    </button>
                    <a href="{{ route('home') }}">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="button">
                            Cancel
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection


