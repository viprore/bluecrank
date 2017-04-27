@extends('layouts.app')

@section('content')
  <form action="{{ route('social.regist') }}" method="POST" role="form" class="form__auth">
    {!! csrf_field() !!}

    <input type="hidden" name="id" value="{{ $user->id }}">
    <input type="hidden" name="name" value="{{ $user->name ? : $user->nickname }}">
    <input type="hidden" name="provider" value="{{ $provider }}">

    <div class="page-header">
      <h4>추가 정보 입력</h4>
      <p class="text-muted">
        {{ $user->name ? : $user->nickname }}님의 이메일 주소가 필요합니다.
        이메일로 가입하신 후, 메일박스를 확인하세요.
      </p>
    </div>

    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}" autofocus>
      {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
    </div>

    <button class="btn btn-primary btn-lg btn-block" type="submit">
      회원가입
    </button>
  </form>
@stop