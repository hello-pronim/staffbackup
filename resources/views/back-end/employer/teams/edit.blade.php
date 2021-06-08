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
                            {!! Form::open(['class' =>'edit-team-form wt-haslayout', 'id' => 'edit_team_form',  '@submit.prevent'=>'updateTeam']) !!}
                            <input type="hidden" id="team_id" name="id" value={{$team->id}}>
                            <div class="wt-dashboardbox">
                                <div class="wt-dashboardboxtitle text-center">
                                    <h2 class="text-bold text-uppercase" style="font-family: AganeLight;">{{ trans('lang.edit_team') }}</h2>
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
                                    <div class="form-group">
                                        <div class="wt-tabscontenttitle">
                                            <div class="flex-row align-items-center justify-content-between">
                                                <h2>{{ trans('lang.team_members') }}</h2>
                                                <a href="{{route('addTeamMembers', ['slug'=>$team->slug])}}">Add member</a>
                                            </div>
                                        </div>
                                        <div class="form-group wt-userform">
                                            <table class="wt-tablecategories">
                                                <thead>
                                                    <tr>
                                                        <th>{{{ trans('lang.name') }}}</th>
                                                        <th>{{{ trans('lang.professions') }}}</th>
                                                        <th>{{{ trans('lang.hourly_rate') }}}</th>
                                                        <th>{{{ trans('lang.action') }}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($members as $key => $member)
                                                    <tr class="del-team-{{ $member->id }}">
                                                        <td><a href="{{route('showUserProfile', ['slug'=>$member->slug])}}">{{ $member->first_name." ".$member->last_name }}</a></td>
                                                        <td></td>
                                                        <td>{{ $symbol['symbol']." ".$member->hourly_rate." per hour" }}</td>
                                                        <td>
                                                            <div class="wt-actionbtn">
                                                                <a href="javascript:void()" class="wt-deleteinfo wt-skillsaddinfo"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="wt-updatall">
                                    <i class="ti-announcement"></i>
                                    <span>{{{ trans('lang.save_changes_note') }}}</span>
                                    {!! Form::submit(trans('lang.update_team'), ['class' => 'wt-btn', 'id'=>'submit-team']) !!}
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
