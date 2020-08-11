<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <li class="nav-item">
            <a class="{{{ \Request::route()->getName()==='supportProfile'? 'active': '' }}}" href="{{{ route('supportProfile') }}}">{{{ trans('lang.profile_detail') }}}</a>
        </li>
        {{--<li class="nav-item">--}}
            {{--<a class="{{{ \Request::route()->getName()==='experienceEducation'? 'active': '' }}}" href="{{{ route('experienceEducation') }}}">{{{ trans('lang.experience_education') }}}</a>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a class="{{{ \Request::route()->getName()==='bookingAndAvailability'? 'active': '' }}}" href="{{{ route('bookingAndAvailability') }}}">Availability</a>--}}
        {{--</li>--}}
        <li class="nav-item">
            <a class="{{{ \Request::route()->getName()==='resetPassword'? 'active': '' }}}" href="{{{ route('resetPassword', ['role' => 'support']) }}}">{{{ trans('lang.reset_pass') }}}</a>
        </li>
    </ul>
</div>
