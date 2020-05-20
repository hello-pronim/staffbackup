@php

    $user = Auth::user();

 $arrOrgTypes = array(
        'NHS'=>'NHS',
        'Private organisation providing NHS care'=>'Private organisation providing NHS care',
        'Private organisation proving private healthcare'=>'Private organisation proving private healthcare',
    );
@endphp
<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.your_details') }}}</h2>
</div>
<div class="lara-detail-form">
    <fieldset>
        <div class="form-group ">
            <input type="text"
                   class="form-control"
                   name="org_name"
                   value="{{$user->org_name}}"
                   placeholder="Organisation name">
        </div>
        <div class="form-group ">
            {!! Form::select('org_type', $arrOrgTypes, $user->profile->org_type, array('placeholder' => "Organisation type")) !!}
        </div>
        <div class="form-group">
            <input id="org_desc" type="text"
                   class="form-control"
                   name="org_desc"
                   value="{{$user->org_desc}}"

                   placeholder="Organisation description">
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ) !!}
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
