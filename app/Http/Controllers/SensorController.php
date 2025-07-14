<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;

class SensorController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        $flowRate = $this->firebase->get('flowSensor/flowRate');
        $totalML = $this->firebase->get('flowSensor/totalML');

        return view('index-test', [
            'flowRate' => $flowRate,
            'totalML' => $totalML
        ]);
    }
}
