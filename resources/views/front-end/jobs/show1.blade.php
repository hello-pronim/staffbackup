@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@section('title'){{ $job->title }} @stop
@section('description', "$job->description")
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
                    <img class="content-public-profile__main-content-avatar"
                        src="{{ file_exists(Helper::PublicPath().Helper::getProfileImageSmall($user->id)) ? asset(Helper::getProfileImageSmall($user->id)) : '/images/user.jpg' }}"
                        alt="{{ trans('lang.user_avatar') }}">
                    <h2 class="content-public-profile__main-content-name mbottom35">
                        @if(!empty($job->title))
                        {{ $job->title }}
                        @else
                        Undefined
                        @endif
                    </h2>

                    <div class="mbottom35">
                        <h4 class="content-public-profile__main-content-slag">
                        {{ trans('lang.project_id') . ": " . $job->code }}
                        </h4>
                        <p>{{ trans('lang.created_at') }}&nbsp;{{ date('d-m-Y H:i', strtotime($job->created_at)) }} </p>
                    </div>

                    @if($user->profession != "")
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Profession:</span>
                        {{ $user->profession }}
                    </div>
                    @endif
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
</div>
@endsection
@push('scripts')
    <script>
        var popupMeta = {
            width: 400,
            height: 400
        }
        $(document).on('click', '.social-share', function(event){
            event.preventDefault();

            var vPosition = Math.floor(($(window).width() - popupMeta.width) / 2),
                hPosition = Math.floor(($(window).height() - popupMeta.height) / 2);

            var url = $(this).attr('href');
            var popup = window.open(url, 'Social Share',
                'width='+popupMeta.width+',height='+popupMeta.height+
                ',left='+vPosition+',top='+hPosition+
                ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                return false;
            }
        })
    </script>
@endpush
