@extends('layouts.main')

@section('title'){{ config('app.name') }} @stop

@section('content')
    <div class="header-wrapper">
        <header class="header">
            <div class="header__container index-main-container">
                <div class="header-logo__wrapper">
                    <img class="header-logo__img" src="images/img/index-main/logo-3.png">
                    <span class="header-logo__slogan">Dedicated to Primary Health Care</span>
                </div><!-- .header-logo__wrapper -->

                <div class="header-navigation">
                    <a class="header-navigation__menu-item" href="{{ url('/') }}">START BROWSING ADHOC STAFF</a>
                    <a class="header-navigation__menu-item" href="{{ url('/page/how-it-works') }}">FIND TEMPORARY SHORT TERM WORK</a>
                    <a class="header-navigation__menu-item" href="{{ url('/page/main') }}">FAQs</a>
                    <a class="header-navigation__menu-item" href="{{ url('/contact-us') }}">FCONTACT US<br>FOR INFORMATION</a>
                </div>

            </div><!-- .header__container -->
        </header>

        <section class="hero">
            <div class="header__container hero__container">
                <div class="hero__wrapper">
                    <h1 class="hero__title">Connecting Primary Health Care professionals with the adhoc &amp; temp staff they need, when they need them</h1>
                    <div class="hero__experience">10 years professional clinical experience surgeries and healthcare stackeholders with adhoc and temporary staffing solutions.</div>
                    <div class="hero__buttons">
                        <a href="{{ url('/login') }}"><button class="hero__buttons-login">Log In</button></a>
                        <a href="{{ url('/register') }}" class="hero__buttons-signup-link"><button class="hero__buttons-signup">Sign Up</button></a>
                    </div>
                </div><!-- .hero__wrapper -->
            </div><!-- .hero__container -->
        </section><!-- .hero -->

    </div>



@endsection