@if (Schema::hasTable('pages') || Schema::hasTable('site_managements'))
    @php
        $settings = array();
        $pages = App\Page::all();
        $setting = \App\SiteManagement::getMetaValue('settings');
        $logo = !empty($setting[0]['logo']) ? Helper::getHeaderLogo($setting[0]['logo']) : '/images/logo.png';
        $inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
        $type = Helper::getAccessType();
        if(Auth::user())
        {
            $user_role_type = \App\User::getUserRoleType(Auth::user()->id);
            $user_role = $user_role_type->role_type;
        }


    @endphp
@endif
<header id="wt-header" class="wt-header wt-haslayout {{$inner_header}}">
        <div class="container-fluid headernew" >
           <!-- <div class="row " >
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <ul id="newmenu"  class="list-unstyled" style="list-style: none;">
                        <li><a href="{{url('/')}}" class="active-menu-li">Home</a></li>
                        <li><a href="{{url('page/how-it-works')}}">About us</a></li>
                        <li><a href="">Search</a></li>
                        <li><a href="">Users</a></li>
                        <li><a href="{{{ Auth::user() ? url($user_role.'/dashboard') : url('register')}}}">{{Auth::user() ? "Dashboard" : "Join us"}}</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>

                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 telno" >
                    <span>Email:info@staffbackup.co.uk</span>
                </div>
            </div>-->
            <div class="row">

                <div class="headingcenter text-center">
                        <img src="images/newlogo.png"/>
                    <h2>We connect professionals<br> with the people who need them most</h2>
                    <div>10 years professional clinical experience</div>
                </div>

            </div>
        </div>

</header>
