@extends('layouts.layouts')

@section('main')

<h1>회원 탈퇴 완료</h1>

<p>탈퇴 완료되었습니다.</p>

{{ link_to_route('index', '메인으로 가기', array(), array('class' => 'btn btn-default', 'role' => 'button')); }}

@stop