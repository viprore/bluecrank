<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * SocialController constructor.
     */
    function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle social login process.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $provider
     * @return \App\Http\Controllers\Response
     */
    public function execute(Request $request, $provider)
    {

        if (!$request->has('code')) {
            return $this->redirectToProvider($provider);
        }
        return $this->handleProviderCallback($provider);
    }

    /**
     * Redirect the user to the Social Login Provider's authentication page.
     *
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToProvider($provider)
    {

        return \Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the Social Login Provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function handleProviderCallback($provider)
    {
        $user = \Socialite::driver($provider)->user();

        $return = request('return');
        if ($return == null) {
            $previous_url = session('_previous')['url'];
            $return = $this->getUrlParameter($previous_url, 'return');
        }

        if ($user->getEmail() === null) {
            $native_user = User::where($provider . '_id', '=', $user->id)->first();

            if ($native_user == null) {
                return view('socials.email', compact('user', 'provider', 'return'));
            } else {
                if (! $native_user->activated) {
                    flash()->error(
                        '가입 이메일을 확인해 주세요.'
                    );

                    return back()->withInput();
                }
            }
        } else {
            $native_user = User::where($provider . '_id', '=', $user->id)->first();

            if ($native_user === null) {
                // no social_id
                $native_user = (User::whereEmail($user->getEmail())->first());

                if ($native_user === null) {
                    // no social, no email
                    $native_user = User::create([
                        'name' => $user->getName() ?: ($user->getNickname() ?:'unknown'),
                        'email' => $user->getEmail(),
                        $provider . '_id' => $user->getId(),
                        'activated' => 1,
                    ]);
                } else {
                    //no social, have email
                    $native_user->update([
                        $provider . '_id' => $user->getId()
                    ]);
                }
            }
        }




        auth()->login($native_user);

        flash(auth()->user()->name . '님, 환영합니다.');



        if (!empty($return) && str_contains(urldecode($return), env('APP_URL'))) {
            return redirect(urldecode($return));
        } else {
            return redirect(route('products.index'));
        }


    }

    public function createUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $socialId = $request->input('id');
        $provider = $request->input('provider'). '_id';

        $return = request('return');
        if ($return == null) {
            $previous_url = session('_previous')['url'];
            $return = $this->getUrlParameter($previous_url, 'return');
        }

        /*$this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            $provider . '_id' => 'required|unique:users',
        ]);*/

        // socialId 탐색
        $confirmCode = str_random(60);
        $native_user = User::where($provider, '=', $socialId)->first();

        if ($native_user === null) {
            // 소셜 아이디 최초 등록
            $native_user = User::whereEmail($email)->first();

            if ($native_user === null) {
                // 이메일도 등록한 적 없음


                $native_user = \App\User::create([
                    'name' => $name,
                    'email' => $email,
                    'confirm_code' => $confirmCode,
                    $provider => $socialId,
                ]);
            } else {
                // 기존에 등록된 이메일이 존재함

                if ($native_user->$provider === null) {
                    // 해당 아이디에 소셜 아이디가 미기재
                    $native_user->$provider = $socialId;
                    $native_user->activated = false;
                    $native_user->confirm_code = $confirmCode;
                    $native_user->save();
                    event(new \App\Events\UserCreated($native_user));
                    flash('가입 이메일을 확인해 주세요.');
                    return redirect(route('sessions.create'));
                } else {
                    // 해당 아이디에 소셜 아이디가 이미 기입되어 있음
                    flash()->error('해당 이메일을 다른 유저가 사용중으로 나옵니다.<br />다른 이메일을 기입하시거나 고객센터에 문의하세요.');
                    return redirect(route('sessions.create'));
                }
            }
        }else{
            // 기존 등록된 소셜 아이디가 있을 경우
            auth()->login($native_user);
            flash(auth()->user()->name . '님, 환영합니다.');

            if (!empty($return) && str_contains(urldecode($return), env('APP_URL'))) {
                return redirect(urldecode($return));
            } else {
                return redirect(route('products.index'));
            }
        }


        event(new \App\Events\UserCreated($native_user));

        flash('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해 주세요.');
        return redirect(route('sessions.create'), compact('return', 'email'));

    }

    function getUrlParameter($url, $sch_tag) {
        $parts = parse_url($url);
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
            return isset($query[$sch_tag]) ? $query[$sch_tag] : "";
        } else {
            return "";
        }
    }
}
