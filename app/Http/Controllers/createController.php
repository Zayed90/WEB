<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Md1_Lookup_Result;

class createController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $source = $request->get('data_source') != '' ? $request->get('data_source') : -1;
        $field = $request->get('field') != '' ? $request->get('field') : 'name';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';
        $customers = new Customer();
        if ($source != -1)
            $customers = $customers->where('data_source', $source);
        $customers = $customers->where('company_name', 'like', '%' . $search . '%')
            ->orderBy($field, $sort)
            ->paginate(5)
            ->withPath('?search=' . $search . '&data_source=' . $source . '&field=' . $field . '&sort=' . $sort);
        return view('showNoMatch', compact('customers'));
    }
}
