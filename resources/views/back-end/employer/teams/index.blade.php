@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
                @if (Session::has('message'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{{ trans('lang.manage_teams') }}}</h2>
                        <a href="{{route('createEmployerTeam')}}" class="wt-btn wt-formsearch ml-20">{{{ trans('lang.add_team') }}}</a>
                        <form class="wt-formtheme wt-formsearch">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}"
                                        class="form-control" placeholder="{{{ trans('lang.ph_search_teams') }}}">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                        @if ($teams->count() > 0)
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th>{{{ trans('lang.team_name') }}}</th>
                                        <th>{{{ trans('lang.description') }}}</th>
                                        <th>{{{ trans('lang.number_members') }}}</th>
                                        <th>{{{ trans('lang.action') }}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($teams as $key => $teamData)
                                    <tr class="del-team-{{ $teamData->id }}">
                                        <td>{{ $teamData->name }}</td>
                                        <td>{{ $teamData->description }}</td>
                                        <td>
                                            <?php
                                                $num_members = DB::table('team_user')->where('team_id', $teamData->id)->get()->count();
                                            ?>
                                            {{ $num_members }}
                                        </td>
                                        <td>
                                            <div class="wt-actionbtn">
                                                <a href="{{ route('editEmployerTeam', ['slug' => $teamData->slug]) }}" class="wt-disableinfo wt-skillsaddinfo"><i class="fa fa-edit"></i></a>
                                                <a href="javascript:void()" class="wt-deleteinfo wt-skillsaddinfo"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            @if (file_exists(resource_path('views/extend/errors/no-record.blade.php')))
                                @include('extend.errors.no-record')
                            @else
                                @include('errors.no-record')
                            @endif
                        @endif
                        @if ( method_exists($teams,'links') )
                            {{ $teams->links('pagination.custom') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
