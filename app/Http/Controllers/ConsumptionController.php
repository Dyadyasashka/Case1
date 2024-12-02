<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsumptionController extends Controller
{
   public function index(Request $request, $object_id)
   {
      $sessionId = $request->cookie('session_id');

      if (!$sessionId) {
          return redirect('/login');
      }

       $requestData = [
           'jsonrpc' => '2.0',
           'method' => 'consumption.object',
           'params' => [
               'object' => (int)$object_id,
               'minimalLevel' => 1,
               'period' => [
                  'type' => 'year'
               ]
           ],
           'id' => 1,
       ];

       $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $requestData);
       $consumption = $response->json();
       //dd($consumption);
       return view('consumption', ['consumption' => $consumption]);
   }
}