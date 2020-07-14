<div class="short-header-wrapper header-wrapper">
    <header class="header">
        <div class="header__container index-main-container">
            <div class="header-logo">
                <a href="{{ url('/') }}">
                    <div class="header-logo__wrapper">
                        <img class="header-logo__img" src="/images/img/index-main/logo-3.png" alt="{{ trans('lang.site_logo') }}">
                        <span class="header-logo__slogan">Dedicated to Primary Health Care</span>
                    </div><!-- .header-logo__wrapper -->
                </a>
            </div>

            <div class="header-navigation">
                <div class="header-navigation__menu-item-wrapper">
                    <a class="header-navigation__menu-item" href="{{ url('/') }}">START BROWSING ADHOC STAFF</a>
                </div>
                <div class="header-navigation__menu-item-wrapper">
                    <a class="header-navigation__menu-item" href="{{ url('/page/how-it-works') }}">FIND TEMPORARY SHORT TERM WORK</a>
                </div>
                <div class="header-navigation__menu-item-wrapper">
                    <a class="header-navigation__menu-item" href="{{ url('/page/main') }}">FAQs</a>
                </div>
                <div class="header-navigation__menu-item-wrapper">
                    <a class="header-navigation__menu-item" href="{{ url('/contact-us') }}">CONTACT US FOR INFORMATION</a>
                </div>
            </div>

            @if(!\Auth::User())
                <div class="header__buttons">
                    <a href="{{ route('register') }}"><button class="hero__buttons-left">Sign In</button></a>
                    <a href="{{ route('register') }}" class="hero__buttons-right-link"><button class="hero__buttons-right">{{ trans('lang.join_now') }}</button></a>
                </div>
            @endif

        </div><!-- .header__container -->
    </header>

    <section class="hero">
        <div class="header__container hero__container">
            <div class="hero__wrapper">
                <h1 class="hero__title">Adhoc and temp staff are just a new steps away...</h1>
            </div><!-- .hero__wrapper -->
            @if(!\Auth::User())
                <div class="hero__buttons">
                    <a href="{{ route('register') }}"><button class="hero__buttons-left">Sign In</button></a>
                    <a href="{{ route('register') }}" class="hero__buttons-right-link"><button class="hero__buttons-right">{{ trans('lang.join_now') }}</button></a>
                </div>
            @endif
        </div><!-- .hero__container -->
    </section><!-- .hero -->

    <div class="header__container header-navigation header-sm-navigation">
        <div class="header-navigation__menu-item-wrapper header-navigation__menu-item-wrapper-without-border">
            <a class="header-navigation__menu-item" href="{{ url('/') }}">START BROWSING ADHOC STAFF</a>
        </div>
        <div class="header-navigation__menu-item-wrapper">
            <a class="header-navigation__menu-item" href="{{ url('/page/how-it-works') }}">FIND TEMPORARY SHORT TERM WORK</a>
        </div>
        <div class="header-navigation__menu-item-wrapper">
            <a class="header-navigation__menu-item" href="{{ url('/page/main') }}">FAQs</a>
        </div>
        <div class="header-navigation__menu-item-wrapper">
            <a class="header-navigation__menu-item" href="{{ url('/contact-us') }}">FCONTACT US FOR INFORMATION</a>
        </div>
    </div>
</div>

@if (!\Request::is('register'))
    @include('components.header.header-navbar')
@endif