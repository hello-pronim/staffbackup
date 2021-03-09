@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@section('title'){{ $job->title }} @stop
@section('description', "$job->description")
@section('content')
    @php $breadcrumbs = Breadcrumbs::generate('jobDetail',$job->slug); @endphp
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                    <div class="wt-title"><h2>{{ trans('lang.job_detail') }}</h2></div>
                    @if (!empty($show_breadcrumbs) && $show_breadcrumbs === 'true')
                        @if (count($breadcrumbs))
                            <ol class="wt-breadcrumb">
                                @foreach ($breadcrumbs as $breadcrumb)
                                    @if ($breadcrumb->url && !$loop->last)
                                        <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                                    @else
                                        <li class="active">{{{ $breadcrumb->title }}}</li>
                                    @endif
                                @endforeach
                            </ol>
                        @endif
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wt-haslayout wt-main-section">
        <div class="container">
            <div class="row">
                <div class="job-single wt-haslayout">
                    <div id="jobs" class="wt-twocolumns wt-haslayout">
                        @if (Session::has('error'))
                            <div class="flash_msg">
                                <flash_messages :message_class="'danger'" :time='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                            </div>
                        @endif
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-left">
                            <div class="wt-proposalholder">
                                <div class="wt-btnarea"><a class="wt-btn" href="{{ $back_url }}">Back</a></div>
                            </div>
                        </div>
                        @if (!empty($job))
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-left">
                                <div class="wt-proposalholder">
                                    @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                        <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.img') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                    @endif
                                    @if (
                                        !empty($job->professional_level) ||
                                        !empty($job->title) ||
                                        !empty($location['title'])  ||
                                        !empty($job->project_type) ||
                                        !empty($job->duration)
                                        )
                                        <div class="wt-proposalhead">
                                            @if (!empty($job->title))
                                                <h2>{{{ $job->title }}}</h2>
                                            @endif

                                            <ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
                                                 @if ($job->project_rates)
                                                    <li>
                                                        <span>
                                                            <i class="wt-budget">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}</i> {{{ $job->project_rates.' per hour' }}}
                                                        </span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="wt-btnarea"><a href="javascript:void(0);" @click.prevent="check_auth('{{ $job->slug }}')" class="wt-btn">{{{ trans('lang.send_propsal') }}}</a></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                                <div class="wt-projectdetail-holder">
                                    @if (!empty($job->description))
                                        <div class="wt-projectdetail">
                                            <div class="wt-title">
                                                <h3>{{ trans('lang.project_detail') }}</h3>
                                            </div>
                                            <div class="wt-description">
                                                {{ $job->description }}
                                            </div>
                                        </div>
                                    @endif
                                    @if (!empty($job->professions))
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>{{ trans('lang.skills_req') }}</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                            @foreach ($job->professions as $profession)
                                                <a href="#">{{{ $profession->title }}}</a>
                                            @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if($job->employer->itsoftware != "")
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>Computer System in use</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                <p>{{ implode(', ', $job->employer->getItsoftware()) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(!empty($job->calendars))
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>Start and End time</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                @foreach($job->calendars as $calendar_event)
                                                    @if($calendar_event->class=="booking_calendar" || $calendar_event->class=="booking_hired")
                                                    <p>Start: {{$calendar_event->start->format('d-m-Y H:i')}} &nbsp; End: {{$calendar_event->end->format('d-m-Y H:i')}}</p>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if($job->breaks)
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>Breaks</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                <p>{{ $job->breaks }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($job->breaks)
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>Admin Catch Up Provided (interval)</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                <p>{{ $job->job_adm_catch_time_interval }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($job->job_appo_slot_times)
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>Appointment Slot Times</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                <p> {{ $job->job_appo_slot_times }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($job->home_visits)
                                        <div class="wt-skillsrequired">
                                            <div class="wt-title">
                                                <h3>Home Visits</h3>
                                            </div>
                                            <div class="wt-tag wt-widgettag">
                                                <p> {{ $job->home_visits }}</p>
                                            </div>
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
                            </div>
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">
                            @if (file_exists(resource_path('views/extend/front-end/jobs/sidebar/index.blade.php')))
                                @include('extend.front-end.jobs.sidebar.index')
                            @else
                                @include('front-end.jobs.sidebar.index')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
