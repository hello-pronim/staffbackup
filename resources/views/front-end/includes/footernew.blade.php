@if( Schema::hasTable('site_managements'))
    @php
        $footer = \App\SiteManagement::getMetaValue('footer_settings');
        $search_menu = \App\SiteManagement::getMetaValue('search_menu');
        $menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
    @endphp
    <footer id="wt-footer">
        <div class="row">
        <div class="footerCopyright col-md-5">
            COPYRIGHT © STAFF BACKUP LTD 2019, ALL RIGHTS RESERVED
        </div>
            </div>

    </footer>
@endif
