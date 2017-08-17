@extends('layouts.app')

@section('style')
    <style>
        .user__table > tbody > tr > td{
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    @php $viewName = 'admin.edit.main'; @endphp


    <div class="page-header">
        <h4>
            <a href="{{ route('admin.index') }}">
                회원관리
            </a>
            <small>
                등급 및 기타 수정
            </small>
        </h4>
    </div>

    <div class="row">
        <div class="col-md-2 sidebar__article">
            @include('admin.partial.menu', $statusList)
        </div>

        <div class="col-md-10 list__article">
            <div class="row">
                <table class="table table-striped user__table">
                    <thead>
                    <th>번호</th>
                    <th>등급</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>인증</th>
                    <th>소셜</th>
                    <th>가입일</th>
                    <th>최근 로그인</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <form action="{{ route('admin.update.users', $user->id) }}" method="post">
                            {!! csrf_field() !!}
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <select class="form-control" name="grade">
                                        <option value="1" {{ $user->grade == 1 ? 'selected' : '' }}>일반</option>
                                        <option value="5" {{ $user->grade == 5 ? 'selected' : '' }}>교육생</option>
                                        <option value="10" {{ $user->grade == 10 ? 'selected' : '' }}>관리자</option>
                                    </select>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <select class="form-control" name="activated">
                                        <option value="1" {{ $user->activated ? 'selected' : '' }}>Y</option>
                                        <option value="0" {{ $user->activated == 0 ? 'selected' : '' }}>N</option>
                                    </select>
                                </td>
                                <td>
                                    {{ $user->facebook_id ? '페이스북' : '' }}
                                    {{ $user->naver_id ? '네이버' : '' }}
                                    {{ $user->google_id ? '구글' : '' }}
                                    {{ $user->kakao_id ? '카카오' : '' }}
                                    {{ $user->password ? '네이티브' : '' }}
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>{{ $user->last_login ? $user->last_login->diffForHumans() : $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <button type="submit" class="btn btn-success">변경</button>
                                </td>
                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
