<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\MultiProccess;

class MultiProccessController extends Controller
{

  public static function jsonReader($data, $column_name)
  {
      $data_decode = json_decode($data);
      $data_properties = get_object_vars($data_decode);
      $data = $data_properties['data'];
      // $data_decode = $data_properties[$column_name][0];
      // $data = json_decode(json_encode($data_decode), true);

      return $data;
  }
    
    public function index(){
       // return view('multiproccess.homeMultiProccess');

        $results = DB::select(DB::raw('SELECT DISTINCT id AS id, created_at FROM multi_proccess_result GROUP BY id ORDER BY id DESC'));

        return view('multiproccess.homeMultiProccess')->with(array(
      'results' => $results,
    ));
        

    }
    public function proccess(Request $request){
        $username = Auth::user()->username;
        $tipe = $request->tipe_database;
        $res = DB::select(DB::raw("SELECT  * FROM database_settings WHERE id_user = (SELECT id FROM logins WHERE username = '$username') AND db_type='$tipe'"));
        $column = $request->column;
        $table = $request->table;
        $host = $res[0]->hostname;
        $db_name = $res[0]->db_name;
        $db_username = $res[0]->db_username;
        $db_password = $res[0]->db_password;
        $port = $res[0]->port;

        $exec = 'E:\KULIAH\Semester7\Newfolder\ppd\data-integration\pan.bat /file:"E:\KULIAH\Semester7\Newfolder\ppd\data-integration\web_'.$tipe.'\web_clustering.ktr" /param:"col='.$column.'" /param:"tab='.$table.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'"';
        shell_exec($exec);
        $results = DB::statement(DB::raw('DROP TABLE IF EXISTS tempo_tbl'));
        $create = DB::statement(DB::raw('CREATE TABLE tempo_tbl AS SELECT * FROM clustering_table_result WHERE id_running = (SELECT max(id_running) from clustering_table_result)'));
        $select =  DB::select(DB::raw('SHOW COLUMNS FROM tempo_tbl;'));
        $table2 = "tempo_tbl";
        $column2 = $select[2]->Field;
        $exec = 'E:\KULIAH\Semester7\Newfolder\ppd\data-integration\pan.bat /file:"E:\KULIAH\Semester7\Newfolder\ppd\data-integration\web_'.$tipe.'\web_val_distribution.ktr" /param:"col='.$column2.'" /param:"tab='.$table2.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'"';
        shell_exec($exec);

        
        

        $result_clustering = DB::select(DB::raw("SELECT MAX(id_running) as id_running, created_at FROM clustering_table_result"));
        $result_val = DB::select(DB::raw('SELECT MAX(id_running) as id_running, created_at FROM val_distribution_table_result'));

        $from = array("id_running"=>$result_clustering[0]->id_running
              ,"proccess"=>$request->first_step
              ,"created_at"=>$result_clustering[0]->created_at);

        $to = array("id_running"=>$result_val[0]->id_running
              ,"proccess"=>$request->second_step
              ,"created_at"=>$result_val[0]->created_at);
        $proccess = array($from,$to);
        $p = array("data"=>$proccess);
        $data = json_encode($p);
        $save = new MultiProccess;
        $save->proc_data = $data;
        $save->save();

        // dd($to);
        

       // return redirect('multiproccess');
        //return view('multiproccess.homeMultiProccess');

    }
    public function viewResult(){
        $id_running = $_GET['id'];
        $results = MultiProccess::where('id', $id_running)->get();
        //$datasource_detail = MultiProccess::where('id', $id_running)->get();
        $data = $this->jsonReader($results[0]->proc_data, 'proc_data');
        $link[0] = "http://localhost:8000/pentaho/clustering/view?id=".strval($data[0]->id_running);
        $link[1] = "http://localhost:8000/pentaho/valueDistribution/view?id=".strval($data[1]->id_running);
        return view('multiproccess.multiproccessView')->with(array(
          'results' => $results,
          'id_running' => $id_running,
          'data' => $data,
          'link'=> $link,
          
        ));


    }

}
