@extends('layouts.layouts')

@section('main')

<h1>비밀번호 분실</h1>

{{ $errors->first('message'); }}

<p>
    회원 가입시 사용한 이메일을 입력하세요
</p>

{{ Form::open(array('route' => 'user_forgot_password_post', 'class' => 'form-inline')); }}

<div class="form-group">
    {{ Form::label('inputEmail', '이메일 주소', array('class' => 'sr-only')); }}
    {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Enter email')); }}
    {{ Form::submit('초기화 메일 받기', array('class' => 'btn btn-default')); }}
</div>

{{ Form::close(); }}

@stop