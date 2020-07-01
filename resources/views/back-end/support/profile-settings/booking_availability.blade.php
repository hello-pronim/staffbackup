@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <div class="wt-dbsectionspace wt-haslayout la-ed-freelancer">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                <div class="freelancer-profile" id="booking_availability">
                    @if (Session::has('message'))
                        <div class="flash_msg">
                            <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                        </div>
                    @endif
                    @if ($errors->any())
                        <ul class="wt-jobalerts">
                            @foreach ($errors->all() as $error)
                                <div class="flash_msg">
                                    <flash_messages :message_class="'danger'" :time ='10' :message="'{{{ $error }}}'" v-cloak></flash_messages>
                                </div>
                            @endforeach
                        </ul>
                    @endif
                    <div class="wt-dashboardbox wt-dashboardtabsholder">
                        @if (file_exists(resource_path('views/extend/back-end/freelancer/profile-settings/tabs.blade.php')))
                            @include('extend.back-end.freelancer.profile-settings.tabs')
                        @else
                            @include('back-end.freelancer.profile-settings.tabs')
                        @endif
                            <div id="support_availability" style="margin:0 auto; width: 775px;">

                                <div class="wt-tabscontent tab-content">
                                    <vue-cal ref="vuecal" style="height: 650px"
                                             :time-from="0 * 60"
                                             :time-to="24 * 60"
                                             :disable-views="['years', 'year']"
                                             :events="events"
                                             default-view="month"
                                             events-on-month-view="short"
                                             resize-y
                                             resize-x
                                             editable-events
                                             {{--:on-event-create="onEventCreate"--}}
                                             {{--@event-drag-create="onEventCreate"--}}
                                             @event-drag-create="onEventCreate"
                                             :on-event-click="onEventClick"
                                            {{--@cell-click=false--}}
                                    >
                                        <button class="confirmButton btn btn-outline-primary float-right" @click="confButton">confirm</button>
                                    </vue-cal>

                                    <div class="wt-tabscontenttitle" style="margin-top: 50px; ">
                                        <h2>
                                            Green equals free this day<br>
                                            Blue equals booking on this day<br>
                                            Red equals away on holiday<br>
                                        </h2>
                                    </div>
                                    <div{{-- v-if="clickedDate != ''"--}}>
                                        <div class="wt-tabcompanyinfo wt-tabsinfo" style="margin-top:50px">
                                            <div class="wt-tabscontenttitle">
                                                <h2>Create new availability</h2>
                                            </div>
                                        </div>
                                        <div class="wt-accordiondetails">


                                            <form>
                                                <div class="form-group form-group-half classScrollTo" style="">
                                                    <label>Selected Start Date </label>
                                                    <input type="text" disabled class="form-control " placeholder="Selected Date" v-model="availability_selected_date">
                                                </div>
                                                <div class="form-group form-group-half" style="">
                                                    <label>Selected End Date </label>
                                                    <input type="text" disabled class="form-control " placeholder="Selected Date" v-model="availability_selected_end_date">
                                                </div>
                                                <div class="form-group form-group-half">
                                                    <label for="availability_start_time">Holiday Start date/time:</label>
                                                    <vue-timepicker name="availability_start_time" required  format="HH:mm" v-model="availability_start_time"></vue-timepicker>

                                                </div>
                                                <div class="form-group form-group-half">
                                                    <label for="availability_end_time">Holiday End date/time:</label>
                                                    <vue-timepicker name="availability_end_time" required  format="HH:mm" v-model="availability_end_time"></vue-timepicker>

                                                </div>
                                                <div class="form-group">
                                                    <label for="availability_title">Title:</label>
                                                    {!! Form::text( 'availability_title',null, ['class' =>'form-control', 'placeholder' => 'Holiday Title', 'v-model'=>'availability_title', 'required'=>'required'] ) !!}
                                                </div>
                                                <div class="form-group">
                                                    <label for="availability_title">Content:</label>
                                                    {!! Form::text( 'availability_content',null, ['class' =>'form-control', 'placeholder' => 'Holiday description', 'v-model'=>'availability_content', 'required'=>'required'] ) !!}
                                                </div>
                                                <div class="form-group">
                                                    <label for="recuring_date">Recuring date:
                                                        <input type="checkbox" name="recuring_date" v-model="recuring_date"></label>
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::select('skill_id', $skills, null, ['placeholder' => trans('lang.skills'), 'v-model'=>'skill_id']) !!}
                                                </div>
                                                <input type="hidden" name="class" >
                                                <input type="hidden" name="user_id" v-model="user_id">
                                                <input type="hidden" name="id" v-model="id">
                                                <button class="btn btn-success" id="available_class" @click="saveNewEventAvailability">Create Availability</button>
                                                <button class="btn btn-danger" id="busy_class" @click="saveNewEventBusy">Create Holiday/Busy</button>
                                                <button class="btn btn-danger" id="update_event" @click="updateEvent">Update Event</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('bootstrap_script')
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>

@stop
