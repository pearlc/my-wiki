@extends('layouts.layouts')

@section('main')

<ul>
    <li>{{ link_to_action('MarkupTestController@index', '마크업 메인'); }}</li>
    <li>{{ link_to_action('MarkupTestController@editor', '에디터 테스트'); }}</li>
    <li>{{ link_to_route('markuptest_email', '테스트 메일 발송'); }}</li>
    <li>---</li>
    <li>{{ link_to_action('UserController@register', '회원가입', ['param' => 5], ['attribute' => 7]); }} </li>
    <li>{{ link_to_action('UserController@activate', '메일 인증', ['333'], ['aaa']); }} </li>
    <li>{{ link_to_action('UserController@login', '로그인'); }} </li>
    <li>{{ link_to_action('UserController@profile', '프로필'); }} </li>
    <li>{{ link_to_action('UserController@logout', '로그아웃'); }} </li>
    <li>{{ link_to_action('UserController@delete', '회원탈퇴'); }} </li>
    <li>{{ link_to_action('UserController@forgotPassword', '비밀번호 분실'); }} </li>
    <li>---</li>
    <li>{{ link_to_route('wiki', '위키'); }}</li>
</ul>

@stop