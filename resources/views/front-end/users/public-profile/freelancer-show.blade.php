@extends('front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
<link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{ html_entity_decode($user_name, ENT_QUOTES) }} | {{ html_entity_decode($tagline, ENT_QUOTES) }} @stop
@section('description', "$desc")
@section('content')
<div class="content-public-profile" id="user_profile">
    <div class="content-public-profile__wrapper">
        <section class="block-circles">
            <div class="block-circles__container">
                <div class="block-circles__wrapper">
                    <div class="block-circles__item block-circles__item-cyan"></div>
                    <div class="block-circles__item block-circles__item-blue"></div>
                    <div class="block-circles__item block-circles__item-yellow"></div>
                </div>
            </div>
        </section><!-- .circles -->

        <section class="content-public-profile__main-content">
            <div class="content-public-profile__main-content-wrapper">
                <a class="content-public-profile__main-content-back-btn"
                    href="{{ $back_url }}"><button>Back</button></a>

                <!-- Left content -->
                <div class="content-public-profile__main-content-left">
                    @if (!empty($badge) && !empty($enable_package) && $enable_package === 'true')
                    <span class="content-public-profile__main-content-badge"
                        style="border-top: 40px solid {{ $badge_color }};">
                        <img src="{{ asset(Helper::getBadgeImage($badge_img))   }}"
                            alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member"
                            class="template-content tipso_style">
                    </span>
                    @endif
                    <img class="content-public-profile__main-content-avatar"
                        src="{{ file_exists(Helper::PublicPath().Helper::getProfileImageSmall($user->id)) ? asset(Helper::getProfileImageSmall($user->id)) : '/images/user.jpg' }}"
                        alt="{{ trans('lang.user_avatar') }}">
                    <h2 class="content-public-profile__main-content-name mbottom35">
                        @if(!empty($user_name))
                        @if($user->user_verified === 1)<i class="fa fa-check-circle"></i> @endif
                        {{ $user_name }}
                        @else
                        Undefined
                        @endif
                    </h2>

                    <div class="mbottom35">
                        <h4 class="content-public-profile__main-content-slag">{{ '@' }}{{ $user->slug }}</h4>
                        @if (!empty($joining_date))
                        <p>{{ trans('lang.member_since') }}&nbsp;{{ $joining_date }} </p>
                        @endif
                    </div>

                    @if($user->profession != "")
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Profession:</span>
                        {{ $user->profession }}
                    </div>
                    @endif

                    @php
                        $arrQualif = json_decode($user->prof_qualifications);
                    @endphp
                    @if(count($arrQualif))
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Professional Qualification:</span>
                        <table class="fs-12" border="1">
                            <tr>
                                <th>Level</th>
                                <th>Name</th>
                                <th>Place</th>
                                <th>Year</th>
                            </tr>
                        @if(!empty($arrQualif) && isset($arrQualif[0]) && isset($arrQualif[0][0]) && $arrQualif[0][0] != "")
                        @foreach($arrQualif as $qualif)
                            <tr>
                                <td>{{$qualif[0]}}</td>
                                <td>{{$qualif[1]}}</td>
                                <td>{{$qualif[2]}}</td>
                                <td>{{$qualif[3]}}</td>
                            </tr>
                        @endforeach
                        @endif
                        </table>
                    </div>
                    @endif

                    @if($user->itsoftware != "")
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Computer System in use:</span>
                        {{ implode(', ', $user->getItsoftware()) }}
                    </div>
                    @endif

                    @if($user->limitied_company_name != "")
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Limited Company Name:</span>
                        {{ $user->limitied_company_name }}
                    </div>
                    @endif

                    @if($user->limitied_company_number != "")
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Limited Company Number:</span>
                        {{ $user->limitied_company_number }}
                    </div>
                    @endif

                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">{{ trans('lang.my_skills') }}:</span>
                        {{$user->title}}
                    </div>
                </div>

                <!-- Right content -->
                <div class="content-public-profile__main-content-right">

                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        @if (!empty($profile->tagline))
                        <span class="content-public-profile__main-content-title">{{ html_entity_decode($profile->tagline, ENT_QUOTES) }}</span>
                        @endif
                        @if(!empty($profile->description))
                            <div class="content-full-less">
                                <div id="profile-description" class="content-full-less-paragraph">
                                    <p class="content-public-profile__main-content-description">
                                        {{ html_entity_decode($profile->description, ENT_QUOTES) }}
                                    </p>
                                </div>
                                <div class="content-full-less_link-wrapper">
                                    <span class="content-full-less_link" data-more="Read More" data-less="Less" data-content="profile-description">Read More</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (!empty($profile->hourly_rate))
                    <div
                        class="content-public-profile__main-content-separator content-public-profile__main-content-separator-blue">
                    </div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Hour Rate:</span>
                        <p class="content-public-profile__main-content-paragraph-large"><i
                                class="far fa-money-bill-alt"></i> {{ $symbol }}{{ $profile->hourly_rate }}
                            {{ trans('lang.per_hour') }}</p>
                    </div>
                    @endif

                    @if (!empty($user->location->title))
                    <div
                        class="content-public-profile__main-content-separator content-public-profile__main-content-separator-blue">
                    </div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Location:</span>
                        <p class="content-public-profile__main-content-paragraph-large"><span>
                                <img src="{{ asset(Helper::getLocationFlag($user->location->flag)) }}"
                                    alt="{{ trans('lang.flag_img') }}"> {{ $user->location->title }}
                            </span></p>
                    </div>
                    @endif

                    @if (in_array($profile->id, $save_freelancer))
                    <a href="javascript:void(0);" class="wt-clicksave wt-clicksave">
                        <i class="fa fa-heart"></i>
                        {{ trans('lang.saved') }}
                    </a>
                    @endif
                    
                    @if($doc_visible && $user->passport_visa!=="")
                    <div class="wt-hireduserstatus">
                        <i class="fa fa-paperclip"></i>
                        <a target="_blank" href="<?= url('uploads/files/'.$user->passport_visa) ;?>" download>Passport or Visa</a>
                    </div>
                    @endif
                    @if($doc_visible && $user->cert_of_crbdbs!=="")
                    <div class="wt-hireduserstatus">
                        <i class="fa fa-paperclip"></i>
                        <a target="_blank" href="<?= url('uploads/files/'.$user->cert_of_crbdbs) ;?>" download>DBS</a>
                    </div>
                    @endif
                    @if($doc_visible && $user->occup_health!=="")
                    <div class="wt-hireduserstatus">
                        <i class="fa fa-paperclip"></i>
                        <a target="_blank" href="<?= url('uploads/files/'.$user->occup_health) ;?>" download>Occupational Health Information-certificates</a>
                    </div>
                    @endif
                    @if($doc_visible && $profile->cvFile!=="")
                    <div class="wt-hireduserstatus">
                        <i class="fa fa-paperclip"></i>
                        <a target="_blank" href="<?= url('uploads/cvs/'.$profile->cvFile) ;?>" download>CV</a>
                    </div>
                    @endif
                    @if($doc_visible && $user->mand_training!=="")
                    <div class="wt-hireduserstatus">
                        <i class="fa fa-paperclip"></i>
                        <a target="_blank" href="<?= url('uploads/files/'.$user->mand_training) ;?>" download>Mandatory Training</a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- .content-public-profile__main-content -->

        <section class="block-circles">
            <div class="block-circles__container block-circles__container-last">
                <div class="block-circles__wrapper">
                    <div class="block-circles__item block-circles__item-blue"></div>
                    <div class="block-circles__item block-circles__item-blue"></div>
                    <div class="block-circles__item block-circles__item-blue"></div>
                </div>
            </div>
        </section><!-- .circles -->
    </div>

    <b-modal ref="myModalRef" hide-footer title="Project Status">
        <div class="d-block text-center">
            {!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id' =>'send-offer-form',
            '@submit.prevent'=>'submitProjectOffer("'.$profile->user_id.'")'])!!}
            <div class="wt-projectdropdown-hold">
                <div class="wt-projectdropdown">
                    <span class="wt-select">
                        {{{ Form::select('projects', $employer_projects, null, array('class' => 'form-control', 'placeholder' => trans('lang.ph_select_projects'))) }}}
                    </span>
                </div>
            </div>
            <div class="wt-formtheme wt-formpopup">
                <fieldset>
                    <div class="form-group">
                        {{{ Form::textarea('desc', null, array('class' => 'form-control-text-area', 'placeholder' => trans('lang.ph_add_desc'))) }}}
                    </div>
                    <div class="form-group wt-btnarea">
                        {!! Form::submit(trans('lang.btn_send_offer'), ['class' => 'wt-btn']) !!}
                    </div>
                </fieldset>
            </div>
            {!! Form::close() !!}
        </div>
    </b-modal>
</div>
@endsection
