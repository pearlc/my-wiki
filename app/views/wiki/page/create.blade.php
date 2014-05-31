@extends('layouts.layouts')

@section('scripts')
{{ HTML::script('/assets/ckeditor/ckeditor.js') }}
@stop

@section('main')

<div>{{{ '\'' . $title . '\'' }}} 문서를 생성합니다</div>

{{ $errors->first('title'); }}
{{ $errors->first('text'); }}

<p>

{{ Form::open(['route' => 'wiki.page.store']) }}

    {{ Form::hidden('title', $title) }}
    <div class="form-group">
        <label for="text" />
        {{ Form::textarea('text', '', ['id' => 'text', 'rows' => '10', 'cols' => '80']); }}
    </div>

    <div class="form-group">
        <label for="submit" />
        {{ Form::submit('생성', ['id' => 'submit', 'class' => 'btn btn-default', 'id' => 'submit']); }}
    </div>
    <script>
        CKEDITOR.replace( 'text' );
    </script>

{{ Form::close() }}

</p>



@stop
