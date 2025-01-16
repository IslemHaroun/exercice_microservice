<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GatewayController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
        ]);
    }

    public function forwardToSchool($path, Request $request)
    {
        try {
            $response = $this->client->request(
                $request->method(),
                "http://school:8000/api/{$path}",
                ['json' => $request->all()]
            );

            return response($response->getBody(), $response->getStatusCode())
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            Log::error('School Service Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'School Service Error'], 500);
        }
    }

    public function forwardToStudent($path, Request $request)
    {
        try {
            $response = $this->client->request(
                $request->method(),
                "http://student:8000/api/{$path}",
                ['json' => $request->all()]
            );

            return response($response->getBody(), $response->getStatusCode())
                ->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            Log::error('Student Service Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Student Service Error'], 500);
        }
    }
}