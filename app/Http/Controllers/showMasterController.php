<?php

namespace App\Http\Controllers;

use App\dim_application;
use App\Master_Data_Company;
use App\dim_lookup;
use App\Md1_Lookup_Result;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class showMasterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $source = $request->get('source') != '' ? $request->get('source') : -1;
        $field = $request->get('field') != '' ? $request->get('field') : 'company_name';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';
        $view = new Master_Data_Company();
        $sId = $view->orderBy('id', 'ASC');

        if ($source != -1)
            $sId = $sId->where('source', $source);
        $sId = $sId->where('company_name', 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(10)
            ->withPath('?search=' . $search . '&source=' . $source . '&field=' . $field . '&sort=' . $sort);

        $juml = Master_Data_Company::count();



        return view('.showMaster',compact('sId','juml'));

//        SELECT master_data_companies.id, COUNT(metadata.master_data_id) FROM master_data_companies LEFT JOIN metadata on master_data_companies.id = metadata.master_data_id GROUP by master_data_companies.id
    }

    public function masterUser(Request $request)
    {
        $search = $request->get('search');
        $source = $request->get('source') != '' ? $request->get('source') : -1;
        $field = $request->get('field') != '' ? $request->get('field') : 'company_name';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';
        $view = new Master_Data_Company();
        if ($source != -1)
            $view = $view->where('source', $source);
        $view = $view->where('company_name', 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(10)
            ->withPath('?search=' . $search . '&source=' . $source . '&field=' . $field . '&sort=' . $sort);


        return view('mdm_template.masterUser',compact('view'));
    }
}
