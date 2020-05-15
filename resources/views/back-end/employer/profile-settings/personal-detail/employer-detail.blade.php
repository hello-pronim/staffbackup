@php
    $user = Auth::user();

$cqc_ratings = array(
                          'Outstanding'=>'Outstanding',
                          'Good'=>'Good',
                          'Requires Improvement'=>'Requires Improvement',
                          'Inadequate'=> 'Inadequate'
                          );
  $cqc_ratings_date = array(
  '2015'=>'2015',
  '2016'=>'2016',
  '2017'=>'2017',
  '2018'=>'2018',
  '2019'=>'2019',

  );
  $payment_options = array(
  'Paypal'=>'Paypal',
  'BACS'=>'BACS',
  'Cheque'=>'Cheque'
  );
  $subscribe_options  = array(
  'plan_G6DvQf9zdEGczW'=>'6 Months',
  'plan_G6DvMJGDvP6wGz'=>'3 Months',
  'plan_G6DuLUGgkizyrs '=>'Monthly'
  );

  $arrSettings = array(
  'GP Surgery'=>'GP Surgery',
  'Walk-In centre'=>'Walk-In centre',
  'Urgent Care Centre'=>'Urgent Care Centre',
  'GP Out Of Hours'=>'GP Out Of Hours',
  'Community Service'=>'Community Service',
  'Other'=>'Other',

  );
  if(!isset($arrSettings[$user->setting]))
  {
    $arrSettings[$user->setting] = $user->setting;
  }
  $arrProfReq = array(
  'Practice Manager'=>'Practice Manager',
  'Practice Nurse'=>'Practice Nurse',
  'Advanced Nurse Practitioner'=>'Advanced Nurse Practitioner',
  'GP'=>'GP',
  'Receptionist'=>'Receptionist',
  'Pharmacist'=>'Pharmacist',
  'Community Nurse'=>'Community Nurse',
  'District Nurse'=>'District Nurse',
  'Healthcare Assistant (HCA)'=>'Healthcare Assistant (HCA)',
  );

  $arrSpecialInterests = array(
  'Diabetes'=>'Diabetes',
  'Rhematology'=>'Rhematology',
  'Neurology'=>'Neurology',
  'Dermatology'=>'Dermatology',
  'Asthma'=>'Asthma',
  'Mental Health'=>'Mental Health',
  'Substance Misuse and Addictions'=>'Substance Misuse and Addictions',
  'MSK'=>'MSK',
  'Paediatrics'=>'Paediatrics',
  'Cardiology'=>'Cardiology',
  'Gastrointestinal'=>'Gastrointestinal',
  'Other'=>'Other',
  );
  if(!isset($arrSpecialInterests[$user->special_interests]))
  {
    $arrSpecialInterests[$user->special_interests] = $user->special_interests;
  }

  $arrAppo_slot_times = array(
  '10 minutes'=>'10 minutes',
  '15 minutes'=>'15 minutes',
  '20 minutes'=>'20 minutes',
  '30 minutes'=>'30 minutes',
  'Other'=>'Other',
  );
  if(!isset($arrAppo_slot_times[$user->appo_slot_times]))
  {
    $arrAppo_slot_times[$user->appo_slot_times] = $user->appo_slot_times;
  }


  $arrBreaks = array(
  'Morning Break'=>'Morning Break',
  'Lunch Break'=>'Lunch Break',
  'Afternoon Break'=>'Afternoon Break',
  'Evening Break'=>'Evening Break',
  'Not Applicable' => 'Not Applicable',
  );

  $arrPaymentTerms = array(
  'Invoices usually paid within 7 days of receipt'=>'Invoices usually paid within 7 days of receipt',
  'Invoices usually paid within 14 days of receipt'=>'Invoices usually paid within 14 days of receipt',
  'Other'=>'Other',
  );
  if(!isset($arrPaymentTerms[$user->payment_terms]))
  {
    $arrPaymentTerms[$user->payment_terms] = $user->payment_terms;
  }

  $nationals = array(
      'Afghan',
      'Albanian',
      'Algerian',
      'American',
      'Andorran',
      'Angolan',
      'Antiguans',
      'Argentinean',
      'Armenian',
      'Australian',
      'Austrian',
      'Azerbaijani',
      'Bahamian',
      'Bahraini',
      'Bangladeshi',
      'Barbadian',
      'Barbudans',
      'Batswana',
      'Belarusian',
      'Belgian',
      'Belizean',
      'Beninese',
      'Bhutanese',
      'Bolivian',
      'Bosnian',
      'Brazilian',
      'British',
      'Bruneian',
      'Bulgarian',
      'Burkinabe',
      'Burmese',
      'Burundian',
      'Cambodian',
      'Cameroonian',
      'Canadian',
      'Cape Verdean',
      'Central African',
      'Chadian',
      'Chilean',
      'Chinese',
      'Colombian',
      'Comoran',
      'Congolese',
      'Costa Rican',
      'Croatian',
      'Cuban',
      'Cypriot',
      'Czech',
      'Danish',
      'Djibouti',
      'Dominican',
      'Dutch',
      'East Timorese',
      'Ecuadorean',
      'Egyptian',
      'Emirian',
      'Equatorial Guinean',
      'Eritrean',
      'Estonian',
      'Ethiopian',
      'Fijian',
      'Filipino',
      'Finnish',
      'French',
      'Gabonese',
      'Gambian',
      'Georgian',
      'German',
      'Ghanaian',
      'Greek',
      'Grenadian',
      'Guatemalan',
      'Guinea-Bissauan',
      'Guinean',
      'Guyanese',
      'Haitian',
      'Herzegovinian',
      'Honduran',
      'Hungarian',
      'I-Kiribati',
      'Icelander',
      'Indian',
      'Indonesian',
      'Iranian',
      'Iraqi',
      'Irish',
      'Israeli',
      'Italian',
      'Ivorian',
      'Jamaican',
      'Japanese',
      'Jordanian',
      'Kazakhstani',
      'Kenyan',
      'Kittian and Nevisian',
      'Kuwaiti',
      'Kyrgyz',
      'Laotian',
      'Latvian',
      'Lebanese',
      'Liberian',
      'Libyan',
      'Liechtensteiner',
      'Lithuanian',
      'Luxembourger',
      'Macedonian',
      'Malagasy',
      'Malawian',
      'Malaysian',
      'Maldivan',
      'Malian',
      'Maltese',
      'Marshallese',
      'Mauritanian',
      'Mauritian',
      'Mexican',
      'Micronesian',
      'Moldovan',
      'Monacan',
      'Mongolian',
      'Moroccan',
      'Mosotho',
      'Motswana',
      'Mozambican',
      'Namibian',
      'Nauruan',
      'Nepalese',
      'New Zealander',
      'Nicaraguan',
      'Nigerian',
      'Nigerien',
      'North Korean',
      'Northern Irish',
      'Norwegian',
      'Omani',
      'Pakistani',
      'Palauan',
      'Panamanian',
      'Papua New Guinean',
      'Paraguayan',
      'Peruvian',
      'Polish',
      'Portuguese',
      'Qatari',
      'Romanian',
      'Russian',
      'Rwandan',
      'Saint Lucian',
      'Salvadoran',
      'Samoan',
      'San Marinese',
      'Sao Tomean',
      'Saudi',
      'Scottish',
      'Senegalese',
      'Serbian',
      'Seychellois',
      'Sierra Leonean',
      'Singaporean',
      'Slovakian',
      'Slovenian',
      'Solomon Islander',
      'Somali',
      'South African',
      'South Korean',
      'Spanish',
      'Sri Lankan',
      'Sudanese',
      'Surinamer',
      'Swazi',
      'Swedish',
      'Swiss',
      'Syrian',
      'Taiwanese',
      'Tajik',
      'Tanzanian',
      'Thai',
      'Togolese',
      'Tongan',
      'Trinidadian/Tobagonian',
      'Tunisian',
      'Turkish',
      'Tuvaluan',
      'Ugandan',
      'Ukrainian',
      'Uruguayan',
      'Uzbekistani',
      'Venezuelan',
      'Vietnamese',
      'Welsh',
      'Yemenite',
      'Zambian',
      'Zimbabwean'
);
  $arrNationals = array();
  foreach($nationals as $national)
  {
      $arrNationals[$national] = $national;
  }

  $arrPaymentMethods = array(
  'Limited Company'=>'Limited Company',
  'Self Employed'=>'Self Employed',
  '[DELETED]PAYE'=>'[DELETED]PAYE',
  );

