<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CardinalitiesTableResult;
use App\PatternTableResult;
use App\ValueDistributionTableResult;
use App\ValueSimilarityTableResult;
use App\DataCompletenessTableResult;
use App\DataDeduplicationTableResult;
use App\ShownullTableResult;
use App\ClusteringTableResult;
use App\OutlierTableResult;
use App\ShowNull;
//use Config;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Zttp\Zttp;

class PentahoLogicController extends Controller
{
    public static function jsonReader($data, $column_name)
    {
        $data_decode = json_decode($data);
        $data_properties = get_object_vars($data_decode);
        $data_decode = $data_properties[$column_name][0];
        $data = json_decode(json_encode($data_decode), true);

        return $data;
    }

    public function importCsv($request,$namatable)
    {
        $namafile = $request->getClientOriginalName();
        $file = Input::file($namatable);
        $namafile = explode('.', $namafile);
        $table = $namafile[0];
        $table = str_replace(' ', '_', $table);
        //echo $table;

        // $row = fgetcsv($fileHandle, 20, ',');
        // var_dump($row);

        //Display File Name
        //echo $file;
        //dd($file);

        ini_set('auto_detect_line_endings', true);
        ini_set('max_execution_time', 600);

        $handle = fopen($file, 'r');
        // first row, structure
        if (($data = fgetcsv($handle)) === false) {
            //echo "Cannot read from csv $file";
            die();
        }
        $fields = array();
        $field_count = 0;

        for ($i = 0; $i < count($data); ++$i) {
            $f = strtolower(trim($data[$i]));
            if ($f) {
                // normalize the field name, strip to 20 chars if too long
                $f = substr(preg_replace('/[^0-9a-z]/', '_', $f), 0, 20);
                ++$field_count;
                $fields[] = $f.' VARCHAR(50)';
            }
        }
        // echo $field_count;
        $sql = "CREATE TABLE $table (".implode(', ', $fields).')';
        $drop = "DROP TABLE IF EXISTS $table";
        // echo $sql.'<br /><br />';
        DB::connection('import_mysql')->statement($drop);
        DB::connection('import_mysql')->statement($sql);
        // $db->query($sql);
        while (($data = fgetcsv($handle)) !== false) {
            $fields = array();
            for ($i = 0; $i < $field_count; ++$i) {
                $fields[] = '\''.addslashes($data[$i]).'\'';
            }
            $sql = "Insert into $table values(".implode(', ', $fields).')';
            // echo $sql;
            DB::connection('import_mysql')->statement($sql);
            // $db->query($sql);
        }
        fclose($handle);
        ini_set('auto_detect_line_endings', false);
        //$id = 1;
        // return view('import.importData');
        return $table;
    }

