@extends('layouts.layouts')

@section('main')

<h1>{{{ $page['title'] }}}</h1>

<span>{{ link_to_route('wiki.page.edit', '수정하기', ['title' => $page['title']]) }}</span>

<p>
    {{ $revision['text'] }}
</p>

@stop
