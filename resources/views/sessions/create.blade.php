@extends('layouts.app')

@section('style')
    <style>
        .img-social {
            padding: 1px;
            line-height: 1.6;
            background-color: #f5f8fa;
            border: 0 solid #ddd;
            border-radius: 12px;
        }
        .img-social img {
            width:48px;
        }
    </style>
@stop

@section('content')

    <form action="{{ route('sessions.store') }}" method="POST" role="form" class="form__auth">
        {!! csrf_field() !!}

        @if ($return = request('return'))
            <input type="hidden" name="return" value="{{ $return }}">
        @endif

        <div class="page-header">
            <h4>
                로그인
            </h4>
            <p class="text-muted">
                소셜 계정 및 BlueCrank 계정으로 로그인할 수 있습니다!
            </p>
        </div>


        <div class="form-group">
            <div class="row">
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['provider' => 'naver', 'return' => $return]) }}">
                        <img src="{{ url('icons/' .  'btn_naver.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_naver_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_naver.png') }}'">
                    </a>
                </div>
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['provider' => 'kakao', 'return' => $return]) }}">
                        <img src="{{ url('icons/' .  'btn_kakao.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_kakao_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_kakao.png') }}'">
                    </a>
                </div>
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['provider' => 'facebook', 'return' => $return]) }}">
                        <img src="{{ url('icons/' .  'btn_facebook.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_facebook_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_facebook.png') }}'">
                    </a>
                </div>
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['provider' => 'google', 'return' => $return]) }}">
                        <img src="{{ url('icons/' .  'btn_google.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_google_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_google.png') }}'">
                    </a>
                </div>
            </div>

        </div>

        <div class="login-or">
            <hr class="hr-or">
            <span class="span-or">or</span>
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="email" name="email" class="form-control" placeholder="이메일"
                   value="{{ old('email') }}"
                   autofocus/>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" name="password" class="form-control" placeholder="비밀번호">
            {!! $errors->first('password', '<span class="form-error">:message</span>')!!}
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="{{ old('remember', 1) }}" checked>
                    로그인 기억하기
                    <span class="text-danger">
                        (공용 컴퓨터에서는 사용하지 마세요!)
                    </span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block" type="submit">
                로그인
            </button>
        </div>

        <div>
            <p class="text-center">
                회원이 아니라면? <a href="{{ route('users.create') }}">가입하세요</a>
            </p>
            <p class="text-center">
                <a href="{{ route('remind.create') }}">비밀번호를 잊으셨나요?</a>
            </p>
            <p class="text-center">
                <small class="help-block">
                    단 카카오톡 로그인을 이용하실 경우 최초 1회 이메일 인증을 요구합니다.
                </small>
            </p>
        </div>
    </form>
@stop