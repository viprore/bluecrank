@extends('layouts.app')

@section('style')
    <style>
        .user__table > tbody > tr > td {
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
                    <th>작성시간</th>
                    <th>작성자</th>
                    <th>내용</th>
                    <th>답변수</th>
                    <th>해당게시물로</th>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->created_at->diffForHumans() }}</td>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ mb_substr($comment->content, 0, 30, 'utf-8') }}</td>
                            <td>{{ $comment->replies->count() }}</td>
                            <td>
                                @if(str_contains($comment->commentable_type, 'Article'))
                                    <a class="btn btn-warning"
                                       title="{{ $comment->commentable->title }}"
                                       href="{{ route('articles.show', $comment->commentable_id) }}">Go</a>
                                @elseif(str_contains($comment->commentable_type, 'Product'))
                                    @if($comment->commentable->is_old)
                                        <a class="btn btn-danger"
                                           title="{{ $comment->commentable->ad_title }}"
                                           href="{{ route('olds.show', $comment->commentable_id) }}">Go</a>
                                    @else
                                        <a class="btn btn-primary"
                                           title="{{ $comment->commentable->ad_title }}"
                                           href="{{ route('products.show', $comment->commentable_id) }}">Go</a>
                                    @endif
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
