<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ImportDataController extends Controller
{
    public function index()
    {
        $id = 0;

        return view('import.importData')->with(['id' => $id]);
    }

    public function showImportData()
    {
        $sql = "SELECT TABLE_NAME as table_name, CREATE_time as create_time FROM information_schema.tables WHERE table_schema ='database_import'";
        // echo $sql.'<br /><br />';
        $res = DB::connection('import_mysql')->select($sql);

        // dd($res);
        return view('import.showImport')->with(array(
            'res' => $res,
          ));
    }

    public function showImportDetail(String $name)
    {
        $sql = 'SELECT * from '.$name;
        $column_detail = DB::connection('import_mysql')->getSchemaBuilder()->getColumnListing($name);
        $result = DB::connection('import_mysql')->select($sql);
        // dd($res);
        return view('import.importDetail')->with(array(
            'name' => $name,
            'column_detail' => $column_detail,
            'results' => $result,
          ));
    }

    public function importCsv(Request $request)
    {
        $namafile = $request->host->getClientOriginalName();
        $file = Input::file('host');
        $namafile = explode('.', $namafile);
        $table = $namafile[0];
        $table = str_replace(' ', '_', $table);
        echo $table;

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
            echo "Cannot read from csv $file";
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
        // echo $sql.'<br /><br />';
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
        $id = 1;
        // return view('import.importData');
        return redirect()->route('import')->with(['id' => $id]);
    }
}
