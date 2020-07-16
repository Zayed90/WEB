<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\PunctuationResult;
use App\UppercaseResult;
use App\WhitespaceResult;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Zttp\Zttp;


class CleansingMDM extends Controller
{
    public static function jsonReader($data, $column_name)
    {
        $data_decode = json_decode($data);
        $data_properties = get_object_vars($data_decode);
        $data_decode = $data_properties[$column_name][0];
        $data = json_decode(json_encode($data_decode), true);

        return $data;
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


    public function index(){
        return view('cleansing_mdm.index');
    }

    // punctuation functions
    public function punctuation_index()
    {
         $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM punctuation_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('cleansing_mdm.punctuation.punctuation_home')->with(array('results' => $results,));
    }

    public function processPunctuation(Request $request)
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
      $pkey = $request->pkey;
      $condition = $request->condition;
      $isDataExist = $this->isDataExist($host,$port,$db_username,$db_password,$db_name,$table,$column,$tipe,$pkey);
      if(!$isDataExist) {
        Session::flash('error', 'Database Tidak Ditemukan');
        return redirect()->back();
      }
      if ($condition != "") {
        $condition = "WHERE ".$condition;
      }else{
        $condition = " ";
      }
      $update_query = 'UPDATE '.$table.' SET '.$column.' = "nama_perusahaan" WHERE '.$pkey.' = id_company ;';
      
      $filename = 'punctuation.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO_CLEANSING_MDM') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition,
        'pkey' => $pkey,
        'update_query' => $update_query
      ];

      ini_set('max_execution_time', 600);
      set_time_limit(0);
      requestToPentaho($queryParams);

      
      // dd($queryParams);
      return redirect()->back();
    }

    public function viewPunctuation()
    {
        $id_running = $_GET['id'];
        $results = PunctuationResult::where('id_running', $id_running)->get();
        $datasource_detail = PunctuationResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('cleansing_mdm.punctuation.punctuation_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }
    //uppercase functions
    public function uppercase_index()
    {
         $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM uppercase_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('cleansing_mdm.uppercase.uppercase_home')->with(array('results' => $results,));
    }

    public function processUppercase(Request $request)
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
      $pkey = $request->pkey;
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
      $update_query = 'UPDATE '.$table.' SET '.$column.' = "nama_perusahaan" WHERE '.$pkey.' = id_company ;';
      $filename = 'uppercase.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO_CLEANSING_MDM') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition,
        'pkey' => $pkey,
        'update_query' => $update_query
      ];
    // dd($queryParams);
      ini_set('max_execution_time', 600);
      set_time_limit(0);
      requestToPentaho($queryParams);

      return redirect()->back();
    }

    public function viewUppercase()
    {
        $id_running = $_GET['id'];
        $results = UppercaseResult::where('id_running', $id_running)->get();
        $datasource_detail = UppercaseResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        // dd($datasource_detail);
        return view('cleansing_mdm.uppercase.uppercase_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail
    ));
    }

    //whitespace functions
    public function whitespace_index()
    {
        $results = DB::select(DB::raw('SELECT DISTINCT id_running AS id_running, created_at FROM whitespace_result GROUP BY id_running ORDER BY id_running DESC'));

        return view('cleansing_mdm.whitespace.whitespace_home')->with(array('results' => $results,));
    }
    
    public function processWhitespace(Request $request)
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
      $pkey = $request->pkey;
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
      $update_query = 'UPDATE '.$table.' SET '.$column.' = "nama_perusahaan" WHERE '.$pkey.' = id_company ;';
      $filename = 'whitespace.ktr';
      $queryParams = [
        'trans' => env('LOCATION_PENTAHO_CLEANSING_MDM') . $filename,
        'host' => $host,
        'db_name' => $db_name,
        'db_username' => $db_username,
        'port' => $port,
        'col' => $column,
        'tab' => $table,
        'cond' => $condition,
        'pkey' => $pkey,
        'update_query' => $update_query
      ];
    // dd($queryParams);
      ini_set('max_execution_time', 600);
      set_time_limit(0);
      requestToPentaho($queryParams);

      return redirect()->back();
    }

    public function viewWhitespace()
    {
        $id_running = $_GET['id'];
        $results = WhitespaceResult::where('id_running', $id_running)->get();
        $datasource_detail = WhitespaceResult::where('id_running', $id_running)->get()->first();
        $datasource_detail = $this->jsonReader($datasource_detail->datasource_detail, 'datasource_detail');

        return view('cleansing_mdm.whitespace.whitespace_view')->with(array(
      'results' => $results,
      'id_running' => $id_running,
      'datasource_detail' => $datasource_detail,
    ));
    }

}
