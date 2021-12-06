@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-max mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-blue-600 font-bold">
                    {{ $user->name }} You're logged in! | Only text files content can be edited!
                </div>

            </div>



            <div id="control" class="mt-6 space-x-5 flex items-baseline">

                <div id="searchbar">

                    <form action="{{ route('search') }}" method="GET">

                        <div class="pt-2 relative mx-auto text-gray-600">
                            <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                                   type="search" id="search" name="search" placeholder="Search" value="{{ $search }}" required>
                            <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                                <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                     viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                                     width="512px" height="512px">

                        <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                            </button>
                        </div>

                    </form>

                </div>

                <div id="buttons" class="mt-2">

                    <a href="/files/create">
                        <button class="bg-green-400 hover:bg-green-500 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Upload File
                        </button>
                    </a>
                    <a href="/textfiles/create">
                        <button class="bg-green-400 hover:bg-green-500 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Create Text File
                        </button>
                    </a>

                </div>

            </div>
            <table class="table-fixed mt-6">
                <thead>
                <tr class="bg-gray-400">
                    <th class="w-1/2 px-4 py-2">
                        @sortablelink('name')
                    </th>
                    <th class="w-1/4 px-4 py-2">Size</th>
                    <th class="w-1/4 px-4 py-2">Created_at</th>
                    <th class="w-1/4 px-4 py-2">
                        @sortablelink('updated_at')
                    </th>
                    <th class="w-1/4 px-4 py-2">Edit</th>
                    <th class="w-1/4 px-4 py-2">Delete</th>
                    <th class="w-1/4 px-4 py-2">Download</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($files->count() == 0)
                        <tr>
                            <td class="w-full px-4 py-6">No files to display.</td>
                        </tr>
                    @endif

                    @foreach($files as $file)
                        <tr>
                            <td class="border px-4 py-2">{{ $file->name }}</td>
                            <td class="border px-4 py-2">{{ $file->size }} KB</td>
                            <td class="border px-4 py-2">{{ $file->created_at }}</td>
                            <td class="border px-4 py-2">{{ $file->updated_at }}</td>
                            <td class="border px-4 py-2"><a href="/files/{{ $file->id }}/edit"><button class="bg-yellow-300 hover:bg-yellow-400 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Edit</button></a></td>

                            <td class="border px-4 py-2">
                                <form action="/files/{{ $file->id }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-500 hover:bg-red-600 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>

                            <td class="border px-4 py-2">
                                <form action="/files/{{ $file->id }}" method="get">
                                    @csrf

                                    <button class="bg-blue-500 hover:bg-blue-600 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                                        Download
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6" id="container">
                {!! $files->appends(\Request::except('page'))->render() !!}
            </div>

        </div>

    </div>
@endsection


