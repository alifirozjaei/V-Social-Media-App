<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>V-SocialMedia</title>

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{"/favicon2.ico"}}" type="image/x-icon">

    <script>
        @auth
            window.user = {
                name: '{{auth("sanctum")->user()->name}}',
                username: '{{auth("sanctum")->user()->username}}',
                isVerified: '{{ auth('sanctum')->user()->email_verified_at == null ? 1 :2 }}',
                id:'{{auth("sanctum")->user()->id}}',
                profile_src:'{{auth("sanctum")->user()->profile_src}}',
            }
        @endauth
    </script>

    <script>
        window.csrf_token = '{{ csrf_token() }}'
    </script>

</head>

<body >
    <div id="app">
        <v-app>
            <router-view :key='$route.fullPath'></router-view>
        </v-app>
    </div>
    <script src="{{ asset('js/app.js') }}">
    </script>

</body>

</html>
