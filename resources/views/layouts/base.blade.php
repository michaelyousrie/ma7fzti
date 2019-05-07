<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <title>Application</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    
    <div id="app">
        @yield('content')
    </div>
    
    
    <script src="{{ asset('js/app.js') }}"></script>


    {{-- <script>
        @if ( session()->has('message') )
            swal(
                "{{ session('title') ?? 'Success' }}",
                "{{ session('message') }}",
                "{{ session('message-class') ?? 'success' }}"
            );
        @endif
    </script> --}}
</body>
</html>
