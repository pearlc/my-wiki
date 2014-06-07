@extends('layouts.layouts')

@section('main')

<h1>최근 편집 문서</h1>

@if (count($pageChanges))
<ul>
    @foreach ($pageChanges as $pageChange)
    <li>
        {{ link_to_route('wiki.page.show', $pageChange->page->title, $pageChange->page->title) }}
        {{ $pageChange->created_at }}
        {{ $pageChange->ip }}
        ({{ sprintf('%+d', $pageChange->new_bytes - $pageChange->old_bytes) }})
    </li>
    @endforeach
</ul>
@else
<p>
    이력 없음
</p>
@endif

{{ $pageChanges->links() }}

@stop
