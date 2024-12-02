<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ObjectsController extends Controller
{
   public function index(Request $request, $networkId)
   {
       $sessionId = $request->cookie('session_id');

       if (!$sessionId) {
           return redirect('/login');
       }

       $objectsData = [
           'jsonrpc' => '2.0',
           'method' => 'object.list',
           'params' => [
               'filter' => [
                [
                    'type' => 'networkId',
                    'value' => (int)$networkId
                ],
            ],
           ],
           'id' => 1,
       ];

       $response = Http::post('https://тутяконечножеубрал)' . $sessionId, $objectsData);
       $objects = $response->json()['result'];  
       //dd($objects);
       return view('objects', ['objects' => $objects, 'networkId' => $networkId]);
   }
}