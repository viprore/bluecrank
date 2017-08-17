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
                상품관리
            </a>
            <small>
                전체 상품을 요약해서 보여줍니다.
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
                    <th>중고</th>
                    <th>제목</th>
                    <th>상태</th>
                    <th>조작</th>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->is_old ? 'Y' : 'N' }}</td>
                            <td>{{ $product->ad_title }}</td>
                            <td>{{ $product->ad_status == '준비중' ? '교육생(준비중)' : $product->ad_status }}</td>
                            <td>
                                <a class="btn btn-default"
                                   title="상세보기"
                                   href="{{ $product->is_old ? route('olds.show', $product->id) : route('products.show', $product->id) }}"><i
                                            class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-default"
                                   title="상품수정"
                                   href="{{ $product->is_old ? route('olds.edit', $product->id) : route('products.edit', $product->id) }}"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn btn-default"
                                   title="옵션수정"
                                   href="{{ $product->is_old ? route('olds.edit.option', $product->id) : route('products.edit.option', $product->id) }}"><i
                                            class="fa fa-tasks" aria-hidden="true"></i></a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
