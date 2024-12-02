<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $sessionId = $request->cookie('session_id');

        if (!$sessionId) {
            return redirect('/login');
        }
    
        $networksData = [
            'jsonrpc' => '2.0',
            'method' => 'network.list',
            'id' => 1,
        ];
    
        $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $networksData);
        $networks = $response->json()['result'];
        
        $networkId = $request->cookie('network_id');
        $cookie = cookie('network_id');

        //dd($networks);

        return view('networks', ['networks' => $networks, 'cookie' => $cookie, 'networkId' => $networkId]);
    }
}

