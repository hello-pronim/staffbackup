@if (Schema::hasTable('pages') || Schema::hasTable('site_managements'))
    @php
        $settings = array();
        $pages = App\Page::all();
        $setting = \App\SiteManagement::getMetaValue('settings');
        $logo = !empty($setting[0]['logo']) ? Helper::getHeaderLogo($setting[0]['logo']) : '/images/logo.png';
        $inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
        $type = Helper::getAccessType();
    @endphp
@endif
<header id="wt-header" class="wt-header wt-haslayout {{$inner_header}}">
        <div class="container-fluid headernew" >
            <div class="row " >
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <ul id="newmenu"  class="list-unstyled" style="list-style: none;">
                        <li><a href="{{url('/')}}" class="active-menu-li">Home</a></li>
                        <li><a href="{{url('page/how-it-works')}}">About us</a></li>
                        <li><a href="">Search</a></li>
                        <li><a href="">Users</a></li>
                        <li><a href="{{url('register')}}">Join us</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>

                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 telno" >
                    <span>Call:03450 300 811</span>
                </div>
            </div>
            <div class="row">

                <div class="headingcenter text-center">
                        <img src="images/newlogo.png"/>
                    <h2>We connect professionals<br> with the people who need them most</h2>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-8">10 years professional clinical experience</div>
                </div>

            </div>
        </div>

</header>
