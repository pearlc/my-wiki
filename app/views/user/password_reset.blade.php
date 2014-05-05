@extends('layouts.layouts')

@section('main')

{{ $errors->first('password'); }}

<p>
    {{ $user->email }}님의 새로운 비밀번호를 등록해 주세요.
</p>

{{ Form::open(array('route' => 'user_password_reset_post', 'class' => 'form-horizontal')) }}

{{ Form::hidden('user_id', $user->id) }}
{{ Form::hidden('reset_code', $reset_code) }}
<div class="form-group">
    {{ Form::label('inputpassword', '비밀번호', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::password('password', array('class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => '비밀번호')); }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('inputPasswordConfirm', '비밀번호 확인', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'inputPasswordConfirm', 'placeholder' => '비밀번호 확인')); }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('비밀번호 등록', array('class' => 'btn btn-default')); }}
    </div>
</div>
</form>

{{ Form::close(); }}

@stop