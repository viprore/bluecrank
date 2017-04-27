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
    <form action="{{ route('users.store') }}" method="POST" role="form" class="form__auth">
        {!! csrf_field() !!}

        @if ($return = request('return'))
            <input type="hidden" name="return" value="{{ $return }}">
        @endif

        <div class="page-header">
            <h4>회원가입</h4>
            <p class="text-muted">
                소셜 계정으로도 가입이 가능합니다
            </p>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['naver']) }}">
                        <img src="{{ url('icons/' .  'btn_naver.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_naver_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_naver.png') }}'">
                    </a>
                </div>
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['kakao']) }}">
                        <img src="{{ url('icons/' .  'btn_kakao.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_kakao_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_kakao.png') }}'">
                    </a>
                </div>
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['facebook']) }}">
                        <img src="{{ url('icons/' .  'btn_facebook.png') }}"
                             onmouseover="this.src='{{ url('icons/' .  'btn_facebook_ov.png') }}'"
                             onmouseout="this.src='{{ url('icons/' .  'btn_facebook.png') }}'">
                    </a>
                </div>
                <div class="col-md-3 col-xs-3">
                    <a class="img-social" href="{{ route('social.login', ['google']) }}">
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

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" name="name" class="form-control" placeholder="이름" value="{{ old('name') }}" autofocus/>
            {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}"/>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" name="password" class="form-control" placeholder="비밀번호"/>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인" />
            {!! $errors->first('password_confirmation', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group" style="margin-top: 2em;">
            <button class="btn btn-primary btn-lg btn-block" type="submit">
                가입하기
            </button>
        </div>
    </form>
@stop