<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">메인</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li id="navbar-item-wiki" {{ ($currentNavBarItem === 'wiki')?'class="active"':'' }}>{{ link_to_route('wiki', '위키'); }}</li>
                <li id="navbar-item-link" {{ ($currentNavBarItem === 'link')?'class="active"':'' }}>{{ link_to_route('index', 'Link'); }}</li>
                <li id="navbar-item-another-link"><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            {{ Form::open(['route' => ['wiki.page.search'], 'class' => 'navbar-form navbar-left', 'role' => 'search', 'method' => 'get']); }}
                <div class="form-group">
                    {{ Form::text('keyword', null, ['class' => 'form-control', 'placeholder' => '검색어를 입력하세요']); }}
                </div>
                {{ Form::button('검색', ['type' => 'submit', 'class' => 'btn btn-default']); }}
            {{ Form::close(); }}
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">문의하기</a></li>
                @if (is_null($user))
<!--                    <li>{{ link_to_route('user_login', '로그인') }}</li>-->
                    <li data-toggle="modal" data-target="#login-modal"><a href="#">로그인</a></li>
                    <li>{{ link_to_route('user_register', '회원가입') }}</li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $user->email }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to_route('user_profile', '내정보') }}</li>
                            <li>{{ link_to_route('user_logout', '로그아웃') }}</li>
                            <li class="divider"></li>
                            <li>{{ link_to_route('user_delete', '회원탈퇴') }}</li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
