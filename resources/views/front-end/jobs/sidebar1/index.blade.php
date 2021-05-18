<aside id="wt-sidebar" class="wt-sidebar">

    <div class="wt-proposalsr">
        @if ($job->project_rates_type == 'Per hour')
        <div class="wt-proposalsrcontent">
            <span class="wt-proposalsicon"><i class="fa fa-angle-double-down"></i><i class="fa fa-money"></i></span>
            <div class="wt-title">
                <h3>{{{ $job->project_rates }}}</h3>
                <span>{{{ $job->project_rates_type }}}</span>
            </div>
        </div>
        @endif
    </div>
    @if (file_exists(resource_path('views/extend/front-end/jobs/sidebar1/wt-employerinfo-widget.blade.php')))
        @include('extend.front-end.jobs.sidebar1.wt-employerinfo-widget')
    @else
        @include('front-end.jobs.sidebar1.wt-employerinfo-widget')
    @endif
    @if (file_exists(resource_path('views/extend/front-end/jobs/sidebar1/wt-sharejob-widget.blade.php')))
        @include('extend.front-end.jobs.sidebar1.wt-sharejob-widget')
    @else
        @include('front-end.jobs.sidebar1.wt-sharejob-widget')
    @endif
    @if (file_exists(resource_path('views/extend/front-end/jobs/sidebar1/wt-reportjob-widget.blade.php')))
        @include('extend.front-end.jobs.sidebar1.wt-reportjob-widget')
    @else
        @include('front-end.jobs.sidebar1.wt-reportjob-widget')
    @endif
</aside>

