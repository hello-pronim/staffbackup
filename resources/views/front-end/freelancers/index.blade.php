@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
<link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{ $f_list_meta_title }} @stop
@section('description', $f_list_meta_desc)
@section('content')
@if ($show_f_banner == 'true')
@php
$breadcrumbs = Breadcrumbs::generate('searchResults');
$user = auth()->user();
@endphp
<div class="wt-haslayout wt-innerbannerholder"
    style="background-image:url({{{ asset(Helper::getBannerImage('uploads/settings/general/'.$f_inner_banner)) }}})">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-10 push-lg-3">
                <div class="search" id="searchHomePage" attr-type="freelancer">
                    <div class="searchtop">
                        @if (auth()->user()->hasRole('employer'))
                        <div v-bind:class="{'searchtype':true, 'searchactive':(search_type === 'freelancer')}"
                            @click="changeSearchType('freelancer')">Search Adhoc Staff
                        </div>
                        <div class="searchtype searchtype-inactive">
                            Search Adhoc Sessions
                        </div>
                        @elseif (auth()->user()->hasRole(['freelancer', 'support']))
                        <div class="searchtype searchtype-inactive">
                            Search Adhoc Staff
                        </div>
                        <div v-bind:class="{'searchtype':true, 'searchactive':(search_type === 'job')}"
                            @click="changeSearchType('job')">Search Adhoc Sessions
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
                                <input type="hidden" id="latitude" name="latitude" value="{{ $latitude }}">
                                <input type="hidden" id="longitude" name="longitude" value="{{ $longitude }}">
                            </div>
                        </div>
                        <div class="filters">
                            <div>RADIUS</div>
                            <div>
                                <img src="{{url('images/icons/Layer 46.png')}}" alt="">
                                <input type="text" v-model="radius" placeholder="Radius" ref="radius"
                                    data-value="{{ $radius }}" />
                            </div>
                        </div>
                        <div v-bind:class="{'filters': true, 'invalid-search-field': profession_id === '' && isInValidSearch}">
                            <div class="search-field-label">{{ trans('lang.skills_req') }}</div>
                            <div class="search-field-input">
                                <img src="{{url('images/icons/Layer 47.png')}}" alt="">
                                <select style="font-weight: normal;border:none;padding:0px;width: 80%; font-size: 12px"
                                    v-model="profession_id" ref="profession" data-value="{{ $profession_id }}">
                                    <option value="" disabled selected>Profession...</option>
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
                            <div class="search-field-label" ref="time" data-hours="{{ $time['hours'] }}" data-minutes="{{ $time['minutes'] }}">
                                TIME
                            </div>
                            <div class="search-field-input">
                                <img src="{{url('images/icons/Layer 48.png')}}" alt="">
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
                    <h1>Professional Search</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{--@if (!empty($categories) && $categories->count() > 0)--}}
{{--<div class="wt-categoriesslider-holder wt-haslayout {{$show_f_banner == 'false' ? 'la-categorty-top-mt' : ''}}">--}}
{{--<div class="wt-title">--}}
{{--<h2>{{ trans('lang.browse_job_cats') }}</h2>--}}
{{--</div>--}}
{{--<div id="wt-categoriesslider" class="wt-categoriesslider owl-carousel">--}}
{{--@foreach ($categories as $cat)--}}
{{--@php--}}
{{--$category = \App\Category::find($cat->id);--}}
{{--$active = (!empty($_GET['category']) && in_array($cat->id, $_GET['category'])) ? 'active-category' : '';--}}
{{--$active_wrapper = ( !empty($_GET['category']) && in_array($cat->id, $_GET['category'])) ? 'active-category-wrapper' : '';--}}
{{--@endphp--}}
{{--<div class="wt-categoryslidercontent item {{$active_wrapper}}">--}}
{{--<figure><img src="{{{ asset(Helper::getCategoryImage($cat->image)) }}}" alt="{{{ $cat->title }}}"></figure>--}}
{{--<div class="wt-cattitle">--}}
{{--<h3><a href="{{{url('search-results?type=job&category%5B%5D='.$cat->slug)}}}"
class="{{$active}}">{{{ $cat->title }}}</a></h3>--}}
{{--<span>Items: {{{$category->jobs->count()}}}</span>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endforeach--}}
{{--</div>--}}
{{--</div>--}}
{{--@endif--}}
<div class="wt-haslayout wt-main-section" id="user_profile">
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
                    {{--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">--}}
                    {{--@if (file_exists(resource_path('views/extend/front-end/freelancers/filters.blade.php')))--}}
                    {{--@include('extend.front-end.freelancers.filters')--}}
                    {{--@else--}}
                    {{--@include('front-end.freelancers.filters')--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">--}}
                    <div class="row">
                        <div class="wt-userlistingholder wt-userlisting wt-haslayout">
                            <div class="wt-userlistingtitle">
                                @if (!empty($users))
                                <span>{{ trans('lang.01') }} {{$users->count()}} of
                                    {{\App\User::role('freelancer')->count()}} results @if (!empty($keyword)) for
                                    <em>"{{{$keyword}}}"</em> @endif</span>
                                @endif
                            </div>
                            @if (!empty($users))
                            @foreach ($users as $key => $freelancer)
                            @php
                            if( isset($_GET['hours_avail']) && !empty($_GET['hours_avail']))
                            {
                            $freelancer_hours_avail = $freelancer->profile->hours_avail;
                            if($freelancer_hours_avail =='')
                            {
                            continue;
                            }
                            else{
                            $hours = explode('-', $freelancer_hours_avail);
                            $requestTime = explode('-', $_GET['hours_avail']);
                            $requestedTimeStart = strtotime($requestTime[0]);
                            $requestedTimeEnd = strtotime($requestTime[1]);
                            $freeStartTime = strtotime($hours[0]);
                            $freeEndTime = strtotime($hours[1]);

                            if (
                            $freeStartTime < $freeEndTime && $requestedTimeStart < $requestedTimeEnd &&
                                $requestedTimeStart>= $freeStartTime &&
                                $requestedTimeEnd <= $freeEndTime ) { } else { continue; } } }
                                    $user_image=!empty($freelancer->profile->avater) ?
                                    '/uploads/users/'.$freelancer->id.'/'.$freelancer->profile->avater :
                                    'images/user.jpg';
                                    $flag = !empty($freelancer->location->flag) ?
                                    Helper::getLocationFlag($freelancer->location->flag) :
                                    '/images/img-01.png';
                                    $avg_rating = \App\Review::where('receiver_id', $freelancer->id)->sum('avg_rating');
                                    $rating = $avg_rating != 0 ? round($avg_rating/\App\Review::count()) : 0;
                                    $reviews = \App\Review::where('receiver_id', $freelancer->id)->get();
                                    $stars = $reviews->sum('avg_rating') != 0 ? $reviews->sum('avg_rating')/20*100 : 0;
                                    $feedbacks = \App\Review::select('feedback')->where('receiver_id',
                                    $freelancer->id)->count();
                                    $verified_user = \App\User::select('user_verified')->where('id',
                                    $freelancer->id)->pluck('user_verified')->first();
                                    $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ?
                                    unserialize(auth()->user()->profile->saved_freelancer) : array();
                                    $badge = Helper::getUserBadge($freelancer->id);
                                    if (!empty($enable_package) && $enable_package === 'true') {
                                    $feature_class = (!empty($badge) && $freelancer->expiry_date >= $current_date) ?
                                    'wt-featured' : 'wt-exp';
                                    $badge_color = !empty($badge) ? $badge->color : '';
                                    $badge_img = !empty($badge) ? $badge->image : '';
                                    } else {
                                    $feature_class = 'wt-exp';
                                    $badge_color = '';
                                    $badge_img = '';
                                    }
                                    @endphp
                                    <div class="wt-userlistinghold {{ $feature_class }}">
                                        @if(!empty($enable_package) && $enable_package === 'true')
                                        @if ($freelancer->expiry_date >= $current_date && !empty($freelancer->badge_id))
                                        <span class="wt-featuredtag" style="border-top: 40px solid {{ $badge_color }};">
                                            @if (!empty($badge_img))
                                            <img src="{{{ asset(Helper::getBadgeImage($badge_img)) }}}"
                                                alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member"
                                                class="template-content tipso_style">
                                            @else
                                            <i class="wt-expired fas fa-bold"></i>
                                            @endif
                                        </span>
                                        @endif
                                        @endif
                                        <figure class="wt-userlistingimg">
                                            <img src="{{{ asset($user_image) }}}" alt="{{ trans('lang.img') }}">
                                        </figure>
                                        <div class="wt-userlistingcontent">
                                            <div class="wt-contenthead">
                                                <div class="wt-title">
                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                        @if ($verified_user == 1)
                                                        <i class="fa fa-check-circle"></i>
                                                        @endif
                                                        {{{ Helper::getUserName($freelancer->id) }}}
                                                    </a>
                                                    @if (!empty($freelancer->profile->tagline))
                                                    <h2><a
                                                            href="{{{ url('profile/'.$freelancer->slug) }}}">{{{ $freelancer->profile->tagline }}}</a>
                                                    </h2>
                                                    @endif
                                                    <h5>Availability</h5>
                                                    @php
                                                    $dates = [];
                                                    $singleDates = [];

                                                    foreach($freelancer->calendars as $calendar) {
                                                    $dates[$calendar->created_at->timestamp][] = $calendar;
                                                    }

                                                    foreach($dates as $date) {
                                                    if(count($date) > 1) {

                                                    if($date[0]->recurring_date == 'day') {
                                                    echo 'Daily ';
                                                    } else if($date[0]->recurring_date == 'week') {
                                                    echo 'Weekly ';
                                                    } else if($date[0]->recurring_date == 'year') {
                                                    echo 'Yearly ';
                                                    }

                                                    if ($date[0]->recurring_date != 'day') {
                                                    echo '(' . $date[0]->start->format('l') . ')';
                                                    }
                                                    echo '<br>from: ' . $date[0]->start->format('d-m-yy');
                                                    echo ' to: ' . end($date)->end->format('d-m-yy') . '<br>';
                                                    echo '<br>';
                                                    } else {
                                                    $singleDates[] = $date[0];
                                                    }
                                                    }

                                                    if(count($singleDates)) {
                                                    echo 'single dates: <br>';

                                                    $singleDatesCounter = count($singleDates);
                                                    foreach($singleDates as $k => $date) {
                                                    echo $date->start->format('d-m-yy');
                                                    if($singleDatesCounter > 1 && ($k != $singleDatesCounter - 1 )) {
                                                    echo ', ';
                                                    }
                                                    }
                                                    }
                                                    @endphp
                                                    <hr>
                                                </div>
                                                <ul class="wt-userlisting-breadcrumb">
                                                    @if (!empty($freelancer->profile->hourly_rate))
                                                    <li><span><i class="far fa-money-bill-alt"></i>
                                                            {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '£' }}{{{ $freelancer->profile->hourly_rate }}}
                                                            {{ trans('lang.per_hour') }}</span>
                                                    </li>
                                                    @endif
                                                    @if (!empty($freelancer->itsoftware))
                                                    <li>
                                                        <strong>Computer System in use:</strong>
                                                        {{ implode(', ', $freelancer->getItsoftware()) }}
                                                    </li>
                                                    @endif
                                                    {{--@if (!empty($freelancer->location))--}}
                                                    {{--<li><span><img src="{{{ asset($flag)}}}" alt="Flag">
                                                    {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}</span>
                                                    </li>--}}
                                                    {{--@endif--}}
                                                    <?php /*
                                                        <li>
                                                            <span>DITANCE: {{ $freelancer->distance }}</span>
                                                            <span>lat: {{ $freelancer->profile->latitude }}</span>
                                                            <span>lng: {{ $freelancer->profile->longitude }}</span>
                                                        </li> */ ?>
                                                    @if (in_array($freelancer->id, $save_freelancer))
                                                    <li class="wt-btndisbaled">
                                                        <a href="javascript:void(0);" class="wt-clicksave wt-clicksave">
                                                            <i class="fa fa-heart"></i>
                                                            {{ trans('lang.saved') }}
                                                        </a>
                                                    </li>
                                                    @else
                                                    {{--<li v-cloak>--}}
                                                    {{--<a href="javascript:void(0);" class="wt-clicklike" id="freelancer-{{$freelancer->id}}"
                                                    @click.prevent="add_wishlist('freelancer-{{$freelancer->id}}',
                                                    {{$freelancer->id}}, 'saved_freelancer',
                                                    '{{trans("lang.saved")}}')">--}}
                                                    {{--<i class="fa fa-heart"></i>--}}
                                                    {{--<span class="save_text">{{ trans('lang.click_to_save') }}</span>--}}
                                                    {{--</a>--}}
                                                    {{--</li>--}}
                                                    @endif
                                                </ul>
                                                @if (!empty($freelancer->profile->description))
                                                <div class="wt-description" style="padding-top: 40px">
                                                    <p>{{{ str_limit($freelancer->profile->description, 180) }}}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <!-- <div class="wt-rightarea">
                                                <span class="wt-stars"><span
                                                        style="width: {{ $stars }}%;"></span></span>
                                                <span
                                                    class="wt-starcontent">{{{ $rating }}}<sub>{{ trans('lang.5') }}</sub>
                                                    <em>({{{ $feedbacks }}} {{ trans('lang.feedbacks') }})</em></span>
                                            </div> -->
                                        </div>

                                        @if (!empty($freelancer->skills))
                                        <div class="wt-tag wt-widgettag">
                                            @foreach($freelancer->skills as $skill)
                                            <a
                                                href="{{{url('search-results?type=job&skills%5B%5D='.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                    @if ( method_exists($users,'links') )
                                    {{ $users->links('pagination.custom', ['xxx' => 'yyyy']) }}
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
@push('scripts')
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
if (APP_DIRECTION == 'rtl') {
    var direction = true;
} else {
    var direction = false;
}

jQuery("#wt-categoriesslider").owlCarousel({
    item: 6,
    rtl: direction,
    loop: true,
    nav: false,
    margin: 0,
    autoplay: false,
    center: true,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
        },
        481: {
            items: 2,
        },
        768: {
            items: 3,
        },
        1440: {
            items: 4,
        },
        1760: {
            items: 6,
        }
    }
});
</script>
@endpush
@endsection
