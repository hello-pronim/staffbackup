@php
    $user = Auth::user();

        $arrAppo_slot_times = config('job-settings.appo_slot_times');
        if(!empty($user->appo_slot_times) && !isset($arrAppo_slot_times[$user->appo_slot_times]))
        {
            $arrAppo_slot_times[$user->appo_slot_times] = $user->appo_slot_times;
        }
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
    <div class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left" id="post_job_edit">
                @if (Session::has('error'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'danger'" :time='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="preloader-section" v-if="loading" v-cloak>
                    <div class="preloader-holder">
                        <div class="loader"></div>
                    </div>
                </div>
                <div class="wt-haslayout wt-post-job-wrap">
                    <div>
                        {{--{{dump($job)}}--}}
                    </div>
                    {!! Form::open(['url' => '', 'class' =>'post-job-form wt-haslayout', 'id' => 'post_job_edit_form', '@submit.prevent'=>'updateJob("'.$job->id.'")']) !!}
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{ trans('lang.edit_job') }}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent  classScrollTo">
                            <div class="wt-tabscontenttitle" style="height: 40px;">
                                <div class="float-left">
                                    <h2>Change dates</h2>
                                </div>
                                <div class="form-group form-group-half  float-right">
                                    <switch_button v-model="changing_date">changing dates</switch_button>
                                    <input type="hidden" v-bind:value="changing_date" name="changing_date">
                                </div>
                            </div>

                            <div v-if="changing_date != false">
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

                                <div class="form-group" id="listDates">
                                    <div class="isDay">
                                        <div class="form-group form-group-half">
                                            <div class="wt-divtheme wt-userform wt-userformvtwo">
                                                <div class="form-group">
                                                    <span class="wt-select">
                                                        @if($firstJobStart)
                                                            @php
                                                                $startDate = (isset($firstJobStart)) ? $firstJobStart[0] : "";
                                                            @endphp
                                                            <date-picker :config="{format: 'DD-MM-YYYY'}" value="{{ $startDate }}" class="form-control" name="start_date[0]" placeholder="{{ trans('lang.start_date') }}"></date-picker>
                                                        @else
                                                            <date-picker :config="{format: 'DD-MM-YYYY'}" value="{{date("d-m-Y")}}" class="form-control" name="start_date[0]" placeholder="{{ trans('lang.start_date') }}"></date-picker>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-half">
                                            <div class="wt-divtheme wt-userform wt-userformvtwo">
                                                <div class="form-group">
                                                    <span class="wt-select">
                                                        @if($firstJobEnd)
                                                            <date-picker :config="{format: 'DD-MM-YYYY'}" value="{{$firstJobEnd[0]}}" class="form-control" name="end_date[0]" placeholder="{{ trans('lang.end_date') }}"></date-picker>
                                                        @else
                                                            <date-picker :config="{format: 'DD-MM-YYYY'}" value="{{date("d-m-Y")}}" class="form-control" name="end_date[0]" placeholder="{{ trans('lang.end_date') }}"></date-picker>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="getIsDay" v-for="d in 6" style="display:none">
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
                                    <button type="button" class="wt-btn" v-on:click="createList" v-if="addDay!=6" id="addDay">add day</button>
                                </div>

                                <div class="form-group form-group-half">
                                    <div class="wt-tabscontenttitle">
                                        <h2>Start Time</h2>
                                    </div>
                                    <div class="wt-divtheme wt-userform wt-userformvtwo">
                                        <div class="form-group">
                                            @if($firstJobStart)
                                                <vue-timepicker name="booking_start" required format="HH:mm" value="{{$firstJobStart[1]}}"></vue-timepicker>
                                            @else
                                                <vue-timepicker name="booking_start" required format="HH:mm" value="00:00"></vue-timepicker>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-half">
                                    <div class="wt-tabscontenttitle">
                                        <h2>End Time</h2>
                                    </div>
                                    <div class="wt-divtheme wt-userform wt-userformvtwo">
                                        <div class="form-group">
                                            @if($firstJobEnd)
                                            <vue-timepicker name="booking_end" required format="HH:mm" value="{{$firstJobEnd[1]}}"></vue-timepicker>
                                            @else
                                            <vue-timepicker name="booking_end" required format="HH:mm" value="23:59"></vue-timepicker>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
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
                                    @if($firstJob)
                                        <select name="recurring_date" class="form-control" id="recurring_date" placeholder="Recurring dates">
                                            <option value="day" @if($firstJob->recurring_date=='day') selected @endif>day</option>
                                            <option value="week" @if($firstJob->recurring_date=='week') selected @endif>week</option>
                                            <option value="month" @if($firstJob->recurring_date=='month') selected @endif>month</option>
                                        </select>
                                        <!-- {!! Form::select('recurring_date', ['day'=>'day','week'=>'week','month'=>'month'], $firstJob->recurring_date, ['class' => 'form-control','id'=>'recurring_date', 'placeholder' => "Recurring dates"]) !!} -->
                                    @else
                                        <select name="recurring_date" class="form-control" id="recurring_date" placeholder="Recurring dates">
                                            <option value="day">day</option>
                                            <option value="week">week</option>
                                            <option value="month">month</option>
                                        </select>
                                        <!-- {!! Form::select('recurring_date', ['day'=>'day','week'=>'week','month'=>'month'], null, ['class' => 'form-control','id'=>'recurring_date', 'placeholder' => "Recurring dates"]) !!} -->
                                    @endif
                                </div>
                                <div class="form-group form-group-half float-right" v-if="is_recurring != false">
                                    <span class="wt-select">
                                        <date-picker :config="{format: 'DD-MM-YYYY'}" class="form-control" name="recurring_end_date" placeholder="Last date recurring" requare value={{date('d-m-Y', strtotime($firstJob->recurring_end_date))}}></date-picker>
                                    </span>
                                </div>
                            </div>

                            </div>
                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>Other Appointment</h2>
                                </div>
                                <div class="form-group form-group-half">
                                    {!! Form::select('job_appo_slot_times[]', $arrAppo_slot_times, $job->job_appo_slot_times, array( 'placeholder' => "Appointment Slot Times")) !!}
                                </div>
                                <div class="form-group form-group-half" v-if="this.appo_slot_times=='Other'">
                                    <input id="other_appo" type="text" class="form-control" name="job_appo_slot_times[]">
                                </div>
                            </div>

                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="form-group form-group-half">
                                    {!! Form::select('job_adm_catch_time', array('Yes'=>'Yes', 'No'=>'No'), $job->job_adm_catch_time, array('placeholder' => "Admin Catch Up Time Provided")) !!}
                                </div>
                                <div class="form-group form-group-half">
                                    {!! Form::select('breaks', $arrBreaks, $job->breaks, array('placeholder' => "Breaks")) !!}
                                </div>

                                <div class="form-group form-group-half">
                                    {!! Form::select('home_visits', $homeVisits, $job->home_visits, array('placeholder' => "Home visits")) !!}
                                </div>
                            </div>

                            <div class="wt-jobskills wt-tabsinfo la-jobedit">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.skills_req') }}</h2>
                                </div>
                                <div class="la-jobedit-content">
                                    <!-- <job_skills :placeholder="'select professions'"></job_skills> -->
                                    {!! Form::select('profession_id', $professions, $job->profession_id, array('placeholder' => "Profession")) !!}
                                </div>
                            </div>

                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.job_title') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                        <div class="form-group">
                                            {!! Form::text('title', $job->title, ['class' =>'form-control', 'placeholder' => trans('lang.job_title')]) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::textarea('description', $job->description, ['class' =>'form-control', 'placeholder' => trans('lang.job_dtl_note')]) !!}
                                        </div>

                                        <div class="form-group form-group-half">
                                            <div class="left-inner-addon">
                                                <span>£</span>
                                                {!! Form::text('project_rates', $job->project_rates, array('class' => 'form-control halfWidth ratePicker', 'placeholder' => 'Your rate - per hour', 'min'=>'0')) !!}
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                {{--<div class="wt-formtheme wt-userform wt-userformvtwo calendarbookingform" style="display: none;" @click.prevent="preventClick">--}}
                                    {{--<div class="form-group " style="margin-top: 25px;">--}}
                                        {{--<label>Booking Title / Job Title</label>--}}
                                        {{--{!! Form::text( 'first_name', $job->title, ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group" style="margin-top: 25px;">--}}
                                        {{--<label>Booking description</label>--}}
                                        {{--{!! Form::textarea('booking_content', $job->description, ['placeholder' => 'Booking description' ]) !!}--}}
                                    {{--</div>--}}
                                    {{--<button @click="setBooking" class="wt-btn" style="margin-top: 25px;">See booking in calendar</button>--}}
                                {{--</div>--}}
                            </div>

                            <div class="wt-jobcategories wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>Direct Bookings</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    {{$user->direct_booking}}
                                    <div class="form-group">
                                        {!! Form::select('direct_booking', array('Yes'=>'yes', 'No'=>'no'), $job->direct_booking, ['placeholder' => 'Direct Bookings' ]) !!}
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


                                {{--<div class="form-group form-group-half">--}}
                                {{--{!! Form::text('emp_contact', $user->emp_contact, ['class' =>'form-control', 'placeholder' => trans('lang.emp_contact')] ) !!}--}}
                                {{--</div>--}}
                                {{--<div class="form-group form-group-half">--}}
                                {{--{!! Form::tel('emp_telno', $user->emp_telno, ['class' =>'form-control', 'placeholder' => trans('lang.emp_telno')] ) !!}--}}
                                {{--</div>--}}
                                {{--<div class="form-group form-group-half">--}}
                                {{--{!! Form::url('emp_pos', $user->emp_pos, ['class' =>'form-control', 'placeholder' => 'Position'] ) !!}--}}
                                {{--</div>--}}
                                {{--<div class="form-group form-group-half">--}}
                                {{--{!! Form::email('emp_email', $user->emp_email, ['class' =>'form-control', 'placeholder' => 'Email'] ) !!}--}}
                                {{--</div>--}}

                                {{--<div class="form-group ">--}}
                                {{--<input type="text" class="form-control" name="org_name" value="{{$user->emp_contact}}" placeholder="Organisation name">--}}
                                {{--</div>--}}
                                {{--<div class="form-group form-group-half">--}}
                                {{--<input id="organisation_position" type="text" class="form-control" name="organisation_position" value="{{$user->emp_pos}}" placeholder="Position">--}}
                                {{--</div>--}}
                                {{--<div class="form-group form-group-half">--}}
                                {{--<input id="organisation_email" type="email" class="form-control" name="organisation_email" value="{{$user->emp_email}}" placeholder="Email">--}}
                                {{--</div>--}}
                                {{--<div class="form-group form-group-half">--}}
                                {{--<input id="organisation_contact" type="text" class="form-control" name="organisation_contact" value="{{$user->emp_telno}}" placeholder="Direct Contact No">--}}
                                {{--</div>--}}

                            </div>

                            {{--<div class="wt-jobcategories wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.job_cats') }}</h2>--}}
                            {{--</div>--}}
                            {{--<div class="wt-divtheme wt-userform wt-userformvtwo">--}}
                            {{--<div class="form-group">--}}
                            {{--<span class="wt-select">--}}
                            {{--{!! Form::select('categories[]', $categories, null, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_job_cats'))) !!}--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="wt-languages-holder wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.langs') }}</h2>--}}
                            {{--</div>--}}
                            {{--<div class="wt-divtheme wt-userform wt-userformvtwo">--}}
                            {{--<div class="form-group">--}}
                            {{--<span class="wt-select">--}}
                            {{--{!! Form::select('languages[]', $languages, null, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_lang'))) !!}--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="wt-jobdetails wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>Calendar Booking</h2>--}}
                            {{--</div>--}}
                            {{--<div class="wt-tabscontenttitle" style="margin-top: 20px; ">--}}
                            {{--<h2>--}}
                            {{--Green equals free this day<br>--}}
                            {{--Blue equals booking on this day<br>--}}
                            {{--Red equals away on holiday<br>--}}
                            {{--</h2>--}}
                            {{--</div>--}}

                            {{--</div>--}}
                            {{--<div class="wt-jobdetails wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.job_dtl') }}</h2>--}}
                            {{--</div>--}}
                            {{--<div class="wt-formtheme wt-userform wt-userformvtwo">--}}
                            {{--{!! Form::textarea('description', null, ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.job_dtl_note'), 'v-model'=>'description']) !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="hourly_rate_desc">Please enter--}}
                            {{--additional information in the--}}
                            {{--communication box if required</label>--}}
                            {{--<input id="hourly_rate_desc" type="text"--}}
                            {{--class="form-control"--}}
                            {{--name="hourly_rate_desc"--}}
                            {{--value="{{ $user->profile->hourly_rate_desc }}"--}}
                            {{--placeholder="Additional info">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="wt-jobskills wt-jobskills-holder wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.skills_req') }}</h2>--}}
                            {{--</div>--}}
                            {{--<job_skills :placeholder="'skills already selected'"></job_skills>--}}
                            {{--</div>--}}

                            {{--<div class="wt-joblocation wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.your_loc') }}</h2>--}}
                            {{--</div>--}}
                            {{--<div class="wt-formtheme wt-userform">--}}
                            {{--<div class="wt-tabsinfo">--}}
                            {{--<div class="form-group">--}}
                            {{--<input type="text" name="radius" class="form-control" placeholder="Radius" />--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group form-group-half">--}}
                            {{--<span class="wt-select">--}}
                            {{--{!! Form::select('locations', $locations, null, array('class' => 'skill-dynamic-field', 'placeholder' => trans('lang.select_locations'))) !!}--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<location-selector></location-selector>--}}


                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="wt-featuredholder wt-tabsinfo">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.is_featured') }}</h2>--}}
                            {{--<div class="wt-rightarea">--}}
                            {{--<div class="wt-on-off float-right">--}}
                            {{--<switch_button v-model="is_featured">{{{ trans('lang.is_featured') }}}</switch_button>--}}
                            {{--<input type="hidden" :value="is_featured" name="is_featured">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="wt-attachmentsholder">--}}
                            {{--<div class="lara-attachment-files">--}}
                            {{--<div class="wt-tabscontenttitle">--}}
                            {{--<h2>{{ trans('lang.attachments') }}</h2>--}}
                            {{--<div class="wt-rightarea">--}}
                            {{--<div class="wt-on-off float-right">--}}
                            {{--<switch_button v-model="show_attachments">{{{ trans('lang.attachments_note') }}}</switch_button>--}}
                            {{--<input type="hidden" :value="show_attachments" name="show_attachments">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<job_attachments :temp_url="'{{url('job/upload-temp-image')}}'"></job_attachments>--}}
                            {{--<div class="form-group input-preview">--}}
                            {{--<ul class="wt-attachfile dropzone-previews">--}}

                            {{--</ul>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            {{--</div>--}}



                            {{--</div>--}}


                        </div>
                        <div class="wt-updatall">
                            <input type="hidden" name="job_id" value="{{$job->id}}">
                            <input type="hidden" name="english_level" value="{{($job->english_level)?$job->english_level:'basic'}}">
                            <input type="hidden" name="freelancer_type" value="{{($job->freelancer_type)?$job->freelancer_type:'pro_independent'}}">
                            <input type="hidden" name="project_levels" value="{{($job->project_levels)?$job->project_levels:'basic'}}">
                            <i class="ti-announcement"></i>
                            <span>{{{ trans('lang.save_changes_note') }}}</span>
                            {!! Form::submit(trans('lang.btn_save_update'), ['class' => 'wt-btn']) !!}

                        </div>

                    </div>
                    {!! form::close(); !!}
                </div>
            </div>
        </div>
    </div>
@endsection
