<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 회원가입 폼
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * User 저장
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 이메일로 소셜 계정이 이미 존재하는지 여부 확인
        if ($socialUser = \App\User::socialUser($request->get('email'))->first()) {
            return $this->updateSocialAccount($request, $socialUser);
        }

        return $this->createNativeAccount($request);
    }

    /**
     * 이메일 인증 처리
     *
     * @param string $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirm($code)
    {
        $user = \App\User::whereConfirmCode($code)->first();

        if (! $user) {
            return $this->respondError('URL이 정확하지 않습니다.');
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);
        flash($user->name . '님 환영합니다. 가입 확인되었습니다.');

        return redirect(route('products.index'));
    }

    /**
     * 소셜계정에 패스워드를 업데이트하여
     * 네이티브로 로그인이 가능하게 한다.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function updateSocialAccount(Request $request, \App\User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);

        auth()->login($user);

        return $this->respondCreated($user->name . '님, 환영합니다.');
    }

    /**
     * 네이티브 회원 생성
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function createNativeAccount(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $confirmCode = str_random(60);

        $user = \App\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);

        event(new \App\Events\UserCreated($user));

        return $this->respondCreated(
            '가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해 주세요.'
        );
    }

    /* Helpers */

    /**
     * Make an error response.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function respondError($message)
    {
        flash()->error($message);

        return redirect()->back();
    }

    /**
     * 계정 생성 성공시 로그인창으로 이동
     *
     * @param $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function respondCreated($message)
    {
        flash($message);

        return redirect(route('sessions.create'));
    }

    /**
     * TODO : 작성글 관리
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $user = \Auth::user();

        return view('products.show', compact('product', 'comments'));
    }


}
