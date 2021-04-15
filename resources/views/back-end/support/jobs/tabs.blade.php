<div class="wt-dashboardtabs">
    <ul class="wt-tabstitle nav navbar-nav">
        <li class="nav-item">
            <a class="{{ $status ==='hired'? 'active': '' }}" href="{{route('supportJobsByStatus', ['status'=>'hired'])}}">{{{ trans('lang.ongoing_jobs') }}}</a>
        </li>
        <li class="nav-item">
            <a class="{{ $status ==='completed'? 'active': '' }}" href="{{route('supportJobsByStatus', ['status'=>'completed'])}}">{{{ trans('lang.completed_jobs') }}}</a>
        </li>
        <li class="nav-item">
            <a class="{{ $status ==='cancelled'? 'active': '' }}" href="{{route('supportJobsByStatus', ['status'=>'cancelled'])}}">{{{ trans('lang.cancelled_jobs') }}}</a>
        </li>
    </ul>
</div>
