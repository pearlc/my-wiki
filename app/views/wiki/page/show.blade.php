@extends('layouts.layouts')

@section('main')

<h1>{{{ $page['title'] }}}</h1>

<p>
    <span>{{ '최종 수정 : ' . $page['updated_at']->diffForHumans(\Carbon\Carbon::now()) }} </span>
    /
    <span>{{ link_to_route('wiki.page.edit', '수정하기', ['title' => $page['title']]) }}</span>
    /
    <span>{{ link_to_route('wiki.page.history', '편집 이력', ['title' => $page['title']]) }}</span>
</p>

<hr>
<p>
    {{ $text }}
</p>
<hr>

@stop
