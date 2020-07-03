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
                    <div class="row newStyleBoxes" style="display:block; margin: 0 auto">
                        <div style="margin: 0 auto">
                            <div class="newBoxStyle">
                                <div class="firsthalf"><a href="{{route('showFreelancerProposals')}}">{{ trans('lang.latest_proposals') }}</a></div>
                                <div class="secondhalf">9</div>
                                {{--   <a href="{{{ route('employerManageJobs') }}}">{{ trans('lang.click_view') }}</a>--}}
                            </div>
                            <div class="newBoxStyle">
                                <div class="firsthalf"><a href="{{{ route('message') }}}">{{ trans('lang.new_msgs') }}</a></div>
                                <div class="secondhalf">10</div>
                                {{--                            <a href="{{ url('message-center') }}">{{ trans('lang.click_view') }}</a>--}}

                            </div>

                            <div class="newBoxStyle">
                                <div class="firsthalf">Applications</div>
                                <div class="secondhalf">23</div>
                                {{--   <a href="{{{ url('employer/dashboard/manage-jobs') }}}">{{ trans('lang.click_view') }}</a>--}}
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                            {{--<div class="wt-insightsitem wt-dashboardbox">--}}
                                {{--<figure class="wt-userlistingimg">--}}
                                    {{--{{ Helper::getImages('uploads/settings/icon',$latest_proposals_icon, 'layers') }}--}}
                                {{--</figure>--}}
                                {{--<div class="wt-insightdetails">--}}
                                    {{--<div class="wt-title">--}}
                                        {{--<h3></h3>--}}
                                        {{--<a href="{{route('showFreelancerProposals')}}">{{ trans('lang.click_view') }}</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@if (!empty($enable_package) && $enable_package === 'true')--}}
                            {{--@if (!empty($package))--}}
                                {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                                    {{--<div class="wt-insightsitem wt-dashboardbox user_current_package">--}}
                                        {{--<countdown--}}
                                        {{--date="{{$expiry_date}}"--}}
                                        {{--:image_url="'{{{ Helper::getDashExpiryImages('uploads/settings/icon',$latest_package_expiry_icon, 'img-21.png') }}}'"--}}
                                        {{--:title="'{{ trans('lang.check_pkg_expiry') }}'"--}}
                                        {{--:package_url="'{{url('dashboard/packages/freelancer')}}'"--}}
                                        {{--:trail="'{{$trail}}'"--}}
                                        {{--:current_package="'{{$package->title}}'"--}}
                                        {{-->--}}
                                        {{--</countdown>--}}
                                    {{--</div>--}}
                                {{--</div>  --}}
                            {{--@endif          --}}
                        {{--@endif--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                            {{--<div class="wt-insightsitem wt-dashboardbox {{ $notify_class }}">--}}
                                {{--<figure class="wt-userlistingimg">--}}
                                    {{--{{ Helper::getImages('uploads/settings/icon',$latest_new_message_icon, 'book') }}--}}
                                {{--</figure>--}}
                                {{--<div class="wt-insightdetails">--}}
                                    {{--<div class="wt-title">--}}
                                        {{--<h3>{{ trans('lang.new_msgs') }}</h3>--}}
                                        {{--<a href="{{{ route('message') }}}">{{ trans('lang.click_view') }}</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                            {{--<div class="wt-insightsitem wt-dashboardbox">--}}
                                {{--<figure class="wt-userlistingimg">--}}
                                    {{--{{ Helper::getImages('uploads/settings/icon',$latest_saved_item_icon, 'lnr lnr-heart') }}--}}
                                {{--</figure>--}}
                                {{--<div class="wt-insightdetails">--}}
                                    {{--<div class="wt-title">--}}
                                        {{--<h3>{{ trans('lang.view_saved_items') }}</h3>--}}
                                        {{--<a href="{{url('freelancer/saved-items')}}">{{ trans('lang.click_view') }}</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@if ($access_type == 'jobs' || $access_type== 'both')--}}
                            {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                                {{--<div class="wt-insightsitem wt-dashboardbox">--}}
                                    {{--<figure class="wt-userlistingimg">--}}
                                        {{--{{ Helper::getImages('uploads/settings/icon',$latest_cancel_project_icon, 'cross-circle') }}--}}
                                    {{--</figure>--}}
                                    {{--<div class="wt-insightdetails">--}}
                                        {{--<div class="wt-title">--}}
                                            {{--<h3>{{{ $cancelled_projects->count() }}}</h3>--}}
                                            {{--<h3>{{ trans('lang.total_cancelled_projects') }}</h3>--}}
                                            {{--<a href="{{{ url('freelancer/jobs/cancelled') }}}">{{ trans('lang.click_view') }}</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                                {{--<div class="wt-insightsitem wt-dashboardbox">--}}
                                    {{--<figure class="wt-userlistingimg">--}}
                                        {{--{{ Helper::getImages('uploads/settings/icon',$latest_ongoing_project_icon, 'cloud-sync') }}--}}
                                    {{--</figure>--}}
                                    {{--<div class="wt-insightdetails">--}}
                                        {{--<div class="wt-title">--}}
                                            {{--<h3>{{{ $ongoing_projects->count() }}}</h3>--}}
                                            {{--<h3>{{ trans('lang.total_ongoing_projects') }}</h3>--}}
                                            {{--<a href="{{{ url('freelancer/jobs/hired') }}}">{{ trans('lang.click_view') }}</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                            {{--<div class="wt-insightsitem wt-dashboardbox">--}}
                                {{--<figure class="wt-userlistingimg">--}}
                                    {{--{{ Helper::getImages('uploads/settings/icon',$latest_pending_balance_icon, 'cart') }}--}}
                                {{--</figure>--}}
                                {{--<div class="wt-insightdetails">--}}
                                    {{--<div class="wt-title">--}}
                                        {{--<h3>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '£' }}{{{ Helper::getProposalsBalance(Auth::user()->id, 'hired') }}}</h3>--}}
                                        {{--<h3>{{ trans('lang.pending_bal') }}</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">--}}
                            {{--<div class="wt-insightsitem wt-dashboardbox">--}}
                                {{--<figure class="wt-userlistingimg">--}}
                                    {{--{{ Helper::getImages('uploads/settings/icon',$latest_current_balance_icon, 'gift') }}--}}
                                {{--</figure>--}}
                                {{--<div class="wt-insightdetails">--}}
                                    {{--<div class="wt-title">--}}
                                    {{--<h3>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '£' }}{{{ Helper::getProposalsBalance(Auth::user()->id, 'completed') }}}</h3>--}}
                                        {{--<h3>{{ trans('lang.curr_bal') }}</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        @if ($access_type == 'services' || $access_type== 'both')
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$ongoing_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Helper::getFreelancerServices('hired', Auth::user()->id)->count() }}}</h3>
                                            <h3>{{ trans('lang.total_ongoing_services') }}</h3>
                                            <a href="{{{ url('freelancer/services/hired') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$completed_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Helper::getFreelancerServices('completed', Auth::user()->id)->count() }}}</h3>
                                            <h3>{{ trans('lang.total_completed_services') }}</h3>
                                            <a href="{{{ url('freelancer/services/completed') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$cancelled_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Helper::getFreelancerServices('cancelled', Auth::user()->id)->count() }}}</h3>
                                            <h3>{{ trans('lang.total_cancelled_services') }}</h3>
                                            <a href="{{{ url('freelancer/services/cancelled') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="wt-insightsitem wt-dashboardbox">
                                    <figure class="wt-userlistingimg">
                                        {{ Helper::getImages('uploads/settings/icon',$published_services_icon, 'gift') }}
                                    </figure>
                                    <div class="wt-insightdetails">
                                        <div class="wt-title">
                                            <h3>{{{ Helper::getFreelancerServices('published', Auth::user()->id)->count() }}}</h3>
                                            <h3>{{ trans('lang.total_published_services') }}</h3>
                                            <a href="{{{ url('freelancer/services/posted') }}}">{{ trans('lang.click_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
        </div>

        {{--<div class="row">--}}
            {{--@if ($access_type == 'jobs' || $access_type== 'both')--}}
                {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">--}}
                    {{--<div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects">--}}
                        {{--<div class="wt-dashboardboxtitle wt-titlewithsearch">--}}
                            {{--<h2>{{ trans('lang.ongoing_project') }}</h2>--}}
                        {{--</div>--}}
                        {{--@if (!empty($ongoing_projects) && $ongoing_projects->count() > 0)--}}
                            {{--<div class="wt-dashboardboxcontent wt-hiredfreelance">--}}
                                {{--<table class="wt-tablecategories wt-freelancer-table">--}}
                                    {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th>{{trans('lang.project_title')}}</th>--}}
                                            {{--<th>{{trans('lang.employer_name')}}</th>--}}
                                            {{--<th>{{trans('lang.project_cost')}}</th>--}}
                                            {{--<th>{{trans('lang.actions')}}</th>--}}
                                        {{--</tr>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                        {{--@foreach ($ongoing_projects as $projects)--}}
                                            {{--@php--}}
                                                {{--$project = \App\Proposal::find($projects->id);--}}
                                                {{--$user = \App\User::find($project->job->user_id);--}}
                                                {{--$user_name = Helper::getUsername($project->job->user_id);--}}
                                            {{--@endphp--}}
                                            {{--<tr>--}}
                                                {{--<td data-th="Project title"><span class="bt-content"><a target="_blank" href="{{{ url('freelancer/job/'.$project->job->slug) }}}">{{{ $project->job->title }}}</a></span></td>--}}
                                                {{--<td data-th="Hired freelancer">--}}
                                                    {{--<span class="bt-content">--}}
                                                        {{--<a href="{{{url('profile/'.$user->slug)}}}">--}}
                                                            {{--@if ($user->user_verified)--}}
                                                                {{--<i class="fa fa-check-circle"></i>&nbsp;--}}
                                                            {{--@endif--}}
                                                            {{--{{{$user_name}}}--}}
                                                        {{--</a>--}}
                                                    {{--</span>--}}
                                                {{--</td>--}}
                                                {{--<td data-th="Project cost"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '£' }}{{$projects->amount}}</span></td>--}}
                                                {{--<td data-th="Actions">--}}
                                                    {{--<span class="bt-content">--}}
                                                        {{--<div class="wt-btnarea">--}}
                                                            {{--<a href="{{{ url('freelancer/job/'.$project->job->slug) }}}" class="wt-btn">{{ trans('lang.view_detail') }}</a>--}}
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
            {{--@endif--}}
            {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">--}}
                {{--<div class="wt-dashboardbox  wt-ongoingproject la-ongoing-projects">--}}
                    {{--<div class="wt-dashboardboxtitle wt-titlewithsearch">--}}
                        {{--<h2>{{ trans('lang.past_earnings') }}</h2>--}}
                    {{--</div>--}}
                    {{--@php--}}
                        {{--$pastearing_check = '';--}}
                        {{--if (Schema::hasTable('services') && Schema::hasTable('service_user')) {--}}
                            {{--$pastearing_check = Helper::getFreelancerServices('completed', Auth::user()->id)->count() > 0;--}}
                        {{--}--}}
                    {{--@endphp--}}
                    {{--@if ((!empty($completed_projects) && $completed_projects->count() > 0) || $pastearing_check)--}}
                        {{--@php--}}
                            {{--$commision = \App\SiteManagement::getMetaValue('commision');--}}
                            {{--$admin_commission = !empty($commision[0]['commision']) ? $commision[0]['commision'] : 0;--}}
                        {{--@endphp--}}
                        {{--<div class="wt-dashboardboxcontent wt-hiredfreelance">--}}
                            {{--<table class="wt-tablecategories">--}}
                                {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>{{trans('lang.project_title')}}</th>--}}
                                        {{--<th>{{trans('lang.date')}}</th>--}}
                                        {{--<th>{{trans('lang.earnings')}}</th>--}}
                                    {{--</tr>--}}
                                {{--</thead>--}}
                                {{--@if ($access_type == 'jobs' || $access_type== 'both')--}}
                                    {{--@if (!empty($completed_projects) && $completed_projects->count() > 0)--}}
                                        {{--<tbody>--}}
                                            {{--@foreach ($completed_projects as $projects)--}}
                                                {{--@php--}}
                                                    {{--$project = \App\Proposal::find($projects->id);--}}
                                                    {{--$user_name = Helper::getUsername($project->job->user_id);--}}
                                                    {{--$amount = !empty($project->amount) ? $project->amount - ($project->amount / 100) * $admin_commission : 0;--}}
                                                {{--@endphp--}}
                                                {{--<tr class="wt-earning-contents">--}}
                                                    {{--<td class="wt-earnig-single" data-th="Project Title"><span class="bt-content">{{{ $project->job->title }}}</span></td>--}}
                                                    {{--<td data-th="Date"><span class="bt-content">{{$project->updated_at}}</span></td>--}}
                                                    {{--<td data-th="Earnings"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '£' }}{{{$amount}}}</span></td>--}}
                                                {{--</tr>--}}
                                            {{--@endforeach--}}
                                        {{--</tbody>--}}
                                    {{--@endif--}}
                                {{--@endif--}}
                                {{--@if ($access_type == 'services' || $access_type== 'both')--}}
                                    {{--@if (Helper::getFreelancerServices('completed', Auth::user()->id)->count() > 0)--}}
                                        {{--<tbody>--}}
                                            {{--@foreach (Helper::getFreelancerServices('completed', Auth::user()->id) as $service)--}}
                                                {{--@php--}}
                                                    {{--$freelancer = Helper::getServiceSeller($service->id);--}}
                                                    {{--$user_name = Helper::getUsername($freelancer->seller_id);--}}
                                                    {{--$amount = !empty($service->price) ? $service->price - ($service->price / 100) * $admin_commission : 0;--}}
                                                {{--@endphp--}}
                                                {{--<tr class="wt-earning-contents">--}}
                                                    {{--<td class="wt-earnig-single" data-th="Project Title"><span class="bt-content">{{{ $service->title }}}</span></td>--}}
                                                    {{--<td data-th="Date"><span class="bt-content">{{$service->updated_at}}</span></td>--}}
                                                    {{--<td data-th="Earnings"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '£' }}{{{$amount}}}</span></td>--}}
                                                {{--</tr>--}}
                                            {{--@endforeach--}}
                                        {{--</tbody>--}}
                                    {{--@endif--}}
                                {{--@endif--}}
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
        {{--</div>--}}

        <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
            <h2>Your Calendar</h2>
        </div>
        <div id="support_availability" style="margin:0 auto; width: 775px;">

            <div class="wt-tabscontent tab-content">
                <vue-cal ref="vuecal" style="height: 650px"
                         :time-from="0 * 60"
                         :time-to="24 * 60"
                         :disable-views="['years', 'year']"
                         :events="events"
                         default-view="month"
                         events-on-month-view="short"
                         resize-y
                         resize-x
                         editable-events
                         {{--:on-event-create="onEventCreate"--}}
                         {{--@event-drag-create="onEventCreate"--}}
                         @event-drag-create="onEventCreate"
                         :on-event-click="onEventClick"
                         {{--@cell-click=false--}}
                >
                    <button class="confirmButton btn btn-outline-primary float-right" @click="confButton">confirm</button>
                </vue-cal>

                <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
                    <h2>
                        Green equals free this day<br>
                        Blue equals booking on this day<br>
                        Red equals away on holiday<br>
                    </h2>
                </div>
                <div{{-- v-if="clickedDate != ''"--}}>
                    <div class="wt-tabcompanyinfo wt-tabsinfo" style="margin-top:50px">
                        <div class="wt-tabscontenttitle">
                            <h2>Create new availability</h2>
                        </div>
                    </div>
                    <div class="wt-accordiondetails">


                        <form>
                            <div class="form-group form-group-half classScrollTo" style="">
                                <label>Selected Start Date </label>
                                <input type="text" disabled class="form-control " placeholder="Selected Date" v-model="availability_selected_date">
                            </div>
                            <div class="form-group form-group-half" style="">
                                <label>Selected End Date </label>
                                <input type="text" disabled class="form-control " placeholder="Selected Date" v-model="availability_selected_end_date">
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
                                <label for="recurring_date">Recurring date:
                                    <input type="checkbox" name="recurring_date" v-model="recurring_date"></label>
                            </div>
                            <div class="form-group">
                                {!! Form::select('skill_id', $skills, null, ['placeholder' => trans('lang.skills'), 'v-model'=>'skill_id']) !!}
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
    </section>
@endsection
