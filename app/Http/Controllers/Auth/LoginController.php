<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/networks';

    protected function authenticateThroughApi(Request $request)
    {
        $user = $request->input('email');
        $password = $request->input('password');
        $verifyCode = $request->input('verifyCode');
        $attempts = $request->session()->get('login_attempts', 0);

        $requestData = [
            'jsonrpc' => '2.0',
            'method' => 'auth.login',
            'params' => [
                'mode' => 'user',
                'user' => $user,
                'password' => $password,
                'verifyCode' => $verifyCode,
            ],
            'id' => 1,
        ];

        $response = Http::post('https://https://тутяконечножеубрал).ru/api?v2', $requestData);
        $apiData = $response->json();
        //dd($apiData);
        if (isset($apiData['result'])) {
            
            session(['session_id' => $apiData['result']]);

            $sessionId = $apiData['result'];
            $cookie = cookie('session_id', $sessionId, );

            $userInfoApi = [
                'jsonrpc' => '2.0',
                'method' => 'user.info',
                'params' => [],
                'id' => 1,
            ];
            
            $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $userInfoApi);
            $userInfo = $response->json();
            //dd($userInfo);
            if (isset($userInfo['result']['name'])) {
                session(['user_name' => $userInfo['result']['name']]);
            }

            return redirect()->intended($this->redirectTo)->withCookie($cookie);
        } elseif ($apiData['error']['code'] == 10201) {
            $request->session()->put('login_data', [
                'email' => $user,
                'password' => $password,
            ]);
            $verifyImage = $apiData['data']['verifyImage'];
            return view('auth.login')->with('verifyImage', $verifyImage);
        } else {
            return back()->withErrors(['email' => 'Неверный логин или пароль']);
        }
    }

    protected function login(Request $request)
    {
        $sessionId = $request->cookie('session_id');
    
        if ($sessionId) {
            session(['session_id' => $sessionId]);
        }
    
        return $this->authenticateThroughApi($request);
    }

    protected function logout(Request $request)
    {
        $sessionId = $request->cookie('session_id');
    
        if ($sessionId) {
            $logoutData = [
                'jsonrpc' => '2.0',
                'method' => 'auth.logout',
                'params' => [],
                'id' => 1,
            ];
    
            $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $logoutData);
            $logoutResult = $response->json();
            //dd($logoutResult);
            $cookie = cookie('session_id', '', -1);
            session()->forget(['session_id', 'user_name']);
            return redirect('/')->withCookie($cookie);
        }
        return redirect('/login');
    }
    
}

