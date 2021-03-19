@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace la-dbproposal" id="message-send">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2>{{ trans('lang.send_msg') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-jobdetailsholder">
                        <div class="wt-freelancerholder wt-tabsinfo">
                            <div class="wt-jobdetailscontent">
                                <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                    <div class="wt-userlistingcontent">
                                    
                                        {!! Form::open(['url' => url('message-center/send'), 'method' => 'post', 'class' => 'wt-formtheme wt-formsearch', 'id'=>'message_send_form', '@submit.prevent'=>'submitMessage'])!!}
                                        <input type="hidden" name="receiver_id" value="{{$user->id}}">
                                        <div class="wt-contenthead">
                                            <div class="wt-title">
                                                <span class="mr-10">To: </span>
                                                <span>
                                                    <a href="{{{ url('profile/'.$user->slug) }}}">
                                                        <img src="{{ asset($profile->avatar ? '/uploads/users/' . $user->id . '/' . $profile->avatar : 'images/user-login.png') }}" alt="{{ trans('lang.profie_img') }}">
                                                        <span class="ml-10 mr-10">{{{ $user->first_name." ".$user->last_name }}}</span>
                                                        @if($user->user_verified)
                                                            <i class="fa fa-check-circle"></i>&nbsp;
                                                        @endif
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="wt-rightarea">
                                            <textarea class="form-control" id="message-area" name="body" placeholder="Type message here" v-model="messageText"></textarea>
                                        </div>
                                        <div class="form-group mt-10">
                                            {!! Form::submit(trans('lang.save'), ['class' => 'wt-btn float-right', 'id'=>'submit-message']) !!}
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('js/linkify.min.js') }}"></script>
    <script src="{{ asset('js/linkify-jquery.min.js') }}"></script>
    <script>
        jQuery("#message-area").emojioneArea();
    </script>
@endpush

