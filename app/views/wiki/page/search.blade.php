@extends('layouts.layouts')

@section('main')

<h1>검색 결과</h1>

@if (!is_null($page))
    <p>
        '{{{ $keyword }}}' 문서가 존재합니다 -> {{ link_to_route('wiki.page.show', '바로가기', ['title' => $page['title']]) }}
    </p>
@else
    <p>
        '{{{ $keyword }}}' 라는 이름의 문서가 존재하지 않습니다 -> {{ link_to_route('wiki.page.create', '생성하기', ['title' => $keyword]) }}
    </p>
@endif


<p>
    검색 결과
</p>

@stop
