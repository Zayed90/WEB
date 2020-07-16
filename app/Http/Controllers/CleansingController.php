<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CleansingPatternResult;
use App\CleansingNullResult;
use App\CleansingDeduplicationResult;
use App\CleansingClusteringResult;
use App\DataDeduplicationTableResult;
use App\ClusteringTableResult;
use Illuminate\Support\Facades\Input;
use Config;

class CleansingController extends Controller
{

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

  public static function jsonReader($data, $column_name)
    {
        $data_decode = json_decode($data);
        $data_properties = get_object_vars($data_decode);
        $data_decode = $data_properties[$column_name][0];
        $data = json_decode(json_encode($data_decode), true);

        return $data;
    }

  public function stringToRegex($reg){
    $current;
$prev="";
$count=1;

$str = $reg;
$a = "";

$arr1 = str_split($str);
//echo count($arr1);
for ($x = 0; $x <count($arr1); $x++) {
  $current = $arr1[$x];

  if($prev==""){

     if($current=="A"){
        $a .= "[A-Za-z]";
        }else if($current=="9"){
        $a .= "\d";

          }else{
          $a.= "[".$arr1[$x]."]";
          }

  }else{

      if($current!=$prev){
          if($count!=1){
          $a .= "{".$count."}";
              }

         $count=1;

     if($current=="A"){
        $a .= "[A-Za-z]";
        }else if($current=="9"){
            $a .= "\d";

          }else{

          $a.= "[".$arr1[$x]."]";
          }

            }else{

            $count++;

            if($x+1==count($arr1)){
				$a .= "{".$count."}";

            }

            }

    }
  $prev = $current;

}
return $a;

  }


