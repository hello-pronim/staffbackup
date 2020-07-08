@if( Schema::hasTable('site_managements'))
    @php
        $footer = \App\SiteManagement::getMetaValue('footer_settings');
        $search_menu = \App\SiteManagement::getMetaValue('search_menu');
        $menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
    @endphp
    <div id="homenew" class="la-home-page" >
        <div style="text-align: center;margin-top: 400px;margin-bottom: 0;">
            <div class="boxes3 bg-orange">
                <div class="boxheading">Locate</div>
                <img src="{{url('images/icons/Layer 89.png')}}">
                <p>
                    Search staff using loactions that suit you, actually need.
                </p>
            </div>
            <div class="boxes3 bg-blue" style="height: 270px;padding-top: 50px;">
                <div class="boxheading">Book</div>
                <img src="{{url('images/icons/Layer 84.png')}}">
                <p>
                    Search staff using loactions that suit you, actually need.
                </p>
            </div>
            <div class="boxes3 bg-green">
                <div class="boxheading">Staff</div>
                <img src="{{url('images/icons/Layer 79.png')}}">
                <p>
                    Search staff using loactions that suit you, actually need.
                </p>
            </div>
        </div>

    </div>
    <footer id="wt-footer">
        <div class="row">
            <div class="footerCopyright col-md-5" style="    padding-top: 53px;">
                COPYRIGHT © STAFF BACKUP LTD 2019, ALL RIGHTS RESERVED
            </div>
        </div>
        <ul class="socialIcons">
            <li style="list-style: none;">
                <a href="#" class="facebook_icon"><img src="{{url('images/facebook.png')}}"/></a>
                <a href="#" class="linkedin_icon"><img src="{{url('images/linkedin.png')}}"/></a>
                <a href="#" class="twitter_icon"><img src="{{url('images/twitter.png')}}"/></a>
                <a href="#" class="envelope_icon"><img src="{{url('images/envelope.png')}}"/></a>
            </li>
        </ul>

    </footer>

@endif
