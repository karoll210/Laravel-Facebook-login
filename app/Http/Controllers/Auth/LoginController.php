<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;
use Socialite;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
	 /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
       	 $user = Socialite::driver('facebook')->user();

	
	$token = $user->token;
	$refreshToken = $user->refreshToken; // not always provided
	$expiresIn = $user->expiresIn;

	// OAuth One Providers
	$token = $user->token;
	//$tokenSecret = $user->tokenSecret;

	// All Providers
	$user->getId();
	$nickname = $user->getNickname();
	$user->getName();
	$user->getEmail();
	$picture = $user->getAvatar();

	$user = Socialite::driver('facebook')->userFromToken($token);

	echo '<h1 style="text-align:center; color:blue;">Gratulacje '.$user['name'].'! Właśnie zalogowałeś się za pośrednictwem Facebook!</h1>';
	
	echo '<div style="width:200px; float:left; margin:1% 45%;"><img src="'.$picture.'" height="150px" width="150px" style="border-radius:200px; margin:5px auto;"/></div>';
	echo '<h3 style="text-align:center;">ID: '.$user['id'].'</h3>';
	echo '<h3 style="text-align:center;">NICKNAME: '.$nickname.'</h3>';
	echo '<h3 style="text-align:center;">NAME: '.$user['name'].'</h3>';
	echo '<h3 style="text-align:center;">EMAIL: '.$user['email'].'</h3>';
    }


}
