<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Config;
use App\DatabaseConnection;

class DatabaseConnectionController extends Controller
{
    private $x;
    public function isMysqlExist($host,$port,$db_username,$db_password,$db_name){
        Config::set('database.connections.external_mysql.host', $host);
        Config::set('database.connections.external_mysql.port', $port);
        Config::set('database.connections.external_mysql.username', $db_username);
        Config::set('database.connections.external_mysql.password', $db_password);
        Config::set('database.connections.external_mysql.database', $db_name);
        try{
        $column_detail = DB::connection('external_mysql')->getPdo();
        $isDataExist = true;
    }catch(\Exception $e){
        $isDataExist = false;

    }
        return $isDataExist;
      }
    
      public function isPgsqlExist($host,$port,$db_username,$db_password,$db_name){
        Config::set('database.connections.external_pgsql.host', $host);
        Config::set('database.connections.external_pgsql.port', $port);
        Config::set('database.connections.external_pgsql.username', $db_username);
        Config::set('database.connections.external_pgsql.password', $db_password);
        Config::set('database.connections.external_pgsql.database', $db_name);
        try{
        $column_detail = DB::connection('external_pgsql')->getPdo();
        $isDataExist = true;
    }catch(\Exception $e){
        $isDataExist = false;

    }
        return $isDataExist;
      }
      

    public function index(Request $request)
    {
        $username = Auth::user()->username;
        $results_mysql = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='mysql'"));
        $results_postgre = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='postgre'"));
        
       // $hostname_mysql = $results_mysql->hostname;
        
        //echo $results_mysql[0]->hostname;
        //dd($results_mysql);
        //dd($results);
        //echo $results[0]->port;
        //return view('databaseSettings');
        $mysqlConnect = true;
        $pgsqlConnect = true;
          
          
        return view('databaseSettings')->with(array(
            'results_postgre' => $results_postgre,
            'results_mysql' => $results_mysql,
            'pgsqlConnect' => $pgsqlConnect,
            'mysqlConnect' => $mysqlConnect,
          ));
        //   $request->session()->put('pgsqlConnect', true);
        //   $request->session()->put('mysqlConnect', true);
    }
    public function update(Request $req){
        $hostname_mysql = $req->host_mysql;
        $port_mysql = $req->port_mysql;
        $db_name_mysql = $req->db_name_mysql;
        $db_username_mysql = $req->db_username_mysql;
        $db_password_mysql = $req->db_password_mysql;

        $hostname_postgre = $req->host_postgre;
        $port_postgre = $req->port_postgre;
        $db_name_postgre = $req->db_name_postgre;
        $db_username_postgre = $req->db_username_postgre;
        $db_password_postgre = $req->db_password_postgre;

                
        $isMysqlExist = $this->isMysqlExist($hostname_mysql,$port_mysql,$db_username_mysql,$db_password_mysql,$db_name_mysql);
        if($isMysqlExist){
        DatabaseConnection::where('db_type', '=', 'mysql')->update(array('hostname' => $hostname_mysql,
                                                                        'port'=>$port_mysql,
                                                                        'db_name'=>$db_name_mysql,
                                                                        'db_username'=>$db_username_mysql,
                                                                        'db_password'=>$db_password_mysql,));
        }else{
            $req->session()->put('mysqlConnect', false);
        }

        $isPgsqlExist = $this->isPgsqlExist($hostname_postgre,$port_postgre,$db_username_postgre,$db_password_postgre,$db_name_postgre);
        if($isPgsqlExist){
        DatabaseConnection::where('db_type', '=', 'postgre')->update(array('hostname' => $hostname_postgre,
                                                                        'port'=>$port_postgre,
                                                                        'db_name'=>$db_name_postgre,
                                                                        'db_username'=>$db_username_postgre,
                                                                        'db_password'=>$db_password_postgre,));
        }else{
            $req->session()->put('pgsqlConnect', false);
        }
        
        return redirect()->route('database');


    }

}
