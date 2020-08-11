@php $user_id = !empty(Auth::user()) ? Auth::user()->id : '';  @endphp

<div class="wt-passwordholder" id="wt-password">
    <div class="wt-changepassword">
        <div class="wt-tabscontenttitle">
            <h2>{{{ trans('lang.change_pass') }}}</h2>
        </div>
        {!! Form::open(['url' => url('profile/settings/request-password'), 'class' =>'wt-formtheme wt-userform'])!!}
        <fieldset>
            <div class="form-group form-group-half">
                {!! Form::password('old_password', ['class' => 'form-control'.($errors->has('old_password') ? ' is-invalid' : ''),
                    'placeholder' => trans('lang.ph_oldpass')]) !!}
                @if ($errors->has('old_password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('old_password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group form-group-half">
                {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => trans('lang.ph_newpass')]) !!}
            </div>
            <div class="form-group">
                {!! Form::password('confirm_new_password', ['class' => 'form-control','placeholder' => trans('lang.ph_confirm_new_pass')]) !!}
            </div>
            {!! Form::hidden('user_id', $user_id) !!}
            <div class="form-group form-group-half wt-btnarea">
                {!! Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']) !!}
            </div>
        </fieldset>
        {!! Form::close() !!}
    </div>
</div>
