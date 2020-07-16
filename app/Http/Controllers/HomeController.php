<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\DataSource;
use App\ShowNull;
use App\EregMPabrik;
use App\EregMTrader;
use JavaScript;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $rows1 = EregMPabrik::count();
        $cols1 = count(DB::select('desc ereg_m_pabrik'));
        $rows2 = EregMTrader::count();
        $cols2 = count(DB::select('desc ereg_m_trader'));

        // $jml_clusteringFalse = DataSource::where('STATUS','=','FALSE')->get()->count();
        // $jml_clusteringTrue = DataSource::where('STATUS','=','TRUE')->get()->count();
        // $jml_clusteringSelect = DataSource::where('STATUS','=','SELECTED')->get()->count();
        $jml_null = ShowNull::all()->count();

        return view('dashboard')->with(array(
            // 'clusteringFalse' => $jml_clusteringFalse,
            // 'clusteringTrue' => $jml_clusteringTrue,
            // 'clusteringSelect' => $jml_clusteringSelect,
            // 'null' => $jml_null,
            'rows1' => $rows1,
            'cols1' => $cols1,
            'rows2' => $rows2,
            'cols2' => $cols2
            ));;
    }

    public function indexManager()
    {
        $jml_clusteringFalse_M = DataSource::where('STATUS','=','FALSE')->get()->count();

        $jml_clusteringTrue_M = DataSource::where('STATUS','=','TRUE')->get()->count();

        $jml_null_M = ShowNull::all()->count();

        return view('dashboardManager')->with(array(
            'clusteringFalse_M' => $jml_clusteringFalse_M,
            'clusteringTrue_M' => $jml_clusteringTrue_M,
            'null_M' => $jml_null_M
            ));;
    }
    public function test(){
        $patterndashboard = DB::table("pattern_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("COUNT(id) as jumlah_pattern")
            )
            ->groupBy(DB::raw("id_running"))
            ->get();
        $shownulldashboard = DB::table("shownull_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("COUNT(id) as jumlah_null")
            )
            ->groupBy(DB::raw("id_running"))
            ->get();
        $completenessdashboard = DB::table("data_completeness_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("COUNT(IF(type='VALID',1, NULL)) as valid"),
                DB::raw("COUNT(IF(type='NOT_COMPLETE',1, NULL)) as not_complete"),
                DB::raw("COUNT(IF(type='NOT_IN_DICTIONARY',1, NULL)) not_in_dictionary")
            )
            ->groupBy(DB::raw("id_running"))
            ->get();

        $clusteringdashboard = DB::table("clustering_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("COUNT(id) as jumlah_cluster")
            )->groupBy(DB::raw("id_running"))
            ->get();

        $distributiondashboard = DB::table("val_distribution_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("COUNT(id) as jumlah_distribusi")
            )->groupBy(DB::raw("id_running"))
            ->get();

        // SIL
        $similaritydashboard = DB::table("val_similarity_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8) as kolom"),
                DB::raw("COUNT(IF(measure_value=1,1, NULL)) as similar"),
                DB::raw("COUNT(IF(measure_value<>1,1, NULL)) as high_similarity"),
                DB::raw("COUNT(IF(measure_value IS NULL, 1, NULL)) as uniquee")
            )
            // ->groupBy(DB::raw("id_running"))
            ->groupBy(DB::raw("datasource_detail"))
            ->get();

        $deduplicationdashboard = DB::table("data_deduplication_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9) as kolom"),
                DB::raw("COUNT(IF(measure_value=0,1, NULL)) as duplicated"),
                DB::raw("COUNT(IF(measure_value=1,1, NULL)) as probably_duplicated"),
                DB::raw("COUNT(IF(measure_value IS NULL,1, NULL)) as uniquee")

            )
            // ->groupBy(DB::raw("id_running"))
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
            
        $patternscore=ProfilingScoringController::patternScoring();
        $completenessdata=array(['KOLOM','VALID','NOT COMPLETE','NOT IN DICTIONARY']);
        // SIL
        $similaritydata=array(['KOLOM','UNIQUE','SIMILAR DATA','PROBABLY SIMILAR']);
        $deduplicationdata=array(['KOLOM','UNIQUE','DUPLICATED','PROBABLY DUPLICATED']);
        // 
        $patterndata=array(['DESC','SCORE'],['PASS SCORE',$patternscore[0]],['FAIL SCORE',$patternscore[1]]);
        $shownulldata=array(['KOLOM','JUMLAH NULL']);
        $clusteringdata=array(['KOLOM', "JUMLAH CLUSTER"]);
        $distributiondata=array(['KOLOM', "JUMLAH DISTRIBUSI"]);

        foreach ($shownulldashboard as $row){
            $shownulldata[] =[$row->kolom,$row->jumlah_null];
        }
        foreach ($completenessdashboard as $row){
            $completenessdata[] =[$row->kolom,$row->valid,$row->not_complete,$row->not_in_dictionary];
        }
        // SIL
        foreach ($similaritydashboard as $row){
            $similaritydata[] =[$row->kolom,$row->uniquee,$row->similar,$row->high_similarity];
            // $similaritydata[] =[$row->kolom,$row->similar,$row->high_similarity];
        }
        foreach ($deduplicationdashboard as $row){
            $deduplicationdata[] =[$row->kolom,$row->uniquee,$row->duplicated,$row->probably_duplicated];
        }
        // 
        foreach ($clusteringdashboard as $row){
            $clusteringdata[] =[$row->kolom,$row->jumlah_cluster];
        }
        foreach ($distributiondashboard as $row){
            $distributiondata[] =[$row->kolom,$row->jumlah_distribusi];
        }
        JavaScript::put([
            'testname'=>'reza',
            'patterndashboard'=> $patterndata,
            'shownulldashboard'=> $shownulldata,
            'completenessdashboard'=>$completenessdata,
            'clusteringdashboard'=>$clusteringdata,
            'distributiondashboard'=>$distributiondata,
            // SIL
            'similaritydashboard'=>$similaritydata,
            'deduplicationdashboard'=>$deduplicationdata
        ]);
        return view('dashboard');
    }
}