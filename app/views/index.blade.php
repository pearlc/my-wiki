@extends('layouts.layouts')

@section('main')

<ul>
    <li>{{ link_to_action('MarkupTestController@index', '마크업 메인'); }}</li>
    <li>{{ link_to_action('UserController@register', '회원가입', ['param' => 5], ['attribute' => 7]); }} </li>
    <li>{{ link_to_action('UserController@activate', '메일 인증', ['333'], ['aaa']); }} </li>
    <li>{{ link_to_action('UserController@login', '로그인'); }} </li>
    <li>{{ link_to_action('UserController@profile', '프로필'); }} </li>
    <li>{{ link_to_action('UserController@logout', '로그아웃'); }} </li>
    <li>{{ link_to_action('UserController@delete', '회원탈퇴'); }} </li>
</ul>

@stop