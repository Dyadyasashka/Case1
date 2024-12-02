<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MeterController extends Controller
{
    public function index(Request $request, $networkId, $object_id)
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
                'group' => ['object'],
                'include' => ['ascueState', 'zones'],
                'filter' => [
                    [
                        'type' => 'object',
                        'value' => (int)$object_id
                    ],
                ],
            ],
            'id' => 1,
        ];

        $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $meterListData);
        $meters = $response->json();
        //dd($meters);
        //dd($networkId);
        return view('meter', compact('meters'));
    }
}


