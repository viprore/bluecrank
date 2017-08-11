<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * SessionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * 로그인 폼을 보여준다
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('sessions.create');
    }

    /**
     * 로그인 요청을 처리한다
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 네이티브 계정 로그인 실패시 소셜 여부 확인
        if (! auth()->attempt($request->only('email', 'password'), $request->has('remember'))) {
            $user = \App\User::socialUser($request->input('email'))->first();
            if ($user) {
                if (!$user->activated) {
                    return $this->respondError('가입시 기입한 이메일을 확인해주세요.');
                }else{
                    return $this->respondError('이전에 소셜 계정으로 접속하셨습니다.');
                }
            }
            return $this->respondError('이메일 또는 비밀번호가 맞지 않습니다.');
        }

        // 인증 여부 확인
        if (! auth()->user()->activated) {
            auth()->logout();

            return $this->respondError('등록하신 이메일 계정에서 가입을 확인해주세요');
        }

        return $this->respondCreated(auth()->user()->name . "님 환영합니다.");
    }

    /**
     * 유저 로그아웃
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        auth()->logout();
        flash('잘가열!');

        return redirect(route('products.index'));
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

        return back()->withInput();
    }

    /**
     * Make a success response.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function respondCreated($message)
    {
        flash($message);

        // 리턴 정보 유무에 따른 리다이렉트 처리
        return ($return = request('return'))
            ? redirect(urldecode($return))
            : redirect()->intended('products');
    }
}
