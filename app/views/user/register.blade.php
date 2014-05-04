@extends('layouts.layouts')

@section('main')

<!-- TODO : 닉네임(optional) 하게 받는것 처리. -->

{{ $errors->first('email'); }}
{{ $errors->first('nick_name'); }}
{{ $errors->first('password'); }}

{{ Form::open(array('action' => 'UserController@registerPost', 'class' => 'form-horizontal')) }}
    <div class="form-group">
        {{ Form::label('inputEmail', '이메일', array('class' => 'col-sm-2 control-label')); }}
        <div class="col-sm-10">
            {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'example@example.com')); }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('inputNickName', '닉네임', array('class' => 'col-sm-2 control-label')); }}
        <div class="col-sm-10">
            {{ Form::text('nick_name', null, array('class' => 'form-control', 'id' => 'inputNickName', 'placeholder' => '닉네임')); }}
        </div>
    </div>
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
            {{ Form::submit('회원가입', array('class' => 'btn btn-default')); }}
        </div>
    </div>
</form>

{{ Form::close(); }}

@stop