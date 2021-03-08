@php
    $user = Auth::user();

    $recurringDates = [
        'day'=>'day',
        'week'=>'week',
        'month'=>'month'
    ];

@endphp
@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <div class="row" style="margin:0 auto;width: 850px;padding-top: 80px;">

        <div class="headingcenter text-center">
            <h2>Dashboard</h2>
            <div style="color:gray">Great! You're ready to go.</div>
        </div>

    </div>
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">

        <div class="row dashboard-wt-tabscontent-wrapper">
            <div class="wt-tabscontenttitle">
                <h2>Your Updates</h2>
            </div>
            <div class="row newStyleBoxes" style="display:block; margin: 0 auto">
                <div class="newStyleBoxesWrapper" style="margin: 0 auto">
                    <div class="newBoxStyle">
                        <div class="firsthalf"><a href="{{route('showFreelancerProposals')}}">{{ trans('lang.latest_proposals') }}</a></div>
                        <div class="secondhalf">{{$lastest_proposals}}</div>
                    </div>
                    <div class="newBoxStyle">
                        <div class="firsthalf"><a href="{{{ route('message') }}}">{{ trans('lang.new_msgs') }}</a></div>
                        <div class="secondhalf">{{$message_status}}</div>
                    </div>
                    <div class="newBoxStyle">
                        <div class="firsthalf"><a href="{{route('showFreelancerProposals')}}">{{ trans('lang.sessions') }}</a></div>
                        <div class="secondhalf">{{$applications}}</div>
                    </div>
                </div>
            </div>

            <div class="row">
 
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


        <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
            <h2>All availabilities</h2>
        </div>

        <div class="freelancer-profile scrolToCalend" id="all_availability">
            <div class="dashboard-vuecal-wrapper">
                <vue-cal ref="vuecal" style="height: 650px"
                         :time-from="0 * 60"
                         :time-to="24 * 60"
                         :disable-views="['years', 'year', 'week', 'day']"
                         :selected-date="selected_date"
                         default-view="month"
                         events-on-month-view="short"
                         :events="events"
                         :on-event-click="onEventClick"
                >
                </vue-cal>
            </div>

            <div class="wt-tabscontent tab-content">
                <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
                    <h2>Blue equals free this day</h2>
                </div>
                <div class="wt-tabscontenttitle">
                    <h2>Green equals busy on this day</h2>
                </div>
                <div class="wt-tabscontenttitle">
                    <h2>Red equals away on holiday</h2>
                </div>
                <div v-if="clickedDate != ''">
                    <div class="wt-tabcompanyinfo wt-tabsinfo" style="margin-top:50px">
                        <div class="wt-tabscontenttitle">
                            <h2 v-if="event_id">@{{user_name}}'s availability</h2>
                            <h2 v-if="!event_id">Create new availability</h2>
                        </div>
                    </div>
                    <div class="wt-accordiondetails classScrollTo">
                        <form id="availability_dashboard_form">

                            <div class="form-group">
                                <label for="availability_title">Title:</label>
                                {!! Form::text( 'availability_title',null, ['class' =>'form-control', 'placeholder' => 'Availability Title', 'v-model'=>'availability_title', 'required'=>'required'] ) !!}
                            </div>
                            <div class="form-group">
                                <label for="availability_title">Content:</label>
                                {!! Form::text( 'availability_content',null, ['class' =>'form-control', 'placeholder' => 'Availability description', 'v-model'=>'availability_content', 'required'=>'required'] ) !!}
                            </div>
                            <div class="form-group"  id="listDates">
                                <div class="isDay">
                                    <div class="form-group form-group-half">
                                        <div class="wt-divtheme wt-userform wt-userformvtwo">
                                            <div class="form-group">
                                                <span class="wt-select">
                                                    <date-picker
                                                            :config="{format: 'DD-MM-YYYY'}"
                                                            class="form-control"
                                                            name="start_date[0]"
                                                            placeholder="{{ trans('lang.start_date') }}"
                                                            v-model="availability_selected_date">
                                                    </date-picker>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-half">
                                        <div class="wt-divtheme wt-userform wt-userformvtwo">
                                            <div class="form-group">
                                                <span class="wt-select">
                                                    <date-picker
                                                            :config="{format: 'DD-MM-YYYY'}"
                                                            class="form-control"
                                                            name="end_date[0]"
                                                            placeholder="{{ trans('lang.end_date') }}"
                                                            v-model="availability_selected_end_date">
                                                    </date-picker>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="getIsDay"  v-if="!event_id" v-for="d in 6" style="display:none">
                                    <div class="form-group form-group-half">
                                        <div class="wt-divtheme wt-userform wt-userformvtwo">
                                            <div class="form-group">
                                        <span class="wt-select">
                                            <date-picker :config="{format: 'DD-MM-YYYY'}" class="form-control" placeholder="{{ trans('lang.start_date') }}" value=""></date-picker>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-half">
                                        <div class="wt-divtheme wt-userform wt-userformvtwo">
                                            <div class="form-group">
                                        <span class="wt-select">
                                            <date-picker :config="{format: 'DD-MM-YYYY'}" class="form-control" placeholder="{{ trans('lang.end_date') }}" value=""></date-picker>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button"  v-if="!event_id" class="wt-btn" v-on:click="createList" v-if="addDay!=6" id="addDay">add day</button>
                            </div>


                            <div class="form-group form-group-half">
                                <div class="wt-tabscontenttitle">
                                    <h2>Start Time</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <vue-timepicker name="booking_start" required  format="HH:mm" v-model="start"></vue-timepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-half">
                                <div class="wt-tabscontenttitle">
                                    <h2>End Time</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <vue-timepicker name="booking_end"  required   format="HH:mm" v-model="end"></vue-timepicker>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="wt-tabscontenttitle">
                                    <div class="float-left">
                                        <h2>Recurring date</h2>
                                    </div>
                                    <div class="form-group form-group-half  float-right">
                                        <switch_button v-model="is_recurring">Recurring Dates</switch_button>
                                        <input type="hidden" :value="false">
                                    </div>
                                </div>
                                <div class="form-group form-group-half float-left" v-if="is_recurring != false && availability_selected_date >= availability_selected_end_date">
                                    {!! Form::select('recurring_date', ['day'=>'day','week'=>'week','month'=>'month'], null, ['class' => 'form-control', 'placeholder' => "Recurring dates", 'v-model'=>'recurring_date']) !!}
                                </div>
                                <div class="form-group form-group-half float-left" v-if="is_recurring != false && availability_selected_date < availability_selected_end_date">
                                    {!! Form::select('recurring_date', ['week'=>'week','month'=>'month'], null, ['class' => 'form-control', 'placeholder' => "Recurring dates", 'v-model'=>'recurring_date']) !!}
                                </div>

                                <div class="form-group form-group-half float-right" v-if="recurring_date != '' && is_recurring != false">
                                    <span class="wt-select">
                                    <date-picker :config="{format: 'DD-MM-YYYY'}" class="form-control" name="recurring_end_date" placeholder="Last date recurring" requare value="" v-model="recurring_end_date"></date-picker>
                                    </span>
                                </div>
                            </div>
                            <div class="wt-jobskills wt-tabsinfo la-jobedit"  id="post_job">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.skills_req') }}</h2>
                                </div>
                                <div class="form-group">
                                    <select name="profession_id" id="" v-model="skill_id">
                                        <option>Profession</option>
                                        @foreach($professions as $profession)
                                            <option
                                                value="{{ $profession->id }}"
                                                @if(auth()->user()->profession_id == $profession->id) selected @endif
                                                :selected="skill_id==={{$profession->id}}"
                                            >
                                                {{ $profession->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="text-center">

                            <input type="hidden" name="recurring_date" v-if="event_id" v-model="recurring_date">
                            <input type="hidden" name="class" v-if="event_class" v-model="event_class">
                            <input type="hidden" name="user_id" v-if="user_id" v-model="user_id">
                            <input type="hidden" name="event_id" v-if="event_id" v-model="event_id">
                            <button class="btn btn-danger" v-if="event_id" @click="deleteEvent">Delete Availability</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
