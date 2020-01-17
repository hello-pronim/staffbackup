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
<header class="wt-header wt-haslayout {{$inner_header}}">
        <div class="container-fluid headernew" >
            <div class="row " >
                <img style="margin: 31px;" src="images/logo2.png"/>
                <div class="mainhomeMenu">
                    <ul id="newmenu"  class="list-unstyled" style="list-style: none;">
                        <li><a href="{{url('/')}}">START BROWSING ADHOC STAFF</a></li>
                        <li><a href="{{url('page/how-it-works')}}">FIND TEMPORARY SHORT TERM WORK</a></li>
                        <li><a href="">FAQs</a></li>
                        <li style="border-right:none"><a href="" style="color:#2a3b65">CONTACT US<br> FOR INFORMATION</a></li>

                    </ul>

                </div>
                {{--<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 telno" >--}}
                    {{--<span>Email:info@staffbackup.co.uk</span>--}}
                {{--</div>--}}
            </div>
            <div class="row" style="margin:0 auto;width: 850px;padding-bottom: 150px;">

                <div class="headingcenter text-center">
                    <h2>We connect professionals with the <br> people who need them most, (when they needed them).</h2>
                    <div>10 years professional clinical experience connecting surgeries and <br> healthcare stakeholders with adhoc and temporary staffing solutions</div>
                </div>
                <div class="signupBtn">
                    <a href="{{{ Auth::user() ? url($user_role.'/dashboard') : url('register')}}}">{{Auth::user() ? "Dashboard" : "SIGN-UP"}}</a>
                </div>

            </div>

            <div class="search" id="searchHomePage">
                <div class="searchtop">
                    <div v-bind:class="{'searchtype':true, 'searchactive':(search_type === 'freelancer')}"  @click="changeSearchType('freelancer')">Search Adhoc Staff</div>
                    <div v-bind:class="{'searchtype':true, 'searchactive':(search_type === 'job')}" @click="changeSearchType('job')">Search Temp Jobs</div>
                    <div class="searchbtn">
                        <button @click="submit_search">Search</button>
                    </div>
                </div>
                <div class="searchinputs" >
                    <div class="filters">
                        <div>LOCATION</div>
                        <div><img src="{{url('images/icons/Layer 46.png')}}" alt=""><input type="text" v-model="location" placeholder="Area or Postcode"></div>
                    </div>
                    <div class="filters">
                        <div>SPECIALIST</div>
                        <div>
                            <img src="{{url('images/icons/Layer 47.png')}}" alt="">
                            <select style="font-weight: normal;border:none;padding:0px;" v-model="selectedSkills" v-model="skill">
                                <option value="" disabled selected>Doctor, Nurse...</option>

                                <option v-for="skill in skills" v-bind:value="skill.title">
                                    @{{ skill.title}}
                                </option>
                                ]
                            </select>

                        </div>
                    </div>

                    <div class="filters">
                        <div>DATE</div>
                        <div><img src="{{url('images/icons/Layer 48.png')}}" alt=""><input type="text" name="" v-model="selectedDate" placeholder="Time, Date..." class="selectDatePicker">
                            <vue-cal id="calendar_small"
                                     style="display:none;z-index:5; background-color:white;width:230px;position: absolute; height: 290px;"
                                     class=" vuecal--green-theme"
                                     xsmall
                                     hide-view-selector
                                     :time="false"
                                     default-view="month"
                                     :disable-views="['week', 'day', 'year']"
                                     @cell-click="changeSelectedDate"
                                     :events="events"
                            >
                            </vue-cal>
                        </div>
                    </div>
                    <div class="filters" style="border-right:none">
                        <div>RATE</div>
                        <div><img src="{{url('images/icons/Layer 49.png')}}" alt=""><input type="text" placeholder="Per Hour, Day..."></div>
                    </div>
                </div>

            </div>
        </div>

</header>
