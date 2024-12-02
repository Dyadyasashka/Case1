<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReadingsController extends Controller
{
   public function index(Request $request, $meter_id)
   {
      $sessionId = $request->cookie('session_id');

      if (!$sessionId) {
          return redirect('/login');
      }

       $requestData = [
           'jsonrpc' => '2.0',
           'method' => 'reading.list',
           'params' => [
               'meter' => (int)$meter_id,
               'include' => ['zones', 'errors'],
               'period' => [
                   'type' => 'month',
               ],
               'mode' => 'archive',
               'sort' => 'desc',
           ],
           'id' => 1,
       ];

       $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $requestData);
       $readings = $response->json();
      // dd($readings);
       return view('readings', ['readings' => $readings]);
   }
}

