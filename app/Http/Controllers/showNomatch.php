<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Md1_Lookup_Result;



class showNomatch extends Controller
{
    public function index(Request $request)
    {



        $dataHs = DB::select("select * from insert_master_data_histories group by created_at");
        $dataUp = DB::select("select * from update_master_data_histories group by created_at");


        $search = $request->get('search');
        $source = $request->get('data_source') != '' ? $request->get('data_source') : -1;
        $field = $request->get('field') != '' ? $request->get('field') : 'company_name';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';
        $customer = new Md1_Lookup_Result();
        $customers = $customer->where('status', 'Not match');
        if ($source != -1)
            $customers = $customers->where('data_source', $source);
        $customers = $customers->where('company_name' , 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(10)
            ->withPath('?search=' . $search . '&data_source=' . $source . '&field=' . $field . '&sort=' . $sort);

       return view('showNoMatch', compact('dataHs','dataUp','customers'));


    }


}
