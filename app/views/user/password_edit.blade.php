@extends('layouts.layouts')

@section('main')

{{ $errors->first('message'); }}
{{ $errors->first('password'); }}
{{ $errors->first('password_confirmation'); }}

{{ Form::open(array('route' => 'user_password_edit_post', 'class' => 'form-horizontal')) }}
<div class="form-group">
    {{ Form::label('oldInputpassword', '현재 비밀번호', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::password('old_password', array('class' => 'form-control', 'id' => 'oldInputPassword', 'placeholder' => '현재 비밀번호')); }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('inputpassword', '새로운 비밀번호', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::password('password', array('class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => '새로운 비밀번호')); }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('inputPasswordConfirm', '새로운 비밀번호 확인', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::password('password_confirmation', array('class' => 'form-control', 'id' => 'inputPasswordConfirm', 'placeholder' => '새로운 비밀번호 확인')); }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('변경', array('class' => 'btn btn-default')); }}
    </div>
</div>
</form>

{{ Form::close(); }}

@stop