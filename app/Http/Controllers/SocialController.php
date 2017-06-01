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


        if ($user->getEmail() === null) {
            $native_user = User::where($provider . '_id', '=', $user->id)->first();

            if ($native_user == null) {
                return view('socials.email', compact('user', 'provider'));
            } else {
                if (! $native_user->activated) {
                    flash()->error(
                        '가입확인해 주세요.'
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

        flash(
            auth()->user()->name . '님, 환영합니다.'
        );

        return redirect(route('products.index'));
    }

    public function createUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'id' => 'required|unique:users',
        ]);

        $confirmCode = str_random(60);

        $user = \App\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'confirm_code' => $confirmCode,
            $request->input('provider') . '_id' => $request->input('id'),
        ]);

        event(new \App\Events\UserCreated($user));

        flash('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해 주세요.');
        return redirect(route('sessions.create'));

    }
}
