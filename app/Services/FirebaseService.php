<?php

namespace App\Services; // <== Nama namespace Laravel sesuai struktur folder
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    private $baseUrl;
    private $secret;

    /**
     * Constructor dengan parameter opsional, agar bisa digunakan dinamis
     */
    public function __construct($baseUrl = null, $secret = null)
    {
        $this->baseUrl = rtrim($baseUrl ?: config('services.firebase.url'), '/') . '/';
        $this->secret = $secret ?? config('services.firebase.secret');
    }

    /**
     * @param string
     */
    public function get($path)
    {
        $url = $this->baseUrl . $path . '.json';

        if (!empty($this->secret)) {
            $url .= '?auth=' . $this->secret;
        }

        // cURL untuk GET request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("Firebase Error: $err");
            return null;
        }

        return json_decode($response, true); // Kembalikan data sebagai array/objek
    }

    /**
     * Mengirim data ke Firebase (PUT untuk replace / POST untuk append)
     * @param string $path path node tujuan
     * @param mixed $data data yang akan dikirim
     * @param string $method 'PUT' atau 'POST'
     */
    public function set($path, $data, $method = 'PUT')
    {
        $url = $this->baseUrl . $path . '.json';

        if (!empty($this->secret)) {
            $url .= '?auth=' . $this->secret;
        }

        $jsonData = json_encode($data);

        // cURL untuk POST/PUT request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("Firebase Error: $err");
            return null;
        }

        return json_decode($response, true); // Kembalikan response Firebase
    }
}
