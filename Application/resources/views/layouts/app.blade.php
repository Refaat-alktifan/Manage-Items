<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/components/table.min.css" />

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="color fa fa-archive"></i>    {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                      @if (!Auth::guest())
    <div class="search-bar">

 <form class="navbar-form navbar-left" method="POST" action="{{ url('search') }}">
 {{ csrf_field() }}
        <div class="form-group">
          <input type="text" class="form-control" name="search" placeholder="Item ID" style="border-radius: 25px;width: 298px;" autofocus="">
        </div>
       </form>
    </div>
                      @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                               <li><a href="{{ url('/') }}">Open Item</a></li>
                               <li><a href="{{ url('view') }}">View Item</a></li>
                        @else
                             <li><a href="{{ url('home') }}">home</a></li>
                             <li><a href="{{ url('manage/items') }}">Items</a></li>

                            @if (Auth::user()->is_admin == "1")

                             <li><a href="{{ url('manage/settings') }}">Settings</a></li>
                             <li><a href="{{ url('manage/user') }}">Staffs</a></li>
                            @endif

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('profile') }}">Profile</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

<div class="margin-20t"></div>
<hr>
     <div class="footer container">
© {{ date('Y') }} {{ config('app.name', 'Laravel') }} | All Rights Reserved.

</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/davidshimjs-qrcodejs@0.0.2/qrcode.min.js"></script>

    <script>
        {{--const qrcode = new QRCode(document.getElementById('qrcode'), {--}}
        {{--    text: '{{ url('/item/')}}{{ $item->tid }}',--}}
        {{--    width: 128,--}}
        {{--    height: 128,--}}
        {{--    colorDark : '#000',--}}
        {{--    colorLight : '#fff',--}}
        {{--    correctLevel : QRCode.CorrectLevel.H--}}
        {{--});--}}

        // QR code
        const makeQR = (url, filename) => {
            var qrcode = new QRCode("qrcode", {
                text: document.querySelector('#text').value,
                width: 128,
                height: 128,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            qrcode.makeCode(url);

            setTimeout(() => {
                let qelem = document.querySelector('#qrcode img')
                let dlink = document.querySelector('#qrdl')
                let qr = qelem.getAttribute('src');
                dlink.setAttribute('href', qr);
                dlink.setAttribute('download', 'filename');
                dlink.removeAttribute('hidden');
            }, 500);
        }
        makeQR(document.querySelector('#text').value, 'qr-code.png')
    </script>
    @include('flashy::message')
</body>
</html>
