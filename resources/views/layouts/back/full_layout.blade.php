<html>

    {{-- head inclusion--}}
    <head>
        @include('layouts.back.partials.head')
    </head>

    @include('layouts.common.partials.javascript')

    {{-- body inclusion--}}
    <body id="top">

        <div id="layout" class="container-fluid">

            {{-- no script specifications --}}
            <noscript>
                <div class="container-fluid noscript text-muted">
                    <div class="col-lg-offset-2 col-lg-8">
                        <h3>
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                            Attention
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                        </h3>
                        Le Javascript de votre navigateur est désactivé et vous naviguez actuellement en version dégradée.<br/>
                        Merci de réactiver votre Javascript pour bénéficier de l'ensemble des fonctionnalités de l'application.
                    </div>
                </div>
            </noscript>

            {{-- header inclusion --}}
            @include('layouts.back.partials.header')

            {{-- nav inclusion --}}
            @include('layouts.back.partials.nav')

            {{-- content inclusion --}}
            @yield('content')

            {{-- footer inclusion --}}
            @include('layouts.back.partials.footer')

            {{-- alerts management --}}
            @if(\Session::get('alert'))
                @include('layouts.common.modal.alert')
            @endif

        </div>

    </body>

    {{-- end file inclusion --}}
    @include('layouts.back.partials.end')

</html>