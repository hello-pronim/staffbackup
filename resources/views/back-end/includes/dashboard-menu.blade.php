@auth
    <div id="wt-sidebarwrapper" class="wt-sidebarwrapper">
        <div id="wt-btnmenutoggle" class="wt-btnmenutoggle">
            <span class="menu-icon">
                <em></em>
                <em></em>
                <em></em>
            </span>
        </div>
        @php
            $user = !empty(Auth::user()) ? Auth::user() : '';
            $role = !empty($user) ? $user->getRoleNames()->first() : array();
            $profile = \App\User::find($user->id)->profile;
            $setting = \App\SiteManagement::getMetaValue('footer_settings');
            $payment_settings = \App\SiteManagement::getMetaValue('commision');
            $payment_module = !empty($payment_settings) && !empty($payment_settings[0]['enable_packages']) ? $payment_settings[0]['enable_packages'] : 'true';
            $employer_payment_module = !empty($payment_settings) && !empty($payment_settings[0]['employer_package']) ? $payment_settings[0]['employer_package'] : 'true';
            $copyright = !empty($setting) ? $setting['copyright'] : 'StaffBackup All Rights Reserved';
        @endphp
        <div id="wt-verticalscrollbar" class="wt-verticalscrollbar">
            <div class="wt-companysdetails wt-usersidebar">
                {{--<figure class="wt-companysimg">--}}
                    {{--<img src="{{{ asset(Helper::getUserProfileBanner($user->id, 'small')) }}}" alt="{{{ trans('lang.profile_banner') }}}">--}}
                {{--</figure>--}}
                <div class="wt-companysinfo" style="{{ (!isset($violetLayoutClasses)  || empty($violetLayoutClasses)) ? 'margin-top: 110px;' : '' }}">


                    @if ($role === 'employer')
                        @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'jobs')
                            <div class="wt-btnarea mb-10" style="float:none"><a href="{{{ url(route('showUserProfile', ['slug' => Auth::user()->slug])) }}}" class="wt-btn">{{{ trans('lang.view_profile') }}}</a></div>
                            <div class="wt-btnarea mb-10" style="float:none"><a href="{{{ url(route('employerPostJob')) }}}" class="wt-btn">{{{ trans('lang.post_job') }}}</a></div>
                        @else
                            <div class="wt-btnarea" style="float:none"><a href="{{{ url(route('showUserProfile', ['slug' => Auth::user()->slug])) }}}" class="wt-btn">{{{ trans('lang.view_profile') }}}</a></div>
                        @endif
                    @elseif ($role === 'freelancer')
                        @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services')
                            <div class="wt-btnarea" style="float:none"><a href="{{{ url(route('freelancerPostService')) }}}" class="wt-btn">{{{ trans('lang.post_service') }}}</a></div>
                        @else
                            <div class="wt-btnarea" style="float:none"><a href="{{{ url(route('showUserProfile', ['slug' => Auth::user()->slug])) }}}" class="wt-btn">{{{ trans('lang.view_profile') }}}</a></div>
                        @endif
                    @elseif ($role === 'support')
                        @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services')
                            <div class="wt-btnarea" style="float:none"><a href="{{{ url(route('freelancerPostService')) }}}" class="wt-btn">{{{ trans('lang.post_service') }}}</a></div>
                        @else
                            <div class="wt-btnarea" style="float:none"><a href="{{{ url(route('showUserProfile', ['slug' => Auth::user()->slug])) }}}" class="wt-btn">{{{ trans('lang.view_profile') }}}</a></div>
                        @endif
                    @endif
                    <figure><img src="{{{ asset(Helper::getProfileImageSmall($user->id)) }}}" alt="{{{ trans('lang.profile_photo') }}}"></figure>

                    <div class="wt-title">
                        <h2>
                            <a href="{{{ $role != 'admin' ? url($role.'/dashboard') : 'javascript:void()' }}}">
                                {{{ !empty(Auth::user()) ? html_entity_decode(Helper::getUserName(Auth::user()->id), ENT_QUOTES) : 'No Name' }}}
                            </a>
                        </h2>
                        <span style="font-family: AganeBold">{{{ !empty(Auth::user()->profile->tagline) ? str_limit(html_entity_decode(Auth::user()->profile->tagline, ENT_QUOTES), 26, '') :  Helper::getAuthRoleName() }}}</span><br>
                        <span style="font-family: AganeLight">{{{ !empty(Auth::user()->city) ? str_limit(Auth::user()->city, 26, '') : "" }}}</span>
                    </div>

                </div>
            </div>

            <div class="orangeline"></div>
            <nav id="wt-navdashboard" class="wt-navdashboard">
                <div style="width:80%;border-bottom:1px solid white;margin:0 auto 30px auto"></div>
                <ul>
                    @if ($role === 'admin' || $role === 'super-admin')
                        <li>
                            <a href="{{{ url($role.'/dashboard') }}}">
                                <i class="ti-desktop"></i>
                                <span>{{ trans('lang.dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('userListing') }}}">
                                <i class="ti-user"></i>
                                <span>{{ trans('lang.manage_users') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('allJobs') }}}">
                                <i class="ti-briefcase"></i>
                                <span>{{ trans('lang.manage_jobs') }}</span>
                            </a>
                        </li>
                        @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services')
                            <li>
                                <a href="{{{ route('allServices') }}}">
                                    <i class="ti-briefcase"></i>
                                    <span>{{ trans('lang.services') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{{ route('ServiceOrders') }}}">
                                    <i class="ti-briefcase"></i>
                                    <span>{{ trans('lang.service_orders') }}</span>
                                </a>
                            </li>
                        @endif
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-pulse"></i>
                                <span>{{ trans('lang.analytics') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{ route('allPayments') }}">{{ trans('lang.all_payments') }}</a></li>
                                <li><hr><a href="{{ route('monthlyUsers') }}">{{ trans('lang.total_users_by_month') }}</a></li>
                                <li><hr><a href="{{ route('growthActivity') }}">{{ trans('lang.growth_activity') }}</a></li>
                                <li><hr><a href="{{ route('internationalLocations') }}">{{ trans('lang.international_use_locations') }}</a></li>
                                <li><hr><a href="{{ route('popularFreelancers') }}">{{ trans('lang.popular_freelancers_chosen') }}</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{{ route('message') }}}">
                                <i class="ti-comment"></i>
                                <span>{{ trans('lang.messages') }}</span>
                            </a>
                        </li>
                        @if($role === 'super-admin')
                        <li>
                            <a href="{{{ route('reviewOptions') }}}">
                                <i class="ti-check-box"></i>
                                <span>{{ trans('lang.review_options') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{{ route('emailTemplates') }}}">
                                <i class="ti-email"></i>
                                <span>{{ trans('lang.email_templates') }}</span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span>{{ trans('lang.pages') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('pages') }}}">{{ trans('lang.all_pages') }}</a></li>
                                <li><hr><a href="{{{ route('createPage') }}}">{{ trans('lang.add_pages') }}</a></li>

                            </ul>
                        </li>
                           {{-- <li>
                                <a href="{{{ route('createPackage') }}}">
                                    <i class="ti-package"></i>
                                    <span>{{ trans('lang.packages') }}</span>
                                </a>
                            </li>--}}
                       {{-- <li>
                            <a href="{{{ route('adminPayoufts') }}}">
                                <i class="ti-money"></i>
                                <span>{{ trans('lang.payouts') }}</span>
                            </a>
                        </li>--}}
                        <li>
                            <a href="{{{ route('homePageSettings') }}}">
                                <i class="ti-home"></i>
                                <span>{{ trans('lang.home_page_settings') }}</span>
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i>
                                <span>{{ trans('lang.settings') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('adminProfile') }}}">{{ trans('lang.acc_settings') }}</a></li>
                                <li><hr><a href="{{{ url('admin/settings') }}}">{{ trans('lang.general_settings') }}</a></li>
                                <li><hr><a href="{{{ route('resetPassword') }}}">{{ trans('lang.reset_pass') }}</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                            <a href="javascript:void(0)">
                                <i class="ti-layers"></i>
                                <span>{{ trans('lang.taxonomies') }}</span>
                            </a>
                            <ul class="sub-menu">
                                <li><hr><a href="{{{ route('skills') }}}">{{ trans('lang.skills') }}</a></li>
                                <li><hr><a href="{{{ route('categories') }}}">{{ trans('lang.job_cats') }}</a></li>
                                <li><hr><a href="{{{ route('departments') }}}">{{ trans('lang.dpts') }}</a></li>
                                <li><hr><a href="{{{ route('languages') }}}">{{ trans('lang.langs') }}</a></li>
                                <li><hr><a href="{{{ route('locations') }}}">{{ trans('lang.locations') }}</a></li>
                                <li><hr><a href="{{{ route('badges') }}}">{{ trans('lang.badges') }}</a></li>
                                <li><a href="{{{ route('deliveryTime') }}}">{{ trans('lang.delivery_time') }}</a></li>
                                <li><a href="{{{ route('ResponseTime') }}}">{{ trans('lang.response_time') }}</a></li>
                            </ul>
                        </li>
                        @endif
                    @endif
                    @if ($role === 'employer' || $role === 'freelancer'  || $role === 'support' )
                            <li>
                                <img src="{{url('images/icons/leftmenu/Layer 67.png')}}"/>

                                <a href="{{{ url($role.'/dashboard') }}}">
                                    <span>{{ trans('lang.dashboard') }}</span>
                                </a>
                            </li>
                        <li>
                            <img src="{{url('images/icons/leftmenu/staffbackup-web-design.004.svg')}}"/>

                            <a  href="{{{ url($role.'/profile') }}}">{{ trans('lang.profile_settings') }}</a>

                        </li>

                        @if($role=='employer')
                                @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'jobs')
                                    <li class="menu-item-has-children">
                                        <img src="{{url('images/icons/leftmenu/Layer 59.png')}}"/>

                                        <a href="javascript:void(0)">
                                            <span>{{ trans('lang.jobs') }}</span>
                                        </a>

                                        <ul class="sub-menu">
                                            <li><a href="{{{ url(route('employerPostJob')) }}}">{{ trans('lang.post_job') }}</a></li>
                                            <li><a href="{{{ route('employerManageJobs') }}}">{{ trans('lang.manage_job') }}</a></li>
                                        </ul>
                                    </li>
                                @endif
                            <li class="menu-item-has-children">
                                <a href="javascript:void(0)">
                                    <i class="ti-list"></i>
                                    <span>Teams</span>
                                </a>
                                <ul class="sub-menu">
                                    <li><a href="{{{ route('createEmployerTeam') }}}">{{ trans('lang.create_team') }}</a></li>
                                    <li><a href="{{{ route('manageEmployerTeams') }}}">{{ trans('lang.manage_teams') }}</a></li>
                                </ul>
                            </li>
                        @endif
                            <li>
                                <img src="{{url('images/icons/leftmenu/Layer 63.png')}}"/>

                                <a href="{{{ route('message') }}}">
                                    <span>Messages</span>
                                </a>
                            </li>
                            <li>
                                <img  style="width: 12px;" src="{{url('images/icons/leftmenu/Layer 55.png')}}"/>

                                <a style="margin-left: 3px;" href="{{{ route('manageAccount') }}}">{{ trans('lang.acc_settings') }}</a>
                            </li>

                            @if($role=='employer')
                                <!-- <li>
                                    <img src="{{url('images/icons/leftmenu/Layer 71.png')}}"/>

                                    <a href="{{{ url($role.'/billing') }}}">
                                        <span>Billing</span>
                                    </a>
                                </li> -->
                            @endif
                            {{--<li>--}}
                                {{--<img src="{{url('images/icons/leftmenu/Layer 75.png')}}"/>--}}

                                {{--<a href="{{{ url($role.'/notifications') }}}">--}}
                                    {{--<span>Notifications</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            @if ($role === 'employer')

                            @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services')
                                <li class="menu-item-has-children">
                                    <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                    <a href="javascript:void(0)">
                                        <i class="ti-briefcase"></i>
                                        <span>{{ trans('lang.manage_services') }}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><hr><a href="{{{ url('employer/services/hired') }}}">{{ trans('lang.ongoing_services') }}</a></li>
                                        <li><hr><a href="{{{ url('employer/services/completed') }}}">{{ trans('lang.completed_services') }}</a></li>
                                        <li><hr><a href="{{{ url('employer/services/cancelled') }}}">{{ trans('lang.cancelled_services') }}</a></li>
                                    </ul>
                                </li>
                            @endif
                           {{-- <li>
                                <a href="{{{ route('employerPayoutsSettings') }}}">
                                    <i class="ti-money"></i>
                                    <span> {{ trans('lang.payouts') }}</span>
                                </a>
                            </li>--}}
                           {{-- <li class="menu-item-has-children">
                                <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                <a href="javascript:void(0)">
                                    <i class="ti-file"></i>
                                    <span>{{ trans('lang.invoices') }}</span>
                                </a>
                                <ul class="sub-menu">
                                    @if ($employer_payment_module === 'true' )
                                        <li><hr><a href="{{{ url('employer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                                    @endif
                                    <li><hr><a href="{{{ url('employer/project/invoice') }}}">{{ trans('lang.project_inv') }}</a></li>
                                </ul>
                            </li>--}}
                            @if ($employer_payment_module === 'true' )
                               {{-- <li>
                                    <a href="{{{ url('dashboard/packages/'.$role) }}}">
                                        <i class="ti-package"></i>
                                        <span>{{ trans('lang.packages') }}</span>
                                    </a>
                                </li>--}}
                            @endif
                        @elseif ($role === 'support')
                            <li>
                                <a href="{{route('supportJobsByStatus', ['status'=>'hired'])}}">
                                    <i class="ti-briefcase"></i>
                                    <span>{{ trans('lang.manage_jobs') }}</span>
                                </a>
                                <!-- <ul class="sub-menu">
                                    <li><a href="{{{ url('support/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                                    <li><a href="{{{ url('support/jobs/cancelled') }}}">{{ trans('lang.cancelled_projects') }}</a></li>
                                    <li><a href="{{{ url('support/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                                </ul> -->
                            </li>
                        @elseif ($role === 'freelancer')
                            <li>
                                <a href="{{route('freelancerJobsByStatus', ['status'=>'hired'])}}">
                                    <i class="ti-briefcase"></i>
                                    <span>{{ trans('lang.manage_jobs') }}</span>
                                </a>
                                <!-- <ul class="sub-menu">
                                    <li><a href="{{{ url('freelancer/jobs/completed') }}}">{{ trans('lang.completed_projects') }}</a></li>
                                    <li><a href="{{{ url('freelancer/jobs/cancelled') }}}">{{ trans('lang.cancelled_projects') }}</a></li>
                                    <li><a href="{{{ url('freelancer/jobs/hired') }}}">{{ trans('lang.ongoing_projects') }}</a></li>
                                </ul> -->
                            </li>

                            @if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services')
                                <li class="menu-item-has-children">
                                    <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                    <a href="javascript:void(0)">
                                        <i class="ti-briefcase"></i>
                                        <span>{{ trans('lang.manage_services') }}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><hr><a href="{{{ route('ServiceListing', ['status'=>'posted']) }}}">{{ trans('lang.posted_services') }}</a></li>
                                        <li><hr><a href="{{{ route('ServiceListing', ['status'=>'hired']) }}}">{{ trans('lang.ongoing_services') }}</a></li>
                                        <li><hr><a href="{{{ route('ServiceListing', ['status'=>'completed']) }}}">{{ trans('lang.completed_services') }}</a></li>
                                        <li><hr><a href="{{{ route('ServiceListing', ['status'=>'cancelled']) }}}">{{ trans('lang.cancelled_services') }}</a></li>
                                    </ul>
                                </li>
                            @endif
                            {{--<li>--}}
                                {{--<a href="{{{ route('showFreelancerProposals') }}}">--}}
                                    {{--<i class="ti-bookmark-alt"></i>--}}
                                    {{--<span> {{ trans('lang.proposals') }}</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                           {{-- <li>
                                <a href="{{{ route('FreelancerPayoutsSettings') }}}">
                                    <i class="ti-money"></i>
                                    <span> {{ trans('lang.payouts') }}</span>
                                </a>
                            </li>--}}
                            @if ($payment_module === 'true' )
                              {{--  <li class="menu-item-has-children">
                                    <span class="wt-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
                                    <a href="javascript:void(0)">
                                        <i class="ti-file"></i>
                                        <span>{{ trans('lang.invoices') }}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><hr><a href="{{{ url('freelancer/package/invoice') }}}">{{ trans('lang.pkg_inv') }}</a></li>
                                    </ul>
                                </li>--}}
                              {{--  <li>
                                    <a href="{{{ url('dashboard/packages/'.$role) }}}">
                                        <i class="ti-package"></i>
                                        <span>{{ trans('lang.packages') }}</span>
                                    </a>
                                </li>--}}
                            @endif
                        @endif
                        {{--<li>--}}
                            {{--<a href="{{{ url($role.'/saved-items') }}}">--}}
                                {{--<i class="ti-heart"></i>--}}
                                {{--<span>{{ trans('lang.saved_items') }}</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    @endif
                    <li>

                        <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>

            </nav>


            <div class="wt-navdashboard-footer" style="margin-top: 30px;margin-left: 73px;">
                <a style="color:gray;font-family: AganeBold; font-size: 13px" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                    {{{trans('lang.logout')}}}
                </a>
                <br>
                <a href="{{ url('contact-us') }}">Contact Us</a>
                {{--<span class="version-area">{{ config('app.version') }}</span>--}}
            </div>
            <div class="orangeline" style="margin-top: 25px"></div>

            <div style="margin-top: 20px; float: left;margin-left: 25px;font-size: 12px;text-align: center;padding: 0px 24px; margin-bottom: 80px;">
                <span>{{{ $copyright }}}</span>
            </div>
        </div>
    </div>
@endauth
