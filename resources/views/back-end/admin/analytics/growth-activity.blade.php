@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace" id="growth_activity">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
                @if (Session::has('message'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="wt-dashboardbox flex-column mb-50">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{{ trans('lang.growth') }}}</h2>
                    </div>
                    <div class="row dashboard-wt-tabscontent-wrapper">
                        <div class="row newStyleBoxes" style="display:block; margin: 0 auto">
                            <div class="newStyleBoxesWrapper mt-10" style="margin: 0 auto">
                                <div class="newBoxStyle">
                                    <div class="firsthalf"><a href="{{route('userListing')}}">{{ trans('lang.new_users') }}</a></div>
                                    <div class="secondhalf">
                                        {{($growth['percent'] > 0 ? '+' : '') . $growth['percent']."%"}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="wt-dashboardbox flex-column">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{{ trans('lang.activity') }}}</h2>
                        <form class="wt-formtheme wt-formsearch">
                            <fieldset>
                                <div class="form-group">
                                    <div class="flex-row align-items-center pr-40">
                                        <div class="search-field-input">
                                            <input type="text" class="selectDatePicker w-100" name="from" v-model="from" placeholder="Date..."
                                                ref="from" data-value="{{ isset($_GET['from']) ? $_GET['from']: date('m/Y', strtotime('first day of previous month')) }}" />
                                            <vue-cal id="calendar_small_from"
                                                :selected-date="selectedDateFrom"
                                                style="display:none;z-index:5; background-color:white;width:230px;position: absolute; height: 290px;"
                                                class=" vuecal--green-theme" xsmall hide-view-selector :time="false"
                                                default-view="year" :disable-views="['week', 'day', 'month']"
                                                @cell-click="changeSelectedDateFrom">
                                            </vue-cal>
                                        </div>
                                        <div class="search-field-input">
                                            <input type="text" class="selectDatePicker w-100" name="to" v-model="to" placeholder="Date..."
                                                ref="to" data-value="{{ isset($_GET['to']) ? $_GET['to']: date('m/Y', strtotime('first day of this month')) }}" />
                                            <vue-cal id="calendar_small_to"
                                                :selected-date="selectedDateTo"
                                                style="display:none;z-index:5; background-color:white;width:230px;position: absolute; height: 290px;"
                                                class=" vuecal--green-theme" xsmall hide-view-selector :time="false"
                                                default-view="year" :disable-views="['week', 'day', 'month']"
                                                @cell-click="changeSelectedDateTo">
                                            </vue-cal>
                                        </div>
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="row dashboard-wt-tabscontent-wrapper">
                        <div class="row newStyleBoxes" style="display:block; margin: 0 auto">
                            <div class="newStyleBoxesWrapper mt-10" style="margin: 0 auto">
                                <div class="newBoxStyle">
                                    <div class="firsthalf"><a href="{{route('userListing')}}">{{ trans('lang.sign_up') }}</a></div>
                                    <div class="secondhalf">
                                        {{($activity['user_change']['more'] > 0 ? '+' : '') . $activity['user_change']['more']}}
                                    </div>
                                </div>
                                <div class="newBoxStyle">
                                    <div class="firsthalf"><a href="{{{ route('allJobs') }}}">{{ trans('lang.jobs_posted') }}</a></div>
                                    <div class="secondhalf">
                                        {{($activity['job_change']['more'] > 0 ? '+' : '') . $activity['job_change']['more']}}
                                    </div>
                                </div>
                                <div class="newBoxStyle">
                                    <div class="firsthalf"><a href="{{route('adminDashboard')}}">{{ trans('lang.availability_posted') }}</a></div>
                                    <div class="secondhalf">
                                        {{($activity['availability_change']['more'] > 0 ? '+' : '') . $activity['availability_change']['more']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 float-right">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch text-center">
                        <h2>{{isset($_GET['from'])? $_GET['from']: "Last month"}}</h2>
                    </div>
                    <div class="text-center mt-10">
                        <p><b>New users:</b> {{($activity['user_change']['before'] > 0 ? '+' : '') . $activity['user_change']['before']}}</p>
                        <p><b>New Jobs:</b> {{($activity['job_change']['before'] > 0 ? '+' : '') . $activity['job_change']['before']}}</p>
                        <p><b>New Availabilities:</b> {{($activity['availability_change']['before'] > 0 ? '+' : '') . $activity['availability_change']['before']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 float-right">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch text-center">
                        <h2>{{isset($_GET['to'])? $_GET['to']: "This month"}}</h2>
                    </div>
                    <div class="text-center mt-10">
                        <p><b>New users:</b> {{($activity['user_change']['now'] > 0 ? '+' : '') . $activity['user_change']['now']}}</p>
                        <p><b>New Jobs:</b> {{($activity['job_change']['now'] > 0 ? '+' : '') . $activity['job_change']['now']}}</p>
                        <p><b>New Availabilities:</b> {{($activity['availability_change']['now'] > 0 ? '+' : '') . $activity['availability_change']['now']}}</p>
                    </div>
                </div>
            </div>
        </div>
        --}}
    </section>
@endsection