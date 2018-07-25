<style type="text/css">
    @font-face {
        font-family: header;
        src: url('{{ public_path('fonts/Avenida.tff') }}');
    }
</style>

<header class="header row">
    <div class="col-sm-4 col-md-6 col-lg-6">
        <div class="header__left">
            <span class="header__left__logo"><a href="{{ url('/') }}">The Animation Library</a></span>
        </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4">
        <div class="header__right">
            <nav class="header__right__nav">
                <a href="{{ url("webshop") }}">Shop</a>
                <a href="#">Freebies</a>
                <a href="#">Tips & Tricks</a>
                <a href="#">Contact</a>
            </nav>

        </div>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2">
        <div class="header__cart">
                @yield('aimeos_head')
            </div>
    </div>
</header>


