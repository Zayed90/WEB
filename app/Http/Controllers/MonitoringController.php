<?php

namespace App\Http\Controllers;

use App\CompletenessView;
use App\DQResult;
use Illuminate\Http\Request;
use App\Monitoring;
use App\DataSource;
use App\ShowNull;
use Illuminate\Support\Facades\DB;
use Session;
use App\PatternTableResult;
use App\ValueDistributionTableResult;
use App\DataCompletenessTableResult;
use App\ShownullTableResult;
use App\ClusteringTableResult;
// SIL
use App\ValueSimilarityTableResult;
use App\DataDeduplicationTableResult;
use JavaScript;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Monitoring::all();
        $jml_clustering = DataSource::where('STATUS', '=', 'FALSE')->get()->count();
        $jml_null = ShowNull::all()->count();

        return view('monitoringAdmin')->with(array(
            'data' => $data,
            'clustering' => $jml_clustering,
            'null' => $jml_null,
            ));
    }

    public function indexMonitorManager()
    {
        $data = Monitoring::all();

        return view('monitoringManager')->with(array(
            'data' => $data,
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Monitoring::create([
            'NAMA_TABEL' => 'data_pabrik, data_trader',
            'KOLOM_TABEL' => 'data_pabrik.NAMA, data_trader.TELEPON',
            'JUMLAH_CLUSTERING' => $request->clustering,
            'JUMLAH_NULL' => $request->null,
            ]);
        Session::flash('status', 'Data saved');

        return redirect('/monitoringAdmin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    public static function jsonReader($data, $column_name)
    {
        $data_decode = json_decode($data);
        $data_properties = get_object_vars($data_decode);
        $data_decode = $data_properties[$column_name][0];
        $data = json_decode(json_encode($data_decode), true);

        return $data;
    }
    public function view()
    {
        return view('monitoring.monitoring');
    }

    //Function for view each profiling
    public function showPatternMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM pattern_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.patternMonitoring')->with(array('results' => $results,));
    }
    public function showNullMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM shownull_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.nullMonitoring')->with(array('results'=>$results));
    }
    public function showCompletenessMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM data_completeness_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.completenessMonitoring')->with(array('results'=>$results));
    }
    public function showDistributionMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM val_distribution_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.distributionMonitoring')->with(array('results'=>$results));
    }
    public function showClusteringMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM clustering_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.clusteringMonitoring')->with(array('results'=>$results));
    }

    //MCP Monitoring SIL
    public function showSimilarityMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM val_similarity_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.similarityMonitoring')->with(array('results'=>$results));
        // return view('monitoring.similarityMonitoring');
    }

    public function showDeduplicationMonitoring(){
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM data_deduplication_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('monitoring.deduplicationMonitoring')->with(array('results'=>$results));
        // return view('monitoring.deduplicationMonitoring');
    }
    // end

    //Function for getting data to pivot table
    public function getPatternData(){
        $patternmonitor = DB::table("pattern_table_result")
            ->select("id_running",DB::raw("COUNT(id) as jumlah_pattern"),
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->groupBy(DB::raw("id_running"))
            ->get();
        return response($patternmonitor);
    }
    public function getNullData(){
        $nullmonitor = DB::table("shownull_table_result")
            ->select("id_running",DB::raw("COUNT(id) as jumlah_null"),
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->groupBy(DB::raw("id_running"))
            ->get();
        return response($nullmonitor);
    }
    public function getCompletenessData(){
        $completemonitor = DB::table("data_completeness_table_result")
            ->select("id_running","type",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->get();
            // dd($completemonitor);
        return response($completemonitor);
    }

    public function getDistributionData(){
        $distributionmonitor = DB::table("val_distribution_table_result")
            ->select("id_running","column_value","column_value_distribution",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->get();
        return response($distributionmonitor);
    }
    public function getClusteringData(){
        $clusteringnmonitor = DB::table("clustering_table_result")
            ->select("id_running","name_new as clustering_value","total",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->get();
        return response($clusteringnmonitor);
    }

        // SIL
        public function getSimilarityData(){
            $completemonitor = DB::table("val_similarity_table_result")
                ->select(
                    "id_running",
                    "measure_value",
                    DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+8+3,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-8-3) as db_name"),
                    // DB::raw("substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8) as port"),
                    DB::raw("substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8) as tab1"),
                    DB::raw("substring(datasource_detail, locate('\"col1\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"col1\":',datasource_detail))-locate('\"col1\":',datasource_detail)-8) as col1"),
                    // DB::raw("substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8) as tab2"),
                    // DB::raw("substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8) as col2"),
                    DB::raw("substring(created_at, 1, 10) as tanggal")
                )
                // ->limit(2000)
                ->get();

            // Di sini mapping measure_value nya di grouping terus di alias in
            $finalResponse = $completemonitor->map(function ($item, $key) {
                if ($item->measure_value == null){
                    $item->measure_value_group = 'Unique Data'; 
                  }
                  elseif ($item->measure_value == 1) {
                    $item->measure_value_group = 'Similar Data';
                  }
                  elseif ($item->measure_value < 1) {
                    $item->measure_value_group = 'Data with High Similarity';
                  }

                  return $item;
                
              });

            return response($finalResponse);
        }
    
        public function getDeduplicationData(){
            $deduplicationmonitor = DB::table("data_deduplication_table_result")
                ->select(
                    "id_running",
                    "measure_value",
                    "datasource_detail",
                    "created_at"
                    // DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as db_name"),
                    // DB::raw("substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8) as port"),
                    // DB::raw("substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8) as tab1"),
                    // DB::raw("substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8) as tab2"),
                    // DB::raw("substring(datasource_detail, locate('\"col1a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1a\":',datasource_detail))-locate('\"col1a\":',datasource_detail)-9) as col1a"),
                    // DB::raw("substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9) as col1b"),
                    // DB::raw("substring(datasource_detail, locate('\"col2a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2a\":',datasource_detail))-locate('\"col2a\":',datasource_detail)-9) as col2a"),
                    // DB::raw("substring(datasource_detail, locate('\"col2b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2b\":',datasource_detail))-locate('\"col2b\":',datasource_detail)-9) as col2b"),
                )
                ->get();

                // dikasih alias
                $finalResponse = $deduplicationmonitor->map(function ($item, $key) {
                    if ($item->measure_value == null){
                        $item->measure_value_group = 'Unique Data'; 
                      }
                      elseif ($item->measure_value == 0) {
                        $item->measure_value_group = 'Duplicated Data';
                      }
                      elseif ($item->measure_value = 1) {
                        $item->measure_value_group = 'Probably Duplicated Data';
                      }
    
                      return $item;
                    
                  });

            return response($finalResponse);
        }

    //Function for result each profiling
    public function viewPattern()
    {
        $id_running = $_GET['id'];
        $results = PatternTableResult::where('id_running', $id_running)->get();
        $datasource_detail = PatternTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('monitoring.patternResultMonitor')->with(array(
            'results' => $results,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }
    public function viewShownull()
    {
        $id_running = $_GET['id'];
        $results = ShownullTableResult::where('id_running', $id_running)->get();
        $first_result = ShownullTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = ShownullTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
        $data = $this->jsonReader($first_result->data, 'data');

        return view('monitoring.nullResultMonitor')->with(array(
            'results' => $results,
            'first_result' => $first_result->filtered,
            'id_running' => $id_running,
            'column_detail' => $data,
            'datasource_detail' => $datasource_detail,
        ));
    }
    public function viewDataCompleteness()
    {
        $id_running = $_GET['id'];
        $results = DataCompletenessTableResult::where('id_running', $id_running)->get();
        // $first_result = DataCompletenessTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = DataCompletenessTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('monitoring.completenessResultMonitor')->with(array(
            'results' => $results,
            // 'first_result' => $first_result->clusteredby,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }

    // SIL
    public function viewValueSimilarity()
    {
        $id_running = $_GET['id'];
        $results = ValueSimilarityTableResult::where('id_running', $id_running)->get();
        $datasource_detail = ValueSimilarityTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('monitoring.similarityResultMonitor')->with(array(
            'results' => $results,
            // 'first_result' => $first_result->clusteredby,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }

    public function viewValueDistribution()
    {
        $id_running = $_GET['id'];
        $results = ValueDistributionTableResult::where('id_running', $id_running)->get();
        $datasource_detail = ValueDistributionTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('monitoring.distributionResultMonitor')->with(array(
            'results' => $results,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }
    public function viewClustering()
    {
        $id_running = $_GET['id'];
        $results = ClusteringTableResult::where('id_running', $id_running)->get();
        $first_result = ClusteringTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = ClusteringTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('monitoring.clusteringResultMonitor')->with(array(
            'results' => $results,
            'first_result' => $first_result->clusteredby,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }

    //MCP SIL
    public function viewSimilarity()
    {
        $id_running = $_GET['id'];
        $results = ValueSimilarityTableResult::where('id_running', $id_running)->get();
        $datasource_detail = ValueSimilarityTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('monitoring.similarityResultMonitor')->with(array(
            'results' => $results,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }

    public function viewDeduplication()
    {
        $id_running = $_GET['id'];
        $results = DataDeduplicationTableResult::where('id_running', $id_running)->get();
        $datasource_detail = DataDeduplicationTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        // Pie Chart Back End
        // All Data Pie (Yang baru)
        $tbname='data_deduplication_table_result';
        $allpiedata = DB::table($tbname)
            ->select(
                DB::raw("measure_value"),
                DB::raw("COUNT(id) as jumlah_alldatapie")
            )
            ->where("id_running","=",$id_running)
            ->groupBy(DB::raw("measure_value"))
            ->get();
        
        $allpiedatachart=array(['DATA CATEGORY','DATA COUNT']);
        foreach ($allpiedata as $row){
            $allpiedatachart[]=[$row->measure_value,$row->jumlah_alldatapie];
        }
        
        JavaScript::put([
            'allpiedatachart'=>$allpiedatachart,
        ]);

        return view('monitoring.deduplicationResultMonitor')->with(array(
            'results' => $results,
            // 'first_result' => $first_result->clusteredby,
            'id_running' => $id_running,
            'datasource_detail' => $datasource_detail,
        ));
    }

}
