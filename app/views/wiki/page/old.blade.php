@extends('layouts.layouts')

@section('main')

<h1>{{{ $page['title'] }}}</h1>

<p>
    <span>{{ $revision['created_at'] }} 버전 </span>
</p>

<p>
    {{ $revision['text'] }}
</p>

@stop
