@extends('layouts.layouts')

@section('main')

<h1>검색 결과</h1>

<p>
    문서가 있으면 : 바로가기 링크
</p>

<p>
    문서가 없으면 : 문서를 새로 만드시겠습니까? : {{ link_to_route('wiki.page.create', ' --> 생성하기', ['title' => $keyword]) }}
</p>

<p>
    검색어와 연관된 문서들
</p>

@stop