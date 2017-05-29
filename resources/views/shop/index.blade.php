@extends('layouts.app')

@section('style')
    <style>
        .img-w100{
            width: 100%;
        }
    </style>
@endsection

@section('content')
    @php $viewName = 'shop.index'; @endphp

    <div class="page-header">
        <h4>
            <a href="{{ route('shops.index') }}">
                오프라인 매장
            </a>
            <small>
                / 포럼 검색
            </small>
        </h4>
    </div>

    <div class="row container__article">
        {{--<div class="col-md-3 sidebar__article">
            <aside>
                @include('articles.partial.search')

                @include('tags.partial.index')
            </aside>
        </div>--}}

        <div class="col-md-12 list__article">
            <div class="row">
                <img class="img-w100" src="{{ url('icons/shops.png') }}">
            </div>
            {{--<div class="row" align="center">
                <table width="800" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="374" valign="top">
                            <center>
                                <p><img src="{{ url('icons/' .  'dongmun_list_map.jpg') }}" alt="" width="629"
                                        height="526"
                                        border="0" usemap="#map"/>
                                    <map name="map" id="map">
                                        <area shape="rect" coords="280,177,319,197" href="#seoul"/>
                                        <area shape="rect" coords="223,179,275,203" href="#incheon"/>
                                        <area shape="rect" coords="439,-200,535,-155" href="mm_sl.php"/>
                                        <area shape="rect" coords="281,198,322,220" href="#gyeonggi"/>
                                        <area shape="rect" coords="309,219,364,237" href="#chungbuk"/>
                                        <area shape="rect" coords="254,226,310,250" href="#chungnam"/>
                                        <area shape="rect" coords="292,252,338,272" href="#daejeon"/>
                                        <area shape="rect" coords="345,242,401,270" href="#gyeongbuk"/>
                                        <area shape="rect" coords="357,281,396,300" href="#daegu"/>
                                        <area shape="rect" coords="380,302,436,324" href="#ulsan"/>
                                        <area shape="rect" coords="379,324,434,352" href="#busan"/>
                                        <area shape="rect" coords="325,309,381,336" href="#gyeongnam"/>
                                        <area shape="rect" coords="275,283,331,310" href="#jeonbuk"/>
                                        <area shape="rect" coords="267,320,315,341" href="#gwangju"/>
                                        <area shape="rect" coords="258,341,322,373" href="#jeonnam"/>
                                        <area shape="rect" coords="243,402,297,427" href="#jeju"/>
                                        <area shape="rect" coords="327,145,388,211" href="#gangwon"/>
                                    </map>
                                </p>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td height="1204" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>서울특별시</b><a name="seoul" id="seoul"></a></td>
                                </tr>
                                --}}{{--@php
                                    $seoul = $shops->where('state', '서울시');
                                @endphp
                                @forelse($seoul as $shop)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'odd' : 'even' }}">
                                        <td height="24">행복한자전거 본점</td>
                                        <td width="50">1기</td>
                                        <td width="60">이병익</td>
                                        <td width="350">서울시 서초구 반포동 62-1</td>
                                    </tr>
                                @empty
                                    <tr class="odd">
                                        <td colspan="4">No data</td>
                                    </tr>
                                @endforelse--}}{{--
                                <tr class="odd">
                                    <td height="24">행복한자전거 본점</td>
                                    <td width="50">1기</td>
                                    <td width="60">이병익</td>
                                    <td width="350">서울시 서초구 반포동 62-1</td>
                                </tr>
                                <tr class="even">
                                    <td>행복한자전거 본점</td>
                                    <td>1기</td>
                                    <td>이병선</td>
                                    <td>서울시 서초구 반포동 62-1</td>
                                </tr>
                                <tr class="odd">
                                    <td>바이크미캐닉스쿨_BMS</td>
                                    <td>4기</td>
                                    <td>손준익</td>
                                    <td>서울시 강서구 둔촌동 496-1</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">바이크 보드</td>
                                    <td>5기</td>
                                    <td>김영도</td>
                                    <td>서울시 마포구 서교동 드림빌딩 3층</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">삼천리 중계점</td>
                                    <td>5기</td>
                                    <td>이건화</td>
                                    <td>서울시 노원구 중계동 아파트 상가 104호</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">구일MTB</td>
                                    <td>6기</td>
                                    <td>서종수</td>
                                    <td>서울시 구로구 구로2동 88-1</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">바이크루즈 발산점</td>
                                    <td>6기</td>
                                    <td>안경호</td>
                                    <td>서울시 강서구 방화 1동 608-122호</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">삼천리 번동점</td>
                                    <td>6기</td>
                                    <td>장성수</td>
                                    <td>서울시 광진구 화양동 16-57</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">강변 MTB</td>
                                    <td>8기</td>
                                    <td>황덕하</td>
                                    <td>서울시 마포구 공덕동 280번지</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">삼천리 화곡점</td>
                                    <td>10기</td>
                                    <td>김태진</td>
                                    <td>서울시 강서구 화곡8동 409-91</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">자전거관광</td>
                                    <td>11기</td>
                                    <td>이경훈</td>
                                    <td>서울시 마포구 신수동 경남 아너스빌 103</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">정달자 광명점</td>
                                    <td>11기</td>
                                    <td>김명호</td>
                                    <td>서울시 용산구 후암동 44-1 현대&nbsp; 102호</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">하남 B&amp;C</td>
                                    <td>13기</td>
                                    <td>이광은</td>
                                    <td>서울시 구로구 개봉2동&nbsp; 2708호</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">삼천리 신림점</td>
                                    <td>14기</td>
                                    <td>김동호</td>
                                    <td>서울시 동작구 신대방 1동 712번지&nbsp;</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">ES바이크</td>
                                    <td>14기</td>
                                    <td>김택훈</td>
                                    <td>서울시 강서구 화곡2동 454-20</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">행복한자전거 노들점</td>
                                    <td>16기</td>
                                    <td>김상영</td>
                                    <td>서울시 노원구 중계동 건영 306-104</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">삼천리 중계점</td>
                                    <td>16기</td>
                                    <td>김종원</td>
                                    <td>서울시 노원구 중계동 아파트 상가 104호</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">자전거그리고 본점</td>
                                    <td>15기</td>
                                    <td>홍정표</td>
                                    <td>서울시 마포구 연남동 245-9</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">ES바이크</td>
                                    <td>18기</td>
                                    <td>정원교</td>
                                    <td>서울시 은평구 연신내동 35-9</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">필굿바이크</td>
                                    <td>19기</td>
                                    <td>김홍근</td>
                                    <td>서울시 노원구 수락산동 589-38</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">바이크리밍</td>
                                    <td>19기</td>
                                    <td>박상민</td>
                                    <td>서울시 양천구 목2동 539-4 목동 1602</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">벤조바이크</td>
                                    <td>19기</td>
                                    <td>박정민</td>
                                    <td>서울시 중랑구 면목2동 190-18&nbsp;</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">리버바이크</td>
                                    <td>19기</td>
                                    <td>이성희</td>
                                    <td>서울시 마포구 염리동 521번지</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">송파바이크</td>
                                    <td>19기</td>
                                    <td>임형묵</td>
                                    <td>서울시 송파구 문정동 72-3</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">자전거그리고 홍은점</td>
                                    <td>20기</td>
                                    <td>고순희</td>
                                    <td>서울시 서대문구 홍은동 내천길 25번지</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">바이크카페</td>
                                    <td>20기</td>
                                    <td>김기범</td>
                                    <td>서울시 관악구 서원동 10-479 102호</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">바이크카페</td>
                                    <td>20기</td>
                                    <td>조용찬</td>
                                    <td>서울시 금천구 가산동 146-83</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">한양MTB 강북점</td>
                                    <td>21기</td>
                                    <td>김동현</td>
                                    <td>서울시 성북구 석관동 332-242</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">ES바이크</td>
                                    <td>21기</td>
                                    <td>김재석</td>
                                    <td>서울시 은평구 연신내동 35-9</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">삼천리 상도점</td>
                                    <td>21기</td>
                                    <td>송광식</td>
                                    <td>서울시 동작구 상도1동 444&nbsp;</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">바이클</td>
                                    <td>22기</td>
                                    <td>서현정</td>
                                    <td>서울시 용산구 용산동2가 22-21</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">바이크 아카데미</td>
                                    <td>22기</td>
                                    <td>이한샘</td>
                                    <td>서울시 영등포구 양평동4가 29-1</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">아조키 코리아</td>
                                    <td>23기</td>
                                    <td>임현호</td>
                                    <td>서울시 영등포구 신길3동 342-261</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">삼천리 강동점</td>
                                    <td>24기</td>
                                    <td>김창회</td>
                                    <td>서울시 강동구 성내2동 226-33</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">행복한자전거 목동점</td>
                                    <td>24기</td>
                                    <td>김태홍</td>
                                    <td>서울시 양천구 신정6동 321-6호 센트럴 프라자 1층</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">행복한자전거 목동점</td>
                                    <td>24기</td>
                                    <td>정광택</td>
                                    <td>서울시 양천구 신정6동 321-6호 센트럴 프라자 1층</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">ES바이크</td>
                                    <td>25기</td>
                                    <td>박찬용</td>
                                    <td>서울시 은평구 연신내동 35-9</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">후지바이크 본사</td>
                                    <td>25기</td>
                                    <td>이수현</td>
                                    <td>서울시 영등포구 여의도동 4837</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">자전거그리고 본점</td>
                                    <td>26기</td>
                                    <td>고민철</td>
                                    <td>서울시 송파구 잠실 799-80</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">행복한자전거 묵동점</td>
                                    <td>26기</td>
                                    <td>한봉희</td>
                                    <td>서울시 노원구 묵1동 404-20</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">행복한자전거 묵동점</td>
                                    <td>26기</td>
                                    <td>황인철</td>
                                    <td>서울시 노원구 묵1동 404-20</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">ES바이크</td>
                                    <td>27기&nbsp;</td>
                                    <td>권오선</td>
                                    <td>서울시 은평구 연신내동 35-9</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">당산 MTB</td>
                                    <td>28기</td>
                                    <td>김병용</td>
                                    <td>서울시 영등포 당산동 231-6</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">한라사이클</td>
                                    <td>28기</td>
                                    <td>김세원</td>
                                    <td>서울시 강남구 압구정동 로얄빌딩 103호</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">종로구청 도로교통과</td>
                                    <td>30기</td>
                                    <td>김영웅&nbsp;&nbsp;</td>
                                    <td>서울시 종로구 수송동 146-2번지 (삼봉길 50)</td>
                                </tr>
                                <tr class="even">
                                    <td>바이클로(반포점)</td>
                                    <td>31기</td>
                                    <td>최동균&nbsp;</td>
                                    <td>서울시 서초구 잠원동 76-5번지</td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">송파MTB</td>
                                    <td>31기&nbsp;</td>
                                    <td>지종구</td>
                                    <td>서울시 송파구 문정동 72-3</td>
                                </tr>
                                <tr class="even">
                                    <td>바이키 (뚝섬점)</td>
                                    <td>32기</td>
                                    <td>안교순&nbsp;</td>
                                    <td>서울시 성동구 성수동 1가 2동 668-63 1층</td>
                                </tr>
                                <tr class="odd">
                                    <td>Guru</td>
                                    <td>32기</td>
                                    <td>정인영&nbsp;</td>
                                    <td>서울시 강서구 방화1동 293-1</td>
                                </tr>
                                <tr class="even">
                                    <td>벨로라인</td>
                                    <td>35기</td>
                                    <td>서민수</td>
                                    <td><p>서울시 광진구 자양동 156-4</p></td>
                                </tr>
                                <tr class="odd">
                                    <td>동대문삼천리</td>
                                    <td>38기</td>
                                    <td>김원태</td>
                                    <td>서울시 동대문구 휘경동 59-7</td>
                                </tr>
                                <tr class="even">
                                    <td>목동산타자 바이크</td>
                                    <td>40기</td>
                                    <td>도정훈</td>
                                    <td>서울시 강서구 화곡4동 782-5 부경빌딩 1층</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="374" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>경기도</b><a name="gyeonggi" id="gyeonggi"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">일산 OMK</td>
                                    <td width="50">2기</td>
                                    <td width="60">이재원</td>
                                    <td width="350">경기도 고양시 일산서구 라페스타 거리 35번지</td>
                                </tr>
                                <tr class="even">
                                    <td>하남MTB</td>
                                    <td>6기</td>
                                    <td>김태영</td>
                                    <td>경기도 하남시 무원구 219-1</td>
                                </tr>
                                <tr class="odd">
                                    <td>몬테규코리아</td>
                                    <td>8기</td>
                                    <td>서필수</td>
                                    <td>경기도 광주시 오포읍 문형리 486-8</td>
                                </tr>
                                <tr class="even">
                                    <td>이젠MTB</td>
                                    <td>11기</td>
                                    <td>이진순</td>
                                    <td>경기도 광주시 오포읍 양벌리 373-9호</td>
                                </tr>
                                <tr class="odd">
                                    <td>바이크툴즈</td>
                                    <td>13기</td>
                                    <td>이세민</td>
                                    <td>경기도 과천시 문원동 115-388 201호</td>
                                </tr>
                                <tr class="even">
                                    <td>B 바이크</td>
                                    <td>14기</td>
                                    <td>송번웅</td>
                                    <td>경기도 평택시 도일동 784-38</td>
                                </tr>
                                <tr class="odd">
                                    <td>자전거여행&nbsp;</td>
                                    <td>16기</td>
                                    <td>송윤희</td>
                                    <td>경기도 구리시 안창동&nbsp; 115-508</td>
                                </tr>
                                <tr class="even">
                                    <td>자전거사랑</td>
                                    <td>15기</td>
                                    <td>주원욱</td>
                                    <td>경기도 남양주시 화도읍 창현리&nbsp; 101-801</td>
                                </tr>
                                <tr class="odd">
                                    <td>주엽 MTB</td>
                                    <td>17기</td>
                                    <td>이월순</td>
                                    <td>경기도 고양 일산 서구&nbsp; 대화동 2571</td>
                                </tr>
                                <tr class="even">
                                    <td>바이크키네틱</td>
                                    <td>17기</td>
                                    <td>성용헌</td>
                                    <td>경기도 수원시 권선구 금곡동 530번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>행복한자전거 여주점</td>
                                    <td>17기</td>
                                    <td>장정식</td>
                                    <td>경기도 여주군 능현리 439번지&nbsp;</td>
                                </tr>
                                <tr class="even">
                                    <td>자전거사랑 부천점</td>
                                    <td>18기</td>
                                    <td>이광우</td>
                                    <td>경기도 부천시 천리 139-17&nbsp;</td>
                                </tr>
                                <tr class="odd">
                                    <td>시흥 MTB</td>
                                    <td>18기</td>
                                    <td>이보우</td>
                                    <td>경기도 시흥 정왕4동&nbsp; 1303-702</td>
                                </tr>
                                <tr class="even">
                                    <td>코렉스 의정부점</td>
                                    <td>18기</td>
                                    <td>이유하</td>
                                    <td>경기도 의정부시 258-3&nbsp;</td>
                                </tr>
                                <tr class="odd">
                                    <td>풍경속의 자전거</td>
                                    <td>18기</td>
                                    <td>전재홍</td>
                                    <td>경기도 일산서구 올리브상가 1층</td>
                                </tr>
                                <tr class="even">
                                    <td>수원 자전거나라</td>
                                    <td>19기</td>
                                    <td>장보현</td>
                                    <td>경기도 수원시 영통구 영통동 804호</td>
                                </tr>
                                <tr class="odd">
                                    <td>당산 MTB</td>
                                    <td>20기</td>
                                    <td>허성용</td>
                                    <td>경기도 광명 소화 2동 305호</td>
                                </tr>
                                <tr class="even">
                                    <td>산들로MTB</td>
                                    <td>21기</td>
                                    <td>김정훈</td>
                                    <td>경기도 김포시 장기동&nbsp; 105동 408호</td>
                                </tr>
                                <tr class="odd">
                                    <td>구리MTB</td>
                                    <td>21기</td>
                                    <td>임영찬</td>
                                    <td>경기도 구리시 수택동 626-43호</td>
                                </tr>
                                <tr class="even">
                                    <td>삼천리 능곡점</td>
                                    <td>21기</td>
                                    <td>최방원</td>
                                    <td>경기도 고양시 덕양구 능곡 298번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>행복한자전거 부천점</td>
                                    <td>22기</td>
                                    <td>배성권</td>
                                    <td>경기도 부천시 중구 대림상가 107호</td>
                                </tr>
                                <tr class="even">
                                    <td>남양주바이크</td>
                                    <td>24기</td>
                                    <td>신철구</td>
                                    <td>경기도 남양주시 호평동 1707-1303</td>
                                </tr>
                                <tr class="odd">
                                    <td>군포 즐거운자전거</td>
                                    <td>25기</td>
                                    <td>고성우</td>
                                    <td>경기도 군포시 당동880</td>
                                </tr>
                                <tr class="even">
                                    <td>알톤자전거 광명점</td>
                                    <td>26기</td>
                                    <td>김정오</td>
                                    <td>경기도 광명시 하안4동 30번지 1012-308</td>
                                </tr>
                                <tr class="odd">
                                    <td>석수 바이크</td>
                                    <td>26기</td>
                                    <td>이천우</td>
                                    <td>경기도 안양시 만안구 석수2동 7-1402</td>
                                </tr>
                                <tr class="even">
                                    <td>세파스</td>
                                    <td>26기</td>
                                    <td>김형득</td>
                                    <td>경기도 성남시 중원구 상대원동 190-1</td>
                                </tr>
                                <tr class="odd">
                                    <td>벨로시티</td>
                                    <td>28기</td>
                                    <td>문형곤</td>
                                    <td>경기도 성남시 분당구 야탑동 342-1 리더스빌딩1층</td>
                                </tr>
                                <tr class="even">
                                    <td>벨로크래프트 일산점</td>
                                    <td>29기</td>
                                    <td>사공승무</td>
                                    <td>경기도 일산서구 라페스타 123번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>3SamHan BIKE</td>
                                    <td>33기</td>
                                    <td>홍진원</td>
                                    <td>경기도 성남시 분당구 판교동 613-3 도토빌딩 102호</td>
                                </tr>
                                <tr class="even">
                                    <td>3SamHan BIKE</td>
                                    <td>33기</td>
                                    <td>권영균</td>
                                    <td>경기도 성남시 분당구 판교동 613-3 도토빌딩 102호</td>
                                </tr>
                                <tr class="odd">
                                    <td>벨로라인</td>
                                    <td>34기</td>
                                    <td>손시락</td>
                                    <td>경기도 이천시 부발읍 이마리 736번지</td>
                                </tr>
                                <tr class="even">
                                    <td>용인삼천리</td>
                                    <td>39기</td>
                                    <td>지석문</td>
                                    <td>경기도 용인시 처인구 김량장동 218-4</td>
                                </tr>
                                <tr class="odd">
                                    <td>벨로씨엘</td>
                                    <td>39기</td>
                                    <td>이환걸</td>
                                    <td>경기도 성남시 분당구 서현동 253-4 경림빌딩 1,2층</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="256" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>인천광역시</b><a name="incheon" id="incheon"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">삼천리 불로점</td>
                                    <td width="50">12기</td>
                                    <td width="60">김대진</td>
                                    <td width="350">인천광역시 서구 불로동 315-1 1층</td>
                                </tr>
                                <tr class="even">
                                    <td>행복한자전거 논현점</td>
                                    <td>13기</td>
                                    <td>이동하</td>
                                    <td>인천광역시 남동구 논현동&nbsp; 1106/2002</td>
                                </tr>
                                <tr class="odd">
                                    <td>행복한자전거 송도점</td>
                                    <td>13기</td>
                                    <td>필영덕</td>
                                    <td>인천광역시 중구 선진동 58-7</td>
                                </tr>
                                <tr class="even">
                                    <td>B 바이크</td>
                                    <td>17기</td>
                                    <td>이수범</td>
                                    <td>인천광역시 계양구 효성동 301-1</td>
                                </tr>
                                <tr class="odd">
                                    <td>논현바이크</td>
                                    <td>22기</td>
                                    <td>김영삼</td>
                                    <td>인천광역시 남동구 논현동 신영지웰 102호</td>
                                </tr>
                                <tr class="even">
                                    <td>갈산 MTB</td>
                                    <td>22기</td>
                                    <td>임영상</td>
                                    <td>인천광역시 부평구 갈산2동 팬더상가 109호</td>
                                </tr>
                                <tr class="odd">
                                    <td>자전거풍경</td>
                                    <td>22기</td>
                                    <td>정일남</td>
                                    <td>인천광역시 남구 숭의 4동 1-6</td>
                                </tr>
                                <tr class="even">
                                    <td>송파MTB</td>
                                    <td>23기</td>
                                    <td>김대겸</td>
                                    <td width="350">인천광역시 부평구 부개동 1102호</td>
                                </tr>
                                <tr class="odd">
                                    <td>논현MTB</td>
                                    <td>24기</td>
                                    <td>황재호</td>
                                    <td>인천광역시 연수구 논현동&nbsp; 106동 1702호</td>
                                </tr>
                                <tr class="even">
                                    <td>삼천리자전거 청학점</td>
                                    <td>27기</td>
                                    <td>한재웅</td>
                                    <td>인천광역시 연수구 청학동 454 용담마을아파트 상가 107호</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="39" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>강원도</b><a name="gangwon" id="gangwon"></a></td>
                                </tr>
                                <tr class="odd">
                                    <td>프로바이크 삼천리</td>
                                    <td>26기</td>
                                    <td>김현승</td>
                                    <td>강원도 동해시 천곡동 1079-3번지 유한빌딩1층</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">프로바이크 삼천리</td>
                                    <td width="50">39기</td>
                                    <td width="60">이영철</td>
                                    <td width="350">강원도 동해시 천곡동 1079-3번지 유한빌딩1층</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="39" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>충청북도</b><a name="chungbuk" id="chungbuk"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">바이크라이프</td>
                                    <td width="50">16기</td>
                                    <td width="60">조상록</td>
                                    <td width="350">충청북도 청주시 내덕 1동 344-78번지</td>
                                </tr>
                                <tr class="even">
                                    <td>삼천리 충주점</td>
                                    <td>20기</td>
                                    <td>이명기</td>
                                    <td>충청북도 충주시 교현동 1358번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>BA스포츠</td>
                                    <td>38기</td>
                                    <td>정인호</td>
                                    <td>충청북도 청주시 홍덕구 산남동</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="26" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>충청남도</b><a name="chungnam" id="chungnam"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">바퀴벌레 천안점</td>
                                    <td width="50">17기</td>
                                    <td width="60">차승훈</td>
                                    <td width="350">충청남도 천안시 백석동 210</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="66" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>전라남도</b><a name="jeonnam" id="jeonnam"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">모든열쇠와 자전거</td>
                                    <td width="50">33기</td>
                                    <td width="60">김동하</td>
                                    <td width="350">전라남도 목포시 용해동 718-9번지 모든열쇠</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="168" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>대구광역시</b><a name="daegu" id="daegu"></a></td>
                                </tr>
                                <tr class="odd">
                                    <td height="22">타임바이크</td>
                                    <td>8기</td>
                                    <td>김희성</td>
                                    <td>대구광역시 북구 동천동 929-9번지</td>
                                </tr>
                                <tr class="even">
                                    <td width="145">행복한자전거 대구점</td>
                                    <td width="50">25기</td>
                                    <td width="60">안경훈</td>
                                    <td width="350">대구광역시 수성구 별내동 287-8번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>벨로바이크</td>
                                    <td>26기</td>
                                    <td>임영진</td>
                                    <td>대구광역시 수성구 신내동 222동 107호</td>
                                </tr>
                                <tr class="even">
                                    <td>휠러 대구점</td>
                                    <td>33기</td>
                                    <td>성광현</td>
                                    <td>대구광역시 달서구 이곡동 862번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>휠러 대구점</td>
                                    <td>40기</td>
                                    <td>서현민</td>
                                    <td>대구광역시 달서구 이곡동 862번지</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="35" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>경상북도</b><a name="gyeongbuk" id="gyeongbuk"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">삼천리 점촌점</td>
                                    <td width="50">26기</td>
                                    <td width="60">안승식</td>
                                    <td width="350">경상북도 문경시 점촌동 268-41</td>
                                </tr>
                                <tr class="even">
                                    <td>K1 엠티비</td>
                                    <td>37기</td>
                                    <td>류동열</td>
                                    <td>경상북도 경산시 중방동 844-2</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="62" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>경상남도</b><a name="gyeongnam" id="gyeongnam"></a>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">창원바이크</td>
                                    <td width="50">6기</td>
                                    <td width="60">류성현</td>
                                    <td width="350">경상남도 창원시 봉곡동 129-18 번지</td>
                                </tr>
                                <tr class="even">
                                    <td>바이시클엔조이</td>
                                    <td>9기</td>
                                    <td>이상철</td>
                                    <td>경상남도 창원시 용호동 63&nbsp;</td>
                                </tr>
                                <tr class="odd">
                                    <td>행복한자전거 진주점</td>
                                    <td>12기</td>
                                    <td>양영훈</td>
                                    <td>경상남도 진주시 평거동 755-13</td>
                                </tr>
                                <tr class="even">
                                    <td>행복한자전거 창원점</td>
                                    <td>23기</td>
                                    <td>박효조</td>
                                    <td>경상남도 창원시 북면 마산리 221 번지</td>
                                </tr>
                                <tr class="odd">
                                    <td>양산MTB</td>
                                    <td>26기</td>
                                    <td>최현수</td>
                                    <td>경상남도 양산시 중부동 1503호</td>
                                </tr>
                                <tr class="even">
                                    <td height="23">오디바이크(김해직영)</td>
                                    <td>32기</td>
                                    <td>임대호</td>
                                    <td>경상남도 김해시 서상동 102 94-51번지</td>
                                </tr>
                                <tr class="odd">
                                    <td height="23">바이크시티</td>
                                    <td>34기</td>
                                    <td>김성엽</td>
                                    <td>경상남도 창원시 성산구 상남동 60-4</td>
                                </tr>
                                <tr class="even">
                                    <td height="23">바이크시티</td>
                                    <td>35기</td>
                                    <td>박기근</td>
                                    <td>경상남도 창원시 성산구 상남동 60-4</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="51" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>부산광역시</b><a name="busan" id="busan"></a></td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">드림바이크</td>
                                    <td width="50">23기</td>
                                    <td width="60">김범승</td>
                                    <td width="350">부산광역시 남구 용호동 176-30&nbsp;</td>
                                </tr>
                                <tr class="even">
                                    <td height="23">타고마스포트</td>
                                    <td>38기</td>
                                    <td>이창선</td>
                                    <td>부산시 동래구 온천동 180-33번지</td>
                                </tr>
                                <tr class="odd">
                                    <td height="23">부산시설관리공단</td>
                                    <td>36기</td>
                                    <td>남성원</td>
                                    <td>부산시 연제구 중앙대로 1001번지</td>
                                </tr>
                                <tr class="even">
                                    <td height="23">부산시설관리공단</td>
                                    <td>36기</td>
                                    <td>이규열</td>
                                    <td>부산시 연제구 중앙대로 1001번지</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="168" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>울산광역시</b><a name="ulsan" id="ulsan2"></a></td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">자전거 풍경</td>
                                    <td width="50">18기</td>
                                    <td width="60">최흥권</td>
                                    <td width="350">울산광역시 남구 신정1동 547-9</td>
                                </tr>
                                <tr class="even">
                                    <td>BIKE HOUSE</td>
                                    <td>21기</td>
                                    <td>박선화</td>
                                    <td>울산광역시 남구 삼산동 1546-11</td>
                                </tr>
                                <tr class="odd">
                                    <td>그린 바이크</td>
                                    <td>25기</td>
                                    <td>김원태</td>
                                    <td>울산광역시 북구 진장동 284-6</td>
                                </tr>
                                <tr class="even">
                                    <td>BIKE HOUSE</td>
                                    <td>30기</td>
                                    <td>이승욱</td>
                                    <td>울산광역시 남구 삼산동 1546-11</td>
                                </tr>
                                <tr class="odd">
                                    <td>정으로 달리는 자전거</td>
                                    <td>39기</td>
                                    <td>이병훈</td>
                                    <td>울산광역시 남구 신정2동 1266-10</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                        <td height="49" valign="top">
                            <table class="table01" width="90%" border="0" align="center" cellpadding="5"
                                   cellspacing="0">
                                <tr>
                                    <td colspan="4" bgcolor="#CCCCCC"><b>제주특별자치도</b><a name="jeju" id="jeju2"></a></td>
                                </tr>
                                <tr class="odd">
                                    <td width="145">정품코렉스자전거</td>
                                    <td width="50">39기</td>
                                    <td width="60">이경희</td>
                                    <td width="350">제주시 노형동 1157-1&nbsp;</td>
                                </tr>
                            </table>
                            <p>&nbsp;</p></td>
                    </tr>
                </table>

            </div>--}}
        </div>
    </div>
@stop

@section('style')
    @parent
    <style>
        .table01 td {
            padding: 5px;
        }

        .odd > td {
            background: #EFEFEF;
        }

        .even {
            background: #FFFFFF;
        }
    </style>
@stop

