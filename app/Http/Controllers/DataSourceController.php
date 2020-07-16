<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataSource;
use App\EregMTrader;
use App\EregMPabrik;
use App\CardinalitiesTableResult;
use App\PatternTableResult;
use App\ValueDistributionTableResult;
use App\ValueSimilarityTableResult;
use App\DataCompletenessTableResult;
use App\DataDeduplicationTableResult;
use App\ShownullTableResult;
use App\ClusteringTableResult;
use Config;

class DataSourceController extends Controller
{

  public function index()
  {
    //
    $data = DataSource::all();
    return view('listdataSource')->with(array(
      'data' => $data
    ));;
  }

  public function sourceView($data_name){
    // return $data_name;
    if($data_name == 'ereg_m_trader'){
      $results = EregMTrader::all();
      $table_name = 'Ereg_M_Trader';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'ereg_m_pabrik') {
      $results = EregMPabrik::all();
      $table_name = 'Ereg_M_Pabrik';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'cardinalities_table_result') {
      $results = CardinalitiesTableResult::all();
      $table_name = 'Cardinalities_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'pattern_table_result') {
      $results = PatternTableResult::all();
      $table_name = 'pattern_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'val_distribution_table_result') {
      $results = ValueDistributionTableResult::all();
      $table_name = 'val_distribution_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'val_similarity_table_result') {
      $results = ValueSimilarityTableResult::all();
      $table_name = 'val_similarity_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'data_completeness_table_result') {
      $results = DataCompletenessTableResult::all();
      $table_name = 'data_completeness_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'data_deduplication_table_result') {
      $results = DataDeduplicationTableResult::all();
      $table_name = 'data_deduplication_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'shownull_table_result') {
      $results = ShownullTableResult::all();
      $table_name = 'shownull_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }elseif ($data_name == 'clustering_table_result') {
      $results = ClusteringTableResult::all();
      $table_name = 'clustering_table_result';
      $column_detail = DB::getSchemaBuilder()->getColumnListing($data_name);
      return view('source/sourceView')->with(array(
        'results' => $results,
        'table_name' => $table_name,
        'column_detail' => $column_detail
      ));;
    }else {
      return redirect('/');
    }
  }

  public function externalSourceView(Request $request){

    $host = $request->host;
    $username = $request->db_username;
    $password = $request->db_password;
    $database = $request->db_name;
    $table = $request->tab;
    $port = $request->port;

    Config::set('database.connections.external_mysql.host', $host);
    Config::set('database.connections.external_mysql.port', $port);
    Config::set('database.connections.external_mysql.username', $username);
    Config::set('database.connections.external_mysql.password', $password);
    Config::set('database.connections.external_mysql.database', $database);

    // DB::connection('external_mysql')->select ;
    $column_detail = DB::connection('external_mysql')->getSchemaBuilder()->getColumnListing($table);
    $results = DB::connection('external_mysql')->select(DB::raw("SELECT * FROM $table"));
    return view('source/externalSourceView')->with(array(
      'results' => $results,
      'column_detail' => $column_detail,
      'host' => $host,
      'username' => $username,
      'database' => $database,
      'port' => $port,
      'table' => $table
    ));;

    // echo "<pre>";
    // print_r($results);
    // echo "</pre>";


    //If you want to use query builder without having to specify the connection
    // Config::set('database.default', 'external_mysql');
    // EXAMPLE USING CONNECTION $users = DB::connection($connectionConfig)->select(...);
    // DB::reconnect('external_mysql');

    // dd(\DB::connection('external_mysql'));
    // dd(\DB::connection());s

    // return 'GOOD';


  }

}
