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
                        <h2>{{{ trans('lang.total_users_by_month') }}}</h2>
                        <form class="wt-formtheme wt-formsearch">
                            <fieldset>
                                <div class="form-group">
                                    <select name="year" class="form-control" placeholder="{{{ trans('lang.ph_search') }}}">
                                        <option selected>All</option>
                                        @for($y=date('Y'); $y>=date('Y')-10; $y--)
                                        <option value="{{$y}}" @if(isset($_GET['year']) && $_GET['year']==$y) selected @endif>{{$y}}</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                        @if ($monthlyUsers->count() > 0)
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th>{{{ trans('lang.count_users') }}}</th>
                                        <th>{{{ trans('lang.month') }}}</th>
                                        <th>{{{ trans('lang.year') }}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($monthlyUsers as $key => $item)
                                    <tr>
                                        <td>{{ $item->count }}</td>
                                        <td>{{ $item->month }}</td>
                                        <td>{{ $item->year}}</td>
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
                        @if ( method_exists($monthlyUsers, 'links') )
                            {{ $monthlyUsers->links('pagination.custom') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
