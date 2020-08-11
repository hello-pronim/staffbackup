@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')

    <div class="wt-haslayout wt-dbsectionspace">
        <div class="wt-haslayout wt-reset-pass" id="pass-reset">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    @if (Session::has('error'))
                        <div class="flash_msg float-right">
                            <flash_messages :message_class="'danger'" :time='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                        </div>
                    @endif
                    <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                        @if (file_exists(resource_path('views/extend/back-end/settings/tabs.blade.php')))
                            @include('extend.back-end.settings.tabs')
                        @else
                            @include('back-end.settings.tabs')
                        @endif
                        <div class="wt-tabscontent tab-content">
                            @include('back-end.settings.reset-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