    public function runPatternCleansing()
    {
      $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM cleansing_pattern_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('cleansing.pattern.pattern_cleansing_home')->with(array(
      'results' => $results,
    ));
    }
    public function choosePattern(Request $request)
    {
        $username = Auth::user()->username;
        $tipe = $request->tipe_database;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));

      $column = $request->column;
      $table = $request->table;
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $datasource = '{"datasource_detail":[{"col":"'.$column.'","db_name":"database_temp","tab":"hai_tb_ereg_pattern","port":"3306","db_username":"root","host":"localhost"}]}';
      $results = DB::select(DB::raw("SELECT DISTINCT column_pattern FROM pattern_table_result WHERE datasource_detail = ?"),[$datasource]);
      $column_detail =  $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);

    // dd($column_detail);
      return view('cleansing.pattern.choose_pattern')->with(array(
      'column' => $column,
      'table'=>$table,
      'results'=>$results,
      'tipe'=> $tipe
      // 'host'=>$host,
      // 'db_name'=> $db_name,
      // 'db_username'=> $db_username,
      // 'db_password' =>$db_password,
      // 'port'=> $port
    ));
    }

    public function processPatternCleansing(Request $request){
      $username = Auth::user()->username;
        $tipe = $request->tipe;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
        $host = $results[0]->hostname;
        $db_name = $results[0]->db_name;
        $db_username = $results[0]->db_username;
        $db_password = $results[0]->db_password;
        $port = $results[0]->port;
        $regx = $request->pattern;
        $filter = $request->filter;
        $column = $request->column;
        $table = $request->table;
        $pattern = $this->stringToRegex($regx);
        return view('cleansing.pattern.pattern_cleansing_process')->with(array(
          'column' => $column,
          'table'=>$table,
          'results'=>$results,
          'tipe'=> $tipe,
          'host'=>$host,
          'db_name'=> $db_name,
          'db_username'=> $db_username,
          'db_password' =>$db_password,
          'port'=> $port,
          'pattern' =>$pattern,
          'filter'=>$filter
        ));


    }

    public function processPatternCleansingManual(Request $request){
      $username = Auth::user()->username;
      $tipe = $request->tipe;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $regx = $request->pattern;
      $filter = $request->filter;
      $column = $request->column;
      $table = $request->table;
      $pattern = $this->stringToRegex($regx);
      return view('cleansing.pattern.pattern_cleansing_perprocess')->with(array(
        'column' => $column,
        'table'=>$table,
        'results'=>$results,
        'tipe'=> $tipe,
        'host'=>$host,
        'db_name'=> $db_name,
        'db_username'=> $db_username,
        'db_password' =>$db_password,
        'port'=> $port,
        'pattern' =>$pattern,
        'filter'=>$filter
      ));

    }

    public function processPatternCleansingManualSub(Request $request){
      $username = Auth::user()->username;
      $tipe = 'mysql';
      $status;
      if($request->cleansed == "cleansed"){
        $status = 1;
      }else{
        $status = 0;

      }
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $regx = $request->pattern;
      $old_string = $request->old_string;
      $new_string = $request->new_string;
      $id_running =  $request->id_running;
      $table = $request->table;
      $column = $request->column;
      $table = $request->table;
      $pattern = $this->stringToRegex($regx);
      return view('cleansing.pattern.pattern_cleansing_process_sub')->with(array(
        'column' => $column,
        'table'=>$table,
        'results'=>$results,
        'tipe'=> $tipe,
        'host'=>$host,
        'db_name'=> $db_name,
        'db_username'=> $db_username,
        'db_password' =>$db_password,
        'port'=> $port,
        'pattern' =>$pattern,
        'status'=>$status,
        'old_string'=>$old_string,
        'new_string'=>$new_string,
        'id_running'=>$id_running
      ));

    }

    public function viewPattern()
    {
        $id_running = $_GET['id'];
        $results = CleansingPatternResult::where('id_running', $id_running)->get();
        $datasource_detail = CleansingPatternResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
        $pattern = CleansingPatternResult::distinct()->where('id_running',  $id_running)->get(['NOMOR_PATTERN_BARU']);
        //dd($pattern[0]->pattern_nie_all);
        return view('cleansing.pattern.pattern_cleansing_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'pattern' => $pattern,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runNullCleansing()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM tb_ereg_merk_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('cleansing.null.null_cleansing')->with(array(
      'results' => $results,
    ));
    }

    public function processNullCleansing(Request $request)
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
      $ref = $request->ref;
      $label = $request->label;
        $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);


        return view('cleansing.null.null_cleansing_process')->with(array(
      'tipe' => $tipe,
      'column' => $column,
      'table' => $table,
      'done' => '1',
      'host' => $host,
      'db_name' => $db_name,
      'db_username' => $db_username,
      'db_password' => $db_password,
      'port' => $port,
      'label' => $label,
      'ref'=>$ref,
      'isDataExist'=>$isDataExist
    ));
    }

    public function viewNull()
    {
        $id_running = $_GET['id'];
        $results = CleansingNullResult::where('id_running', $id_running)->get();
        $datasource_detail = CleansingNullResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
        return view('cleansing.null.null_cleansing_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function changePattern(){
      $id = $_GET['id'];
      $data = $_GET['data'];
      CleansingPatternResult::where('id', $id)->update(array('nomor_cleansed' => $data));

    }

    public function statusPattern(){
      $id = $_GET['id'];
      $data = $_GET['data'];
      $status;
      if($data=="Data Cleansed"){
        $status = 1;
      }else{
        $status = 0;
      }
      CleansingPatternResult::where('id', $id)->update(array('status' => $status));

    }

    //CAHYA

    public function viewDedup()
    {
        $id_running = $_GET['id'];
        $results = CleansingDeduplicationResult::where('id_running', $id_running)->get();
        $datasource_detail = CleansingDeduplicationResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
        $dedup = CleansingDeduplicationResult::distinct()->where('id_running',  $id_running)->get(['name']);
        //dd($pattern[0]->pattern_nie_all);
        return view('cleansing.dedup.dedup_cleansing_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'dedup' => $dedup,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function runDedupCleansing()
    {
      $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at, datasource_detail FROM cleansing_deduplication_result GROUP BY id_running ORDER BY id_running DESC'));
        return view('cleansing.dedup.dedup_cleansing_home')->with(array(
      'results' => $results,
    ));
    }

    public function chooseDedup(Request $request)
    {
        $username = Auth::user()->username;
        $tipe = $request->tipe_database;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));

      $id = $request->id;
      $id_running = $request->id_running;
      $column1 = $request->column1;
      $table1 = $request->table1;
      $column2 = $request->column2;
      $table2 = $request->table2;
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $datasource_detail = DataDeduplicationTableResult::where('id_running', 1)->get()->first();
      $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
      $datasource = '{"datasource_detail":[{"db_name":"database_temp","port":"3306","db_username":"root","col1b":"alamat","col1a":"'.$column1.'","col2b":"alamat","host":"localhost","col2a":"'.$column2.'","tab1":"'.$table1.'","tab2":"'.$table2.'"}]}';
      $results = DB::select(DB::raw("SELECT * FROM data_deduplication_table_result WHERE datasource_detail = ?"),[$datasource]);
      $column_detail =  $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table1,$column1,$tipe);

    // dd($column_detail);
      return view('cleansing.dedup.choose_dedup')->with(array(
      'id' => $id,
      'id_running' => $id_running,
      'column1' => $column1,
      'table1'=>$table1,
      'column2' => $column2,
      'table2'=>$table2,
      'results'=>$results,
      'tipe'=> $tipe,
      'datasource'=>$datasource,
      'datasource_detail'=>$datasource_detail
      // 'host'=>$host,
      // 'db_name'=> $db_name,
      // 'db_username'=> $db_username,
      // 'db_password' =>$db_password,
      // 'port'=> $port
    ));
    }

    public function runDedup(Request $request)
    {
        $username = Auth::user()->username;
        $tipe = $request->tipe_database;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));

      $id = $request->id;
      $id_running = $request->id_running;
      $column1 = $request->column1;
      $table1 = $request->table1;
      $column2 = $request->column2;
      $table2 = $request->table2;
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $datasource_detail = DataDeduplicationTableResult::where('id_running', 1)->get()->first();
      $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
      $datasource = '{"datasource_detail":[{"db_name":"database_temp","port":"3306","db_username":"root","col1b":"alamat","col1a":"'.$column1.'","col2b":"alamat","host":"localhost","col2a":"'.$column2.'","tab1":"'.$table1.'","tab2":"'.$table2.'"}]}';
      $results = DB::select(DB::raw("SELECT * FROM data_deduplication_table_result WHERE datasource_detail = ?"),[$datasource]);
      $column_detail =  $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table1,$column1,$tipe);

    // dd($column_detail);
      return view('cleansing.dedup.dedup_cleansing_process_manual')->with(array(
      'id' => $id,
      'id_running' => $id_running,
      'column1' => $column1,
      'table1'=>$table1,
      'column2' => $column2,
      'table2'=>$table2,
      'results'=>$results,
      'tipe'=> $tipe,
      'datasource'=>$datasource,
      'datasource_detail'=>$datasource_detail
      // 'host'=>$host,
      // 'db_name'=> $db_name,
      // 'db_username'=> $db_username,
      // 'db_password' =>$db_password,
      // 'port'=> $port
    ));
    }

    public function changeDedup(){
      $id = $_GET['id'];
      $data = $_GET['data'];
      DataDeduplicationTableResult::where('id', $id)->update(array('cleansed_value' => $data));
    }

    public function statusDedup(){
      $id = $_GET['id'];
      $data = $_GET['data'];
      $status;
      if($data=="Data Cleansed"){
        $status = 1;
      }else{
        $status = 0;
      }
      DataDeduplicationTableResult::where('id', $id)->update(array('status' => $status));
    }



    public function processDedupCleansing(Request $request){
      $username = Auth::user()->username;
        $tipe = $request->tipe;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
        $host = $results[0]->hostname;
        $db_name = $results[0]->db_name;
        $db_username = $results[0]->db_username;
        $db_password = $results[0]->db_password;
        $port = $results[0]->port;
        $column1 = $request->column1;
        $table1 = $request->table1;
        $column2 = $request->column2;
        $table2 = $request->table2;
        return view('cleansing.dedup.dedup_cleansing_process')->with(array(
          'results'=>$results,
          'host'=>$host,
          'db_name'=> $db_name,
          'db_username'=> $db_username,
          'db_password' =>$db_password,
          'tipe'=> $tipe,
          'column1' => $column1,
          'table1'=>$table1,
          'column2' => $column2,
          'table2'=>$table2
        ));


    }

    public function processDedupCleansingManual(Request $request){
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $column1 = $request->column1;
      $table1 = $request->table1;
      $column2 = $request->column2;
      $table2 = $request->table2;
      return view('cleansing.dedup.dedup_cleansing_manual')->with(array(
        'results'=>$results,
        'host'=>$host,
        'db_name'=> $db_name,
        'db_username'=> $db_username,
        'db_password' =>$db_password,
        'tipe'=> $tipe,
        'port'=> $port,
        'column1' => $column1,
        'table1'=>$table1,
        'column2' => $column2,
        'table2'=>$table2
      ));
    }

    public function runClusteringCleansing()
    {
      $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM cleansing_clustering_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('cleansing.clustering.clustering_cleansing_home')->with(array(
      'results' => $results,
    ));
    }

    public function chooseClustering(Request $request)
    {
        $username = Auth::user()->username;
        $tipe = $request->tipe_database;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));

      $id = $request->id;
      $id_running = $request->id_running;
      $column = $request->column;
      $table = $request->table;
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $label = $request->label;
      $datasource_detail = ClusteringTableResult::where('id_running', 1)->get()->first();
      $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
      $datasource = '{"datasource_detail":[{"col":"'.$column.'","db_name":"database_temp","tab":"'.$table.'","port":"3306","db_username":"root","host":"localhost"}]}';
      $results = DB::select(DB::raw("SELECT * FROM clustering_table_result WHERE datasource_detail = ?"),[$datasource]);
      $column_detail =  $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe);

    // dd($column_detail);
      return view('cleansing.clustering.choose_clustering')->with(array(
      'id' => $id,
      'id_running' => $id_running,
      'column' => $column,
      'table'=>$table,
      'results'=>$results,
      'tipe'=> $tipe,
      'datasource'=>$datasource,
      'datasource_detail'=>$datasource_detail
      // 'host'=>$host,
      // 'db_name'=> $db_name,
      // 'db_username'=> $db_username,
      // 'db_password' =>$db_password,
      // 'port'=> $port
    ));
    }

    public function processClusteringCleansing(Request $request){
      $username = Auth::user()->username;
        $tipe = $request->tipe;
        $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
        $host = $results[0]->hostname;
        $db_name = $results[0]->db_name;
        $db_username = $results[0]->db_username;
        $db_password = $results[0]->db_password;
        $port = $results[0]->port;
        $column = $request->column;
        $table = $request->table;
        return view('cleansing.clustering.clustering_cleansing_process')->with(array(
          'results'=>$results,
          'host'=>$host,
          'db_name'=> $db_name,
          'db_username'=> $db_username,
          'db_password' =>$db_password,
          'tipe'=> $tipe,
          'column' => $column,
          'table'=>$table,
        ));
    }

    public function viewClustering()
    {
        $id_running = $_GET['id'];
        $results = CleansingClusteringResult::where('id_running', $id_running)->get();
        $datasource_detail = CleansingClusteringResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');
        $clustering = CleansingClusteringResult::distinct()->where('id_running',  $id_running)->get(['name']);
        return view('cleansing.clustering.clustering_cleansing_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'clustering' => $clustering,
      'datasource_detail' => $datasource_detail,
    ));
    }

    public function processClusteringCleansingManual(Request $request){
      $username = Auth::user()->username;
      $tipe = $request->tipe_database;
      $results = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
      $host = $results[0]->hostname;
      $db_name = $results[0]->db_name;
      $db_username = $results[0]->db_username;
      $db_password = $results[0]->db_password;
      $port = $results[0]->port;
      $column1 = $request->column1;
      $table1 = $request->table1;
      $column2 = $request->column2;
      $table2 = $request->table2;
      return view('cleansing.clustering.clustering_cleansing_manual')->with(array(
        'results'=>$results,
        'host'=>$host,
        'db_name'=> $db_name,
        'db_username'=> $db_username,
        'db_password' =>$db_password,
        'tipe'=> $tipe,
        'port'=> $port,
        'column1' => $column1,
        'table1'=>$table1,
        'column2' => $column2,
        'table2'=>$table2
      ));
    }

    public function changeClustering(){
      $id = $_GET['id'];
      $data = $_GET['data'];
      ClusteringTableResult::where('id', $id)->update(array('cleansed_value' => $data));
    }

    public function statusClustering(){
      $id = $_GET['id'];
      $data = $_GET['data'];
      $status;
      if($data=="Data Cleansed"){
        $status = 1;
      }else{
        $status = 0;
      }
      ClusteringTableResult::where('id', $id)->update(array('status' => $status));
    }

}
