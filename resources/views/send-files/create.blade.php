@extends('layouts.app')

@section('content')

    <h1 class="text-4xl ml-10 pt-10 flex justify-center">Send File</h1>
    <div class="flex justify-center">
        <div class="w-full  py-12 ml-16 mr-16 ">
            <form class="bg-white shadow-md rounded" action="{{ route('send.files.store') }}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="">
                    @if($errors->any())
                        <h4 class="text-red-500 font-bold">{{$errors->first()}}</h4>
                    @endif
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Send-to
                    </label>
                    <input class="shadow appearance-none border rounded w-72 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="username" id="username" type="text" placeholder="Username..." required>
                </div>

                <label class="block text-gray-700 text-sm font-bold mb-2" for="files[]">
                    Select-files
                </label>
                <select class="js-example-basic-single" multiple="multiple" name="files[]" required>
                    @foreach( $files as $file)
                        <option value="{{ $file->id }}">{{ $file->name }}</option>
                    @endforeach
                </select>
                <div>
                    <button type="submit" class="mt-10">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: "Select a state",
                allowClear: true,
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>
@endsection


