<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta name="_token" content="{{ @csrf_token() }}" >
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JADBudget</title>
        <link rel="icon" href="{{asset('storage/logoJAD.png')}}">
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="{{ mix('js/JADBudgetV2/master.js') }}" defer></script>
        @yield('style')
        @yield('script')
    </head>
    <body>
        <div id="header"></div>
        @yield('content')
        <div id="toastField"></div>
    </body>
</html>