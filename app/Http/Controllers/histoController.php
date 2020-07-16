<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Insert_Master_Data_History;
use App\Update_Master_Data_History;
use Illuminate\Support\Facades\DB;

class histoController extends Controller
{
    //
    public function index()
    {
        // Insert_Master_Data_History::groupBy('created_at')->paginate(10)
        $dataHs = Insert_Master_Data_History::groupBy('created_at')->get();
        $dataUp = Update_Master_Data_History::groupBy('created_at')->get();
        return view('history', compact('dataHs', 'dataUp'));
    }
    public function viewHis($created_at)
    {

        $hisIns = DB::table('insert_master_data_histories')->where('created_at', $created_at)->get();
        return view('histo', compact('hisIns'));
    }
    public function HisUp($created_at)
    {
        $hisUp = DB::table('update_master_data_histories')->where('created_at', $created_at)->get();
        return view('histoUp', compact('hisUp'));
    }
}
