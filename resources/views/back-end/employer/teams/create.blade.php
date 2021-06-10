@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<div class="wt-haslayout wt-dbsectionspace" id="dashboard">
    <div class="row page-group" style="margin-top: 69px;margin-bottom: 14px;">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
            <div class="page-group-selectors bg-dark-blue">Description</div>
            <div class="triangle"></div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="page-group-selectors bg-light-blue">Dates</div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
            <div class="page-group-selectors bg-specific-green">Requirements</div>
        </div>
    </div>
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser">
    <div class="row">

        <div class="">
            @if (Session::has('payment_message'))
                @php $response = Session::get('payment_message') @endphp
                <div class="flash_msg">
                    <flash_messages :message_class="'{{{$response['code']}}}'" :time ='5' :message="'{{{ $response['message'] }}}'" v-cloak></flash_messages>
                </div>
            @endif
            @if (session()->has('type'))
                @php session()->forget('type'); @endphp
            @endif
            <div class="preloader-section" v-if="loading" v-cloak>
                <div class="preloader-holder">
                    <div class="loader"></div>
                </div>
            </div>
                <div id="create_team" class="post_job_dashboard-wrapper">
                    <div class="dashboard-vuecal-wrapper dashboard-vuecal-wrapper-employer">
                    </div>
                    <div  class="scrolToCalend">
                        <div class="wt-tabscontent tab-content">
                            {!! Form::open(['url' => url('employer/teams/add'), 'class' =>'create-team-form wt-haslayout', 'id' => 'create_team_form',  '@submit.prevent'=>'createTeam']) !!}
                            <div class="wt-dashboardbox">
                                <div class="wt-dashboardboxtitle text-center">
                                    <h2 class="text-bold text-uppercase" style="font-family: AganeLight;">{{ trans('lang.create_team') }}</h2>
                                </div>
                                <div class="wt-dashboardboxcontent  classScrollTo">
                                    <div class="form-group">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.team_information') }}</h2>
                                        </div>
                                        <div class="form-group wt-userform">
                                            <fieldset>
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control" placeholder="{{ trans('lang.team_name') }}" v-model="team_name">
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::textarea('description', null, ['class' =>'form-control', 'placeholder' => trans('lang.team_description') , 'v-model'=>'team_description']) !!}
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="wt-updatall">
                                    <i class="ti-announcement"></i>
                                    <span>{{{ trans('lang.save_changes_note') }}}</span>
                                    {!! Form::submit(trans('lang.create_team'), ['class' => 'wt-btn', 'id'=>'submit-team']) !!}
                                </div>
                            </div>
                            {!! form::close(); !!}
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </section>
</div>
@endsection
