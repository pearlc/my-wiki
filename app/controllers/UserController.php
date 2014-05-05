<?php
/**
 * User: rchung
 * Date: 2014. 4. 19.
 * Time: 오후 8:14
 */

class UserController extends BaseController
{
    public function profile()
    {
        $user = Sentry::getUser();

        return View::make('user.profile', array('user' => $user));
    }

    public function profileEdit()
    {
        $user = Sentry::getUser();
        return View::make('user.profile_edit', array('user' => $user));
    }

    public function profileEditPost()
    {

        $input = Input::get();

        // 유효성 검사
        $rules = array(
            'nick_name' => 'required|unique:users|min:2|max:12|regex:/^[a-zA-Z0-9가-힣]+$/', //  : 한글, 숫자, 알파
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::route('user_profile_edit')->withInput()->withErrors($validator);
        }

        $user = Sentry::getUser();
        $user->nick_name = $input['nick_name'];
        $user->save();

        return View::make('user.profile_edit_done');
    }

    public function passwordEdit()
    {
        $user = Sentry::getUser();

        return View::make('user.password_edit', array('user' => $user));
    }

    public function passwordEditPost()
    {
        $input = Input::get();

        // old 패스워드 검사
        $user = Sentry::getUser();
        if (!$user->checkPassword($input['old_password'])) {
            return Redirect::route('user_password_edit')->withInput()->withErrors(array('message' => '현재 비밀번호가 맞지 않습니다'));
        }

        // 새 패스워드 등록
        $rules = array(
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required'
        );

        $input = Input::get();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::route('user_password_edit')->withInput()->withErrors($validator);
        }

        $user->password = $input['password'];
        $user->save();

