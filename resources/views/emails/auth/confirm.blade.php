<p style="font-size:10pt;font-family:sans-serif;padding:0 0 0 10pt"><span style="font-family: Gulim; font-size: 10pt;">{{ $user->name }}님, 환영합니다!&nbsp;</span></p><p style="font-size:10pt;font-family:sans-serif;padding:0 0 0 10pt"><span style="font-family: Gulim; font-size: 10pt;">가입 확인을 위해 브라우저에서 아래 링크를 열어주세요.</span></p><p style="font-size:10pt;font-family:sans-serif;padding:0 0 0 10pt"><span style="font-family: Gulim; font-size: 10pt;"><br></span></p><p style="font-size:10pt;font-family:sans-serif;padding:0 0 0 10pt"><a href="{{ route('users.confirm', $user->confirm_code) }}">인증하기</a><br></p>





