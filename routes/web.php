<?php

/*
|--------------------------------------------------------------------------
| 웹 라우트 모음(Web Routes)
|--------------------------------------------------------------------------
|
| 이곳은 당신의 어플리케이션의 웹 라우트들을 등록하는 곳입니다.
| "web" 미들웨어 그룹을 포함하는 이 라우트들은
| RouteServiceProvider에서 불러옵니다.
| 작업하시죠.
|
*/




/**
 * 작업중
 * TODO : 인증/점검, 중고 마르쉐, 배송지(ShipController)
 */





/**
 * 1. BC몰 관련
 */

// 리소스, 태그, 카테고리
Route::resource('products', 'ProductController');
Route::get('tags/{slug}/products', [
    'as' => 'tags.products.index',
    'uses' => 'ProductController@index',
]);
Route::get('categories/{category}/products', [
    'as' => 'categories.products.index',
    'uses' => 'ProductController@index',
]);
// 옵션
Route::get('products/{product}/options', [
    'as' => 'products.edit.option',
    'uses' => 'ProductController@optionEdit'
]);
Route::resource('options', 'OptionController', ['only' => ['update', 'destroy']]);
Route::resource('products.options', 'OptionController', ['only' => 'store']);


/**
 * 2. 중고 관련
 *    참고 : 1. 과 기능은 동일하나 url로 구분을 주는 것을 목적
 */

// 리소스, 태그, 카테고리
Route::get('olds', [
    'as' => 'olds.index',
    'uses' => 'ProductController@index',
]);
Route::get('olds/create', [
    'as' => 'olds.create',
    'uses' => 'ProductController@create',
]);
Route::get('olds/{product}/edit', [
    'as' => 'olds.edit',
    'uses' => 'ProductController@edit',
]);
Route::post('olds', [
    'as' => 'olds.store',
    'uses' => 'ProductController@store',
]);
Route::get('olds/{product}', [
    'as' => 'olds.show',
    'uses' => 'ProductController@show',
]);

//Route::resource('olds', 'OldController', ['only' => ['index', 'create', 'store', 'show']]);
Route::get('tags/{slug}/olds', [
    'as' => 'tags.olds.index',
    'uses' => 'ProductController@index',
]);
Route::get('categories/{category}/olds', [
    'as' => 'categories.olds.index',
    'uses' => 'ProductController@index',
]);

// 옵션
Route::get('olds/{product}/options', [
    'as' => 'olds.edit.option',
    'uses' => 'ProductController@optionEdit'
]);
Route::resource('olds.options', 'OptionController', ['only' => 'store']);


/**
 * 3. 구매 관련
 *    참고 : BC몰, 중고 공통
 */
Route::resource('carts', 'ItemController', ['except' => ['show', 'create', 'edit']]);
Route::resource('orders', 'OrderController', ['except' => ['destroy']]);
// 배송지
Route::resource('ships', 'ShipController');
Route::get('json/ships/{ship}', [
    'as' => 'users.ship',
    'uses' => 'ShipController@getJsonShip'
]);

Route::get('shops/{state}', [
    'as' => 'shops.state',
    'uses' => 'OrderController@getCity'
]);
Route::get('auth/carts', [
    'as' => 'users.cart',
    'uses' => 'HomeController@mycart'
]);
Route::post('wants/{product}', [
    'as' => 'users.want',
    'uses' => 'HomeController@wantProduct'
]);
Route::post('article/wants/{product}', [
    'as' => 'users.want.article',
    'uses' => 'HomeController@wantArticle'
]);
Route::post('item/wants/{item}', [
    'as' => 'users.want',
    'uses' => 'HomeController@wantByItem'
]);
Route::post('direct/option', [
    'as' => 'users.direct.option',
    'uses' => 'ItemController@direct'
]);
Route::post('direct/item', [
    'as' => 'users.direct.item',
    'uses' => 'ItemController@directByItem'
]);
Route::post('items/destroy/list', [
    'as' => 'users.destroy.item.list',
    'uses' => 'ItemController@destroyAll'
]);

// 리뷰
Route::resource('reviews', 'ReviewController');
Route::get('reviews/create/{id}', [
    'as' => 'reviews.create',
    'uses' => 'ReviewController@create'
]);


/**
 * 4. 커뮤니티
 */
Route::resource('articles', 'ArticleController');
Route::get('tags/{slug}/articles', [
    'as' => 'tags.articles.index',
    'uses' => 'ArticleController@index',
]);


/**
 * 5. 오프라인 매장, 인증/점검
 */

Route::get('shops', [
    'as' => 'shops.index',
    'uses' => 'WelcomeController@shop'
]);
Route::resource('certifications', 'CertificationController');

/**
 * 6. 공통
 */

// 첨부
Route::resource('attachments', 'AttachmentController', ['only' => ['store', 'destroy', 'update']]);
Route::get('attachments/{file}', 'AttachmentController@show');

