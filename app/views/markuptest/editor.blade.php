@extends('layouts.layouts')

@section('scripts')
{{ HTML::script('/assets/ckeditor/ckeditor.js'); }}
@stop

@section('main')

<p>editor 테스트</p>
<p>
<form>
    <textarea name="editor1" id="editor1" rows="10" cols="80">
        This is my textarea to be replaced with CKEditor.
    </textarea>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'editor1' );
    </script>
</form>
</p>

@stop