@php
    $user = Auth::user();

        $arrJob_Appo_slot_times = config('job-settings.appo_slot_times');

        $arrJob_Adm_catch_time_interval = config('job-settings.adm_catch_time_interval');

        $recurringDates = [
            'day'=>'day',
            'week'=>'week',
            'month'=>'month'
        ];

        $homeVisits = [
            'Yes'=>'Yes',
            'No'=>'No',
            'N/A'=>'N/A'
        ];

        $arrBreaks = array(
            'Morning Break'=>'Morning Break',
            'Lunch Break'=>'Lunch Break',
            'Afternoon Break'=>'Afternoon Break',
            'Evening Break'=>'Evening Break',
            'Not Applicable' => 'Not Applicable',
        );
@endphp
@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<div class="wt-haslayout wt-dbsectionspace" id="dashboard">
    <div class="row page-group" style="margin-top: 69px;margin-bottom: 14px;">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
            <div class="page-group-selectors bg-dark-blue">Description</div>
            <div class="triangle"></div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="page-group-selectors bg-light-blue">Dates</div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
            <div class="page-group-selectors bg-specific-green">Requirements</div>
        </div>
    </div>
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser">
    <div class="row">

        <div class="">
            @if (Session::has('payment_message'))
                @php $response = Session::get('payment_message') @endphp
                <div class="flash_msg">
                    <flash_messages :message_class="'{{{$response['code']}}}'" :time ='5' :message="'{{{ $response['message'] }}}'" v-cloak></flash_messages>
                </div>
            @endif
            @if (session()->has('type'))
                @php session()->forget('type'); @endphp
            @endif
            <div class="preloader-section" v-if="loading" v-cloak>
                <div class="preloader-holder">
                    <div class="loader"></div>
                </div>
            </div>
                <div id="post_job_dashboard" class="post_job_dashboard-wrapper">
                    <div class="dashboard-vuecal-wrapper dashboard-vuecal-wrapper-employer">
                    </div>
                    <div  class="scrolToCalend">
                        <div class="wt-tabscontent tab-content">
                            {!! Form::open(['url' => url('job/post-job'), 'class' =>'post-job-form wt-haslayout', 'id' => 'post_job_dashboard_form',  '@submit.prevent'=>'submitJob']) !!}
                            <div class="wt-dashboardbox">
                                <div class="wt-dashboardboxtitle text-center">
                                    <div class="float-left" style="
                            border-right:4px solid #ffe188;
                            padding-right: 16px;
                            height: 36px;
                            padding-top: 5px;"><img src="{{url('images/icons/jobpost.png')}}" alt=""></div>
                                    <h2   v-if="event_id != ''" style=" font-weight: bold; text-transform: uppercase; font-family: AganeLight; color:#263b65; margin: 7px 0;">Update post event</h2>
                                    <h2   v-if="event_id == ''" style=" font-weight: bold; text-transform: uppercase; font-family: AganeLight; color:#263b65; margin: 7px 0;">{{ trans('lang.post_job') }}</h2>
                                </div>
                                <div class="wt-dashboardboxcontent  classScrollTo">
                                    <div class="form-group form-group-half">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.start_date') }}</h2>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-half">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.end_date') }}</h2>
                                        </div>
                                    </div>
                                    <div class="form-group"  id="listDates">
                                        <div class="isDay">
                                            <div class="form-group form-group-half">
                                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                                    <div class="form-group">
                                                <span class="wt-select">
                                                    <date-picker :config="{format: 'DD-MM-YYYY'}" class="form-control" name="start_date[0]" placeholder="{{ trans('lang.start_date') }}" value="" v-model="selecteddate"></date-picker>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-half" v-if="selecteddate!=''">
                                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                                    <div class="form-group">
                                                <span class="wt-select">
                                                    <date-picker :config="{format: 'DD-MM-YYYY'}"  class="form-control" name="end_date[0]" placeholder="{{ trans('lang.end_date') }}" value="" v-model="selecteddate_end"></date-picker>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="getIsDay" v-if="event_id == ''"  v-for="d in 6" style="display:none">
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
                                        <button type="button" class="wt-btn" v-if="event_id == ''" v-on:click="createList" v-if="addDay!=6" id="addDay">add day</button>
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
                                                <vue-timepicker name="booking_end"  required   format="HH:mm"  v-model="end"></vue-timepicker>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="event_id == ''">
                                        <div class="wt-tabscontenttitle" style="height: 40px;">
                                            <div class="float-left">
                                                <h2>Recurring date</h2>
                                            </div>
                                            <div class="form-group form-group-half  float-right">
                                                <switch_button v-model="is_recurring">Recurring Dates</switch_button>
                                                <input type="hidden" :value="false" name="recurring_date">
                                            </div>
                                        </div>
                                        <div class="form-group form-group-half float-left" v-if="is_recurring != false">
                                            {!! Form::select('recurring_date', ['day'=>'day','week'=>'week','month'=>'month'], null, ['class' => 'form-control', 'placeholder' => "Recurring dates", 'v-model'=>'recurring_date']) !!}
                                        </div>
                                        <div class="form-group form-group-half float-right" v-if="recurring_date != '' && is_recurring != false">
                                    <span class="wt-select">
                                    <date-picker :config="{format: 'DD-MM-YYYY'}" class="form-control" name="recurring_end_date" placeholder="Last date recurring" requare value="" v-model="recurring_end_date"></date-picker>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="wt-jobdescription wt-tabsinfo" v-if="event_id == ''">
                                        <div class="wt-tabscontenttitle">
                                            <h2>Other Appointment</h2>
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::select('job_appo_slot_times[]', $arrJob_Appo_slot_times, null, array( 'placeholder' => "Appointment Slot Times",'v-model'=>'job_appo_slot_times')) !!}
                                        </div>
                                        <div class="form-group form-group-half" v-if="this.job_appo_slot_times=='Other'">
                                            <input id="other_appo" type="text"
                                                   class="form-control"
                                                   name="job_appo_slot_times[]">
                                        </div>
                                    </div>
                                    <div class="wt-jobdescription wt-tabsinfo"   v-if="event_id == ''">
                                        <div class="form-group form-group-half">
                                            {!! Form::select('job_adm_catch_time', array('Yes'=>'Yes', 'No'=>'No'), null, array('placeholder' => "Admin Catch Up Time Provided", 'v-model'=>'job_adm_catch_time')) !!}
                                        </div>
                                        <div class="form-group form-group-half"  v-if="this.job_adm_catch_time=='Yes'">
                                            {!! Form::select('job_adm_catch_time_interval[]', $arrJob_Appo_slot_times, null, array( 'placeholder' => "Admin Catch Up Provided (interval)",'v-model'=>'job_adm_catch_time_interval')) !!}
                                        </div>
                                        <div class="form-group form-group-half" v-if="this.job_adm_catch_time_interval=='Other'">
                                            <input id="other_appo" type="text"
                                                   class="form-control"
                                                   name="job_adm_catch_time_interval[]">
                                        </div>
                                    </div>
                                    <div class="wt-jobdescription wt-tabsinfo"   v-if="event_id == ''">
                                        <div class="form-group form-group-half">
                                            {!! Form::select('breaks', $arrBreaks, $user->breaks, array('placeholder' => "Breaks")) !!}
                                        </div>

                                        <div class="form-group form-group-half">
                                            {!! Form::select('home_visits', $homeVisits, null, array('placeholder' => "Home visits",'v-model'=>'home_visits')) !!}
                                        </div>
                                    </div>
                                    <div class="wt-jobskills wt-tabsinfo la-jobedit" v-if="event_id == ''">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.skills_req') }}</h2>
                                        </div>
                                        <div class="la-jobedit-content">
                                            <!-- <job_skills :placeholder="'select professions'"></job_skills> -->
                                            {!! Form::select('profession_id', $professions, null, array('placeholder' => "Profession")) !!}
                                        </div>
                                    </div>
                                    <div class="wt-jobdescription wt-tabsinfo">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.job_title') }}</h2>
                                        </div>
                                        <div class="wt-formtheme wt-userform wt-userformvtwo">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="text" name="title" class="form-control" placeholder="{{ trans('lang.job_title') }}" v-model="booking_title">
                                                </div>

                                                <div class="form-group">
                                                    {!! Form::textarea('description', null, ['class' =>'form-control', 'placeholder' => trans('lang.job_dtl_note') , 'v-model'=>'booking_content']) !!}
                                                </div>

                                                <div class="form-group form-group-half"  v-if="event_id == ''">
                                                    <div class="left-inner-addon">
                                                        <span>£</span>
                                                        {!! Form::text('project_rates', null, ['class' => 'form-control halfWidth ratePicker', 'placeholder' => 'Your rate - per hour', 'min'=>'0']) !!}
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="wt-formtheme wt-userform wt-userformvtwo calendarbookingform" style=" display: none;" @click.prevent="preventClick">
                                            <div class="form-group " style="margin-top: 25px;">
                                                <label>Booking Title / Job Title</label>
                                                <input type="text" name="booking_title" disabled class="form-control " placeholder="Booking Title" v-model="booking_title">
                                            </div>
                                            <div class="form-group" style="margin-top: 25px;">
                                                <label>Booking description</label>
                                                {!! Form::textarea('booking_content', null, ['placeholder' => 'Booking description' , 'v-model'=>'booking_content']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wt-jobcategories wt-tabsinfo"  v-if="event_id == ''">
                                        <div class="wt-tabscontenttitle">
                                            <h2>Direct Bookings</h2>
                                        </div>
                                        <div class="wt-divtheme wt-userform wt-userformvtwo">
                                            <div class="form-group">
                                                {!! Form::select('direct_booking', array('Yes'=>'yes', 'No'=>'no'), null, array('placeholder' => "Direct Bookings")) !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class="wt-tabscontenttitle">
                                        <h2>Booking Contact Details</h2>
                                    </div>
                                    <div class="wt-jobcategories wt-tabsinfo">

                                        <div class="form-group form-group-half">
                                            {!! Form::text( 'first_name', $user->first_name, ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::text( 'last_name', $user->last_name, ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ) !!}
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::email( 'email', $user->email, ['class' =>'form-control', 'placeholder' => trans('lang.ph_email')] ) !!}
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::number( 'number', $user->number, ['class' =>'form-control', 'placeholder' => trans('lang.number')] ) !!}
                                        </div>


                                    </div>
                                </div>
                                <div class="wt-updatall"   v-if="event_id != ''">
                                    <input type="hidden" name="recurring_date" v-if="event_id" v-model="recurring_date">
                                    <input type="hidden" name="job_id" v-if="job_id" v-model="job_id">
                                    <input type="hidden" name="event_id" v-if="event_id" v-model="event_id">

                                    <i class="ti-announcement"></i>
                                    <span>{{{ trans('lang.save_changes_note') }}}</span>
                                    {!! Form::submit(trans('lang.btn_save_update'), ['class' => 'wt-btn', '@click'=>'updateEvent', 'id'=>'submit-profile']) !!}

                                </div>
                                <div class="wt-updatall"   v-if="event_id == ''">
                                    <i class="ti-announcement"></i>
                                    <span>{{{ trans('lang.save_changes_note') }}}</span>
                                    {!! Form::submit(trans('lang.post_job'), ['class' => 'wt-btn', 'id'=>'submit-profile']) !!}

                                </div>
                            </div>
                            {!! form::close(); !!}
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </section>
</div>
@endsection
