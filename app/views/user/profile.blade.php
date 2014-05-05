@extends('layouts.layouts')

@section('main')

{{ link_to_route('user_profile_edit', '정보 수정', null, array('class'=> 'btn btn-default')) }}

{{ link_to_route('user_password_edit', '비밀번호 변경', null, array('class'=> 'btn btn-default')) }}

<table class="table">
    <tr>
        <td>이메일</td>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <th>닉네임</th>
        <td>{{ $user->nick_name }}</td>
    </tr>
</table>
@stop