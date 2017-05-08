<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'root',
    'uses' => 'WelcomeController@index',
]);

Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@index',
]);

/* 언어 선택 */
/*Route::get('locale', [
    'as' => 'locale',
    'uses' => 'WelcomeController@locale',
]);*/

/* 아티클 */
Route::resource('articles', 'ArticleController');
Route::get('tags/{slug}/articles', [
    'as' => 'tags.articles.index',
    'uses' => 'ArticleController@index',
]);

/* 마켓 */
Route::resource('markets', 'MarketController');
Route::get('tags/{slug}/markets', [
    'as' => 'tags.markets.index',
    'uses' => 'MarketController@index',
]);
Route::get('categories/{category}/markets', [
    'as' => 'categories.markets.index',
    'uses' => 'MarketController@index',
]);

/* BC몰 */
Route::resource('products', 'ProductController');
Route::get('tags/{slug}/products', [
    'as' => 'tags.products.index',
    'uses' => 'ProductController@index',
]);
Route::get('categories/{category}/products', [
    'as' => 'categories.products.index',
    'uses' => 'ProductController@index',
]);
Route::post('wants/{product}', [
    'as' => 'users.want',
    'uses' => 'HomeController@want'
]);

/* 첨부 파일 */
Route::resource('attachments', 'AttachmentController', ['only' => ['store', 'destroy']]);
Route::get('attachments/{file}', 'AttachmentController@show');

/* 옵션 */
Route::get('products/{product}/options', [
        'as' => 'products.edit.option',
        'uses' => 'ProductController@optionEdit'
]);
Route::resource('options', 'OptionController', ['only' => ['update', 'destroy']]);
Route::resource('products.options', 'OptionController', ['only' => 'store']);

/* 코멘트(댓글) */
Route::resource('comments', 'CommentController', ['only' => ['update', 'destroy']]);
Route::resource('articles.comments', 'CommentController', ['only' => 'store']);
Route::resource('markets.comments', 'CommentController', ['only' => 'store']);
Route::resource('products.comments', 'CommentController', ['only' => 'store']);

/* 투표 */
Route::post('comments/{comment}/votes', [
    'as' => 'comments.vote',
    'uses' => 'CommentController@vote',
]);

/* 사용자 가입 */
Route::get('auth/register', [
    'as' => 'users.create',
    'uses' => 'UserController@create'
]);
Route::post('auth/register', [
    'as' => 'users.store',
    'uses' => 'UsersController@store',
]);
Route::get('auth/confirm/{code}', [
    'as' => 'users.confirm',
    'uses' => 'UserController@confirm'
])->where('code', '[\pL-\pN]{60}');
Route::post('auth/manage', [
    'as' => 'users.manage',
    'uses' => 'UserController@manage'
]);
Route::post('auth/profile', [
    'as' => 'users.profile',
    'uses' => 'UserController@profile'
]);

/* 사용자 인증 */
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

/* 소셜 로그인 */
Route::get('social/{provider}', [
    'as' => 'social.login',
    'uses' => 'SocialController@execute',
]);
Route::post('social/regist', [
    'as' => 'social.regist',
    'uses' => 'SocialController@createUser',
]);

/* 비밀번호 초기화 */
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

/* 샵 */
Route::get('shops', [
    'as' => 'shops.index',
    'uses' => 'WelcomeController@shop'
]);