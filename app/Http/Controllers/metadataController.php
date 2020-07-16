<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class metadataController extends Controller
{
    public function viewMeta($id)
    {
        $viewMet = DB::table('metadata')->where('master_data_id', $id)->get();
        return view('meta', compact('viewMet'));
    }
    
}
