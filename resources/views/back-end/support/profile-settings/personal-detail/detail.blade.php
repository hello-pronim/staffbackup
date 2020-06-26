@php

        $arrProfReq = array(
        'GP'=>'GP',
        'Physicians Associate/Assistant'=>'Physicians Associate/Assistant',
        'Advanced Nurse Practitioner'=>'Advanced Nurse Practitioner',
        'Practice Nurse'=>'Practice Nurse',
        'Community Nurse'=>'Community Nurse',
        'District Nurse'=>'District Nurse',
        'Health Care Assistant'=>'Health Care Assistant',
        'Phlebotomist'=>'Phlebotomist',
        'Clinical Pharmacist'=>'Clinical Pharmacist',
        'Community Psychiatric Nurse'=>'Community Psychiatric Nurse',
        'Mental Health Nurse'=>'Mental Health Nurse',
        'Counsellor'=>'Counsellor',
        'Drug and Alcohol worker'=>'Drug and Alcohol worker',
        'Social Worker'=>'Social Worker',
     );


        $user = Auth::user();
@endphp
<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.your_details') }}}</h2>
</div>
<div class="wt-formtheme">
    <fieldset>

        <div class="form-group form-group-half">
            {!! Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ) !!}
        </div>


        <div class="form-group">
            <span class="wt-select">
            {!! Form::select('profession', $arrProfReq, $user->profession, array('placeholder' => "Profession", "class"=>"form-control")) !!}
            </span>
        </div>
{{--
        <div class="form-group form-group-half">
            <input  type="text"
                    class="form-control"
                    name="pin"
                    value="{{$user->pin}}"

                    placeholder="Pin">
        </div>
        <div class="form-group form-group-half">
            <date-picker :config="{format: 'YYYY-MM-DD'}"

                         value="{{$user->pin_date_revalid}}"

                         class="form-control"
                         name="pin_date_revalid"
                         placeholder="Pin date of revalidation"
            ></date-picker>
		</div>
--}}
        <div class="form-group form-group-half">
            {!! Form::text( 'hourly_rate', e($hourly_rate), ['class' =>'form-control', 'placeholder' => trans('lang.ph_service_hoyrly_rate')] ) !!}
        </div>



        <div class="form-group form-group-half">
        <span class="wt-checkbox"
              style="    margin-left: 15px;    margin-top: 17px;">
            <span class="wt-checkbox">
                    <input id="hourly_rate_negotiable"
                           type="checkbox"
                           name="hourly_rate_negotiable"
                            {{$hourly_rate_negotiable=='on'? 'checked' : ''}}

                    >
                    <label for="hourly_rate_negotiable"><span> Hourly rate negotiable</span></label>
            </span>
        </span>
        </div>
        <div class="form-group">
            {!! Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline')] ) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ) !!}
        </div>


    </fieldset>
</div>


{{--<div class="wt-tabscontenttitle" style="margin-top: 20px;">--}}
    {{--<h2>Avilable days and hours</h2>--}}
{{--</div>--}}
{{--<div class="wt-formtheme">--}}
    {{--<div class="form-group form-group-half">--}}
        {{--<select id="multiselect" class="form-control" name="days_avail[]" data-dbValue="{{$days_avail}}" multiple="multiple">--}}
            {{--<option>Monday</option>--}}
            {{--<option>Tuesday</option>--}}
            {{--<option>Wednesday</option>--}}
            {{--<option>Thursday</option>--}}
            {{--<option>Friday</option>--}}
            {{--<option>Saturday</option>--}}
            {{--<option>Sunday</option>--}}
        {{--</select>--}}
    {{--</div>--}}
    {{--<div class="form-group form-group-half">--}}
        {{--<div id="datetimepickerDate" class="input-group timerange">--}}
                    {{--<input class="form-control" name="hours_avail" type="text" value="{{$hours_avail}}" autocomplete="off">--}}
                    {{--<span class="input-group-addon" style="">--}}
          {{--</span>--}}
        {{--</div>--}}

    {{--</div>--}}


{{--</div>--}}
<div class="wt-tabscontenttitle" style="margin-top: 20px;">
    <h2>Driving License</h2>
</div>
<div class="wt-formtheme">
    <div class="form-group ">
        <span class="wt-select">

            {!! Form::select('drive_license', ['Yes'=>'Yes', 'No'=>'No'], $user->drive_license, array('placeholder' => "Do you have full driving license?")) !!}

        </span>
    </div>
</div>
<div class="wt-tabscontenttitle" style="margin-top: 20px;">
    <h2>Endorsements</h2>
</div>
<div class="wt-formtheme">
    <div class="form-group ">
        <span class="wt-select">

            {!! Form::select('endorsements', ['Yes'=>'Yes', 'No'=>'No'], Auth::user()->endorsements, array('placeholder' => "Do you	have any endorsements?")) !!}

        </span>
    </div>
</div>
<div class="wt-tabscontenttitle" style="margin-top: 20px;">
    <h2>Computer System in use</h2>
</div>
<div class="wt-formtheme">
    <div class="form-group ">
        <multiselect v-model="itsoftware" :options="itsoftware_options" :searchable="false" :close-on-select="false" :clear-on-select="false" :preserve-search="false" :show-labels="false" :multiple="true" placeholder="Computer Systems" name="itsoftware" class="multiselect-upd" ref="input" data-value="{{ json_encode($user->itsoftware != null ? unserialize($user->itsoftware) : []) }}">
            <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">@{{ values.length }} option@{{ values.length != 1 ? 's' : '' }} selected</span></template>
        </multiselect>
        <select name="itsoftware[]" style="display:none;" multiple>
            <option v-for="value in itsoftware" :value="value" selected></option>
        </select>
    </div>
</div>

<div class="wt-tabscontenttitle" style="margin-top: 20px;">
    <h2>Limted Company details</h2>
</div>
<div class="wt-formtheme">
    <div class="form-group">
        {!! Form::text( 'limitied_company_number', Auth::user()->limitied_company_number, ['class' =>'form-control', 'placeholder' =>"Limited Company Number"] ) !!}
    </div>
    <div class="form-group">
        {!! Form::text( 'limitied_company_name', Auth::user()->limitied_company_name, ['class' =>'form-control', 'placeholder' => "Limited Company Name" ] ) !!}
    </div>
</div>
