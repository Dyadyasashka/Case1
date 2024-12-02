<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PowerProfileController extends Controller
{
    public function index(Request $request, $meter_id)
    {
        $sessionId = $request->cookie('session_id');
        $group = $request->input('group',1800);
        $selectedDate = $request->input('selectedDate');
        if ($sessionId) {
            
            $requestData = [
                'jsonrpc' => '2.0',
                'method' => 'powerProfile.data',
                'params' => [
                    'meter' => (int)$meter_id,
                    'include' => ['reactive','reverse'],
                    'period' => [
                        'type' => 'month',//ДЕНЬ НЕДЕЛЯ МЕСЯЦ $type
                        'value' => $selectedDate
                    ],
                    'group' => $group,
                ],
                'id' => 1,
            ];

            $response = Http::post("https://тутяконечножеубрал)$sessionId", $requestData);
            $powerProfile = $response->json();
            //dd($powerProfile);
            $dataPoints = collect($powerProfile['result']['data'])->map(function ($dataPoint) {
                return [
                    'date' => date('d.m.Y H:i:s', strtotime($dataPoint[0])),
                    'active_power' => $dataPoint[1],
                    'reverse_active_power' => $dataPoint[3],
                    'reactive_power' => $dataPoint[2],
                    'reverse_reactive_power' => $dataPoint[4],
                ];
            });
            //dd($dataPoints);
            return view('powerprofile', compact('powerProfile', 'dataPoints','group'));
            
        } else {
            return redirect()->route('login');
        }
    }
}
