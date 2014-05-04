@extends('layouts.layouts')

@section('main')

<h1>Activated!!</h1>


<!-- TODO : '로그인' 버튼으로 바꾸는게 좋을듯, 메일 인증 실패시(이미 인증된 메일)에도 해당 버튼 이용 가능하도록 만들것 -->
<p>
    @if ($activationPassed === true)
        메일 인증이 성공하였습니다.

        {{ link_to_route('user_login', '로그인'); }}
    @else
        메일 인증이 실패하였습니다.
        {{ $failedMessage; }}
    @endif
</p>


@stop