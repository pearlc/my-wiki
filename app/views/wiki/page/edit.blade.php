@extends('layouts.layouts')

@section('scripts')
{{ HTML::script('/assets/ckeditor/ckeditor.js') }}
@stop

@section('main')

<div>{{{ '\'' . $page['title'] . '\'' }}} 문서를 수정합니다</div>

{{ $errors->first('title'); }}
{{ $errors->first('text'); }}

<p>

    {{ Form::open(['route' => ['wiki.page.update', $page['id']], 'method' => 'put']) }}

    {{ Form::hidden('title', $page['title']) }}
    {{ Form::hidden('page_id', $page['id']) }}

<div class="form-group">
    <label for="text" />
    {{ Form::textarea('text', $revision['text'], ['id' => 'text', 'rows' => '10', 'cols' => '80']); }}
</div>

<div class="form-group">
    <label for="submit" />
    {{ Form::submit('수정', ['id' => 'submit', 'class' => 'btn btn-default', 'id' => 'submit']); }}
</div>
<script>
    CKEDITOR.replace( 'text' );
</script>

{{ Form::close() }}

</p>



@stop
