@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@section('title'){{ $job_list_meta_title }} @stop
@section('description', $job_list_meta_desc)
@section('content')
@if ($show_job_banner == 'true')
@php $breadcrumbs = Breadcrumbs::generate('searchResults'); @endphp
<div class="wt-haslayout wt-innerbannerholder"
    style="background-image:url({{{ asset(Helper::getBannerImage('uploads/settings/general/'.$job_inner_banner)) }}})">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-10 push-lg-3">

                <div class="search" id="searchHomePage" attr-type="job">
                    <div class="searchtop">
                        @php
                        $user = auth()->user();
                        $uProffecional = $user->hasRole('freelancer');
                        @endphp
                        @if ($user->hasRole('employer'))
                        <div v-bind:class="{'searchtype':true, 'searchactive':(search_type === 'freelancer')}"
                            @click="changeSearchType('freelancer')">
                            Search Adhoc Staff
                        </div>
                        <div class="searchtype searchtype-inactive">
                            Search Adhoc Sessions
                        </div>
                        @elseif (auth()->user()->hasRole(['freelancer', 'support']))
                        <div class="searchtype searchtype-inactive">
                            Search Adhoc Staff
                        </div>
                        <div v-bind:class="{'searchtype':true, 'searchactive':(search_type === 'job')}"
                            @click="changeSearchType('job')" style="width: 24.5%;">
                            Search Adhoc Sessions
                        </div>
                        @endif
                        <div class="searchbtn">
                            <button @click="submit_search">Search</button>
                        </div>
                    </div>
                    <div class="searchinputs">
                        <div v-bind:class="{'filters': true, 'invalid-search-field': straddress === null && isInValidSearch}">
                            <div class="search-field-label">LOCATION</div>
                            <div class="search-field-input">
                                <img src="{{url('images/icons/Layer 46.png')}}" alt="">
                                <gmap-autocomplete class="form-control" placeholder="Area or Postcode" id="straddress"
                                    name="straddress" @place_changed="updateAddressLocation($event)"
                                    :select-first-on-enter="true" ref="straddress" :value="straddress"
                                    @input="straddress=$event.target.value">
                                    <template v-slot:input="slotProps">
                                        <v-text-field outlined ref="input" v-on:listeners="slotProps.listeners"
                                            v-on:attrs="slotProps.attrs">
                                        </v-text-field>
                                    </template>
                                </gmap-autocomplete>
                                <input type="hidden" id="latitude" name="latitude" value="{{ $latitude ?? '' }}">
                                <input type="hidden" id="longitude" name="longitude" value="{{ $longitude ?? '' }}">
                            </div>
                        </div>
                        <div class="filters">
                            <div>RADIUS</div>
                            <div>
                                <img src="{{url('images/icons/Layer 46.png')}}" alt="">
                                <input type="text" v-model="radius" ref="radius" placeholder="Radius" data-value="{{ $radius }}">
                            </div>
                        </div>
                        <div v-bind:class="{'filters': true, 'invalid-search-field': profession_id === '' && isInValidSearch}">
                            <div class="search-field-label">Profession</div>
                            <div class="search-field-input">
                                <img src="{{url('images/icons/Layer 47.png')}}" alt="">
                                <select style="font-weight: normal;border:none;padding:0px;width: 80%;"
                                    v-model="profession_id" ref="profession" data-value="{{ $profession_id }}">
                                    <option value="" disabled selected>
                                        Profession
                                    </option>
                                    <option v-for="profession in professions" :value="profession.id">
                                        @{{ profession.title}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div v-bind:class="{'filters': true, 'invalid-search-field': selectedDateFrom === '' && isInValidSearch}">
                            <div class="search-field-label">FROM</div>
                            <div class="search-field-input">
                                <img src="{{url('images/icons/Layer 48.png')}}" alt="">
                                <input type="text" name="" v-model="selectedDateFrom" placeholder="Date..."
                                    class="selectDatePicker" ref="availDateFrom" data-value="{{ $date }}" />
                                <vue-cal id="calendar_small_from"
                                    style="display:none;z-index:5; background-color:white;width:230px;position: absolute; height: 290px;"
                                    class=" vuecal--green-theme" xsmall hide-view-selector :time="false"
                                    default-view="month" :disable-views="['week', 'day', 'year']"
                                    @cell-click="changeSelectedDateFrom" :events="events">
                                </vue-cal>
                            </div>
                        </div>

                        <div v-bind:class="{'filters': true, 'invalid-search-field': selectedDateTo === '' && isInValidSearch}">
                            <div class="search-field-label">TO</div>
                            <div class="search-field-input">
                                <img src="{{url('images/icons/Layer 48.png')}}" alt="">
                                <input type="text" name="" v-model="selectedDateTo" placeholder="Date..."
                                    class="selectDatePicker" ref="availDateTo" data-value="{{ $date }}" />
                                <vue-cal id="calendar_small_to"
                                    style="display:none;z-index:5; background-color:white;width:230px;position: absolute; height: 290px;"
                                    class=" vuecal--green-theme" xsmall hide-view-selector :time="false"
                                    default-view="month" :disable-views="['week', 'day', 'year']"
                                    @cell-click="changeSelectedDateTo" :events="events">
                                </vue-cal>
                            </div>
                        </div>

                        <div class="filters">
                            <div ref="time" data-hours="{{ $time['hours'] }}" data-minutes="{{ $time['minutes'] }}">
                                TIME
                            </div>
                            <div><img src="{{url('images/icons/Layer 48.png')}}" alt="">
                                <vue-timepicker name="time" format="HH:mm" v-model="selectedTime" class="timepicker">
                                </vue-timepicker>
                            </div>
                        </div>



                        <div class="filters" style="border-right:none">
                            <div>RATE</div>
                            <div>
                                <img src="{{url('images/icons/Layer 49.png')}}" alt="">
                                <input type="text" placeholder="Per Hour" v-model="rate" value="{{ $rate }}" ref="rate">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-center">
                    <span class="error-msg search-error-msg">Location, Professions and Date fields are mandatory. Please
                        check and try
                        again.</span>
                </div>

                <div class="text-center searchTagline">
                    <h1>Job Search</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="wt-haslayout wt-main-section" id="jobs">
    @if (Session::has('payment_message'))
    @php $response = Session::get('payment_message') @endphp
    <div class="flash_msg">
        <flash_messages :message_class="'{{{$response['code']}}}'" :time='5' :message="'{{{ $response['message'] }}}'"
            v-cloak></flash_messages>
    </div>
    @endif
    <div class="wt-haslayout">
        <div class="container">
            <div class="row">
                <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                    {{--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4">--}}
                    {{--@if (file_exists(resource_path('views/extend/front-end/jobs/filters.blade.php')))--}}
                    {{--@include('extend.front-end.jobs.filters')--}}
                    {{--@else--}}
                    {{--@include('front-end.jobs.filters')--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8">--}}
                    <div class="row">
                        <div class="wt-userlistingholder wt-haslayout">
                            @if (!empty($keyword))
                            <div class="wt-userlistingtitle">
                                <span>{{ trans('lang.01') }} {{$jobs->count()}} of {{$Jobs_total_records}} results for
                                    <em>"{{{$keyword}}}"</em></span>
                            </div>
                            @endif
                            @if (!empty($jobs) && $jobs->count() > 0)
                            @foreach ($jobs as $__job)

                            @php
                            $job = \App\Job::find($__job->id);
                            $description = strip_tags(stripslashes($job->description));
                            $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                            $user = Auth::user() ? \App\User::find(Auth::user()->id) : '';
                            $project_type = Helper::getProjectTypeList($job->project_type);
                            $job->skills = ($job->skills != "")?unserialize($job->skills):"";

                            if( isset($_GET['hours_avail']) && !empty($_GET['hours_avail']))
                            {
                            $job_hours_avail = $job->hours_avail;
                            if($job_hours_avail =='')
                            {
                            continue;
                            }
                            else{
                            $hours = explode('-', $job_hours_avail);
                            $requestTime = explode('-', $_GET['hours_avail']);
                            $requestedTimeStart = strtotime($requestTime[0]);
                            $requestedTimeEnd = strtotime($requestTime[1]);
                            $jobStartTime = strtotime($hours[0]);
                            $jobEndTime = strtotime($hours[1]);

                            if (
                            $jobStartTime < $jobEndTime && $requestedTimeStart < $requestedTimeEnd &&
                                $requestedTimeStart>= $jobStartTime &&
                                $requestedTimeEnd <= $jobEndTime ) { } else { continue; } } } @endphp <div
                                    class="wt-userlistinghold wt-userlistingholdvtwo {{$featured_class}}">
                                    @if ($job->is_featured == 'true')
                                    <span class="wt-featuredtag"><img src="images/featured.png"
                                            alt="{{{ trans('ph.is_featured') }}}" data-tipso="Plus Member"
                                            class="template-content tipso_style"></span>
                                    @endif
                                    <div claswt-widget wt-effectiveholders="wt-userlistingcontent">
                                        <div class="wt-contenthead">
                                            <div class="wt-title">
                                                <a href="{{ url('profile/'.$job->employer->slug) }}"><i
                                                        class="fa fa-check-circle"></i>
                                                    {{{ Helper::getUserName($job->employer->id) }}}</a>
                                                <h2><a href="{{ url('job/'.$job->slug) }}">{{{$job->title}}}</a></h2>
                                            </div>
                                            <div class="wt-description">
                                                <p>{{ str_limit($description, 200) }}</p>
                                                <?php /*
                                                        <span>DITANCE: {{ $__job->distance }}</span>
                                                        <span>lat: {{ $job->latitude }}</span>
                                                        <span>lng: {{ $job->longitude }}</span>*/ ?>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                @foreach ($job->professions as $profession )
                                                <a href="#">
                                                    {{ $profession->title }}
                                                </a>
                                                @endforeach
                                            </div>
                                            @if($job->project_rates)
                                            <div>£ {{ $job->project_rates }}</div>
                                            @endif
                                        </div>
                                        <div class="wt-viewjobholder">
                                            <ul>
                                                @if($job->employer->itsoftware != "")
                                                <li><span><i class="fa fa-user wt-viewjobdollar"></i><strong>Computer
                                                            System in use:
                                                        </strong>{{ implode(', ', $job->employer->getItsoftware()) }}</span>
                                                </li>
                                                @endif

                                                @if ($job->professions->count())
                                                <li>
                                                    <span>
                                                        <i class="fa fa-tag wt-viewjobtag"></i>
                                                        {{ $job->professions[0]->title }}
                                                    </span>
                                                </li>
                                                @endif
                                                @if (!empty($job->duration) )
                                                <li><span><i class="fa fa-tag wt-viewjobdollar"></i>
                                                        {{{ $job->duration  }}}</span></li>
                                                @endif
                                                @if (!empty($job->employer->city) )
                                                <li><span><i class="fa fa-tag wt-viewjobdollar"></i>
                                                        {{{ $job->employer->city  }}}</span></li>
                                                @endif
                                                @if (!empty($job->project_rates) && !empty($job->project_rates_type) )
                                                <li><span><i class="fa fa-pound-sign wt-viewjobdollar"></i>
                                                        {{{ $job->project_rates . ' ' . $job->project_rates_type }}}</span>
                                                </li>
                                                @endif
                                                @if (!empty($job->location->title))
                                                <li><span><img
                                                            src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}"
                                                            alt="{{{ trans('lang.location') }}}">
                                                        {{{ $job->location->title }}}</span></li>
                                                @endif
                                                <li><span><i
                                                            class="fa fa-tag wt-viewjobtag"></i>{{{ trans('lang.job_id') }}}
                                                        {{{$job->code}}}</span></li>
                                                @if (!empty($user->profile->saved_jobs) && in_array($job->id,
                                                unserialize($user->profile->saved_jobs)))
                                                <li style=pointer-events:none;><a href="javascript:void(0);"
                                                        class="wt-clicklike wt-clicksave"><i class="fa fa-heart"></i>
                                                        {{trans("lang.saved")}}</a></li>
                                                @endif
                                                <li class="wt-btnarea"><a href="{{url('job/'.$job->slug)}}"
                                                        class="wt-btn">{{{ trans('lang.view_job') }}}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                        </div>

                        @endforeach

                        @if ( method_exists($jobs,'links') )
                        {{ $jobs->links('pagination.custom') }}
                        @endif

                        @else

                        @if (file_exists(resource_path('views/extend/errors/no-record.blade.php')))
                        @include('extend.errors.no-record')
                        @else
                        @include('errors.no-record')
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
