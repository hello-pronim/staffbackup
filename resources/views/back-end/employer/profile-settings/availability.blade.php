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
                <div class="wt-dashboardbox wt-dashboardtabsholder" id="employer_availability">
                    @if (file_exists(resource_path('views/extend/back-end/employer/profile-settings/tabs.blade.php')))
                    @include('extend.back-end.employer.profile-settings.tabs')
                    @else
                    @include('back-end.employer.profile-settings.tabs')
                    @endif
                    <div class="wt-tabscontent tab-content">
                        <vue-cal ref="vuecal" style="height: 650px"
                                 :time-from="0 * 60"
                                 :time-to="24 * 60"
                                 :disable-views="['years', 'year']"
                                 :events="events"
                                 default-view="month"
                                 {{--:events-on-month-view="[true, 'short'][false * 1]"--}}

                                 @cell-click="createNewEvent">
                        </vue-cal>


                        <div v-if="clickedDate != ''">
                            <div class="wt-tabcompanyinfo wt-tabsinfo" style="margin-top:50px">
                                <div class="wt-tabscontenttitle">
                                    <h2>Create new availability</h2>
                                </div>
                            </div>
                            <div class="wt-accordiondetails">


                                <form>
                                    <div class="form-group classScrollTo" style="">
                                        <label>Selected Date </label>

                                        <input type="text" disabled class="form-control " placeholder="Selected Date" v-model="availability_selected_date">
                                    </div>
                                    <div class="form-group-half">
                                        <label for="availability_start_time">Holiday Start date/time:</label>
                                        <vue-timepicker name="availability_start_time" required  format="HH:mm" v-model="availability_start_time"></vue-timepicker>

                                    </div>
                                    <div class="form-group-half">
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
                                    <button class="btn btn-success" @click="saveNewEventBusy">Create Holiday/Busy</button>
                                </form>
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
