@php

    $user = Auth::user();

    $arrITSoftware = array(
           'Adastra'=>'Adastra',
            'Cerna'=>'Cerna',
            'Cerna Millenium'=>'Cerna Millenium',
            'Cleo'=>'Cleo',
            'DGL'=>'DGL',
            'Docman'=>'Docman',
            'Edis & A&E System'=>'Edis & A&E System',
            'Emis Community'=>'Emis Community',
            'Emis LV'=>'Emis LV',
            'Emis PCS'=>'Emis PCS',
            'Emis Web'=>'Emis Web',
            'Frontdesk'=>'Frontdesk',
            'Heydoc'=>'Heydoc',
            'Infoslex'=>'Infoslex',
            'Microtest'=>'Microtest',
            'Premiere'=>'Premiere',
            'Symphony'=>'Symphony',
            'Synergy'=>'Synergy',
            'SystmOne'=>'SystmOne',
            'Torex'=>'Torex',
            'Vision'=>'Vision',
            'Vision Anywhere'=>'Vision Anywhere',
        );

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
        {!! Form::select('itsoftware', $arrITSoftware, Auth::user()->itsoftware, array('placeholder' => "Computer System in use")) !!}
    </div>
</div>