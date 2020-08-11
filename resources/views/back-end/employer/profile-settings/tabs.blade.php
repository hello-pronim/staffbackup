<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <li class="nav-item">
            <a class="{{{ \Request::route()->getName()==='personalDetail'? 'active': '' }}}" href="{{{ route('employerPersonalDetail') }}}">{{{ trans('lang.profile_detail') }}}</a>
        </li>
        {{--<li class="nav-item">--}}
            {{--<a class="{{{ \Request::route()->getName()==='employer_availability'? 'active': '' }}}" href="{{{ route('employerAvailability') }}}">Availability</a>--}}
        {{--</li>--}}
        <li class="nav-item">
            <a class="{{{ \Request::route()->getName()==='resetPassword'? 'active': '' }}}" href="{{{ route('resetPassword', ['role' => 'employer']) }}}">{{{ trans('lang.reset_pass') }}}</a>
        </li>
    </ul>
</div>