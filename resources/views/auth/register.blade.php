@extends((file_exists(resource_path('views/extend/front-end/master.blade.php')) ? 'extend.front-end.master' : 'front-end.master'), ['needShortFooterCards' => true])
@section('content')
    @php
        $employees      = Helper::getEmployeesList();
        $departments    = App\Department::all();
        $locations      = App\Location::select('title', 'id')->get()->pluck('title', 'id')->toArray();
        $roles          = Spatie\Permission\Models\Role::all()->toArray();
		unset($roles[0]); // remove admin role
        $payment_plans  = Helper::getPlanList();
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
    'Cheque'=>'Cheque',
    'Other'=>'Other - please specify'
    );
	$subscribe_options  = $payment_plans;
/*
    $subscribe_options  = array(
    'plan_G6DvQf9zdEGczW'=>'6 Months',
    'plan_G6DvMJGDvP6wGz'=>'3 Months',
    'plan_G6DuLUGgkizyrs'=>'Monthly'
    );
*/
    $arrSettings = config('user-settings.settings');

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

    $arrAppo_slot_times = config('user-settings.appo_slot_times');

    $arrBreaks = array(
    'Morning Break'=>'Morning Break',
    'Lunch Break'=>'Lunch Break',
    'Afternoon Break'=>'Afternoon Break',
    'Evening Break'=>'Evening Break',
    'Not Applicable' => 'Not Applicable',
    );

    $arrPaymentTerms = config('user-settings.payment_terms');

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

    $arrOrgTypes = array(
        'NHS'=>'NHS',
        'Private organisation providing NHS care'=>'Private organisation providing NHS care',
        'Private organisation proving private healthcare'=>'Private organisation proving private healthcare',
    );
    @endphp
    <script src="https://js.stripe.com/v3" xmlns:v-bind="http://www.w3.org/1999/xhtml"></script>
    <style type="text/css">
        select {
            width: 100% !important;
        }
    </style>
    <div class="wt-haslayout wt-main-section wt-main-section-doctor-bkg">
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
                                        <div class="wt-haslayout" v-show="step === 0" v-cloak>
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
                                                            href="javascrip:void(0);">{{{ trans('lang.01_num') }}}</a>
                                                    <div>{{{ trans('lang.01_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.02_num') }}}</a>
                                                    <div>{{{ trans('lang.02_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.03_num') }}}</a>
                                                    <div>{{{ trans('lang.03_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.04_num') }}}</a>
                                                    <div>{{{ trans('lang.04_step') }}}</div>
                                                </li>
                                                <li v-if="user_role=='support'"><a href="javascrip:void(0);">5</a></li>
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
                                                                       value="{{{ $role['role_type'] }}}"
                                                                       checked="<?php echo (isset($_GET['role']) && $_GET['role'] == $role['role_type']) ? "checked" : "";?>"
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

                                            <div class="form-group">
                                                <button type="submit"
                                                        class="wt-btn">{{{  trans('lang.btn_startnow') }}}</button>
                                            </div>
                                        </div>
                                    </fieldset>

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
                                                            href="javascrip:void(0);">{{{ trans('lang.01_num') }}}</a>
                                                    <div>{{{ trans('lang.01_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.02_num') }}}</a>
                                                    <div>{{{ trans('lang.02_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.03_num') }}}</a>
                                                    <div>{{{ trans('lang.03_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.04_num') }}}</a>
                                                    <div>{{{ trans('lang.04_step') }}}</div>
                                                </li>
                                                <li v-if="user_role=='support'"><a href="javascrip:void(0);">5</a></li>
                                            </ul>

                                            <div v-show="user_role!=='employer' || (user_role=='employer' && this.practice_code_checked)">
                                                <div class="form-group"
                                                     v-bind:class="[user_role=='employer' ? 'form-group-20' : 'form-group-half', '']">
                                                <span class="wt-select">
                                                {!! Form::select('title', array("Mr"=>"Mr", "Ms"=>"Ms", "Mrs"=>"Mrs", "Dr"=>"Dr"), isset($_GET['title']) ? $_GET['title'] : null , array('placeholder' => trans('lang.title'),  'v-bind:class' => '{ "is-invalid": form_step2.title_error }')) !!}
                                                    </span>
                                                    <span class="help-block"
                                                          v-if="form_step2.title_error">
                                                                                <strong v-cloak>@{{form_step2.title_error}}</strong>
                                                                            </span>
                                                </div>
                                                <div class="form-group"
                                                     v-bind:class="[user_role=='employer' ? 'form-group-40' : 'form-group-half', '']">
                                                    <input type="text" name="first_name" class="form-control"
                                                           placeholder="{{{ trans('lang.ph_first_name') }}}"
                                                           value="{{ isset($_GET['first_name']) ? $_GET['first_name'] : "" }}"
                                                           v-bind:class="{ 'is-invalid': form_step1.is_first_name_error }"
                                                    >
                                                    <span class="help-block" v-if="form_step1.first_name_error">
                                                <strong v-cloak>@{{form_step1.first_name_error}}</strong>
                                            </span>
                                                </div>
                                                <div class="form-group form-group-half"
                                                     v-bind:class="[user_role=='employer' ? 'form-group-40' : 'form-group-half', '']">
                                                    <input type="text" name="last_name" class="form-control"
                                                           placeholder="{{{ trans('lang.ph_surname') }}}"
                                                           v-bind:class="{ 'is-invalid': form_step1.is_last_name_error }"
                                                           value="{{ isset($_GET['last_name']) ? $_GET['last_name'] : "" }}"
                                                    >
                                                    <span class="help-block" v-if="form_step1.last_name_error">
                                                <strong v-cloak>@{{form_step1.last_name_error}}</strong>
                                            </span>
                                                </div>
                                                <div class="form-group form-group-half">
                                                    <input id="user_email" type="email" class="form-control"
                                                           name="email"
                                                           placeholder="{{{ trans('lang.ph_email') }}}"
                                                           v-bind:class="{ 'is-invalid': form_step1.is_email_error }"
                                                           value="{{ isset($_GET['email']) ? $_GET['email'] : "" }}"

                                                    >
                                                    <span class="help-block" v-if="form_step1.email_error">
                                                <strong v-cloak>@{{form_step1.email_error}}</strong>
                                                </span>
                                                </div>
                                                <div class="form-group form-group-half" v-if="user_role=='employer'">
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
                                            </div>
                                            <div v-if="user_role=='employer'" class="form-group form-group-half">
                                                <input id="practice_code" type="text"
                                                       class="form-control"
                                                       name="practice_code"
                                                       placeholder="Practice Code"
                                                       @input="practiceCodeChanging"
                                                       v-bind:class="{ 'is-invalid': form_step2.is_practice_code_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.practice_code_error">
                                                <strong v-cloak>@{{form_step2.practice_code_error}}</strong>
                                            </div>
                                            <div v-show="user_role=='employer' && !this.practice_code_checked"
                                                 class="form-group form-group-half">
                                                <a href="#" @click.prevent="validatePracticeCode"
                                                   class="wt-btn">Verify</a>
                                            </div>

                                            <div class="form-group">
                                                <a href="#" @click.prevent="prev()"
                                                   class="wt-btn">{{{ trans('lang.previous') }}}</a>
                                                <a v-if="user_role!=='employer' || (user_role=='employer' && this.practice_code_checked)"
                                                   href="#" @click.prevent="next()"
                                                   class="wt-btn">{{{ trans('lang.continue') }}}</a>
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
                                                <li class="wt-done-next"><a
                                                            href="javascrip:void(0);">{{{ trans('lang.01_num') }}}</a>
                                                    <div>{{{ trans('lang.01_step') }}}</div>
                                                </li>
                                                <li class="wt-active"><a
                                                            href="javascrip:void(0);">{{{ trans('lang.02_num') }}}</a>
                                                    <div>{{{ trans('lang.02_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.03_num') }}}</a>
                                                    <div>{{{ trans('lang.03_step') }}}</div>
                                                </li>
                                                <li><a href="javascrip:void(0);">{{{ trans('lang.04_num') }}}</a>
                                                    <div>{{{ trans('lang.04_step') }}}</div>
                                                </li>
                                                <li v-if="user_role=='support'"><a href="javascrip:void(0);">5</a></li>
                                            </ul>
                                            <div class="form-group">
                                                <div class="wt-tabscontenttitle">
                                                    <h2>Address</h2>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-half" v-if="user_role=='employer'">
                                                <input id="emp_website" type="url"
                                                       class="form-control"
                                                       :disabled="user_role=='employer'"
                                                       name="emp_website"
                                                       placeholder="{{{ trans('lang.emp_website') }}}"
                                                       v-bind:class="{ 'is-invalid': form_step2.emp_website_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.emp_website_error">
														<strong v-cloak>@{{form_step2.emp_website_error}}</strong>
												</span>
                                            </div>
                                            <div class="form-group form-group-half">
                                                <gmap-autocomplete class="form-control"
                                                                   placeholder="Address"
                                                                   id="straddress"
                                                                   name="straddress"
                                                                   @place_changed="updateAddressLocation($event)"
                                                                   :select-first-on-enter="true"
                                                                   :disabled="user_role=='employer'"
                                                                   v-bind:class="{ 'is-invalid': form_step2.straddress_error }">
                                                    <template v-slot:input="slotProps">
                                                        <v-text-field outlined
                                                                      ref="input"
                                                                      v-on:listeners="slotProps.listeners"
                                                                      v-on:attrs="slotProps.attrs">
                                                        </v-text-field>
                                                    </template>
                                                </gmap-autocomplete>
                                                <input v-if="user_role=='employer'" type="hidden"
                                                       id="straddress-emloyer" name="straddress" value="">
                                                <span class="help-block"
                                                      v-if="form_step2.straddress_error">
													<strong v-cloak>@{{form_step2.straddress_error}}</strong>
												</span>
                                            </div>
                                            <input type="hidden" id="latitude" name="latitude" value="">
                                            <input type="hidden" id="longitude" name="longitude" value="">


                                            <div class="form-group form-group-half">
                                                <input id="city" type="text"
                                                       class="form-control"
                                                       name="city"
                                                       placeholder="{{{ trans('lang.city') }}}"
                                                       :disabled="user_role=='employer'"
                                                       v-bind:class="{ 'is-invalid': form_step2.city_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.city_error">
													<strong v-cloak>@{{form_step2.city_error}}</strong>
												</span>
                                            </div>
                                            <div class="form-group form-group-half" v-if="user_role!='employer'">
                                                <input id="phone" type="tel"
                                                       class="form-control"
                                                       name="telno"
                                                       placeholder="{{{ trans('lang.phone') }}}"
                                                       :disabled="user_role=='employer'"
                                                       v-bind:class="{ 'is-invalid': form_step2.telno_error }">
                                                <span class="help-block"
                                                      v-if="form_step2.telno_error">
													<strong v-cloak>@{{form_step2.telno_error}}</strong>
												</span>
                                            </div>
                                            <div class="form-group form-group-half">
                                                <input id="postcode" type="text"
                                                       class="form-control"
                                                       name="postcode"
                                                       placeholder="{{{ trans('lang.postcode') }}}"
                                                       :disabled="user_role=='employer'"
                                                       v-bind:class="{ 'is-invalid': form_step2.postcode_error }"
                                                       v-bind:class="[user_role=='employer' ? 'halfWidth' : '', '']">
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
                                                                                id="ischeck"
                                                                                name="insurance"
                                                                                placeholder="Insurance"
                                                                                v-model="insurancecheckbox">
                                                                    </div>
                                                                    <div v-if="insurancecheckbox">
                                                                        <div class="form-group ">
                                                                            <input type="text"
                                                                                   class="form-control org-name"
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
                                                                                   class="form-control org-name"
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
                                                                    <div class="form-group">
                                                                        {!! Form::select('prof_required', \App\User::getProfessionsByRole(App\Role::EMPLOYER_ROLE), null, ['placeholder' => "Professional Required"]) !!}
                                                                    </div>
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

                                                                    <div class="form-group">
                                                                        <label for="hourly_rate_desc">Please enter
                                                                            additional information in the
                                                                            communication box if required</label>
                                                                        <input id="hourly_rate_desc" type="text"
                                                                               class="form-control"
                                                                               name="hourly_rate_desc"
                                                                               placeholder="Additional info">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        @endif
                                                        @if(in_array($role['id']==3, $roles))

                                                            <div class="wt-accordiondetails"
                                                                 v-if="user_role!='employer'" {{--v-if="is_show_freelancer"--}} >

                                                                <div class="form-group form-group-half"
                                                                     v-bind:class="[user_role!='employer' ? 'float-none' : '', '']">
                                                                    <date-picker :config="{format: 'YYYY-MM-DD'}"
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

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='employer'">
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

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='freelancer'">
        <span class="wt-select">
        {!! Form::select('profession', \App\User::getProfessionsByRole(App\Role::FREELANCER_ROLE), null, array('placeholder' => "Profession")) !!}
        </span>
                                                                </div>

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='support'">
        <span class="wt-select">
        {!! Form::select('profession', \App\User::getProfessionsByRole(App\Role::SUPPORT_ROLE), null, array('placeholder' => "Profession")) !!}
        </span>
                                                                </div>

                                                                <div class="form-group"
                                                                     v-bind:class="[user_role=='support'  ? 'form-group-half' : '', '']"
                                                                     v-if="user_role=='employer' || user_role=='support'">
                                                                    <input id="experience" type="number" min="0"
                                                                           class="form-control"
                                                                           name="experience"
                                                                           placeholder="Experience Years"
                                                                           v-bind:class="{ 'is-invalid': form_step2.exp_years_error }">
                                                                    <span class="help-block"
                                                                          v-if="form_step2.exp_years_error">
                    <strong v-cloak>@{{form_step2.exp_years_error}}</strong>
                </span>
                                                                </div>

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='freelancer'">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="pin"
                                                                           placeholder="PIN /GMC/GPhC No."
                                                                           v-bind:class="{ 'is-invalid': form_step2.pin_error }">
                                                                    <span class="help-block"
                                                                          v-if="form_step2.pin_error">
        <strong v-cloak>@{{form_step2.pin_error}}</strong>
      </span>
                                                                </div>

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='freelancer'">
                                                                    <multiselect v-model="itsoftware"
                                                                                 :options="itsoftware_options"
                                                                                 :searchable="false"
                                                                                 :close-on-select="false"
                                                                                 :clear-on-select="false"
                                                                                 :preserve-search="false"
                                                                                 :show-labels="false" :multiple="true"
                                                                                 placeholder="Computer Systems"
                                                                                 name="itsoftware"
                                                                                 class="multiselect-upd">
                                                                        <template slot="selection"
                                                                                  slot-scope="{ values, search, isOpen }">
                                                                            <span class="multiselect__single"
                                                                                  v-if="values.length &amp;&amp; !isOpen">@{{ values.length }} option@{{ values.length != 1 ? 's' : '' }} selected</span>
                                                                        </template>
                                                                    </multiselect>
                                                                    <select name="itsoftware[]" style="display:none;"
                                                                            multiple>
                                                                        <option v-for="value in itsoftware"
                                                                                :value="value" selected></option>
                                                                    </select>
                                                                </div>

                                                                66666666666245345345

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='freelancer'">
        <span class="wt-select">
        {!! Form::select('special_interests[]', $arrSpecialInterests, null, array('v-model'=>'specialInterest','placeholder' => "Special Interest")) !!}
        </span>
                                                                </div>

                                                                <div class="form-group" v-if="specialInterest=='Other'">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           name="special_interests[]"
                                                                           placeholder="Other Special Interest">
                                                                </div>

                                                                <div class="form-group" v-if="user_role=='freelancer'">
                                                                    <div class="wt-tabscontenttitle">
                                                                        <h2>Professional Qualifications</h2>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group form-group"
                                                                     v-if="user_role=='freelancer'">
                                                                    <span class="text-right" id="plusQual"
                                                                          style="cursor:pointer;font-size: 16px; background-color: #fccf17;color:white;padding:7px;border-radius:5px">+</span>
                                                                </div>

                                                                <div class="profQualif_block"
                                                                     v-if="user_role=='freelancer'">
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

                                                                <div class="form-group form-group-half"
                                                                     v-if="user_role=='freelancer'">
                                                                    <div>Professional Qualifications:</div>
                                                                    <input type="file" name="prof_qual_cert"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group form-group-half"
                                                                     v-bind:class="[user_role=='support' ? 'float-right' : '', '']">
                                                                    <div>Mandatory Training:</div>
                                                                    <input type="file" name="mand_training"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group form-group-half"
                                                                     v-bind:class="[user_role=='support' ? 'float-left' : 'float-none', '']">
                                                                    <div>Occupational Health:</div>
                                                                    <input type="file" name="occup_health"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group"
                                                                     v-bind:class="[insurancecheckbox ? 'form-group-half' : '', '']"
                                                                     v-if="user_role=='freelancer'">
                                                                    <div class="wt-checkboxholder">
            <span class="wt-checkbox">
                <input id="insurancecheckbox" type="checkbox"
                       name="insurancecheckbox"
                       v-model="insurancecheckbox">
                <label for="insurancecheckbox"><span>Do you have professional indemnity insurance?</span></label>
            </span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group form-group-half"
                                                                     v-if="insurancecheckbox"
                                                                     v-if="user_role=='freelancer'">
                                                                    <div>Professional Indemnity Insurance:</div>
                                                                    <input type="file" name="prof_ind_cert"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group"
                                                                     v-bind:class="[dbscheck ? 'form-group-half' : '', '']">
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

                                                                <div class="form-group form-group-half" v-if="dbscheck">
                                                                    <div>Certificate of CRB/DBS:</div>
                                                                    <input type="file" name="cert_of_crbdbs"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>

                                                                <div class="form-group form-group"
                                                                     v-if="user_role=='support' || user_role=='freelancer'">
        <span class="wt-select">
        {!! Form::select('drive_license',  array('Yes'=>'Yes', 'No'=>'No'), null, array('placeholder' => "Do you have a full driving licence?")) !!}
        </span>
                                                                </div>

                                                                <div class="form-group form-group"
                                                                     v-if="user_role=='support'">
        <span class="wt-select">
        {!! Form::select('endorsements',  array('Yes'=>'Yes', 'No'=>'No'), null, array('placeholder' => "Do you have any endorsements?")) !!}
        </span>
                                                                </div>


                                                                <div class="form-group form-group-half">
                                                                    <div>CV Upload:</div>
                                                                    <input type="file" name="cvfile"
                                                                           class="form-control"
                                                                           accept=".pdf, image/*,.doc,.docx">
                                                                </div>


                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </fieldset>

                                        <fieldset class="wt-termsconditions">
                                            <div class="wt-checkboxholder">
      <span class="wt-checkbox">
        <input id="termsconditions" type="checkbox" name="termsconditions">
        <label for="termsconditions"><span>Agree to T&Cs and Privacy</span></label>
        <span class="help-block" v-if="form_step2.termsconditions_error">
            <strong style="color: red;" v-cloak>{{trans('lang.register_termsconditions_error')}}</strong>
        </span>
      </span>
                                                <a href="#" @click.prevent="prev()"
                                                   class="wt-btn">{{{ trans('lang.previous') }}}</a>
                                                <a href="#" @click.prevent="checkStep2('Email is not configured')"
                                                   class="wt-btn">{{{ trans('lang.continue') }}}</a>
                                            </div>
                                        </fieldset>
                                    </div>


                                    <div class="wt-joinformc" v-show="step === 3" v-cloak>

                                        <div class="wt-registerhead" v-if="user_role=='employer'">
                                            <div class="wt-title">
                                                <h3>{{{ $reg_three_title }}}</h3>
                                            </div>
                                        </div>

                                        <ul class="wt-joinsteps">
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.01_num') }}}</a>
                                                <div>{{{ trans('lang.01_step') }}}</div>
                                            </li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.02_num') }}}</a>
                                                <div>{{{ trans('lang.02_step') }}}</div>
                                            </li>
                                            <li class="wt-active"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.03_num') }}}</a>
                                                <div>{{{ trans('lang.03_step') }}}</div>
                                            </li>
                                            <li><a href="javascrip:void(0);">{{{ trans('lang.04_num') }}}</a>
                                                <div>{{{ trans('lang.04_step') }}}</div>
                                            </li>
                                            <li v-if="user_role=='support'"><a href="javascrip:void(0);">5</a></li>
                                        </ul>

                                        <figure class="wt-joinformsimg"></figure>

                                        <fieldset class="wt-formregisterstart">
                                            <div class="form-group-n">

                                                <div v-if="user_role!='employer'">

                                                    <div class="form-group form-group-half" style="margin-top: 23px;">
                                                  <span class="wt-select">
                                                  {!! Form::select('right_of_work',  array('Yes'=>'Yes', 'No'=>'No'), null, array('placeholder' => "Right to work")) !!}
                                                  </span>
                                                    </div>

                                                    <div class="form-group form-group-half">
                                                        <div>Passport or Visa:</div>
                                                        <input type="file" name="passport_visa"
                                                               class="form-control"
                                                               v-bind:class="{ 'is-invalid': form_step2.is_passport_visa }"
                                                               accept=".pdf, image/*,.doc,.docx">
                                                        <span class="help-block"
                                                              v-if="form_step2.is_passport_visa">
                                                <strong v-cloak>@{{form_step2.passport_visa}}</strong>
                                                </span>
                                                    </div>

                                                    <div class="form-group form-group-half">
                                                  <span class="wt-select halfWidth">
                                                  {!! Form::select('nationality', $arrNationals, null, array('placeholder' => "Nationality")) !!}
                                                  </span>
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

                                        <div class="wt-registerhead"
                                             v-if="user_role=='freelancer' || user_role=='support'">
                                            <div class="wt-title">
                                                <h3>{{{ $reg_three_title }}}</h3>
                                            </div>
                                        </div>

                                        <ul class="wt-joinsteps">
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.01_num') }}}</a>
                                                <div>{{{ trans('lang.01_step') }}}</div>
                                            </li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.02_num') }}}</a>
                                                <div>{{{ trans('lang.02_step') }}}</div>
                                            </li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.03_num') }}}</a>
                                                <div>{{{ trans('lang.03_step') }}}</div>
                                            </li>
                                            <li class="wt-active"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.04_num') }}}</a>
                                                <div>{{{ trans('lang.04_step') }}}</div>
                                            </li>
                                            <li v-if="user_role=='support'"><a href="javascrip:void(0);">5</a></li>
                                        </ul>

                                        <fieldset class="wt-formregisterstart">

                                            <div v-if="user_role=='employer'">
                                                <div class="wt-registerhead">
                                                    <div class="wt-title">
                                                        <h3>Last step</h3>
                                                    </div>

                                                </div>


                                                <a href="#" class="wt-btn" @click.prevent="checkoutStripe(subscription)"
                                                   v-if="subscription">Go To Checkout</a>


                                                <a href="#" v-if="!subscription" class="wt-btn"
                                                   @click.prevent="loginRegisterUser()">{{{ trans('lang.goto_dashboard') }}}</a>
                                            </div>

                                            <div v-if="user_role=='freelancer' || user_role=='support'">

                                                <div class="form-group form-group-half"
                                                     v-if="user_role=='freelancer' || user_role=='support'">
                                                    <input id="hourly_rate" type="number"
                                                           class="form-control"
                                                           name="hourly_rate"
                                                           min="0"
                                                           placeholder="Hourly Rate">
                                                </div>

                                                <div class="form-group form-group-half" style="margin-bottom: -2px;"
                                                     v-if="user_role=='freelancer' || user_role=='support'">
                                            <span class="wt-checkbox"
                                                  style="    margin-bottom: 13px; margin-top: 17px;">
                                                <span class="wt-checkbox">
                                                  <input id="hourly_rate_negotiable"
                                                         type="checkbox"
                                                         name="hourly_rate_negotiable"
                                                         checked="">
                                                  <label for="hourly_rate_negotiable"><span> Rate Negotiable?</span></label>
                                                </span>
                                            </span>
                                                </div>

                                                <div class="form-group form-group-half">
                                              <span class="wt-select">
                                              {!! Form::select('direct_booking', array('Direct Bookings accepted'=>'Direct Bookings accepted', 'Direct Bookings not accepted'=>'Direct Bookings not accepted'), null, array('placeholder' => "Direct Bookings")) !!}
                                              </span>
                                                </div>

                                                <div class="form-group wt-btnarea">
                                                    <a href="#" @click.prevent="prev()"
                                                       class="wt-btn">{{{ trans('lang.previous') }}}</a>
                                                    <a href="#" v-if="user_role=='support'"
                                                       @click.prevent="checkStep4()"
                                                       class="wt-btn">{{{ trans('lang.continue') }}}</a>
                                                    <a href="#" v-if="user_role=='freelancer'" class="wt-btn"
                                                       @click.prevent="checkStep4()">{{{ trans('lang.goto_dashboard') }}}</a>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>

                                    <div class="wt-gotodashboard" v-show="step === 5" v-cloak>
                                        <ul class="wt-joinsteps">
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.01_num') }}}</a>
                                                <div>{{{ trans('lang.01_step') }}}</div>
                                            </li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.02_num') }}}</a>
                                                <div>{{{ trans('lang.02_step') }}}</div>
                                            </li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.03_num') }}}</a>
                                                <div>{{{ trans('lang.03_step') }}}</div>
                                            </li>
                                            <li class="wt-done-next"><a
                                                        href="javascrip:void(0);">{{{ trans('lang.04_num') }}}</a>
                                                <div>{{{ trans('lang.04_step') }}}</div>
                                            </li>
                                            <li class="wt-active"><a href="javascrip:void(0);">5</a></li>
                                        </ul>

                                        <fieldset class="wt-formregisterstart" style="width: 100%;">
                                            <div class="form-group form-group-half">
                                          <span class="wt-select">
                                          {!! Form::select('payment_option', $payment_options, null, array('placeholder' => "Select Payment Option", 'v-model'=>'choosen_payment' ,'class' => 'form-group', 'v-bind:class' => '{ "is-invalid": form_step2.payment_option_error }', 'v-on:change' => 'selectedPayment(choosen_payment)')) !!}
                                          </span>
                                                <input v-if="choosen_payment=='Other'"
                                                       type="text"
                                                       name="payment_option_other"
                                                       class="form-control"
                                                       placeholder="Please specify">
                                            </div>
                                        </
                                        @>

                                        <div class="form-group wt-btnarea">
                                            <a href="#" @click.prevent="prev()"
                                               class="wt-btn">{{{ trans('lang.previous') }}}</a>
                                            <a href="#" class="wt-btn"
                                               @click.prevent="submitUser()">{{{ trans('lang.goto_dashboard') }}}</a>
                                        </div>
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