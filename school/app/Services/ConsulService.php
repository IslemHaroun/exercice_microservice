<?php

namespace App\Services;

use GuzzleHttp\Client;

class ConsulService
{
    public static function registerService($name, $id, $port, $address, $healthCheckUrl)
    {
        $client = new Client(['base_uri' => 'http://consul:8500/v1/']);

        try {
            $response = $client->put('agent/service/register', [
                'json' => [
                    'Name' => $name,
                    'ID' => $id,
                    'Port' => $port,
                    'Address' => $address,
                    'Check' => [
                        'HTTP' => $healthCheckUrl,
                        'Interval' => '10s',
                        'Timeout' => '5s',
                    ],
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                echo "Service $name enregistré avec succès dans Consul.";
            }
        } catch (\Exception $e) {
            echo "Erreur lors de l'enregistrement de $name dans Consul : " . $e->getMessage();
        }
    }
}
