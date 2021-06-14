@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<div class="wt-haslayout wt-manage-account wt-dbsectionspace" id="profile_settings">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                @if($status=="accept")
                <h3>An email has been sent to employer to notify you accepted the invitation.</h3>
                @elseif($status=="decline")
                <h3>An email has been sent to employer to notify you are not interested in this job.</h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection