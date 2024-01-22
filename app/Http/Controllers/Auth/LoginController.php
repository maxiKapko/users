<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\AwsCognitoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $cognitoService;

    public function __construct(AwsCognitoService $cognitoService)
    {
        $this->cognitoService = $cognitoService;
    }

    public function login(Request $request)
    {
        // Get username and password from the request
        $username = $request->input('email');
        $password = $request->input('password');

        // Use the Cognito service to authenticate the user
        $result = $this->cognitoService->authenticate($username, $password);

        // Handle the authentication result
        if ($result && isset($result['AuthenticationResult'])) {
            // Authentication successful
            $authenticationResult = $result['AuthenticationResult'];

            // Store tokens in the session or use them as needed
            Session::put('access_token', $authenticationResult['AccessToken']);
            Session::put('id_token', $authenticationResult['IdToken']);
            Session::put('refresh_token', $authenticationResult['RefreshToken']);

            // Redirect to the intended page or a default page
            return redirect()->intended('/');
        } else {
            // Authentication failed
            return back()->withErrors(['username' => 'Invalid credentials']);
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function logout()
    {
        // Clear local session
        Auth::logout();

        // Clear Cognito-related tokens
        Session::forget('access_token');
        Session::forget('id_token');
        Session::forget('refresh_token');

        // Redirect to the login page or another desired page
        return redirect('/login');
    }
}
