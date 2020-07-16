<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Clustering;
use App\DataSource;
use Session;
class ClusteringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Clustering::where('JUMLAH','>', 1)->get();
        $jml_cluster = Clustering::where('JUMLAH','>', 1)->get()->count();
        return view('listClustering')->with(array(
            'data' => $data,
            'jml_clustering' => $jml_cluster
            ));;  
    }

    public function testing($id){
        $data = DataSource::where('FINGERPRINT',$id)->get();
        return view('listEditingClustering',['id' => $id,'data' => $data]);
    }

    public function updateTesting($id){
            DataSource::where('FINGERPRINT', $id)
            ->update([
                'NAMA' => $_POST['data'],
                'STATUS' => 'SELECTED'
                ]);
            Clustering::where('FINGERPRINT', $id)
            ->update(['JUMLAH' => 1]);
            Session::flash('status', 'Data updated');
        return redirect('/dataClustering');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('listEditingClustering');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function getDetail($fingerprint)
    // {
    //     //TODO here
    //     $sql = DataSource::where('FINGERPRINT','=',fingerprint)->get();
    //     return view('listEditingClustering');
    // }
}
