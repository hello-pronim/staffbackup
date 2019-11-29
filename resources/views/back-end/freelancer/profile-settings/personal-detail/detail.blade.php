<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.your_details') }}}</h2>
</div>
<div class="wt-formtheme">
    <fieldset>
        <div class="form-group form-group-half">
            <span class="wt-select">
                {!! Form::select( 'gender', ['male' => 'Male', 'female' => 'Female'], e($gender), ['placeholder' => trans('lang.ph_select_gender')] ) !!}
            </span>
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ) !!}
        </div>
        <div class="form-group form-group-half">
            {!! Form::number( 'hourly_rate', e($hourly_rate), ['class' =>'form-control', 'placeholder' => trans('lang.ph_service_hoyrly_rate')] ) !!}
        </div>
        <div class="form-group">
            {!! Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline')] ) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ) !!}
        </div>


    </fieldset>
</div>


<div class="wt-tabscontenttitle" style="margin-top: 20px;">
    <h2>Avilable days and hours</h2>
</div>
<div class="wt-formtheme">
    <div class="form-group form-group-half">
        <select id="multiselect" class="form-control" name="days_avail[]" data-dbValue="{{$days_avail}}" multiple="multiple">
            <option>Monday</option>
            <option>Tuesday</option>
            <option>Wednesday</option>
            <option>Thursday</option>
            <option>Friday</option>
            <option>Saturday</option>
            <option>Sunday</option>
        </select>
    </div>
    <div class="form-group form-group-half">
        <div id="datetimepickerDate" class="input-group timerange">
                    <input class="form-control" name="hours_avail" type="text" value="{{$hours_avail}}" autocomplete="off">
                    <span class="input-group-addon" style="">
          </span>
        </div>

    </div>


</div>