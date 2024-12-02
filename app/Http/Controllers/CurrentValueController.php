<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrentValueController extends Controller
{
   public function index(Request $request, $meter_id, $dataType = 'voltage')
   {
      $sessionId = $request->cookie('session_id');
      $type = $request->input('type', 'month');
      if (!$sessionId) {
          return redirect('/login');
      }

       $requestData = [
           'jsonrpc' => '2.0',
           'method' => 'currentValue.data',
           'params' => [
               'meter' => (int)$meter_id,
               'name' => (string)$dataType,
               'period' => [
                'type' => $type,
               ],
            'limit' => 100,
           ],
           'id' => 1,
       ];

       $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $requestData);
       $currentValues = $response->json();
       //dd($currentValues);
       if (array_key_exists('result', $currentValues)) {
        $dataPoints = collect($currentValues['result']['data'])->map(function ($currentvalue) use ($currentValues) {
            $data = [
                'date' => date('d.m.Y H:i:s', strtotime($currentvalue[0])),
            ];

            foreach ($currentValues['result']['headers'] as $index => $header) {
                if ($index > 0) {
                    $data[$header['name']] = $currentvalue[$index];
                }
            }
            return $data;
        });
        } else {
            $dataPoints = [];
        }
        
       return view('currentvalue', ['currentvalue' => $currentValues, 'dataPoints' => $dataPoints, 'meter_id' => $meter_id, 'dataType' => $dataType]);
   }
}