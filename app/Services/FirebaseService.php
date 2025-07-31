<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Device;
use Illuminate\Support\Facades\Log;


class FirebaseService
{
    private $baseUrl;
    private $secret;

    public function __construct($baseUrl = null, $secret = null)
    {
        // Pastikan base URL diakhiri dengan slash
        $this->baseUrl = rtrim($baseUrl ?: config('services.firebase.url'), '/') . '/';
        $this->secret = $secret ?? config('services.firebase.secret');
    }

    public function get($path)
    {
        // Pastikan path tidak diawali dengan slash
        $url = $this->baseUrl . ltrim($path, '/') . '.json';

        if (!empty($this->secret)) {
            $url .= '?auth=' . $this->secret;
        }

        // Debug log URL
        Log::info("Request Firebase URL: $url");

        // cURL GET
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("Firebase GET Error: $err");
            return null;
        }

        return json_decode($response, true);
    }

    public function set($path, $data, $method = 'PUT')
    {
        $url = $this->baseUrl . ltrim($path, '/') . '.json';

        if (!empty($this->secret)) {
            $url .= '?auth=' . $this->secret;
        }

        $jsonData = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("Firebase SET Error: $err");
            return null;
        }

        return json_decode($response, true);
    }
}
