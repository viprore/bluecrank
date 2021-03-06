@extends('layouts.app')

@section('style')
    <style>
        .no-padding {
            padding : 0;
        }
        .side-padding {
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
@endsection

@section('content')
    @php $viewName = 'admin.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('admin.index') }}">
                관리자
            </a>
            <small>
                Total Page
            </small>
        </h4>
    </div>

    <div class="row">
        <div class="col-md-3 sidebar__article">
            @include('admin.partial.menu', [$statusList])
        </div>

        <div class="col-md-9 list__article">
            <div class="row side-padding">
                <div class="col-md-6 no-padding">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>입금전</th>
                            <th>입금완료</th>
                            <th>배송준비</th>
                            <th>배송중</th>
                            <th>배송완료</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $orders->where('status', '입금전')->count() }}</td>
                            <td>{{ $orders->where('status', '입금완료')->count() }}</td>
                            <td>{{ $orders->where('status', '배송준비')->count() }}</td>
                            <td>{{ $orders->where('status', '배송중')->count() }}</td>
                            <td>{{ $orders->where('status', '배송완료')->count() }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 no-padding">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>취소</th>
                            <th>교환</th>
                            <th>반품</th>
                            <th>상품문의</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $orders->where('status', '취소')->count() }}</td>
                            <td>{{ $orders->where('status', '교환')->count() }}</td>
                            <td>{{ $orders->where('status', '반품')->count() }}</td>
                            <td>{{ App\Comment::all()->where('commentable_type', 'App\Product')->count() }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>날짜</th>
                        <th>주문</th>
                        <th>결제</th>
                        <th>환불(취소/반품)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dates as $date)
                        <tr>
                            <td>{{ $date->created_date }}</td>
                            <td>{{ '\\'. number_format($summary->where('created_date', $date->created_date)->where('status', '입금전')->sum('total')) . " (" .
                                    $summary->where('created_date', $date->created_date)->where('status', '입금전')->sum('order_count') . ")"}}</td>
                            <td>{{ '\\'. number_format($summary->where('created_date', $date->created_date)->whereIn('status', ['입금완료', '배송준비', '배송중', '배송완료'])->sum('total'))." (".
                             $summary->where('created_date', $date->created_date)->whereIn('status', ['입금완료', '배송준비', '배송중', '배송완료'])->sum('order_count').")"}}</td>
                            <td>{{ '\\'. number_format($summary->where('created_date', $date->created_date)->whereIn('status', ['취소', '교환', '반품'])->sum('total'))." (".
                             $summary->where('created_date', $date->created_date)->whereIn('status', ['취소', '교환', '반품'])->sum('order_count').")"}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop