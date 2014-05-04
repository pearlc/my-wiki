@extends('layouts.layouts')

@section('main')

<h1>회원 탈퇴</h1>

<p>정말 탈퇴합니까?</p>

{{ link_to_route('user_delete_confirm', '탈퇴하기', array(), array('class' => 'btn btn-primary btn-danger', 'role' => 'button')); }}

@stop