    public function isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe){
      if($tipe!="postgre"){
      Config::set('database.connections.external_mysql.host', $host);
      Config::set('database.connections.external_mysql.port', $port);
      Config::set('database.connections.external_mysql.username', $db_username);
      Config::set('database.connections.external_mysql.password', $db_password);
      Config::set('database.connections.external_mysql.database', $db_name);
      $column_detail = DB::connection('external_mysql')->getSchemaBuilder()->hasColumn($table,$column);
      }else{
        Config::set('database.connections.external_pgsql.host', $host);
        Config::set('database.connections.external_pgsql.port', $port);
        Config::set('database.connections.external_pgsql.username', $db_username);
        Config::set('database.connections.external_pgsql.password', $db_password);
        Config::set('database.connections.external_pgsql.database', $db_name);
        $column_detail = DB::connection('external_pgsql')->getSchemaBuilder()->hasColumn($table,$column);

      }
      $isDataExist = false;
      if($column_detail){
        $isDataExist = true;
      }else{
        $isDataExist = false;
  
      }
  
      return $isDataExist;
    }

    public function runCardinalities()
    {
        //echo shell_exec('D:\software\data-integration\pan.bat /file:"D:\software\data-integration\web_cardinalities.ktr" /param:"col=status" /param:"tab=ereg_m_trader"');
        $results = CardinalitiesTableResult::all()->sortByDesc('id');

        return view('pentahologic.cardinalities.cardinalities_home')->with(array(
      'results' => $results,
    ));
    }

    public function processCardinalities(Request $request)
    {
        $column = $request->column;
        $table = $request->table;
        $host = $request->host;
        $db_name = $request->db_name;
        $db_username = $request->db_username;
        $db_password = $request->db_password;
        $port = $request->port;

        return view('pentahologic.cardinalities.cardinalities_process')->with(array(
      'column' => $column,
      'table' => $table,
      'done' => '1',
      'host' => $host,
      'db_name' => $db_name,
      'db_username' => $db_username,
      'db_password' => $db_password,
      'port' => $port,
    ));
    }

    public function runPattern()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM pattern_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('pentahologic.pattern.pattern_home')->with(array(
      'results' => $results,
    ));
    }

    public function processPattern(Request $request)
    {
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $column = $request->column;
      $table = $request->table;
      if($tipe == "CSV"){
        $table = $this->importCsv($request->table,'table');

      }
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $condition = $request->condition;
      
      $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);
     
      if(!$isDataExist) {
        Session::flash('error', 'Database Tidak Ditemukan');
        return redirect()->back();
      }

      if ($condition != "") {
        $condition = "WHERE ".$condition;
      }else{
        $condition = " ";
      }

      $filename = 'web_pattern - Copy.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition
      ];

      requestToPentaho($queryParams);

      return redirect()->back();
    }

    public function viewPattern()
    {
        $id_running = $_GET['id'];
        $results = PatternTableResult::where('id_running', $id_running)->get();
        $datasource_detail = PatternTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('pentahologic.pattern.pattern_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runValueDistribution()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM val_distribution_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('pentahologic.value_distribution.valueDistribution_home')->with(array(
      'results' => $results,
    ));
    }

    public function processValueDistribution(Request $request)
    {
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $column = $request->column;
      $table = $request->table;
      if($tipe == "CSV"){
        $table = $this->importCsv($request->table,'table');
      }
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $condition = $request->condition;
      $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);
      if(!$isDataExist) {
        Session::flash('error', 'Database Tidak Ditemukan');
        return redirect()->back();
      }
      if ($condition != "") {
        $condition = "WHERE ".$condition;
      }else{
        $condition = " ";
      }
      $filename = 'web_val_distribution - Copy.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition
      ];

      requestToPentaho($queryParams);

      return redirect()->back();
    }

    public function viewValueDistribution()
    {
        $id_running = $_GET['id'];
        $results = ValueDistributionTableResult::where('id_running', $id_running)->get();
        $datasource_detail = ValueDistributionTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('pentahologic.value_distribution.valueDistribution_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runValueSimilarity()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM val_similarity_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('pentahologic.value_similarity.valueSimilarity_home')->with(array(
      'results' => $results,
    ));
    }

    public function processValueSimilarity(Request $request)
    {

        $username = Auth::user()->username;
        $tipe = $request->tipe_database;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
        $column1 = $request->column1;
        $table1 = $request->table1;
        $column2 = $request->column2;
        $table2 = $request->table2;
        if($tipe == "CSV"){
          $table1 = $this->importCsv($request->table1,'table1');
          $table2 = $this->importCsv($request->table2,'table2');
  
        }
        $label = $request->label;
        $host = $results[0]->hostname;
        $db_name = $results[0]->db_name;
        $db_username = $results[0]->db_username;
        $db_password = $results[0]->db_password;
        $port = $results[0]->port;

        $isDataExist1 = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table1,$column1,$tipe);
        $isDataExist2 = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table2,$column2,$tipe);
        return view('pentahologic.value_similarity.valueSimilarity_process')->with(array(
      'tipe' => $tipe,
      'column1' => $column1,
      'table1' => $table1,
      'column2' => $column2,
      'table2' => $table2,
      'done' => '1',
      'host' => $host,
      'db_name' => $db_name,
      'db_username' => $db_username,
      'db_password' => $db_password,
      'port' => $port,
      'isDataExist1' =>  $isDataExist1,
      'isDataExist2' =>  $isDataExist2,
      'label' => $label
    ));
    }

    public function viewValueSimilarity()
    {
        $id_running = $_GET['id'];
        $results = ValueSimilarityTableResult::where('id_running', $id_running)->get();
        $datasource_detail = ValueSimilarityTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('pentahologic.value_similarity.valueSimilarity_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runDataCompleteness()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM datacomp_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('pentahologic.data_completeness.dataCompleteness_home')->with(array(
      'results' => $results,
    ));
    }

    public function processDataCompleteness(Request $request)
    {
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $column = $request->column;
      $table = $request->table;
      $condition = $request->condition;
      if($tipe == "CSV"){
        $table = $this->importCsv($request->table,'table');

      }
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label= $request->label;
      $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);

      if(!$isDataExist) {
        Session::flash('error', 'Database Tidak Ditemukan');
        return redirect()->back();
      }
      
      if ($condition != "") {
        $condition = "WHERE ".$condition;
      }else{
        $condition = " ";
      }

      $filename = 'data_comp.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition
      ];

      requestToPentaho($queryParams);

      return redirect()->back();
    }

    public function viewDataCompleteness()
    {
        $id_running = $_GET['id'];
        $results = DataCompletenessTableResult::where('id_running', $id_running)->get();
        // $first_result = DataCompletenessTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = DataCompletenessTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('pentahologic.data_completeness.dataCompleteness_view')->with(array(
      'results' => $results,
      // 'first_result' => $first_result->clusteredby,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runDataDeduplication()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM data_deduplication_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('pentahologic.data_deduplication.dataDeduplication_home')->with(array(
      'results' => $results,
    ));
    }

    public function processDataDeduplication(Request $request)
    {
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
        $column1a = $request->column1a;
        $column1b = $request->column1b;
        $table1 = $request->table1;
        $column2a = $request->column2a;
        $column2b = $request->column2b;
        $table2 = $request->table2;
        if($tipe == "CSV"){
            $table1 = $this->importCsv($request->table1,'table1');
            $table2 = $this->importCsv($request->table2,'table2');

        }
        $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $isDataExist1a = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table1,$column1a,$tipe);
      $isDataExist1b = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table1,$column1b,$tipe);
      $isDataExist2a = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table2,$column2a,$tipe);
      $isDataExist2b = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table2,$column2b,$tipe);
        return view('pentahologic.data_deduplication.dataDeduplication_process')->with(array(
      'tipe' => $tipe,
      'column1a' => $column1a,
      'column1b' => $column1b,
      'table1' => $table1,
      'column2a' => $column2a,
      'column2b' => $column2b,
      'table2' => $table2,
      'done' => '1',
      'host' => $host,
      'db_name' => $db_name,
      'db_username' => $db_username,
      'db_password' => $db_password,
      'port' => $port,
      'isDataExist1a' =>  $isDataExist1a,
      'isDataExist2a' =>  $isDataExist2a,
      'isDataExist1b' =>  $isDataExist1b,
      'isDataExist2b' =>  $isDataExist2b,
      'label' => $label
    ));
    }

    public function viewDataDeduplication()
    {
        $id_running = $_GET['id'];
        $results = DataDeduplicationTableResult::where('id_running', $id_running)->get();
        $datasource_detail = DataDeduplicationTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('pentahologic.data_deduplication.dataDeduplication_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runShownull()
    {
      $results = ShownullTableResult::distinct('id_running')->groupBy('id_running')->orderByDesc('id_running')->get();

      return view('pentahologic.shownull.shownull_home')->with(array(
    'results' => $results,
  ));
  }

    public function processShownull(Request $request)
    {
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $column = $request->column;
      $table = $request->table;
      $condition = $request->condition;
      $companyColumn = $request->companyColumn;
      if($tipe == "CSV"){
        $table = $this->importCsv($request->table,'table');

      }
      if ($condition != "") {
        $condition = "WHERE ".$condition;
      }else{
        $condition = " ";
      }

      $label = $request->label;
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
        
      $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);
      if(!$isDataExist) {
        Session::flash('error', 'Database Tidak Ditemukan');
        return redirect()->back();
      }
      $filename = 'web_shownull - Copy.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition,
        'comp' => $companyColumn
      ];

      requestToPentaho($queryParams);

      return redirect()->back();
    }

    public function viewShownull()
    {
      //   $id_running = $_GET['id'];
      //   $results = ShownullTableResult::where('id_running', $id_running)->get();
      //   $first_result = ShownullTableResult::where('id_running', $id_running)->get()->first();
      //   $datasource_detail = ShownullTableResult::where('id_running', $id_running)->get()->first();
      //   $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
      //   $data = $this->jsonReader($first_result->data, 'data');

      //   return view('pentahologic.shownull.shownull_view')->with(array(
      // 'results' => $results,
      // 'first_result' => $first_result->filtered,
      // 'id_running' => $id_running,
      // 'column_detail' => $data,
      // 'datasource_detail' => $datasource_detail,
      $id_running = $_GET['id'];
      $results = ShownullTableResult::where('id_running', $id_running)->get();
      $datasource_detail = ShownullTableResult::where('id_running', $id_running)->get()->first();
      $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

      return view('pentahologic.shownull.shownull_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runClustering()
    {
      $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM clustering_result GROUP BY id_running ORDER BY id_running DESC'));

      return view('pentahologic.clustering.clustering_home')->with(array(
    'results' => $results,
    ));
    }

    public function processClustering(Request $request)
    {
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $column = $request->column;
      $table = $request->table;
      if($tipe == "CSV"){
        $table = $this->importCsv($request->table,'table');

      }
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);
      $condition = $request->condition;
    //     return view('pentahologic.clustering.clustering_process')->with(array(
    //   'tipe' => $tipe,
    //   'column' => $column,
    //   'table' => $table,
    //   'done' => '1',
    //   'host' => $host,
    //   'db_name' => $db_name,
    //   'db_username' => $db_username,
    //   'db_password' => $db_password,
    //   'port' => $port,
    //   'label' => $label,
    //   'isDataExist' => $isDataExist
    // ));
    if(!$isDataExist) {
      Session::flash('error', 'Database Tidak Ditemukan');
      return redirect()->back();
    }
    if ($condition != "") {
      $condition = "WHERE ".$condition;
    }else{
      $condition = " ";
    }
    $filename = 'web_clustering - Copy.ktr';
    $queryParams = [
      'trans' => env('LOCATION_PENTAHO') . $filename,
      'host' => $host,
      'db_name' => $db_name,
      'db_username' => $db_username,
      'port' => $port,
      'col' => $column,
      'tab' => $table,
      'cond' => $condition
    ];

    requestToPentaho($queryParams);

    return redirect()->back();
    }

    public function viewClustering()
    {
        $id_running = $_GET['id'];
        $results = ClusteringTableResult::where('id_running', $id_running)->get();
        $first_result = ClusteringTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = ClusteringTableResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('pentahologic.clustering.clustering_view')->with(array(
      'results' => $results,
      'first_result' => $first_result->clusteredby,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runOutlier()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM outlier_table_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('pentahologic.outlier.outlier_home')->with(array(
      'results' => $results,
    ));
    }

    public function processOutlier(Request $request)
    {
        $column1 = $request->column1;
        $column2 = $request->column2;
        $column3 = $request->column3;
        $table = $request->table;

        return view('pentahologic.outlier.outlier_process')->with(array(
      'column1' => $column1,
      'column2' => $column2,
      'column3' => $column3,
      'table' => $table,
      'done' => '1',
    ));
    }

    public function viewOutlier()
    {
        $id_running = $_GET['id'];
        $results = OutlierTableResult::where('id_running', $id_running)->get();

        return view('pentahologic.outlier.outlier_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
    ));
    }
}
