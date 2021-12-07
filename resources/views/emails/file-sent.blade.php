@component('mail::message')
# New file(s) received! Check out your files!


@component('mail::button', ['url' => 'http://127.0.0.1:8000/home'])
View your files
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
