@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <div class="row" style="margin:0 auto;width: 850px;padding-top: 80px;">

        <div class="headingcenter text-center">
            <h2>Dashboard</h2>
            <div style="color:gray">Great! You're ready to go.</div>
        </div>

    </div>
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">
        <div class="row">
                    <div class="wt-tabscontenttitle">
                        <h2>Your Updates</h2>
                    </div>
                    <div class="row newStyleBoxes" style="margin: 0 auto; display: block">


                        <div class="newBoxStyle">
                            <div class="firsthalf">Jobs</div>
                            <div class="secondhalf">9</div>
                            {{--   <a href="{{{ route('employerManageJobs') }}}">{{ trans('lang.click_view') }}</a>--}}
                        </div>
                        <div class="newBoxStyle">
                            <div class="firsthalf">Messages</div>
                            <div class="secondhalf">10</div>
{{--                            <a href="{{ url('message-center') }}">{{ trans('lang.click_view') }}</a>--}}

                        </div>
                        @if ($access_type == 'jobs' || $access_type== 'both')

                            <div class="newBoxStyle">
                                <div class="firsthalf">Applications</div>
                                <div class="secondhalf">23</div>
                                {{--   <a href="{{{ url('employer/dashboard/manage-jobs') }}}">{{ trans('lang.click_view') }}</a>--}}
                            </div>
                        @endif
                    </div>

                        @if ($access_type == 'jobs' || $access_type== 'both')


                        @endif
                        @if ($access_type == 'services' || $access_type== 'both')

                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$ongoing_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Auth::user()->purchasedServices->count() }}}</h3>
                                            <span>{{ trans('lang.total_ongoing_services') }}</span>
                                            <a href="{{{ url('employer/services/hired') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$completed_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Auth::user()->completedServices->count() }}}</h3>
                                            <span>{{ trans('lang.total_completed_services') }}</span>
                                            <a href="{{{ url('employer/services/completed') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$cancelled_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Auth::user()->cancelledServices->count() }}}</h3>
                                            <span>{{ trans('lang.total_cancelled_services') }}</span>
                                            <a href="{{{ url('employer/services/cancelled') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    {{--<div class="row page-group" style="margin-top: 30px">--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">--}}
                            {{--<div class="page-group-selectors bg-dark-blue">Contacts</div>--}}
                            {{--<div class="triangle"></div>--}}
                        {{--</div>--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                            {{--<div class="page-group-selectors bg-light-blue">Details</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">--}}
                            {{--<div class="page-group-selectors bg-specific-green">Requirements</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
        </div>
        @if ($access_type == 'jobs' || $access_type== 'both')
            <div class="row">
                {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                    {{--<div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects wt-earningsholder">--}}
                        {{--<div class="wt-dashboardboxtitle wt-titlewithsearch">--}}
                            {{--<h2>{{ trans('lang.ongoing_project') }}</h2>--}}
                        {{--</div>--}}
                        {{--@if (!empty($ongoing_jobs) && $ongoing_jobs->count() > 0)--}}
                            {{--<div class="wt-dashboardboxcontent wt-hiredfreelance">--}}
                                {{--<table class="wt-tablecategories wt-freelancer-table">--}}
                                    {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>{{trans('lang.project_title')}}</th>--}}
                                            {{--<th>{{trans('lang.hired_freelancers')}}</th>--}}
                                            {{--<th>{{trans('lang.project_cost')}}</th>--}}
                                            {{--<th>{{trans('lang.actions')}}</th>--}}
                                        {{--</tr>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                        {{--@foreach ($ongoing_jobs as $project)--}}
                                            {{--@php--}}
                                                {{--$proposal_freelancer = $project->proposals->where('status', 'hired')->pluck('freelancer_id')->first();--}}
                                                {{--$freelancer = \App\User::find($proposal_freelancer);--}}
                                                {{--$user_name = Helper::getUsername($proposal_freelancer);--}}
                                            {{--@endphp--}}
                                            {{--<tr>--}}
                                                {{--<td data-th="Project title"><span class="bt-content"><a target="_blank" href="{{{ url('job/'.$project->slug) }}}">{{{ $project->title }}}</a></span></td>--}}
                                                {{--<td data-th="Hired freelancer">--}}
                                                    {{--<span class="bt-content">--}}
                                                        {{--<a href="{{{url('profile/'.$freelancer->slug)}}}">--}}
                                                            {{--@if ($freelancer->user_verified)--}}
                                                                {{--<i class="fa fa-check-circle"></i>&nbsp;--}}
                                                            {{--@endif--}}
                                                            {{--{{{$user_name}}}--}}
                                                        {{--</a>--}}
                                                    {{--</span>--}}
                                                {{--</td>--}}
                                                {{--<td data-th="Project cost"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '£' }}{{$project->price}}</span></td>--}}
                                                {{--<td data-th="Actions">--}}
                                                    {{--<span class="bt-content">--}}
                                                        {{--<div class="wt-btnarea">--}}
                                                            {{--<a href="{{{ url('employer/dashboard/job/'.$project->slug.'/proposals') }}}" class="wt-btn">{{ trans('lang.view_detail') }}</a>--}}
                                                        {{--</div>--}}
                                                    {{--</span>--}}
                                                {{--</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                    {{--</tbody>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        {{--@else--}}
                            {{--@if (file_exists(resource_path('views/extend/errors/no-record.blade.php'))) --}}
                                {{--@include('extend.errors.no-record')--}}
                            {{--@else --}}
                                {{--@include('errors.no-record')--}}
                            {{--@endif--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
                    <h2>Your Calendar</h2>
                </div>


                <div class="wt-dashboardbox wt-dashboardtabsholder" id="employer_availability">

                    <div class="wt-tabscontent tab-content">
                        <vue-cal ref="vuecal" style="height: 650px"
                                 :time-from="0 * 60"
                                 :time-to="24 * 60"
                                 :disable-views="['years', 'year']"
                                 :events="events"
                                 default-view="month"
                                 {{--:events-on-month-view="[true, 'short'][false * 1]"--}}
                                 :on-event-click="onEventClick"
                                 @cell-click="createNewEvent">
                        </vue-cal>

                        <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
                            <h2>
                                Green equals free this day<br>
                                Blue equals booking on this day<br>
                                Red equals away on holiday<br>
                            </h2>
                        </div>
                        <div v-if="clickedDate != ''">
                            <div class="wt-tabcompanyinfo wt-tabsinfo" style="margin-top:50px">
                                <div class="wt-tabscontenttitle">
                                    <h2>Create new availability</h2>
                                </div>
                            </div>
                            <div class="wt-accordiondetails">


                                <form>
                                    <div class="form-group classScrollTo" style="">
                                        <label>Selected Date </label>

                                        <input type="text" disabled class="form-control " placeholder="Selected Date" v-model="availability_selected_date">
                                    </div>
                                    <div class="form-group form-group-half">
                                        <label for="availability_start_time">Holiday Start date/time:</label>
                                        <vue-timepicker name="availability_start_time" required  format="HH:mm" v-model="availability_start_time"></vue-timepicker>

                                    </div>
                                    <div class="form-group form-group-half">
                                        <label for="availability_end_time">Holiday End date/time:</label>
                                        <vue-timepicker name="availability_end_time" required  format="HH:mm" v-model="availability_end_time"></vue-timepicker>

                                    </div>
                                    <div class="form-group">
                                        <label for="availability_title">Title:</label>
                                        {!! Form::text( 'availability_title',null, ['class' =>'form-control', 'placeholder' => 'Holiday Title', 'v-model'=>'availability_title', 'required'=>'required'] ) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="availability_title">Content:</label>
                                        {!! Form::text( 'availability_content',null, ['class' =>'form-control', 'placeholder' => 'Holiday description', 'v-model'=>'availability_content', 'required'=>'required'] ) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="recuring_date">Recuring date:
                                            <input type="checkbox" name="recuring_date" v-model="recuring_date"></label>
                                    </div>
                                    <input type="hidden" name="class" >
                                    <input type="hidden" name="user_id" v-model="user_id">
                                    <input type="hidden" name="id" v-model="id">
                                    <button class="btn btn-success" id="available_class" @click="saveNewEventAvailability">Create Availability</button>
                                    <button class="btn btn-danger" id="busy_class" @click="saveNewEventBusy">Create Holiday/Busy</button>
                                    <button class="btn btn-danger" id="update_event" @click="updateEvent">Update Event</button>
                                </form>
                            </div>
                        </div>
                </div>

            </div>
        @endif
    </section>
@endsection
