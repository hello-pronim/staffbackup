@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <div class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9" id="proposals">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>{{ trans('lang.all_proposals') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-completejobholder">
                            @if (!empty($proposals) && $proposals->count() > 0)
                                <div class="wt-managejobcontent">
                                    @foreach ($proposals as $proposal)
                                        @php
                                            $job = \App\Job::find($proposal->job_id);
                                            $employer = \App\User::find($job->user_id);
                                            $location = \App\Location::find($job->location_id);
                                            $duration = $job->duration;
                                            $status_btn = $proposal->status == 'cancelled' ? trans('lang.view_reason') : trans('lang.view_detail');
                                            $detail_link = $proposal->status == 'hired' ? url('freelancer/job/'.$job->slug) : 'javascript:void(0);';
                                            $user_name = Helper::getUserName($job->user_id);
                                        @endphp
                                        <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                            @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                                <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                            @endif
                                            <div class="wt-userlistingcontent wt-userlistingcontentvtwo">
                                                <div class="wt-contenthead">
                                                    @if (!empty($user_name) || !empty($job->title) )
                                                        <div class="wt-title">
                                                            @if (!empty($user_name))
                                                            <a href="{{{ url('profile/'.$job->employer->slug) }}}">
                                                                @if ($employer->user_verified === 1)
                                                                    <i class="fa fa-check-circle"></i>
                                                                @endif
                                                                &nbsp;{{{ $user_name }}}</a>
                                                            @endif
                                                            @if (!empty($job->title))
                                                                <h2>{{{ $job->title }}}</h2>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @if (!empty($job->price) ||
                                                        !empty($location->title)  ||
                                                        !empty($job->project_type) ||
                                                        !empty($job->duration)
                                                        )
                                                        <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                            @if (!empty($job->price))
                                                                <li><span class="wt-dashboraddoller"><i>{{ !empty($symbol) ? $symbol['symbol'] : '£' }}</i> {{{ $job->price }}}</span></li>
                                                            @endif
                                                            @if (!empty($location->title))
                                                                <li><span><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.locations') }}}"> {{{ $location->title }}}</span></li>
                                                            @endif
                                                            @if (!empty($job->project_type))
                                                                <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> {{ trans('lang.type') }} {{{ $job->project_type }}}</a></li>
                                                            @endif
                                                            @if (!empty($job->duration))
                                                                <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> {{ trans('lang.duration') }} {{{ $duration }}}</span></li>
                                                            @endif
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="wt-rightarea la-pending-jobs">
                                                    <div class="wt-hireduserstatus">
                                                        <h4>{{{ Helper::displayProposalStatus($proposal->status) }}}</h4>
                                                        @if ( $proposal->status != 'pending' )
                                                            <a href="{{{ url('freelancer/job/'.$job->slug) }}}" class="wt-btn">
                                                                {{$status_btn}}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                @if (file_exists(resource_path('views/extend/errors/no-record.blade.php'))) 
                                    @include('extend.errors.no-record')
                                @else 
                                    @include('errors.no-record')
                                @endif
                            @endif
                        </div>
                    </div>
                    @if ( method_exists($proposals,'links') )
                        {{ $proposals->links('pagination.custom') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
