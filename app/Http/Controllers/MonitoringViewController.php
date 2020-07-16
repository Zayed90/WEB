<?php

namespace App\Http\Controllers;

class MonitoringViewController extends Controller
{
    public function index()
    {
        return view('monitoring.monitoringTemplate');
    }
}
