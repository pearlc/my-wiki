@extends('layouts.layouts')

@section('main')

{{ $errors->first('nick_name'); }}

{{ Form::open(array('route' => 'user_profile_edit_post', 'class' => 'form-horizontal')) }}
<div class="form-group">
    {{ Form::label('inputNickName', '닉네임', array('class' => 'col-sm-2 control-label')); }}
    <div class="col-sm-10">
        {{ Form::text('nick_name', $user->nick_name, array('class' => 'form-control', 'id' => 'inputNickName', 'placeholder' => '닉네임')); }}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('변경', array('class' => 'btn btn-default')); }}
    </div>
</div>
</form>

{{ Form::close(); }}

@stop