        return View::make('user.password_edit_done');
    }

    public function register()
    {
        if (Sentry::check()) {
            return Redirect::route('user_profile');
        }

        return View::make('user.register')->with('title', '회원가입')->with('class', 'register');
    }

    public function registerPost()
    {


        // TODO : activate 를 기본적으로 사용하는데, 사용자가 오랫동안 activate 하지 않은 상태에서 다시 해당 메일로 가입하려고 할때, 뭐라고 보여줘야 되는가? <- 별로 안중요함. 신경 안써도 될듯 (어짜피 이메일이라서 중복이라면 본인이 이상하게 생각할듯)

        // TODO : 취약한 비밀번호 입력시 reject 처리? (정책 정하기)

        $rules = array(
            'email' => 'required|email|unique:users',
            'nick_name' => 'required|unique:users|min:2|max:12|regex:/^[a-zA-Z0-9가-힣]+$/', //  : 한글, 숫자, 알파
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required'
        );
        $input = Input::get();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::route('user_register')->withInput()->withErrors($validator);
        }

        // 유저 등록
        try
        {
            // Let's register a user.
            $user = Sentry::register(array(
                    'email'    => Input::get('email'),
                    'password' => Input::get('password'),
                    'nick_name' => Input::get('nick_name')
//                    'metadata' => array(
//                        'nick_name' => Input::get('nick_name')
//                    )
                ));

            // Let's get the activation code
            $activationCode = $user->getActivationCode();

            // Send activation code to the user so he can activate the account
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Login field is required.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'Password field is required.';
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            echo 'User with this login already exists.';
        }


        // TODO : 메일 발송 클래스를 별도로 분리하는게 좋은가? (로그 관리도 해야되니깐.. 먼저 monolog 가 어떻게 작동하는지 확인 필요)
        try
        {
            Mail::send('emails.welcome', array('activationCode' => $activationCode), function($message)
                {
                    $message->to(Input::get('email'))->subject('가입을 환영합니다!');
                });
        }
            // TODO : 메일 발송 실패시 case by case 로 오류처리 할것
        catch (Exception $e)
        {
            echo '에러 발생';
        }

        return Redirect::route('user_welcome');
    }

    public function login()
    {
        return View::make('user.login')->with('titie', '로그인');
    }

    public function loginPost()
    {

        $input = Input::get();

        $authenticated = false;

        $remember = isset($input['remember'])?$input['remember']:false;

        try
        {
            // Set login credentials
            $credentials = array(
                'email'    => $input['email'],
                'password' => $input['password'],
            );

            // Try to authenticate the user
            $user = Sentry::authenticate($credentials, false);

            $authenticated = true;
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Login field is required.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'Password field is required.';
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            echo 'Wrong password, try again.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            echo 'User is not activated.';
        }

        if ($authenticated === false) {
            return Redirect::route('user_login')->withInput();
        }

        return Redirect::route('index');
    }

    public function welcome()
    {
        return View::make('user.welcome')->with('titie', '환영합니다');
    }

    public function activate($activationCode)
    {
        $activationPassed = false;

        try
        {
            // Find the user using the user id
            $user = Sentry::findUserByActivationCode($activationCode);

            // Attempt to activate the user
            if ($user->attemptActivation($activationCode))
            {
                // User activation passed
                $activationPassed  = true;

            }
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            // TODO : 1:1 문의를 링크로 바꿀것
            $failedMessage = '인증 과정에서 문제가 발생했습니다. 1:1 문의를 이용해 주세요';
        }
        catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
        {
            // TODO : '로그인하세요' 버튼으로 바꾸는게 좋을듯
            $failedMessage = '이미 인증된 계정입니다. 로그인하세요';
        }


        if ($activationPassed) {
            // passed
            return View::make('user.activate')->with('title', '메일 인증 성공')->with('activationPassed', true);
        } else {
            // failed
            return View::make('user.activate')->with('title', '메일 인증')->with('activationPassed', false)->with('failedMessage', $failedMessage);
        }
    }

    public function logout()
    {
        Sentry::logout();

        return Redirect::route('index');
    }

    public function delete()
    {
        Session::flash('delete_confirm', true);

        return View::make('user.delete');
    }

    public function deleteConfirm()
    {
        if (Session::get('delete_confirm') !== true) {
            return Redirect::route('index');
        }

        $user = Sentry::getUser();

        Sentry::logout();

        $user->delete();

        View::share('user', null);  // 뷰에서 사용되는 $user 변수 초기화

        return View::make('user.delete_confirm');
    }

    public function forgotPassword()
    {
        return View::make('user.forgot_password');
    }

    public function forgotPasswordPost()
    {
        $rules = array(
            'email' => 'email'
        );

        $input = Input::get();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::route('user_forgot_password')->withInput()->withErrors($validator);
        }

        // TODO : 등록되있지 않은 메일이 입력됬을때 error 메시지와 함께 back 시켜야함

        // TODO : 메일에 포함된 '초기화' 버튼이 현재처럼 되도 문제 없을지 확인 (현재 사용 방식 : userId 와 passwordCode를 base64 encoding 해서 링크에 사용될 문자열 생성)

        try
        {
            // Find the user using the user email address
            $user = Sentry::findUserByLogin($input['email']);

            // Get the password reset code
            $resetCode = $user->getResetPasswordCode();

            $payload = base64_encode($user->id.'-'.$resetCode);

            // Now you can send this code to your user via email for example.
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::route('user_forgot_password')->withInput()->withErrors(array('message' => 'User was not found'));
        }

        // 메일 발송
        try
        {
            Mail::send('emails.password_reset', array('payload' => $payload), function($message)
                {
                    $message->to(Input::get('email'))->subject('비밀번호 재설정 메일입니다');
                });
        }
            // TODO : 메일 발송 실패시 Exception 의 case by case 별로 오류처리 할것
        catch (Exception $e)
        {
            echo '에러 발생';
        }

        return View::make('user.password_reset_mail_sent')->with('email', $input['email']);
    }

    public function passwordReset($payload)
    {

        list($userId, $resetCode) = explode('-', base64_decode($payload));


        $validRequest = false;


        // 여기서 폼을 보여주고 새로운 password 를 입력받아야함

        try
        {
            $user = Sentry::findUserById($userId);

            if ($user->checkResetPasswordCode($resetCode)) {
                //

                $validRequest = true;

            } else {
                // 유효하지 않은 reset code

                throw new Exception();

            }
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }
        catch (Exception $e)
        {
            echo '오류가 발생했습니다.';
        }

        if (!$validRequest) {
            return Redirect::route('user_forgot_password');
        }

        return View::make('user.password_reset', array('user' => $user, 'reset_code' => $resetCode));
    }

    public function passwordResetPost()
    {
        $passwordReseted = false;

        $rules = array(
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required'
        );

        $input = Input::get();

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::route('user_password_reset')->withInput()->withErrors($validator);
        }

        try
        {
            // Find the user using the user id
            $user = Sentry::findUserById($input['user_id']);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($input['reset_code']))
            {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($input['reset_code'], $input['password']))
                {
                    // Password reset passed
                    $passwordReseted = true;
                }
                else
                {
                    // Password reset failed
                }
            }
            else
            {
                // The provided password reset code is Invalid
            }
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
        }

        if (!$passwordReseted) {
            return View::make('user.password_reset_failed');
        }

        return View::make('user.password_reset_done');
    }
}