@extends('layouts.layouts')

@section('main')

<h1>Login</h1>

<!-- TODO : 이메일 틀렸을때와 비번 틀렸을때의 오류메시지를 다르게 처리할것인가? -->

{{ $errors->first('email'); }}
{{ $errors->first('password'); }}

{{ Form::open(array('action' => 'UserController@loginPost', 'class' => 'form-horizontal')) }}
<div class="form-group">
    {{ Form::label('inputEmail', '이메일', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'example@example.com')); }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('inputpassword', '비밀번호', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::password('password', array('class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => '비밀번호')); }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
            {{ Form::label('remember', '자동 로그인'); }}
            {{ Form::checkbox('remember', null, null, array('id' => 'remember')); }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('로그인', array('class' => 'btn btn-default')); }}
    </div>
</div>
</form>

{{ Form::close(); }}

@stop