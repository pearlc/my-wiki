@extends('layouts.layouts')

@section('main')

<h1>'{{{ $page['title'] }}}' 편집 이력</h1>

@if (count($revisions))
    <ul>
        @foreach ($revisions as $revision)
        <li>
            {{ link_to_route('wiki.page.old', $revision->created_at, $revision->id) }}
            {{ $revision->ip }}
            @if ($revision->user !== null)
                {{ $revision->user->nick_name }}
            @endif
        </li>
        @endforeach
    </ul>
@else
<p>
    이력 없음
</p>
@endif

@stop
