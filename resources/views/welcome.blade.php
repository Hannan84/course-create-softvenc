<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Course Creator</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                .module, .content {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
}
.module-header, .content-header {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
}
.toggle-arrow {
    cursor: pointer;
    font-size: 18px;
    user-select: none;
    transition: transform 0.2s ease-in-out;
}
.toggle-arrow.rotated {
    transform: rotate(-90deg);
}
                .remove-btn { margin-left: 10px; color: red; cursor: pointer; }
            </style>
        @endif
    </head>
    <body>
        @yield('content')
    </body>
</html>