@endphp
<div class="wt-tabcompanyinfo wt-tabsinfo">
    {{--<div class="wt-tabscontenttitle">--}}
    {{--<h2>{{{ trans('lang.company_details') }}}</h2>--}}
    {{--</div>--}}
    <div class="wt-accordiondetails">



    </div>

    @if (!empty($emp_contact))
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.emp_contact') }}}</h2>
        </div>
        <div class="wt-accordiondetails">
            <div class="form-group form-group-half">
                {!! Form::text( 'emp_contact', e($emp_contact), ['class' =>'form-control', 'placeholder' => trans('lang.emp_contact')] ) !!}
            </div>
        </div>
    @endif

    @if (!empty($emp_telno))
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.emp_telno') }}}</h2>
        </div>
        <div class="wt-accordiondetails">
            <div class="form-group form-group-half">
                {!! Form::text( 'emp_telno', e($emp_telno), ['class' =>'form-control', 'placeholder' => trans('lang.emp_telno')] ) !!}
            </div>
        </div>
    @endif

    @if (!empty($emp_website))
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.emp_website') }}}</h2>
        </div>
        <div class="wt-accordiondetails">
            <div class="form-group form-group-half">
                {!! Form::text( 'emp_website', e($emp_website), ['class' =>'form-control', 'placeholder' => trans('lang.emp_website')] ) !!}
            </div>
        </div>
    @endif

    @if (!empty($emp_cqc_rating))
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.emp_cqc_rating') }}}</h2>
        </div>
        <div class="wt-accordiondetails">
            <div class="form-group form-group-half">

                {!! Form::select('emp_cqc_rating_date', $cqc_ratings_date, $user->emp_cqc_rating_date, array('placeholder' => trans('lang.emp_cqc_rating_date'), 'class' => 'form-group')) !!}

            </div>
            <div class="form-group form-group-half">

                {!! Form::select('emp_cqc_rating', $cqc_ratings, $user->emp_cqc_rating, array('placeholder' => trans('lang.emp_cqc_rating'), 'class' => 'form-group')) !!}

            </div>
        </div>
    @endif

    <h4>Backup Company contact</h4>
    <div class="form-group form-group-half">
        <input id="backup_emp_contact" type="text"
               class="form-control"
               name="backup_emp_contact"
               value="{{$user->backup_emp_contact}}"
               placeholder="Backup Company Contact"
        >
    </div>
    <div class="form-group form-group-half">
        <input id="backup_emp_email" type="email"
               class="form-control"
               name="backup_emp_email"
               value="{{$user->backup_emp_email}}"
               placeholder="Backup Company Email"
        >
    </div>
    <div class="form-group form-group-half">
        <input id="backup_emp_pos" type="text"
               class="form-control"
               name="backup_emp_pos"
               value="{{$user->backup_emp_pos}}"
               placeholder="Backup Company Position"
        >
    </div>
    <div class="form-group form-group-half">
        <input id="backup_emp_tel" type="number"
               class="form-control"
               name="backup_emp_tel"
               value="{{$user->backup_emp_tel}}"
               placeholder="Backup Company Tel"
        >
    </div>

    {{--<div class="form-group">--}}
        {{--<input id="emp_desc" type="text"--}}
               {{--class="form-control"--}}
               {{--name="emp_desc"--}}
               {{--value="{{$user->emp_desc}}"--}}
               {{--placeholder="Description"--}}
        {{-->--}}

    {{--</div>--}}



    <!-- New columns for sheet-->


    <div class="form-group ">
        {!! Form::select('setting[]', $arrSettings, $user->setting, array('v-model'=>'appoSlotTime', 'placeholder' => "Setting")) !!}
    </div>
    <div class="form-group "
         v-if="appoSlotTime=='Other'">
        <input id="other_setting" type="text"
               class="form-control"
               name="setting[]"
               placeholder="Other Setting">
    </div>

    <div class="form-group form-group-half">
        <input type="text"
               class="form-control"
               name="pin"
               placeholder="Pin">
    </div>
    <div class="form-group form-group-half">
        <date-picker
                :config="{format: 'YYYY-MM-DD'}"
                class="form-control"
                value="{{$user->pin_date_revalid}}"
                name="pin_date_revalid"
                placeholder="Pin date of revalidation"
        ></date-picker>
    </div>
    <br>

    <div class="form-group form-group">
        <label for="insurance"
               style="display: inline-block">Insurance  Details</label>
            <input
                type="checkbox"
                name="insurance"
                {{$user->insurance=='on'? 'checked' : ''}}
                placeholder="Insurance"/>
    </div>

    <div class="form-group ">
        <input type="text"
               class="form-control"
               name="policy_number"
               value="{{$user->policy_number}}"

               placeholder="Policy Number"/>
    </div>

    <div class="form-group">
        <label>Organisation Contact</label>
    </div>
    <div class="form-group form-group-half">
        <input id="org_name" type="text"
               class="form-control"
               name="org_name"
               value="{{$user->org_name}}"

               placeholder="Name">
    </div>
    <div class="form-group form-group-half">
        <input id="organisation_position" type="text"
               class="form-control"
               name="organisation_position"
               value="{{$user->organisation_position}}"

               placeholder="Position">
    </div>
    <div class="form-group form-group-half">
        <input id="organisation_email" type="email"
               class="form-control"
               name="organisation_email"
               value="{{$user->organisation_email}}"

               placeholder="Email">
    </div>
    <div class="form-group form-group-half">
        <input id="organisation_contact" type="text"
               class="form-control"
               name="organisation_contact"
               value="{{$user->organisation_contact}}"
               placeholder="Direct Contact No">
    </div>


    <div class="form-group ">

        <strong>Professional Indemnity
            Certificate:</strong>
        @if(!empty($user->prof_ind_cert))
         <a href="{{url('uploads/files/'.$user->prof_ind_cert)}}" target="_blank">Click To open</a>
       @endif
        <input type="file" name="prof_ind_cert"
               class="form-control"
               accept=".pdf, image/*,.doc,.docx">
    </div>
    <div class="form-group">
        {!! Form::select('prof_required', $arrProfReq, $user->prof_required, array('placeholder' => "Professional Required")) !!}
    </div>
    <div class="form-group">
        {!! Form::select('special_interests[]', $arrSpecialInterests, $user->special_interests, array('placeholder' => "Special Interests")) !!}
    </div>
    <div class="form-group">
        <input type="text"
               class="form-control"
               name="special_interests[]"
               placeholder="Other Special Interest">
    </div>
    <div class="form-group ">
        <strong>Certificates –Vaccinations &
            immunisation
            (Measles/Mumps/Rubella/Hepatitis
            B/Varicella):</strong><br>
        @if(!empty($user->certs))
            <a href="{{url('uploads/files/'.$user->certs)}}" target="_blank">Click To open</a>
        @endif
        <input type="file" name="certs"
               class="form-control"
               accept=".pdf, image/*,.doc,.docx">
    </div>
    <div class="form-group">
        {!! Form::select('appo_slot_times[]', $arrAppo_slot_times, $user->appo_slot_times, array( 'placeholder' => "Appointment Slot Times")) !!}
    </div>
    <div class="form-group">
        <input id="other_appo" type="text"
               class="form-control"
               name="appo_slot_times[]"
               value="{{ $user->appo_slot_times}}"

               placeholder="Other Appointment Slot Times">
    </div>
    <div class="form-group">
        {!! Form::select('adm_catch_time', array('Yes'=>'Yes', 'No'=>'No'), null, array('placeholder' => "Admin Catch Up Time Provided")) !!}
    </div>
    <div class="form-group">
        {!! Form::select('time_allowed[]', $arrAppo_slot_times, $user->time_allowed, array('placeholder' => "Time Allocated")) !!}
    </div>
    <div class="form-group">
        <input id="other_time_allo" type="text"
               class="form-control"
               name="time_allowed[]"
               value="{{ $user->time_allowed}}"

               placeholder="Other Time Allocated">
    </div>
    <div class="form-group">
        {!! Form::select('breaks', $arrBreaks, $user->breaks, array('placeholder' => "Breaks")) !!}
    </div>
    <div class="form-group" >
        <input id="hourly_rate" type="number"
               class="form-control"
               name="hourly_rate"
               value="{{$hourly_rate}}"
               placeholder="Hourly Rate">
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
                    <label for="hourly_rate_negotiable"><span> Hour rate negotiable?</span></label>
            </span>
        </span>
    </div>
    <div class="form-group" >
        <label for="hourly_rate_desc">Additional information about rate</label>
        <input id="hourly_rate_desc" type="number"
               class="form-control"
               name="hourly_rate_desc"
               value="{{$hourly_rate_desc}}"
               placeholder="Additional info">
    </div>
    <div class="form-group">
        {!! Form::select('payment_terms[]', $arrPaymentTerms, $user->payment_terms, array('placeholder' => "Payment Terms")) !!}
    </div>
    <div class="form-group">
        <input id="other_payment_terms" type="text"
               class="form-control"
               name="payment_terms[]"
               placeholder="Other Payment terms">
    </div>
    <div class="form-group">
        {!! Form::select('direct_booking', array('Direct Bookings accepted'=>'Direct Bookings accepted', 'Direct Bookings not accepted'=>'Direct Bookings not accepted'), $user->direct_booking, array('placeholder' => "Direct Bookings")) !!}
    </div>


    <div class="form-group">
        <label>Session Advertised By</label>
    </div>
    <div class="form-group form-group-half">
        <input id="session_ad_by" type="text"
               class="form-control"
               name="session_ad_by"
               value="{{$user->session_ad_by}}"
               placeholder="Name">
    </div>
    <div class="form-group form-group-half">
        <input id="session_ad_by_position" type="text"
               class="form-control"
               name="session_ad_by_position"
               placeholder="Position">
    </div>
    <div class="form-group form-group-half">
        <input id="session_ad_by_email" type="email"
               class="form-control"
               name="session_ad_by_email"
               placeholder="Email">
    </div>
    <div class="form-group form-group-half">
        <input id="session_ad_by_contact" type="text"
               class="form-control"
               name="session_ad_by_contact"
               placeholder="Direct Contact No">
    </div>
</div>
