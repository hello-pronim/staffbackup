@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ? 'extend.front-end.master' : 'front-end.master')
@section('content')
    @php
        $employees      = Helper::getEmployeesList();
        $departments    = App\Department::all();
        $locations      = App\Location::select('title', 'id')->get()->pluck('title', 'id')->toArray();
        $roles          = Spatie\Permission\Models\Role::all()->toArray();
        $register_form = App\SiteManagement::getMetaValue('reg_form_settings');
        $reg_one_title = !empty($register_form) && !empty($register_form[0]['step1-title']) ? $register_form[0]['step1-title'] : trans('lang.join_for_good');
        $reg_one_subtitle = !empty($register_form) && !empty($register_form[0]['step1-subtitle']) ? $register_form[0]['step1-subtitle'] : trans('lang.join_for_good_reason');
        $reg_two_title = !empty($register_form) && !empty($register_form[0]['step2-title']) ? $register_form[0]['step2-title'] : trans('lang.pro_info');
        $reg_two_employer_title = !empty($register_form) && !empty($register_form[0]['step2-title']) ? $register_form[0]['step2-title'] : trans('lang.pro_info_employer');
        $reg_two_support_title = !empty($register_form) && !empty($register_form[0]['step2-title']) ? $register_form[0]['step2-title'] : trans('lang.pro_info_support');
        $reg_two_subtitle = !empty($register_form) && !empty($register_form[0]['step2-subtitle']) ? $register_form[0]['step2-subtitle'] : '';
        $term_note = !empty($register_form) && !empty($register_form[0]['step2-term-note']) ? $register_form[0]['step2-term-note'] : trans('lang.agree_terms');
        $reg_three_title = !empty($register_form) && !empty($register_form[0]['step3-title']) ? $register_form[0]['step3-title'] : trans('lang.almost_there');
        $reg_three_subtitle = !empty($register_form) && !empty($register_form[0]['step3-subtitle']) ? $register_form[0]['step3-subtitle'] : trans('lang.acc_almost_created_note');
        $register_image = !empty($register_form) && !empty($register_form[0]['register_image']) ? '/uploads/settings/home/'.$register_form[0]['register_image'] : 'images/work.jpg';
        $reg_page = !empty($register_form) && !empty($register_form[0]['step3-page']) ? $register_form[0]['step3-page'] : '';
        $reg_four_title = !empty($register_form) && !empty($register_form[0]['step4-title']) ? $register_form[0]['step4-title'] : trans('lang.congrats');
        $reg_four_subtitle = !empty($register_form) && !empty($register_form[0]['step4-subtitle']) ? $register_form[0]['step4-subtitle'] : trans('lang.acc_creation_note');
        $show_emplyr_inn_sec = !empty($register_form) && !empty($register_form[0]['show_emplyr_inn_sec']) ? $register_form[0]['show_emplyr_inn_sec'] : 'true';
        $show_reg_form_banner = !empty($register_form) && !empty($register_form[0]['show_reg_form_banner']) ? $register_form[0]['show_reg_form_banner'] : 'true';
        $reg_form_banner = !empty($register_form) && !empty($register_form[0]['reg_form_banner']) ? $register_form[0]['reg_form_banner'] : null;
        $breadcrumbs_settings = \App\SiteManagement::getMetaValue('show_breadcrumb');
        $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
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
    'plan_G6DuLUGgkizyrs'=>'Monthly'
    );

    $arrSettings = array(
    'GP Surgery'=>'GP Surgery',
    'Walk-In centre'=>'Walk-In centre',
    'Urgent Care Centre'=>'Urgent Care Centre',
    'GP Out Of Hours'=>'GP Out Of Hours',
    'Community Service'=>'Community Service',
    'Other'=>'Other',
    );
    $arrProfReq = array(
    'Practice Manager'=>'Practice Manager',
    'Practice Nurse'=>'Practice Nurse',
    'Advanced Nurse Practitioner'=>'Advanced Nurse Practitioner',
    'GP'=>'GP',
    'Receptionist'=>'Receptionist',
    'Admin & Clerical'=>'Admin & Clerical',
    'Cleaner in clinical settings'=>'Cleaner in clinical settings',
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

    $arrAppo_slot_times = array(
    '10 minutes'=>'10 minutes',
    '15 minutes'=>'15 minutes',
    '20 minutes'=>'20 minutes',
    '30 minutes'=>'30 minutes',
    'Other'=>'Other',
    );

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
    );

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
    <script src="https://js.stripe.com/v3"></script>
    <style type="text/css">
        select {
            width: 100% !important;
        }
    </style>
    @if (!empty($show_reg_form_banner) && $show_reg_form_banner === 'true')
        <div class="headernew">
        <div class="row" style="margin:0 auto;width: 850px;padding: 65px 0px">

            <div class="headingcenter text-center">
                <h2>We connect professionals with the <br> people who need them most, (when they needed them).</h2>
                <div>10 years professional clinical experience connecting surgeries and <br> healthcare stakeholders
                    with adhoc and temporary staffing solutions
                </div>
            </div>


        </div>
        </div>
    @endif
    <div class="wt-haslayout wt-main-section" style="padding: 0px">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-10 push-md-1 col-lg-8 push-lg-2" id="registration">
                    <div class="preloader-section" v-if="loading" v-cloak>
                        <div class="preloader-holder">
                            <div class="loader"></div>
                        </div>
                    </div>
                    <form method="POST" action="{{{ url('register/form-step1-custom-errors') }}}"
                          class="wt-formtheme wt-formregister" @submit.prevent="checkStep1"
                          id="register_form">
                        <div class="wt-registerformhold">
                            <div class="wt-registerformmain">
                                <div class="wt-joinforms">

                                    @csrf
                                    <input type="hidden" name="stripe_token" v-model="stripe_token"/>

                                    <fieldset class="wt-registerformgroup">
                                        <div class="wt-haslayout" v-show="step === 1" v-cloak>
                                            <div class="wt-registerhead">
                                                <div class="wt-title">
                                                    <h3>{{{ $reg_one_title }}}</h3>
                                                </div>
                                                <div class="wt-description">
                                                    <p>{{{ $reg_one_subtitle }}}</p>
                                                </div>
                                            </div>
                                            <ul class="wt-joinsteps">
                                                <li class="wt-active"><a
                                                            href="javascrip:void(0);">{{{ trans('lang.01') }}}</a></li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.02') }}}</a></li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.03') }}}</a></li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.04') }}}</a></li>
                                            </ul>

                                            <ul class="wt-accordionhold wt-formaccordionhold accordion"
                                                style="margin-bottom: 5px">
                                                @foreach ($roles as $key => $role)
                                                    @if (!in_array($role['id'] == 1, $roles))
                                                        <li style="width:33%; <?php if ($key != 3) {
                                                            echo 'padding-right: 10px;';
                                                        };?>">
                                                            <div class="wt-accordiontitle role-{{$role['role_type']}}"
                                                                 id="headingOne"
                                                                 style="height: 69px; border: 1px solid #ddd;"
                                                                 data-toggle="collapse" data-target="#collapseOne">
                                                                <span class="wt-radio">
                                                                <input id="wt-company-{{$key}}" type="radio" name="role"
                                                                       value="{{{ $role['role_type'] }}}" checked="<?php echo (isset($_GET['role']) && $_GET['role'] ==$role['role_type']) ? "checked" : "";?>"
                                                                       v-model="user_role"
                                                                       v-on:change="selectedRole(user_role)">
                                                                <label style="margin-top: 8px"
                                                                       for="wt-company-{{$key}}">
																		@if ($role['name'] === 'freelancer')
																			{{ trans('lang.freelancer') }}
																		@endif
																		@if ($role['name'] === 'support')
																			{{ trans('lang.support') }}
																		@endif
																		@if ($role['name'] === 'employer')
																			{{ trans('lang.employer') }}
																		@endif
                                                                </label>
                                                                </span>
                                                            </div>

                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <div class="form-group" style="width: 20%;">
                                                <span class="wt-select">
                                                {!! Form::select('title', array("Mr"=>"Mr", "Ms"=>"Ms", "Mrs"=>"Mrs", "Dr"=>"Dr"), isset($_GET['title']) ? $_GET['title'] : null , array('placeholder' => trans('lang.title'),  'v-bind:class' => '{ "is-invalid": form_step2.title_error }')) !!}
                                                    </span>
                                                <span class="help-block"
                                                      v-if="form_step2.title_error">
                                                                                <strong v-cloak>@{{form_step2.title_error}}</strong>
                                                                            </span>
                                            </div>
                                            <div class="form-group form-group-half" style="width: 40%">
                                                <input type="text" name="first_name" class="form-control    "
                                                       placeholder="{{{ trans('lang.ph_first_name') }}}"
                                                       value="{{ isset($_GET['first_name']) ? $_GET['first_name'] : "" }}"
                                                       v-bind:class="{ 'is-invalid': form_step1.is_first_name_error }"
                                                >
                                                <span class="help-block" v-if="form_step1.first_name_error">
                                                <strong v-cloak>@{{form_step1.first_name_error}}</strong>
                                            </span>
                                            </div>
                                            <div class="form-group form-group-half" style="width: 40%">
                                                <input type="text" name="last_name" class="form-control"
                                                       placeholder="{{{ trans('lang.ph_last_name') }}}"
                                                       v-bind:class="{ 'is-invalid': form_step1.is_last_name_error }"
                                                       value="{{ isset($_GET['last_name']) ? $_GET['last_name'] : "" }}"
                                                >
                                                <span class="help-block" v-if="form_step1.last_name_error">
                                                <strong v-cloak>@{{form_step1.last_name_error}}</strong>
                                            </span>
                                            </div>
                                            <div class="form-group form-group-half">
                                                <input id="user_email" type="email" class="form-control" name="email"
                                                       placeholder="{{{ trans('lang.ph_email') }}}"
                                                       v-bind:class="{ 'is-invalid': form_step1.is_email_error }"
                                                       value="{{ isset($_GET['email']) ? $_GET['email'] : "" }}"

                                                >
                                                <span class="help-block" v-if="form_step1.email_error">
                                                <strong v-cloak>@{{form_step1.email_error}}</strong>
                                                </span>
                                            </div>
                                            <div class="form-group form-group-half">
                                                <input id="number" type="number"
                                                       class="form-control"
                                                       name="number"
                                                       value="{{ isset($_GET['number']) ? $_GET['number'] : "" }}"

                                                       min="0"
                                                       placeholder="{{{ trans('lang.number') }}}"
                                                >
                                            </div>
                                            <div class="form-group form-group-half">
                                                <input id="password" type="password" class="form-control"
                                                       name="password" placeholder="{{{ trans('lang.ph_pass') }}}"
                                                       value="{{ isset($_GET['password']) ? $_GET['password'] : "" }}"

                                                       v-bind:class="{ 'is-invalid': form_step2.is_password_error }">
                                                <span class="help-block" v-if="form_step2.password_error">
                                                    <strong v-cloak>@{{form_step2.password_error}}</strong>
                                                </span>

                                            </div>
                                            <div class="form-group form-group-half">

                                                <input id="password-confirm" type="password"
                                                       class=" form-control"
                                                       name="password_confirmation"
                                                       placeholder="{{{ trans('lang.ph_retry_pass') }}}"
                                                       value="{{ isset($_GET['password']) ? $_GET['password'] : "" }}"

                                                       v-bind:class="{ 'is-invalid': form_step2.is_password_confirm_error }">
                                                <span class="help-block" v-if="form_step2.password_confirm_error">
                                                <strong v-cloak>@{{form_step2.password_confirm_error}}</strong>
                                            </span>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit"
                                                        class="wt-btn">{{{  trans('lang.btn_startnow') }}}</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="wt-haslayout" v-show="step === 2" v-cloak>
                                        <fieldset class="wt-registerformgroup">
                                            <div class="wt-registerhead">
                                                <div class="wt-title">
                                                    <h3 v-if="user_role=='employer'">{{{ $reg_two_employer_title }}}</h3>
                                                    <h3 v-if="user_role=='freelancer'">{{{ $reg_two_title }}}</h3>
													<h3 v-if="user_role=='support'">{{{ $reg_two_support_title }}}</h3>
                                                </div>
                                                @if (!empty($reg_two_subtitle))
                                                    <div class="wt-description">
                                                        <p>{{{ $reg_two_subtitle }}}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <ul class="wt-joinsteps">
                                                <li class="wt-done-next"><a href="javascrip:void(0);"><i
                                                                class="fa fa-check"></i></a></li>
                                                <li class="wt-active"><a
                                                            href="javascrip:void(0);">{{{ trans('lang.02') }}}</a></li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.03') }}}</a></li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.04') }}}</a></li>
                                            </ul>
                                            <div class="form-group">
                                                <div class="wt-tabscontenttitle">
                                                    <h2>Address</h2>
                                                </div>

                                            </div>


                                            <div v-if="user_role!='support'" class="form-group  form-group-half">
                                                <input id="emp_website" type="url"
                                                       class="form-control"
                                                       name="emp_website"
                                                       placeholder="{{{ trans('lang.emp_website') }}}"
                                                       v-bind:class="{ 'is-invalid': form_step2.emp_website_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.emp_website_error">
                                                                                <strong v-cloak>@{{form_step2.emp_website_error}}</strong>
                                                                            </span>
                                            </div>
                                            <div class="form-group  form-group-half">
                                                <input id="straddress" type="text"
                                                       class="form-control"
                                                       name="straddress"
                                                       placeholder="Address"
                                                       v-bind:class="{ 'is-invalid': form_step2.straddress_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.straddress_error">
													<strong v-cloak>@{{form_step2.straddress_error}}</strong>
												</span>
                                            </div>
                                            <div class="form-group  form-group-half">
                                                <input id="city" type="text"
                                                       class="form-control"
                                                       name="city"
                                                       placeholder="{{{ trans('lang.city') }}}"
                                                       v-bind:class="{ 'is-invalid': form_step2.city_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.city_error">
													<strong v-cloak>@{{form_step2.city_error}}</strong>
												</span>
                                            </div>
                                            <div class="form-group  form-group-half ">
                                                <input id="postcode" type="text"
                                                       class="halfWidth form-control"
                                                       name="postcode"
                                                       placeholder="{{{ trans('lang.postcode') }}}"
                                                       v-bind:class="{ 'is-invalid': form_step2.postcode_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.postcode_error">
													<strong v-cloak>@{{form_step2.postcode_error}}</strong>
												</span>
                                            </div>


                                        </fieldset>
                                        <fieldset class="wt-formregisterstart">

                                            @if(!empty($roles))

                                                @foreach ($roles as $key => $role)
                                                    @if (!in_array($role['id'] == 1, $roles))
                                                        @if ($role['role_type'] === 'employer')
                                                                <div class="wt-accordiondetails "
                                                                     v-if="is_show">

                                                                    <div>
                                                                        <div class="form-group">
                                                                            <div class="wt-tabscontenttitle">
                                                                                <h2>Company Contacts</h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            <input id="emp_contact" type="text"
                                                                                   class="form-control"
                                                                                   name="emp_contact"
                                                                                   placeholder="{{{ trans('lang.emp_contact') }}}"
                                                                                   v-bind:class="{ 'is-invalid': form_step2.emp_contact_error }">
                                                                            <span class="help-block"
                                                                                  v-if="form_step2.emp_contact_error">
                                                                            <strong v-cloak>@{{form_step2.emp_contact_error}}</strong>
                                                                            </span>
                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            <input id="emp_telno" type="tel"
                                                                                   class="form-control"
                                                                                   name="emp_telno"
                                                                                   placeholder="{{{ trans('lang.emp_telno') }}}"
                                                                                   v-bind:class="{ 'is-invalid': form_step2.emp_telno_error }">
                                                                            <span class="help-block"
                                                                                  v-if="form_step2.emp_telno_error">
                                                                        <strong v-cloak>@{{form_step2.emp_telno_error}}</strong>
                                                                            </span>
                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            <input id="emp_pos" type="url"
                                                                                   class="form-control"
                                                                                   name="emp_pos"
                                                                                   placeholder="Position"
                                                                            >
                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            <input id="emp_email" type="email"
                                                                                   class="form-control"
                                                                                   name="emp_email"
                                                                                   placeholder="Email"
																				   v-bind:class="{ 'is-invalid': form_step2.emp_email_error }">
																			<span class="help-block"
																				  v-if="form_step2.emp_email_error">
																				<strong v-cloak>@{{form_step2.emp_email_error}}</strong>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <div class="wt-tabscontenttitle">
                                                                                <h2>Certifications</h2>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group form-group-half">
                                                                            <span class="wt-select">
                                                                            {!! Form::select('emp_cqc_rating_date', $cqc_ratings_date, null, array('placeholder' => trans('lang.emp_cqc_rating_date'), 'class' => 'form-group', 'v-bind:class' => '{ "is-invalid": form_step2.emp_cqc_rating_date_error }')) !!}
                                                                            </span>
                                                                            <span class="help-block"
                                                                                  v-if="form_step2.emp_cqc_rating_error">
                                                                                    <strong v-cloak>@{{form_step2.emp_cqc_rating_date_error}}</strong>
                                                                                </span>

                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            <span class="wt-select">
                                                                            {!! Form::select('emp_cqc_rating', $cqc_ratings, null, array('placeholder' => trans('lang.emp_cqc_rating'), 'class' => 'form-group', 'v-bind:class' => '{ "is-invalid": form_step2.emp_cqc_rating_error }')) !!}
                                                                            </span>

                                                                            <span class="help-block"
                                                                                  v-if="form_step2.emp_cqc_rating_error">
                                                                                    <strong v-cloak>@{{form_step2.emp_cqc_rating_error}}</strong>
                                                                                </span>
                                                                        </div>

                                                                        <!-- New columns for sheet-->

                                                                        <label for="org_type" style="margin-top: 20px">Please
                                                                            indicate the
                                                                            organisation which best describes your
                                                                            service</label>
                                                                        <div class="form-group form-group-half ">
                                                                            <span class="wt-select">
                                                                            {!! Form::select('org_type', $arrOrgTypes, null, array('placeholder' => "Organisation type", 'v-bind:class' => '{ "is-invalid": form_step2.is_org_type_error }')) !!}
                                                                            </span>
                                                                            <span class="help-block"
                                                                                  v-if="form_step2.org_type_error">
                                                                                    <strong v-cloak>@{{form_step2.org_type_error}}</strong>
                                                                                </span>
                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            <input id="org_desc" type="text"
                                                                                   class="form-control"
                                                                                   name="org_desc"
                                                                                   placeholder="Organisation description">
                                                                        </div>
                                                                        <div class="form-group form-group-half ">
                                                                            <span class="wt-select halfWidth">
                                                                            {!! Form::select('setting[]', $arrSettings, null, array('v-model'=>'appoSlotTime', 'placeholder' => "Setting")) !!}
                                                                            </span>
                                                                        </div>
                                                                        <div class="form-group "
                                                                             v-if="appoSlotTime=='Other'">
                                                                            <input id="other_setting" type="text"
                                                                                   class="form-control"
                                                                                   name="setting[]"
                                                                                   placeholder="Other Setting">
                                                                        </div>

																		<div v-if="user_role=='freelancer'">
																			<div class="form-group form-group-half">
																				<input type="text"
																					   class="halfWidth form-control"
																					   name="pin"
																					   placeholder="Pin"
																					   v-bind:class="{ 'is-invalid': form_step2.pin_error }">
																				<span class="help-block"
																					  v-if="form_step2.pin_error">
																					<strong v-cloak>@{{form_step2.pin_error}}</strong>
																			</div>
																			<div class="form-group form-group-half">
																				<date-picker
																						:config="{format: 'YYYY-MM-DD'}"
																						value=""
																						class="form-control"
																						name="pin_date_revalid"
																						placeholder="Pin date of revalidation"
																						v-bind:class="{ 'is-invalid': form_step2.pin_date_revalid_error }"
																				></date-picker>
																				<span class="help-block"
																					  v-if="form_step2.pin_date_revalid_error">
																					<strong v-cloak>@{{form_step2.pin_date_revalid_error}}</strong>
																			</div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group form-group">
                                                                            <label for="insurance"
                                                                                   style="display: inline-block">Insurance
                                                                                Details</label> <input
                                                                                    type="checkbox"
                                                                                    name="insurance"
                                                                                    placeholder="Insurance"
                                                                                    v-model="insurancecheckbox">
                                                                        </div>
                                                                        <div v-if="insurancecheckbox">
                                                                            <div class="form-group ">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="org_name"
                                                                                       placeholder="Organisation name">
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       name="policy_number"
                                                                                       placeholder="Policy Number">
                                                                            </div>


                                                                            <div class="form-group">
                                                                                <label>Organisation Contact</label>
                                                                            </div>
                                                                            <div class="form-group form-group-half">
                                                                                <input id="org_name" type="text"
                                                                                       class="form-control"
                                                                                       name="org_name"
                                                                                       placeholder="Name">
                                                                            </div>
                                                                            <div class="form-group form-group-half">
                                                                                <input id="organisation_position"
                                                                                       type="text"
                                                                                       class="form-control"
                                                                                       name="organisation_position"
                                                                                       placeholder="Position">
                                                                            </div>
                                                                            <div class="form-group form-group-half">
                                                                                <input id="organisation_email"
                                                                                       type="email"
                                                                                       class="form-control"
                                                                                       name="organisation_email"
                                                                                       placeholder="Email">
                                                                            </div>
                                                                            <div class="form-group form-group-half">
                                                                                <input id="organisation_contact"
                                                                                       type="text"
                                                                                       class="form-control"
                                                                                       name="organisation_contact"
                                                                                       placeholder="Direct Contact No">
                                                                            </div>
                                                                        </div>
																		<div v-id="prof-indem-cretificate" v-if="user_role!='employer'">
																			<div class="form-group">
																				<div>Professional Indemnity
																					Certificate:
																				</div>
																			</div>
																			<div class="form-group form-group-half">

																				<input type="file" name="prof_ind_cert"
																					   class="form-control"
																					   accept=".pdf, image/*,.doc,.docx">
																			</div>
                                                                        </div>
                                                                        {{--<div class="form-group">--}}
                                                                        {{--{!! Form::select('prof_required', $arrProfReq, null, array('placeholder' => "Professional Required")) !!}--}}
                                                                        {{--</div>--}}
                                                                        <div class="form-group">
                                                                            <div class="wt-tabscontenttitle">
                                                                                <h2>Company Policies and
                                                                                    Information</h2>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div>Certificates –Vaccinations &
                                                                                immunisation
                                                                                (Measles/Mumps/Rubella/Hepatitis
                                                                                B/Varicella):
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-group-half ">

                                                                            <input type="file" name="certs"
                                                                                   class="form-control"
                                                                                   accept=".pdf, image/*,.doc,.docx">
                                                                        </div>
                                                                        <div class="form-group form-group-half">
                                                                            {!! Form::select('appo_slot_times[]', $arrAppo_slot_times, null, array('v-model'=>'appoSlotTime', 'class'=>'halfWidth', 'placeholder' => "Appointment Slot Times")) !!}
                                                                        </div>
                                                                        <div class="form-group form-group-half"
                                                                             v-if="appoSlotTime=='Other'">
                                                                            <input id="other_appo" type="text"
                                                                                   class="form-control halfWidth"
                                                                                   name="appo_slot_times[]"
                                                                                   placeholder="Other Appointment Slot Times">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <span class="wt-select">
                                                                            {!! Form::select('payment_terms[]', $arrPaymentTerms, null, array('v-model'=>'paymentTerm', 'placeholder' => "Payment Terms")) !!}
                                                                            </span>
                                                                        </div>
                                                                        <div class="form-group form-group-half"
                                                                             v-if="paymentTerm=='Other'">
                                                                            <input id="other_payment_terms" type="text"
                                                                                   class="form-control"
                                                                                   name="payment_terms[]"
                                                                                   placeholder="Other Payment terms">
                                                                        </div>
																		<div v-if="user_role=='employer'" class="form-group form-group-half">
																			<input id="practice_code" type="text"
																				   class="form-control"
																				   name="practice_code"
																				   placeholder="Practice Code"
																				   v-bind:class="{ 'is-invalid': form_step2.is_practice_code_error }">
																			<span class="help-block"
																				  v-if="form_step2.practice_code_error">
																				<strong v-cloak>@{{form_step2.practice_code_error}}</strong>
																		</div>
                                                                        {{--<div class="form-group form-group-half ">--}}
                                                                        {{--<input id="hourly_rate" type="number"--}}
                                                                        {{--min="0"--}}
                                                                        {{--class="halfWidth form-control"--}}
                                                                        {{--name="hourly_rate"--}}
                                                                        {{--placeholder="Hourly Rate">--}}
                                                                        {{--</div>--}}

                                                                        <div class="form-group">
                                                                            <label for="hourly_rate_desc">Please enter
                                                                                additional information in the
                                                                                communication box if required</label>
                                                                            <input id="hourly_rate_desc" type="text"
                                                                                   class="form-control"
                                                                                   name="hourly_rate_desc"
                                                                                   placeholder="Additional info">
                                                                        </div>

                                                                        {{--<div class="form-group">--}}
                                                                        {{--<label>Session Advertised By</label>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="form-group form-group-half">--}}
                                                                        {{--<input id="session_ad_by" type="text"--}}
                                                                        {{--class="form-control"--}}
                                                                        {{--name="session_ad_by"--}}
                                                                        {{--placeholder="Name">--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="form-group form-group-half">--}}
                                                                        {{--<input id="session_ad_by_position"--}}
                                                                        {{--type="text"--}}
                                                                        {{--class="form-control"--}}
                                                                        {{--name="session_ad_by_position"--}}
                                                                        {{--placeholder="Position">--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="form-group form-group-half">--}}
                                                                        {{--<input id="session_ad_by_email" type="email"--}}
                                                                        {{--class="form-control"--}}
                                                                        {{--name="session_ad_by_email"--}}
                                                                        {{--placeholder="Email">--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="form-group form-group-half">--}}
                                                                        {{--<input id="session_ad_by_contact"--}}
                                                                        {{--type="text"--}}
                                                                        {{--class="form-control"--}}
                                                                        {{--name="session_ad_by_contact"--}}
                                                                        {{--placeholder="Direct Contact No">--}}
                                                                        {{--</div>--}}
                                                                    </div>

                                                                </div>
                                                        @endif
                                                        @if(in_array($role['id']==3, $roles))
                                                            <div class="wt-accordiondetails"

                                                                 v-if="is_show_freelancer">


                                                                {{--<div class="form-group form-group-half">--}}
                                                                {{--<input id="telno" class="form-control"--}}
                                                                {{--name="telno" type="tel"--}}
                                                                {{--placeholder="{{{ trans('lang.telno') }}}"--}}
                                                                {{--v-bind:class="{ 'is-invalid': form_step2.telno_error }">--}}
                                                                {{--<span class="help-block"--}}
                                                                {{--v-if="form_step2.telno_error">--}}
                                                                {{--<strong v-cloak>@{{form_step2.telno_error}}</strong>--}}
                                                                {{--</span>--}}
                                                                {{--</div>--}}
                                                                <div class="form-group form-group-half">
                                                                    <date-picker :config="{format: 'DD/MM/YYYY'}"
                                                                                 value=""
                                                                                 id="dob" class="form-control"
                                                                                 name="dob"
                                                                                 placeholder="{{{ trans('lang.dob') }}}"
                                                                                 v-bind:class="{ 'is-invalid': form_step2.dob_error }"></date-picker>
                                                                    <span class="help-block"
                                                                          v-if="form_step2.dob_error">
                                                                        <strong v-cloak>@{{form_step2.dob_error}}</strong>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                    <date-picker :config="{format: 'DD/MM/YYYY'}"
                                                                                 id="date_available"
                                                                                 value=""

                                                                                 class="form-control"
                                                                                 name="date_available"
                                                                                 placeholder="{{{ trans('lang.date_available') }}}"
                                                                                 v-bind:class="{ 'is-invalid': form_step2.date_available_error }"></date-picker>
                                                                    <span class="help-block"
                                                                          v-if="form_step2.date_available_error">
                                                                        <strong v-cloak>@{{form_step2.date_available_error}}</strong>
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div>CV Upload:</div>

                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                    <input type="file" name="cvfile"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group form-group-half">
                                                                    <span class="wt-select halfWidth">
                                                                    {!! Form::select('rate', array("p/h"=>"p/h", "p/m"=>"p/m", "p/a"=>"p/a"), null, array('placeholder' => 'Rate',  'v-bind:class' => '{ "is-invalid": form_step2.rate_error }')) !!}
                                                                    </span>
                                                                    <span class="help-block"
                                                                          v-if="form_step2.rate_error">
                                                                                    <strong v-cloak>@{{form_step2.rate_error}}</strong>
                                                                                </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="hourly_rate" type="number"
                                                                           class="form-control"
                                                                           name="hourly_rate"
                                                                           min="0"
                                                                           placeholder="Hourly Rate">
                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                            <span class="wt-checkbox"
                                                                                  style="    margin-bottom: 13px;    margin-top: 17px;">
                                                                                <span class="wt-checkbox">
                                                                                        <input id="hourly_rate_negotiable"
                                                                                               type="checkbox"
                                                                                               name="hourly_rate_negotiable"
                                                                                               checked="">
                                                                                        <label for="hourly_rate_negotiable"><span> Hour rate negotiable?</span></label>
                                                                                </span>
                                                                            </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="exp_years" type="number" min="0"
                                                                           class="form-control"
                                                                           name="exp_years"
                                                                           placeholder="Experience Years"
                                                                           v-bind:class="{ 'is-invalid': form_step2.exp_years_error }">
                                                                    <span class="help-block"
                                                                          v-if="form_step2.exp_years_error">
                                                                                <strong v-cloak>@{{form_step2.exp_years_error}}</strong>
                                                                            </span>
                                                                </div>
                                                                <!-- <div class="form-group">
                                                                    <span class="wt-select">
                                                                    {!! Form::select('gender', array("Male"=>"Male", "Female"=>"Female"), null, array('placeholder' => 'Gender', 'v-bind:class' => '{ "is-invalid": form_step2.gender_error }')) !!}
                                                                    </span>

                                                                </div> -->
                                                                <div class="form-group form-group-half">
                                                                    <span class="wt-select halfWidth">
                                                                    {!! Form::select('nationality', $arrNationals, null, array('placeholder' => "Nationality")) !!}
                                                                    </span>
                                                                </div>
																<div v-if="user_role=='freelancer'">
																	<div class="form-group form-group-half">
																		<input type="text"
																			   class="halfWidth form-control halfWidth"
																			   name="pin"
																			   placeholder="Pin">
																	</div>
																	<div class="form-group form-group-half">
																		<date-picker :config="{format: 'YYYY-MM-DD'}"

																					 value=""

																					 class="form-control"
																					 name="pin_date_revalid"
																					 placeholder="Pin date of revalidation"
																		></date-picker>
																	</div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="wt-select">
                                                                    {!! Form::select('profession', $arrProfReq, null, array('placeholder' => "Profession")) !!}
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="wt-select">
                                                                    {!! Form::select('right_of_work',  array('Yes'=>'Yes', 'No'=>'No'), null, array('placeholder' => "Right to work")) !!}
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div>Passport or Visa:</div>

                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                    <input type="file" name="passport_visa"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div>Professional Qualifications</div>

                                                                </div>
                                                                <div class="form-group form-group">
                                                                    <span class="text-right" id="plusQual"
                                                                          style="cursor:pointer;font-size: 16px; background-color: #fccf17;color:white;padding:7px;border-radius:5px">+</span>
                                                                </div>

                                                                <div class="profQualif_block">
                                                                    <table>
                                                                        <tr>
                                                                            <td><input type="text"
                                                                                       class="form-control"
                                                                                       name="profQualLevel[]"
                                                                                       placeholder="Level"></td>
                                                                            <td><input type="text"
                                                                                       class="form-control"
                                                                                       name="profQualName[]"
                                                                                       placeholder="Name"></td>
                                                                            <td><input type="text"
                                                                                       class="form-control"
                                                                                       name="profQualPlace[]"
                                                                                       placeholder="Place of Study">
                                                                            </td>
                                                                            <td><input type="number"
                                                                                       min="0"
                                                                                       class="form-control"
                                                                                       name="profQualYear[]"
                                                                                       placeholder="Year"></td>
                                                                        </tr>
                                                                    </table>

                                                                </div>

                                                                <div class="form-group">
                                                                    <div>Professional Qualifications
                                                                        Certificate
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-group-half">

                                                                    <input type="file" name="prof_qual_cert"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div>Mandatory Training:</div>
                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                    <input type="file" name="mand_training"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="wt-checkboxholder">
                                                                        <span class="wt-checkbox">
                                                                            <input id="dbscheck" type="checkbox"
                                                                                   name="dbscheck"
                                                                                   checked=""
                                                                                   v-model="dbscheck">
                                                                            <label for="dbscheck"><span>DBS checked</span></label>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div>Certificate of CRB/DBS:</div>
                                                                </div>
                                                                <div class="form-group form-group-half" v-if="dbscheck">
                                                                    <input type="file" name="cert_of_crbdbs"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group">
                                                                    <div>Occupational Health:</div>
                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                    <input type="file" name="occup_health"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>
                                                                <div class="form-group form-group-half">
                                                                    <span class="wt-select">
                                                                    {!! Form::select('special_interests[]', $arrSpecialInterests, null, array('v-model'=>'specialInterest','placeholder' => "Special Interests")) !!}
                                                                    </span>
                                                                </div>
                                                                <div class="form-group form-group-half"
                                                                     v-if="specialInterest=='Other'">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="special_interests[]"
                                                                           placeholder="Other Special Interest">
                                                                </div>


                                                                <div class="form-group">
                                                                    <label for="insurance"
                                                                           style="display: inline-block">Professional
                                                                        Indemnity Insurance</label> <input
                                                                            type="checkbox"
                                                                            name="insurance"
                                                                            placeholder="Insurance"
                                                                            v-model="insurancecheckbox">
                                                                </div>

                                                                <div v-if="insurancecheckbox">
                                                                    <div class="form-group ">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               name="org_name"
                                                                               placeholder="Organisation name">
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               name="policy_number"
                                                                               placeholder="Insurance Policy Number">
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <span class="wt-select">
                                                                    {!! Form::select('direct_booking', array('Direct Bookings accepted'=>'Direct Bookings accepted', 'Direct Bookings not accepted'=>'Direct Bookings not accepted'), null, array('placeholder' => "Direct Bookings")) !!}
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <span class="wt-select">
                                                                    {!! Form::select('c_payment_methods',$arrPaymentMethods, null, array('placeholder' => "Payment Method", 'v-model'=>'payment_method')) !!}
                                                                    </span>
                                                                    <span v-if="payment_method=='Self Employed'">Please invoice the employer directly for payment</span>
                                                                </div>


                                                                <input v-if="payment_method=='Limited Company'"
                                                                       type="text"
                                                                       name="limitied_company_number"
                                                                       class="form-control"
                                                                       placeholder="Limited Company Number "><br>
                                                                <input v-if="payment_method=='Limited Company'"
                                                                       type="text"
                                                                       name="limitied_company_name"
                                                                       class="form-control"
                                                                       placeholder="Limited Company Name ">
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </fieldset>
                                        <fieldset class="wt-termsconditions">
                                            <div class="wt-checkboxholder">
                                            <span class="wt-checkbox">
                                                <input id="termsconditions" type="checkbox" name="termsconditions"
                                                       >
                                                <label for="termsconditions"><span>Agree to T&Cs and Privacy</span></label>
                                                <span class="help-block" v-if="form_step2.termsconditions_error">
                                                    <strong style="color: red;"
                                                            v-cloak>{{trans('lang.register_termsconditions_error')}}</strong>
                                                </span>
                                            </span>
                                                <a href="#" @click.prevent="prev()"
                                                   class="wt-btn">{{{ trans('lang.previous') }}}</a>
                                                <a href="#"
                                                   @click.prevent="checkStep2('Email is not configured')"
                                                   class="wt-btn">{{{ trans('lang.continue') }}}</a>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="wt-joinformc" v-show="step === 3" v-cloak>

                                        <div class="wt-registerhead">
                                            <div class="wt-title">
                                                <h3>{{{ $reg_three_title }}}</h3>
                                            </div>
                                            {{--<div class="wt-description">--}}
                                            {{--<p>{{{ $reg_three_subtitle }}}</p>--}}
                                            {{--</div>--}}
                                        </div>
                                        <ul class="wt-joinsteps">
                                            <li class="wt-done-next"><a href="javascrip:void(0);"><i
                                                            class="fa fa-check"></i></a></li>
                                            <li class="wt-done-next"><a href="javascrip:void(0);"><i
                                                            class="fa fa-check"></i></a></li>
                                            <li class="wt-active"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.03') }}}</a></li>
                                            <li><a href="javascrip:void(0);">{{{ trans('lang.04') }}}</a></li>
                                        </ul>
                                        <figure class="wt-joinformsimg">
                                            {{--<img src="{{ asset($register_image)}}" alt="{{{ trans('lang.verification_code_img') }}}">--}}
                                        </figure>
                                        <fieldset>
                                            <div class="form-group">
                                                {{--<label>--}}
                                                {{--{{{ trans('lang.verify_code_note') }}}--}}
                                                {{--@if (!empty($reg_page))--}}
                                                {{--<a target="_blank" href="{{{url($reg_page)}}}">--}}
                                                {{--{{{ trans('lang.why_need_code') }}}--}}
                                                {{--</a>--}}
                                                {{--@else--}}
                                                {{--<a href="javascript:void(0)">--}}
                                                {{--{{{ trans('lang.why_need_code') }}}--}}
                                                {{--</a>--}}
                                                {{--@endif--}}
                                                {{--</label>--}}
                                                {{--<input type="text" name="code" class="form-control" placeholder="{{{ trans('lang.enter_code') }}}">--}}
                                                <div v-if="user_role=='freelancer'">
                                                    <span class="wt-select">
                                                    {!! Form::select('payment_option', $payment_options, null, array('placeholder' => "Select Payment Option", 'v-model'=>'choosen_payment' ,'class' => 'form-group', 'v-bind:class' => '{ "is-invalid": form_step2.payment_option_error }', 'v-on:change' => 'selectedPayment(choosen_payment)')) !!}
                                                    </span>
                                                    <div class="form-group form-group-half" v-if="P60upload">
                                                        <strong>P60 Upload:</strong>
                                                        <input type="file" name="p60" class="form-control"
                                                               accept=".pdf, image/*,.doc,.docx">
                                                    </div>
                                                    <div class="form-group" v-if="paypal_show">
                                                        <strong>Paypal Account:</strong>
                                                        <input type="email" name="paypal" class="form-control paypalemail"
                                                               placeholder="Paypal email address"/>
                                                        <span class="help-block" v-if="form_step3.isPaypalEmail_error">
                                                        <strong v-cloak>Not a valid email</strong>
                                                        </span>
                                                    </div>
                                                    <div class="form-group" v-if="cheque_show">
                                                        <strong>Cheque:</strong>
                                                        <p>Your current address details will be used</p>
                                                    </div>


                                                </div>
                                                <div v-if="user_role=='employer'">
                                                    <span class="wt-select">
                                                    {!! Form::select('plan_id', $subscribe_options, null, array('placeholder' => "Select subscription ", 'v-model'=>'subscription' ,'class' => 'form-group',  'v-on:change' => 'selectedSubscription(subscription)')) !!}
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="form-group wt-btnarea">
                                                <a href="#" @click.prevent="prev()"
                                                   class="wt-btn">{{{ trans('lang.previous') }}}</a>
                                                <a href="#" @click.prevent="checkStep3()"
                                                   class="wt-btn">{{{ trans('lang.continue') }}}</a>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="wt-gotodashboard" v-show="step === 4" v-cloak>
                                        <ul class="wt-joinsteps">
                                            <li class="wt-done-next"><a href="javascrip:void(0);"><i
                                                            class="fa fa-check"></i></a></li>
                                            <li class="wt-done-next"><a href="javascrip:void(0);"><i
                                                            class="fa fa-check"></i></a></li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.03') }}}</a></li>
                                            <li class="wt-active"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.04') }}}</a></li>
                                        </ul>
                                        <div class="wt-registerhead">
                                            <div class="wt-title">
                                                <h3>Last step</h3>
                                            </div>
                                            {{--<div class="description">--}}
                                            {{--<p>{{{ $reg_four_subtitle }}}</p>--}}
                                            {{--</div>--}}
                                        </div>


                                        <a href="#" class="wt-btn" @click.prevent="checkoutStripe(subscription)"
                                           v-if="subscription">Go To Checkout</a>


                                        <a href="#" v-if="!subscription" class="wt-btn"
                                           @click.prevent="loginRegisterUser()">{{{ trans('lang.goto_dashboard') }}}</a>

                                    </div>
                                </div>
                            </div>
                            <div class="wt-registerformfooter">
                            <span>{{{ trans('lang.have_account') }}}<a id="wt-lg" href="javascript:void(0);"
                                                                       @click.prevent='scrollTop()'>{{{ trans('lang.btn_login_now') }}}</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>

</style>
