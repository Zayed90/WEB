<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeMasterData extends Controller
{
    public function homeMDM()
    {
        return view('panel.home');
    }
}
