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
        return 'profile';
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

        $rules = array(
            'email' => 'required|email|unique:users',
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
//                    'metadata' => array(
//                        'first_name' => Input::get('first_name'),
//                        'last_name'  => Input::get('last_name'),
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
            Mail::send('emails.welcome', array('userId' => $user->id, 'activationCode' => $activationCode), function($message)
                {
                    $message->to(Input::get('email'))->subject('Welcome to the Foldagram!');
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

    public function activate($userId, $activationCode)
    {
        $activationPassed = false;

        try
        {
            // Find the user using the user id
            $user = Sentry::findUserById($userId);

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
}