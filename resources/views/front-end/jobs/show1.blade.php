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

                    <h4 class="content-public-profile__main-content-slag">
                    {{ trans('lang.project_id') . ": " . $job->code }}
                    </h4>
                    <p>{{ trans('lang.created_at') }}&nbsp;{{ date('d-m-Y H:i', strtotime($job->created_at)) }} </p>

                    <h2 class="content-public-profile__main-content-name mbottom35">
                        @if(!empty($job->title))
                        {{ $job->title }}
                        @else
                        Undefined
                        @endif
                    </h2>

                    @if($job->description != "")
                    <div class="content-public-profile__main-content-text-block mbottom35">
                        <span class="content-public-profile__main-content-title">Description:</span>
                        <div>{{ $job->description }}</div>
                    </div>
                    @endif

                    @if (!empty($job->professions))
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Profession:</span>
                        <div class="wt-tag wt-widgettag">
                        @foreach ($job->professions as $profession)
                            <a href="#">{{{ $profession->title }}}</a>
                        @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if ($job->employer->itsoftware != "")
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Computer System in use:</span>
                        <div>{{ implode(', ', $job->employer->getItsoftware()) }}</div>
                    </div>
                    @endif

                    @if(!empty($job->calendars))
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Start and End time:</span>
                        @foreach($job->calendars as $calendar_event)
                            @if($calendar_event->class=="booking_calendar" || $calendar_event->class=="booking_hired")
                            <div>Start: {{$calendar_event->start->format('d-m-Y H:i')}}</div>
                            <div>End: {{$calendar_event->end->format('d-m-Y H:i')}}</div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                    @php
                    $breaks = @unserialize($job->breaks);
                    @endphp
                    @if($breaks)
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Breaks:</span>
                        <div>
                        @foreach($breaks as $break)
                        {{ $break->when . ": "}} {{ $break->for }}
                        @endforeach 
                        </div>
                    </div>
                    @endif
                    @if($job->job_adm_catch_time_interval)
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Admin Catch Up Provided (interval):</span>
                        {{ $job->job_adm_catch_time_interval }}
                    </div>
                    @endif
                    @if($job->job_appo_slot_times)
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Appointment Slot Times:</span>
                        {{ $job->job_appo_slot_times }}
                    </div>
                    @endif
                    @if($job->home_visits)
                    <div class="content-public-profile__main-content-separator"></div>
                    <div class="content-public-profile__main-content-text-block mtop35 mbottom35">
                        <span class="content-public-profile__main-content-title">Home Visits:</span>
                        {{ $job->home_visits }}
                    </div>
                    @endif
                    @if (!empty($attachments) && $job->show_attachments === 'true')
                        <div class="wt-attachments">
                            <div class="wt-title">
                                <h3>{{ trans('lang.attachments') }}</h3>
                            </div>
                            <ul class="wt-attachfile">
                                @foreach ($attachments as $attachment)
                                    <li>
                                        <span>{{{Helper::formateFileName($attachment)}}}</span>
                                        <em>
                                            @if (Storage::disk('local')->exists('uploads/jobs/'.$job->employer->id.'/'.$attachment))
                                                {{ trans('lang.file_size') }} {{{Helper::bytesToHuman(Storage::size('uploads/jobs/'.$job->employer->id.'/'.$attachment))}}}
                                            @endif
                                            <a href="{{{route('getfile', ['type'=>'jobs','attachment'=>$attachment,'id'=>$job->user_id])}}}"><i class="lnr lnr-download"></i></a>
                                        </em>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Right content -->
                <div class="content-public-profile__main-content-right">
                @if (file_exists(resource_path('views/extend/front-end/jobs/sidebar1/index.blade.php')))
                    @include('extend.front-end.jobs.sidebar1.index')
                @else
                    @include('front-end.jobs.sidebar1.index')
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
