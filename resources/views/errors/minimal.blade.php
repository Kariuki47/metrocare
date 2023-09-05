<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dashlite.css') }}">

</head>

<body class="antialiased nk-body bg-white npc-general pg-error no-touch nk-nio-theme">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle wide-xs mx-auto">
                        <div class="nk-block-content nk-error-ld text-center">
                            <h1 class="nk-error-head">@yield('code')</h1>
                            <h3 class="nk-error-title">@yield('title')</h3>
                            <p class="nk-error-text">@yield('message')</p>
                            <a href="{{ url('/') }}" class="btn btn-lg btn-primary mt-2">Back To Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>