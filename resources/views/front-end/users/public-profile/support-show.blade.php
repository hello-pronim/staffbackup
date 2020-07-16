@extends('front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
<link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{ $user_name }} | {{ $tagline }} @stop
@section('description', "$desc")
@section('content')
    <div class="content-public-profile">
        <div class="content-public-profile__wrapper">
            <section class="block-circles">
                <div class="block-circles__container">
                    <div class="block-circles__wrapper">
                        <div class="block-circles__item block-circles__item-cyan"></div>
                        <div class="block-circles__item block-circles__item-blue"></div>
                        <div class="block-circles__item block-circles__item-yellow"></div>
                    </div>
                </div>
            </section><!-- .circles -->

            <section class="content-public-profile__main-content">
                <div class="content-public-profile__main-content-wrapper">
                    <div class="content-public-profile__main-content-left">
                        <img class="content-public-profile__main-content-avatar" src="/images/user.jpg" alt="avatar">
                        <h2 class="content-public-profile__main-content-name mbottom35">Christine</h2>
                        <h4 class="content-public-profile__main-content-slag mbottom35">@christine-updated</h4>
                        <div class="content-public-profile__main-content-text-block mbottom35">
                            <span class="content-public-profile__main-content-title">Profession:</span> Doctor
                        </div>
                        <div class="content-public-profile__main-content-separator content-public-profile__main-content-separator-blue"></div>
                        <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                            <span class="content-public-profile__main-content-title">Availability:</span> Doctor
                        </div>
                        <div class="content-public-profile__main-content-separator content-public-profile__main-content-separator-blue"></div>
                    </div>
                    <div class="content-public-profile__main-content-right">
                        text right
                    </div>
                </div>
            </section>

            <section class="block-circles">
                <div class="block-circles__container block-circles__container-last">
                    <div class="block-circles__wrapper">
                        <div class="block-circles__item block-circles__item-blue"></div>
                        <div class="block-circles__item block-circles__item-blue"></div>
                        <div class="block-circles__item block-circles__item-blue"></div>
                    </div>
                </div>
            </section><!-- .circles -->
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('js/readmore.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/countTo.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/appear.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    /* FREELANCERS SLIDER */
    var _wt_freelancerslider = jQuery('.wt-freelancerslider')
    _wt_freelancerslider.owlCarousel({
        items: 1,
        loop:true,
        nav:true,
        margin: 0,
        autoplay:false,
        navClass: ['wt-prev', 'wt-next'],
        navContainerClass: 'wt-search-slider-nav',
        navText: ['<span class="lnr lnr-chevron-left"></span>', '<span class="lnr lnr-chevron-right"></span>'],
    });

    var _readmore = jQuery('.wt-userdetails .wt-description');
    _readmore.readmore({
        speed: 500,
        collapsedHeight: 230,
        moreLink: '<a class="wt-btntext" href="#">'+readmore_trans+'</a>',
        lessLink: '<a class="wt-btntext" href="#">'+less_trans+'</a>',
    });
    $('#wt-ourskill').appear(function () {
        jQuery('.wt-skillholder').each(function () {
            jQuery(this).find('.wt-skillbar').animate({
                width: jQuery(this).attr('data-percent')
            }, 2500);
        });
    });
    var popupMeta = {
        width: 400,
        height: 400
    }
    $(document).on('click', '.social-share', function(event){
        event.preventDefault();

        var vPosition = Math.floor(($(window).width() - popupMeta.width) / 2),
            hPosition = Math.floor(($(window).height() - popupMeta.height) / 2);

        var url = $(this).attr('href');
        var popup = window.open(url, 'Social Share',
            'width='+popupMeta.width+',height='+popupMeta.height+
            ',left='+vPosition+',top='+hPosition+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            return false;
        }
    });
</script>
@endpush
