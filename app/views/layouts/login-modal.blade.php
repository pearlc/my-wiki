<div id="login-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="login-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            {{ Form::open(array('action' => 'UserController@loginPost', 'class' => 'form-horizontal')) }}

                {{ Form::hidden('returnUrl', Request::url()); }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">로그인</h4>
                </div>

                <div class="modal-body">
                    {{ $errors->first('email'); }}
                    {{ $errors->first('password'); }}

                    <div class="form-group">
                        {{ Form::label('inputEmail', '이메일', array('class' => 'col-sm-2 control-label')); }}
                        <div class="col-sm-10">
                            {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'example@example.com')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('inputpassword', '비밀번호', array('class' => 'col-sm-2 control-label')); }}
                        <div class="col-sm-10">
                            {{ Form::password('password', array('class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => '비밀번호')); }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                {{ Form::labelWithCheckbox('자동 로그인', null, null, null, [], ['id' => 'remember']); }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::submit('로그인', array('class' => 'btn btn-primary')); }}
                </div>
            {{ Form::close(); }}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
