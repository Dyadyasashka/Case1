<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MeterAllController extends Controller
{
    public function index(Request $request, $networkId)
    {
        $sessionId = $request->cookie('session_id');

        if (!$sessionId) {
            return redirect('/login');
        }

        $meterListData = [
            'jsonrpc' => '2.0',
            'method' => 'meter.list',
            'params' => [
                'network' => (int)$networkId,
                'include' => ['ascueState', 'zones'],
            ],
            'id' => 1,
        ];

        $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $meterListData);
        $meters = $response->json('result');
        //dd($meters);
        return view('meterall', compact('meters'));
    }
}