// 코멘트(댓글)
Route::resource('comments', 'CommentController', ['only' => ['update', 'destroy']]);
Route::resource('articles.comments', 'CommentController', ['only' => 'store']);
Route::resource('markets.comments', 'CommentController', ['only' => 'store']);
Route::resource('products.comments', 'CommentController', ['only' => 'store']);

// 투표
Route::post('comments/{comment}/votes', [
    'as' => 'comments.vote',
    'uses' => 'CommentController@vote',
]);


/**
 * 7. 유저 관련
 */

// 0-1. 등록
Route::get('auth/register', [
    'as' => 'users.create',
    'uses' => 'UserController@create'
]);
Route::post('auth/register', [
    'as' => 'users.store',
    'uses' => 'UserController@store',
]);
Route::get('auth/confirm/{code}', [
    'as' => 'users.confirm',
    'uses' => 'UserController@confirm'
])->where('code', '[\pL-\pN]{60}');

// 로그인/아웃
Route::get('auth/login', [
    'as' => 'sessions.create',
    'uses' => 'SessionController@create'
]);
Route::post('auth/login', [
    'as' => 'sessions.store',
    'uses' => 'SessionController@store'
]);
Route::get('auth/logout', [
    'as' => 'sessions.destroy',
    'uses' => 'SessionController@destroy'
]);

// 소셜 서비스
Route::get('social/{provider}', [
    'as' => 'social.login',
    'uses' => 'SocialController@execute',
]);
Route::post('social/regist', [
    'as' => 'social.regist',
    'uses' => 'SocialController@createUser',
]);

// 비밀번호 초기화
Route::get('auth/remind', [
    'as' => 'remind.create',
    'uses' => 'PasswordController@getRemind'
]);
Route::post('auth/remind', [
    'as' => 'remind.store',
    'uses' => 'PasswordController@postRemind'
]);
Route::get('auth/reset/{token}', [
    'as' => 'reset.create',
    'uses' => 'PasswordController@getReset'
]);
Route::post('auth/reset', [
    'as' => 'reset.store',
    'uses' => 'PasswordController@postReset'
]);


// 관심목록(좋아요)
Route::get('wants', [
    'as' => 'wants.index',
    'uses' => 'HomeController@wantIndex'
]);
// 주문내역
Route::get('auth/orders', [
    'as' => 'users.order',
    'uses' => 'HomeController@order'
]);
// 작성글 관리(작업중) ******************************
Route::post('auth/manage', [
    'as' => 'users.manage',
    'uses' => 'UserController@manage'
]);
// 내 프로필(작업중) ********************************
Route::post('auth/profile', [
    'as' => 'users.profile',
    'uses' => 'UserController@profile'
]);



/**
 * 8. 관리자 페이지 관련
 */
Route::resource('admin', 'AdminController', ['except' => ['show', 'create', 'edit']]);
Route::get('admin/status/{slug}', [
    'as' => 'admin.orders.status',
    'uses' => 'AdminController@status'
]);

Route::post('admin/orders/{order}/status/{slug}', [
    'as' => 'admin.orders.update',
    'uses' => 'AdminController@statusPost'
]);
// 주문서 상태 변경(일부 유저, 일부 관리자)
Route::post('status/{status}/orders/{order}', [
    'as' => 'orders.status',
    'uses' => 'OrderController@updateStatus'
]);
// 주문 취소
Route::get('cancel/orders', [
    'as' => 'orders.index.cancel',
    'uses' => 'OrderController@index'
]);
// 모바일용 주문 완료
Route::get('payments/complete', [
    'as' => 'payment.check',
    'uses' => 'OrderController@checkPayment'
]);



/**
 * 0. 기타
 */
// Root 페이지, 요청에 의해 products.index로 Redirect
Route::get('/', [
    'as' => 'root',
    'uses' => 'WelcomeController@index',
]);

// PhpInfo Page
Route::get('phpinfo', [
    'as' => 'php.info',
    'uses' => 'WelcomeController@phpinfo'
]);





















/**
 * 유저 중고장터
 * 현재 보류됨
 */
/*Route::resource('markets', 'MarketController');
Route::get('tags/{slug}/markets', [
    'as' => 'tags.markets.index',
    'uses' => 'MarketController@index',
]);
Route::get('categories/{category}/markets', [
    'as' => 'categories.markets.index',
    'uses' => 'MarketController@index',
]);*/

/**
 * 로그인시 사용했던 페이지이나
 * 현재 미사용중(6월 말 까지 경과 보고 관련 데이터 제거)
 */
/*Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@index',
]);*/

/* 다국어 지원용이었으나 폐기됨 */
/*Route::get('locale', [
    'as' => 'locale',
    'uses' => 'WelcomeController@locale',
]);*/