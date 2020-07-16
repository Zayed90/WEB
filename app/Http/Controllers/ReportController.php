<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 5/16/2019
 * Time: 11:43 PM
 */

namespace App\Http\Controllers;
use App\ClusteringTableResult;
use App\DataCompletenessTableResult;
use App\ShownullTableResult;
use App\ValueDistributionTableResult;
// SIL
use App\ValueSimilarityTableResult;
use App\DataDeduplicationTableResult;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use JavaScript;
use App\PatternTableResult;
use App\Http\Controllers\ProfilingScoringController;


class ReportController
{
    public static function jsonReader($data, $column_name)
    {
        $data_decode = json_decode($data);
        $data_properties = get_object_vars($data_decode);
        $data_decode = $data_properties[$column_name][0];
        $data = json_decode(json_encode($data_decode), true);

        return $data;
    }
    public static function countryPatternCheck(){
        $countrypattern=DB::table('pattern_table_result')
            ->select(DB::raw("distinct column_pattern as column_pattern"),"total_each_pattern")
            ->whereRaw("(substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7))='negara_id'")
            ->get();
        $postalcodepattern=DB::table('pattern_table_result')
            ->select(DB::raw("distinct column_pattern as column_pattern"),"total_each_pattern")
            ->whereRaw("(substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7))='kodepos'")
            ->get();

        $countrypass=0;
        $countryfail=0;
        $countryrows=0;
        $postalcodepass=0;
        $postalcodefail=0;
        $postalcoderows=0;

        foreach ($countrypattern as $row){
            if($row->column_pattern=='XX'){
                $countrypass+=$row->total_each_pattern;
                $countryrows+=$row->total_each_pattern;
            }else{
                $countryfail+=$row->total_each_pattern;
                $countryrows+=$row->total_each_pattern;
            }
        }

        foreach ($postalcodepattern as $row){
            if($row->column_pattern=='99999'){
                $postalcodepass+=$row->total_each_pattern;
                $postalcoderows+=$row->total_each_pattern;
            }else{
                $postalcodefail+=$row->total_each_pattern;
                $postalcoderows+=$row->total_each_pattern;
            }
        }
        $patternformat=[["FORMAT TYPE","MATCH","NOT MATCH"],["COUNTRY ID FORMAT",($countrypass/$countryrows)*100,($countryfail/$countryrows)*100],["POSTAL CODE FORMAT",($postalcodepass/$postalcoderows)*100,($postalcodefail/$postalcoderows)*100]];
        JavaScript::put([
            'patternformat'=>$patternformat,
            'a'=>$postalcodepattern
        ]);
        return $patternformat;

    }
    public function getPatternData(){
        $patternmonitor = DB::table("pattern_table_result")
            ->select("id_running",DB::raw("COUNT(id) as jumlah_pattern"),
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->groupBy(DB::raw("id_running"))
            ->get();
        return $patternmonitor;
    }
    public function getMostPattern(){
        $this->countryPatternCheck();
        $mostpattern = DB::table("pattern_table_result")
            ->select(
                DB::raw("CONCAT(\"ID RUNNING : \",id_running,\" - KOLOM : \",substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7),\" - TABEL : \",substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7),\" - DATABASE : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),\" - PATTERN : \",IFNULL(column_pattern,'NULL PATTERN')) as data"),
                DB::raw("max(total_each_pattern) AS jumlah_record"))
            ->groupBy("id_running")
            ->get();
        $mostpatternchart=array(["DETAIL","JUMLAH RECORD"]);
        foreach ($mostpattern as $row){
            $mostpatternchart[]=[$row->data,$row->jumlah_record];
        }
        return $mostpatternchart;
    }
    public function patternReport(){
        $allpattern=$this->getPatternData();
        $mostpatternchart=$this->getMostPattern();
        $score = ProfilingScoringController::patternScoring();
        $patterndata=DB::table('pattern_table_result')
            ->select(
                "id_running",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"),
                DB::raw("COUNT(id) as jumlah_pattern")
            )
            ->groupBy('id_running')->orderBy('jumlah_pattern','desc')
            ->get();

        $data=json_decode($patterndata);
        $e=count($data);
        $mostpattern=[$patterndata[0]->id_running,$patterndata[0]->kolom,$patterndata[0]->tabel,$patterndata[0]->tanggal,$patterndata[0]->jumlah_pattern];
        $leastpattern=[$patterndata[$e-1]->id_running,$patterndata[$e-1]->kolom,$patterndata[$e-1]->tabel,$patterndata[$e-1]->tanggal,$patterndata[$e-1]->jumlah_pattern];

        JavaScript::put([
            'testname'=>'reza',
            'mostpattern'=>$mostpattern,
            'leastpattern'=>$leastpattern,
            'mostpatternchart' =>$mostpatternchart
        ]);
        $id_most =$mostpattern[0];
        $id_least =$leastpattern[0];

        $resultsmost = PatternTableResult::where('id_running', $id_most)->get();
        $datasource_most = PatternTableResult::where('id_running', $id_most)->get()->first();
        $desc_most = $this->jsonReader($datasource_most->datasource_detail, 'datasource_detail');

        $resultsleast = PatternTableResult::where('id_running', $id_least)->get();
        $datasource_least = PatternTableResult::where('id_running', $id_least)->get()->first();
        $desc_least = $this->jsonReader($datasource_least->datasource_detail, 'datasource_detail');

        return view('monitoring.patternReport')->with(array(
            'mostpattern' => $mostpattern[4],
            'resultsmost' => $resultsmost,
            'id_running_most' => $id_most,
            'datasource_most' => $desc_most,
            'leastpattern' => $leastpattern[4],
            'resultsleast' => $resultsleast,
            'id_running_least' => $id_least,
            'datasource_least' => $desc_least,
            'allpattern' => $allpattern,
            'patternscore' => $score,
        ));
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
            // dd($nullmonitor);
        return $nullmonitor;
    }
    public function nullReport(){
        $allnulldata=$this->getNullData();
        $nulldata=DB::table('shownull_table_result')
            ->select(
                "id_running",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"),
                DB::raw("COUNT(id) as jumlah_null")
            )
            ->groupBy('id_running')->orderBy('jumlah_null','desc')
            ->get();
        $shownulldata = DB::table("shownull_table_result")
            ->select(
                DB::raw("CONCAT(\"ID RUNNING : \",id_running,\" - KOLOM : \",substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7),\" - TABEL : \",substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7),\" - DATABASE : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11)) as data"),
                DB::raw("COUNT(id) as jumlah_null")
            )
            ->groupBy(DB::raw("id_running"))
            ->get();
        $shownullfail = DB::table("shownull_table_result")
            ->select(
                DB::raw("COUNT(id) as jumlah_null")
            )
            ->get();
        $nulltable = DB::table("shownull_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel")
            )
            ->groupBy("id_running")
            ->get();
        $alltrader = DB::table("ereg_m_trader")
            ->select(DB::raw("COUNT(id) as jumlah_trader"))->get();
        $allpabrik = DB::table("ereg_m_pabrik")
            ->select(DB::raw("COUNT(id) as jumlah_pabrik"))->get();
        $shownulldatachart=array(['DETAIL SOURCE','JUMLAH NULL']);
        foreach ($shownulldata as $row){
            $shownulldatachart[]=[$row->data,$row->jumlah_null];
        }
        foreach ($shownullfail as $row){
            $nullfail=$row->jumlah_null;
        }
        $counttrader=0;
        $countpabrik=0;
        $allrecord=0;
        foreach ($alltrader as $row){
            $counttrader=$row->jumlah_trader;
        }
        foreach ($allpabrik as $row){
            $countpabrik=$row->jumlah_pabrik;
        }
        foreach ($nulltable as $row){
            if ($row=="ereg_m_trader"){
                $allrecord+=$counttrader;
            }else{
                $allrecord+=$countpabrik;
            }
        }
        $data=json_decode($nulldata);
        $e=count($data);
        $mostnull=[$nulldata[0]->id_running,$nulldata[0]->kolom,$nulldata[0]->tabel,$nulldata[0]->tanggal,$nulldata[0]->jumlah_null];
        $leastnull=[$nulldata[$e-1]->id_running,$nulldata[$e-1]->kolom,$nulldata[$e-1]->tabel,$nulldata[$e-1]->tanggal,$nulldata[$e-1]->jumlah_null];
        JavaScript::put([
            'testname'=>'reza',
            'mostnull'=>$mostnull,
            'leastnull'=>$leastnull,
            'nullfail'=>$shownullfail,
            'shownulldatachart'=>$shownulldatachart
        ]);
        $id_most =$mostnull[0];
        $id_least =$leastnull[0];

        $resultsmost = ShownullTableResult::where('id_running', $id_most)->get();
        $first_result_most = ShownullTableResult::where('id_running', $id_most)->get()->first();
        $datasource_detail_most = ShownullTableResult::where('id_running', $id_most)->get()->first();
        $datasource_detail_most = $this->jsonReader($datasource_detail_most->datasource_detail, 'datasource_detail');
        $data_most = $this->jsonReader($first_result_most->data, 'data');
        $resultsleast = ShownullTableResult::where('id_running', $id_least)->get();
        $first_result_least = ShownullTableResult::where('id_running', $id_least)->get()->first();
        $datasource_detail_least = ShownullTableResult::where('id_running', $id_least)->get()->first();
        $datasource_detail_least = $this->jsonReader($datasource_detail_least->datasource_detail, 'datasource_detail');
        $data_least = $this->jsonReader($first_result_least->data, 'data');

        return view('monitoring.nullReport')->with(array(
            'mostnull' => $mostnull[4],
            'resultsmost' => $resultsmost,
            'first_result_most' => $first_result_most->filtered,
            'id_running_most' => $id_most,
            'column_detail_most' => $data_most,
            'datasource_most' => $datasource_detail_most,

            'leastnull' => $leastnull[4],
            'resultsleast' => $resultsleast,
            'first_result_least' => $first_result_least->filtered,
            'id_running_least' => $id_least,
            'column_detail_least' => $data_least,
            'datasource_least' => $datasource_detail_least,

            'allnulldata'=>$allnulldata,
            'nullfail'=>$nullfail,
            'nullsuccess'=>$allrecord-$nullfail,
            'allrecord'=>$allrecord
        ));
    }

    public function getMostNull(){
        $mostnull = DB::table("pattern_table_result")
            ->select(
                DB::raw("CONCAT(\"ID RUNNING : \",id_running,\" - KOLOM : \",substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7),\" - TABEL : \",substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7),\" - DATABASE : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),\" - PATTERN : \",IFNULL(column_pattern,'NULL PATTERN')) as data"),
                DB::raw("max(total_each_pattern) AS jumlah_record"))
            ->groupBy("id_running")
            ->get();
        $mostpatternchart=array(["DETAIL","JUMLAH RECORD"]);
        foreach ($mostnull as $row){
            $mostnullchart[]=[$row->data,$row->jumlah_record];
        }
        return $mostnullchart;
    }

    public function clusteringReport(){
        $countcluster=$this->getCountCluster();
        $a=$this->clusteringReportJson();
        $allcluster=$this->getClusterData();
        $clusterdata=DB::table('clustering_table_result')
            ->select(
                "id_running",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"),
                DB::raw("COUNT(id) as jumlah_cluster")
            )
            ->groupBy('id_running')->orderBy('jumlah_cluster','desc')
            ->get();

        $data=json_decode($clusterdata);
        $e=count($data);
        $mostcluster=[$clusterdata[0]->id_running,$clusterdata[0]->kolom,$clusterdata[0]->tabel,$clusterdata[0]->tanggal,$clusterdata[0]->jumlah_cluster];
        $leastcluster=[$clusterdata[$e-1]->id_running,$clusterdata[$e-1]->kolom,$clusterdata[$e-1]->tabel,$clusterdata[$e-1]->tanggal,$clusterdata[$e-1]->jumlah_cluster];

        $id_most =$mostcluster[0];
        $id_least =$leastcluster[0];

        $resultsmost = ClusteringTableResult::where('id_running', $id_most)->get();
        $datasource_most = ClusteringTableResult::where('id_running', $id_most)->get()->first();
        $desc_most = $this->jsonReader($datasource_most->datasource_detail, 'datasource_detail');

        $resultsleast = ClusteringTableResult::where('id_running', $id_least)->get();
        $datasource_least = ClusteringTableResult::where('id_running', $id_least)->get()->first();
        $desc_least = $this->jsonReader($datasource_least->datasource_detail, 'datasource_detail');

        $z=0;
        $y=100;
        for($i=1;$i<count($a);$i++){
            if($a[$i][2]>$z){
                $z=round($a[$i][2],2);
            }
        }
        for($i=1;$i<count($a);$i++){
            if($a[$i][2]<=$y){
                $y=round($a[$i][2],2);
            }
        }
        JavaScript::put([
            'countcluster' => $countcluster,
        ]);
        return view('monitoring.clusteringReport')->with(array(
            'allcluster'=>$allcluster,
            'clusterterbanyak'=>$mostcluster[4],
            'clustertersedikit'=>$leastcluster[4],
            'resultsmost' => $resultsmost,
            'id_running_most' => $id_most,
            'datasource_most' => $desc_most,
            'resultsleast' => $resultsleast,
            'id_running_least' => $id_least,
            'datasource_least' => $desc_least,
            'z'=>$z,
            'y'=>$y

        ));
    }
    public function getCountCluster(){
        $clusteringdashboard = DB::table("clustering_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("COUNT(id) as jumlah_cluster")
            )->groupBy(DB::raw("id_running"))
            ->get();
        $clusteringdata=array(['KOLOM', "JUMLAH CLUSTER"]);
        foreach ($clusteringdashboard as $row){
            $clusteringdata[] =[$row->kolom,$row->jumlah_cluster];
        }
        return $clusteringdata;
    }
    public function getClusterData(){
        $patternmonitor = DB::table("clustering_table_result")
            ->select("id_running",DB::raw("COUNT(id) as jumlah_cluster"),
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->groupBy(DB::raw("id_running"))
            ->get();
        return $patternmonitor;
    }
    public static function clusteringReportJson(){
        $a=DB::table("clustering_table_result")
            ->select(
                "name_new",
                "id_running",
                DB::raw("(select (total/sum(total)) from clustering_table_result) as ratio"),
                DB::raw("CONCAT(\" - KOLOM : \",substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7),\" - TABEL : \",substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7),\" - DATABASE : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11)) as datadetail"),
                "total"
            )->get();
        $b=DB::table("clustering_table_result")->sum('total');
        $data=array(["CLUSTER NAME","TOTAL DATA","CLUSTER RATIO","DATA DETAIL"]);
        foreach ($a as $r){
            $data[]=[$r->name_new,$r->total,(($r->total)/$b)*100,$r->datadetail];
        }
        JavaScript::put([
            'a'=>$data,
            'b'=>$b,
        ]);
        return $data;
    }

    public function getCompletenessData(){

        $completenessmonitor = DB::table("data_completeness_table_result")
            ->select("id_running",
                DB::raw("substring(datasource_detail, 
                                    locate('\"col\":',datasource_detail)+7,
                                    locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))
                                    -locate('\"col\":',datasource_detail)-7
                                ) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("COUNT(IF(type='VALID',1, NULL)) as valid"),
                DB::raw("COUNT(IF(type='NOT_COMPLETE',1, NULL)) as not_complete"),
                DB::raw("COUNT(IF(type='NOT_IN_DICTIONARY',1, NULL)) not_in_dictionary"),
                DB::raw("COUNT(id) as totalrecord"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->groupBy(DB::raw("id_running"))
            ->get();
        return $completenessmonitor;
    }

    public function completenessReport(){
        $allcompleteness=$this->getCompletenessData();
        $allcompletenesschart=array(['DATA DETAIL',"VALID","NOT COMPLETE","NOT IN DICTIONARY"]);
        foreach ($allcompleteness as $item){
            $allcompletenesschart[]=["KOLOM : ".$item->kolom." - TABEL : ".$item->tabel." - DATABASE : ".$item->nama_database, $item->valid, $item->not_complete,$item->not_in_dictionary];
        }
        $completenessdata=DB::table('data_completeness_table_result')
            ->select(
                "id_running",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("substring(created_at, 1, 10) as tanggal"),
                DB::raw("COUNT(IF(type='VALID',1, NULL)) as jumlah_valid")
            )
            ->groupBy('id_running')->orderBy('jumlah_valid','desc')
            ->get();
        $totalvalid=DB::table('data_completeness_table_result')
            ->select(
                DB::raw("COUNT(IF(type='VALID',1, NULL)) as jumlah_valid")
            )
            ->get();
        $totalnotvalid=DB::table('data_completeness_table_result')
            ->select(
                DB::raw("COUNT(IF(type='NOT_COMPLETE',1, NULL)) as jumlahnotcomplete"),
                DB::raw("COUNT(IF(type='NOT_IN_DICTIONARY',1, NULL)) as jumlahnotindictionary")
            )
            ->get();
        $jumlahvalid=0;
        $jumlahnotvalid=0;
        foreach ($totalvalid as $row){
            $jumlahvalid=$row->jumlah_valid;
        }
        foreach ($totalnotvalid as $row){
            $jumlahnotvalid=($row->jumlahnotcomplete)+($row->jumlahnotindictionary);
        }
        $data=json_decode($completenessdata);
        $e=count($data);
        $mostcompleteness=[$completenessdata[0]->id_running,$completenessdata[0]->kolom,$completenessdata[0]->tabel,$completenessdata[0]->tanggal,$completenessdata[0]->jumlah_valid];
        $leastcompleteness=[$completenessdata[$e-1]->id_running,$completenessdata[$e-1]->kolom,$completenessdata[$e-1]->tabel,$completenessdata[$e-1]->tanggal,$completenessdata[$e-1]->jumlah_valid];


        $id_most =$mostcompleteness[0];
        $id_least =$leastcompleteness[0];

        $mostvalid=['id_running'=>$id_most,'type'=>'VALID'];
        $mostnotcomplete=['id_running'=>$id_most,'type'=>'NOT_COMPLETE'];
        $mostnotdictionary=['id_running'=>$id_most,'type'=>'NOT_IN_DICTIONARY'];
        $leasstvalid=['id_running'=>$id_least,'type'=>'VALID'];
        $leastnotcomplete=['id_running'=>$id_least,'type'=>'NOT_COMPLETE'];
        $leastnotdictionary=['id_running'=>$id_least,'type'=>'NOT_IN_DICTIONARY'];

        $resultsmostvalid = DataCompletenessTableResult::where($mostvalid)->get();
        $resultsmostnotcomplete = DataCompletenessTableResult::where($mostnotcomplete)->get();
        $resultsmostnotdictionary = DataCompletenessTableResult::where($mostnotdictionary)->get();
        $datasource_most = DataCompletenessTableResult::where('id_running', $id_most)->get()->first();
        $desc_most = $this->jsonReader($datasource_most->datasource_detail, 'datasource_detail');

        $resultsleastvalid = DataCompletenessTableResult::where($leasstvalid)->get();
        $resultsleastnotcomplete = DataCompletenessTableResult::where($leastnotcomplete)->get();
        $resultsleastnotdictionary = DataCompletenessTableResult::where($leastnotdictionary)->get();
        $datasource_least = DataCompletenessTableResult::where('id_running', $id_least)->get()->first();
        $desc_least = $this->jsonReader($datasource_least->datasource_detail, 'datasource_detail');

        JavaScript::put([
            'allcompletenesschart' => $allcompletenesschart,
            'mostcomplete'=>$mostcompleteness,
            'leastcomplete'=>$leastcompleteness,
            'result'=>$resultsmostvalid,
        ]);
        return view('monitoring.completenessReport')->with(array(
            'allcompleteness'=>$allcompleteness,
            'mostcompleteness' => $mostcompleteness[4],
            'resultsmostvalid' => $resultsmostvalid,
            'resultsmostnotcomplete' => $resultsmostnotcomplete,
            'resultsmostnotindictionary' => $resultsmostnotdictionary,
            'id_running_most' => $id_most,
            'datasource_most' => $desc_most,
            'leastcompleteness' => $leastcompleteness[4],
            'resultsleastvalid' => $resultsleastvalid,
            'resultsleastnotcomplete' => $resultsleastnotcomplete,
            'resultsleastnotindictionary' => $resultsleastnotdictionary,
            'id_running_least' => $id_least,
            'datasource_least' => $desc_least,
            'jumlahvalid'=>$jumlahvalid,
            'jumlahnotvalid'=>$jumlahnotvalid
        ));
    }
    
    public function getDistributionData(){
        $distributionmonitor = DB::table("val_distribution_table_result")
            ->select("id_running","column_value","column_value_distribution",
                DB::raw("substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7) as kolom"),
                DB::raw("substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7) as tabel"),
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as nama_database"),
                DB::raw("COUNT(column_value) as total_value"),
                DB::raw("substring(created_at, 1, 10) as tanggal"))
            ->groupBy(DB::raw("id_running"))->orderBy('total_value','desc')
            ->get();
        return $distributionmonitor;
    }
    public function distributionReportJson(){
        $a=DB::table("val_distribution_table_result")
            ->select(
                "column_value",
                "id_running",
                DB::raw("(select (column_value_distribution/sum(column_value_distribution)) from val_distribution_table_result) as ratio"),
                DB::raw("CONCAT(\" - KOLOM : \",substring(datasource_detail, locate('\"col\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"col\":',datasource_detail))-locate('\"col\":',datasource_detail)-7),\" - TABEL : \",substring(datasource_detail, locate('\"tab\":',datasource_detail)+7,locate('\",\"',datasource_detail, locate('\"tab\":',datasource_detail))-locate('\"tab\":',datasource_detail)-7),\" - DATABASE : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11)) as datadetail"),
                "column_value_distribution")
            ->get();
        $b=DB::table('val_distribution_table_result')
            ->select(DB::raw('id_running'), DB::raw('sum(column_value_distribution) as total'))
            ->groupBy(DB::raw('id_running'))
            ->get();
        $data=array(["COLUMN VALUE","TOTAL DATA","DISTRIBUTION RATIO","DATA DETAIL","DATA"]);
        foreach ($a as $r){
            foreach ($b as $s){
                if($r->id_running===$s->id_running){
                    $data[]=[$r->column_value,$r->column_value_distribution,(($r->column_value_distribution)/$s->total)*100,$r->datadetail,$r->column_value_distribution];
                }
            }
        }
        JavaScript::put([
            'distributiondata'=>$data,
            'b'=>$b,
        ]);
        return $data;
    }
    public function distributionReport(){
        $alldistribution=$this->getDistributionData();
        $distributionratio=$this->distributionReportJson();
        $data=json_decode($alldistribution);
        $e=count($data);
        $mostdistribution=[$alldistribution[0]->id_running,$alldistribution[0]->kolom,$alldistribution[0]->tabel,$alldistribution[0]->tanggal,$alldistribution[0]->total_value];
        $leastdistribution=[$alldistribution[$e-1]->id_running,$alldistribution[$e-1]->kolom,$alldistribution[$e-1]->tabel,$alldistribution[$e-1]->tanggal,$alldistribution[$e-1]->total_value];

        $id_most =$mostdistribution[0];
        $id_least =$leastdistribution[0];

        $resultsmost = ValueDistributionTableResult::where('id_running', $id_most)->get();
        $datasource_most = ValueDistributionTableResult::where('id_running', $id_most)->get()->first();
        $desc_most = $this->jsonReader($datasource_most->datasource_detail, 'datasource_detail');

        $resultsleast = ValueDistributionTableResult::where('id_running', $id_least)->get();
        $datasource_least = ValueDistributionTableResult::where('id_running', $id_least)->get()->first();
        $desc_least = $this->jsonReader($datasource_least->datasource_detail, 'datasource_detail');

        $maxratio=0;
        $minratio=100;
        for($i=1;$i<count($distributionratio);$i++){
            if($distributionratio[$i][2]>$maxratio){
                $maxratio=round($distributionratio[$i][2],2);
            }
        }
        for($i=1;$i<count($distributionratio);$i++){
            if($distributionratio[$i][2]<=$minratio){
                $minratio=round($distributionratio[$i][2],2);
            }
        }

        return view('monitoring.distributionReport')->with(array(
            'alldistribution'=>$alldistribution,
            'distributionterbanyak'=>$mostdistribution[4],
            'distributiontersedikit'=>$leastdistribution[4],
            'resultsmost' => $resultsmost,
            'id_running_most' => $id_most,
            'datasource_most' => $desc_most,
            'resultsleast' => $resultsleast,
            'id_running_least' => $id_least,
            'datasource_least' => $desc_least,
            'maxratio' => $maxratio,
            'minratio' => $minratio
        ));

    }

    // SIL
    public function getSimilarityData(){
        $himpun_similaritydata = DB::table("val_similarity_table_result")
        ->select(
            DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+8+3,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-8-3) as db_name"),
            DB::raw("substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8) as port"),
            DB::raw("substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8) as tab1"),
            DB::raw("substring(datasource_detail, locate('\"col1\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"col1\":',datasource_detail))-locate('\"col1\":',datasource_detail)-8) as col1"),
            DB::raw("substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8) as tab2"),
            DB::raw("substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8) as col2"),
            DB::raw("COUNT(IF(measure_value=1,1, NULL)) as similar"),
            DB::raw("COUNT(IF(measure_value<>1,1, NULL)) as high_similarity"),
            DB::raw("COUNT(IF(measure_value IS NULL, 1, NULL)) as uniquee"),
            DB::raw("COUNT(id) as totalrecord"),
            DB::raw("substring(created_at, 1, 10) as tanggal"),
            DB::raw("id_running")
        )
        ->groupBy(DB::raw("id_running"))
        ->get();

        // dd($himpun_similaritydata);

        return $himpun_similaritydata;
    }
    
    public function similarityReport(){
        $tbname='val_similarity_table_result';
        $allsimilarity=$this->getSimilarityData();
        // ini buat bar chart
        $similaritybarchart = DB::table($tbname)
        ->select(
            DB::raw("substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8) as kolom"),
            DB::raw("COUNT(IF(measure_value=1,1, NULL)) as similar"),
            DB::raw("COUNT(IF(measure_value<>1,1, NULL)) as high_similarity"),
            DB::raw("COUNT(IF(measure_value IS NULL, 1, NULL)) as uniquee")
        )
        ->groupBy(DB::raw("datasource_detail"))
        ->get();

        // mengambil informasi sumber data
        $table1=$allsimilarity[0]->tab1;
        $table2=$allsimilarity[0]->tab2;
        $database_name=$allsimilarity[0]->db_name;

        // kategori data similar/probably/uniquee
        $similardatas = DB::table($tbname)
            ->select("*")
            ->where("measure_value","=","1")
            ->get();

        $highsimilardatas = DB::table($tbname)
            ->select("*")
            ->where("measure_value","<>","1")
            ->get();

        $uniqueedatas = DB::table($tbname)
            ->select("*")
            ->whereNull("measure_value")
            ->get();

        $similaritydata=array(['KOLOM','UNIQUE DATA','SIMILAR DATA','DATA WITH HIGH SIMILARITY']);

        foreach ($similaritybarchart as $row){
            $similaritydata[] =[$row->kolom,$row->uniquee,$row->similar,$row->high_similarity];
        }

        // menghitung jumlah per kategori
        $totalsimilar=DB::table($tbname)
            ->select(
                DB::raw("COUNT(IF(measure_value=1,1, NULL)) as jumlah_similar")
            )
            ->get();
            
        $totalhighsimilarity=DB::table($tbname)
            ->select(
                DB::raw("COUNT(IF(measure_value<>1,1, NULL)) as jumlah_highsimilar")
            )
            ->get();

        $totaluniquee=DB::table($tbname)
            ->select(
                DB::raw("COUNT(IF(measure_value IS NULL, 1, NULL)) as jumlah_uniquee")
            )
            ->get();

        $jumlahsimilar=0;
        $jumlahhighsimiar=0;
        $jumlahuniquee=0;

        foreach ($totalsimilar as $row){
            $jumlahsimilar=$row->jumlah_similar;
        }
        foreach ($totalhighsimilarity as $row){
            $jumlahhighsimiar=$row->jumlah_highsimilar;
        }
        foreach ($totaluniquee as $row){
            $jumlahuniquee=$row->jumlah_uniquee;
        }
        
        $data=json_decode($similaritybarchart);
        $e=count($data);

        // Pie Chart Back End
        // Similar Data Pie
        $similarpiedata = DB::table($tbname)
            ->select(
                DB::raw("CONCAT(  
                                \" - COL1: \",substring(datasource_detail, locate('\"col1\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"col1\":',datasource_detail))-locate('\"col1\":',datasource_detail)-8),
                                \" - COL2: \",substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8),
                                \" - DB : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),
                                \" - PORT : \",substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8)
                        ) as data"),
                DB::raw("COUNT(id) as jumlah_similarpie")
            )
            ->where("measure_value","=","1")
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        $similarpiedatachart=array(['SOURCE DETAIL','SIMILAR DATA COUNT']);
        foreach ($similarpiedata as $row){
            $similarpiedatachart[]=[$row->data,$row->jumlah_similarpie];
        }

        // Highly Similar Data Pie
        $highlysimilarpiedata = DB::table($tbname)
            ->select(
                DB::raw("CONCAT(  
                                \" - COL1: \",substring(datasource_detail, locate('\"col1\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"col1\":',datasource_detail))-locate('\"col1\":',datasource_detail)-8),
                                \" - COL2: \",substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8),
                                \" - DB : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),
                                \" - PORT : \",substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8)
                        ) as data"),
                DB::raw("COUNT(id) as jumlah_highlysimilar")
            )
            ->where("measure_value","<>","1")
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        $highlysimilarpiedatachart=array(['SOURCE DETAIL','HIGHLY SIMILAR DATA COUNT']);
        foreach ($highlysimilarpiedata as $row){
            $highlysimilarpiedatachart[]=[$row->data,$row->jumlah_highlysimilar];
        }
        
        // Highly Similar Data Pie
        $uniqueepiedata = DB::table($tbname)
            ->select(
                DB::raw("CONCAT(  
                                \" - COL1: \",substring(datasource_detail, locate('\"col1\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"col1\":',datasource_detail))-locate('\"col1\":',datasource_detail)-8),
                                \" - COL2: \",substring(datasource_detail, locate('\"col2\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"col2\":',datasource_detail))-locate('\"col2\":',datasource_detail)-8),
                                \" - DB : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),
                                \" - PORT : \",substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8)
                        ) as data"),
                DB::raw("COUNT(id) as jumlah_similarpie")
            )
            ->whereNull("measure_value")
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        $uniqueepiedatachart=array(['SOURCE DETAIL','SIMILAR DATA COUNT']);
        foreach ($uniqueepiedata as $row){
            $uniqueepiedatachart[]=[$row->data,$row->jumlah_similarpie];
        }
        
        //Yang di sini buat yang dipakai Javascript aja 
        JavaScript::put([
            'similaritybarchart'=>$similaritydata,
            'similarpiedatachart'=>$similarpiedatachart,
            'highlysimilarpiedatachart'=>$highlysimilarpiedatachart,
            'uniqueepiedatachart'=>$uniqueepiedatachart,
        ]);
        
        // Yang di sini langsung dipakai di viewnya
        return view('monitoring.similarityReport')
            ->with(array(
                'allsimilarity'=>$allsimilarity,
                'jumlahsimilar'=>$jumlahsimilar,
                'jumlahhighsimiar'=>$jumlahhighsimiar,
                'jumlahuniquee'=>$jumlahuniquee,
                'similardatas'=>$similardatas,
                'highsimilardatas'=>$highsimilardatas,
                'uniqueedatas'=>$uniqueedatas,
                'table1'=>$table1,
                'table2'=>$table2,
                'database_name'=>$database_name,
            ));
    }

    public function getDeduplicationData(){
        $himpun_deduplicationdata = DB::table("data_deduplication_table_result")
            ->select(
                DB::raw("substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11) as db_name"),
                DB::raw("substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8) as port"),
                DB::raw("substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8) as tab1"),
                DB::raw("substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8) as tab2"),
                DB::raw("substring(datasource_detail, locate('\"col1a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1a\":',datasource_detail))-locate('\"col1a\":',datasource_detail)-9) as col1a"),
                DB::raw("substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9) as col1b"),
                DB::raw("substring(datasource_detail, locate('\"col2a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2a\":',datasource_detail))-locate('\"col2a\":',datasource_detail)-9) as col2a"),
                DB::raw("substring(datasource_detail, locate('\"col2b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2b\":',datasource_detail))-locate('\"col2b\":',datasource_detail)-9) as col2b"),
                DB::raw("COUNT(IF(measure_value=0,1, NULL)) as duplicated"),
                DB::raw("COUNT(IF(measure_value=1,1, NULL)) as probably_duplicated"),
                DB::raw("COUNT(IF(measure_value IS NULL,1, NULL)) as uniquee"),
                DB::raw("COUNT(id) as total"),
                DB::raw("substring(created_at, 1, 10) as tanggal"),
                DB::raw("id_running")
            )
            // ->groupBy(DB::raw("id_running"))
            ->groupBy(DB::raw("id_running"))
            ->get();
            
            // dd($himpun_deduplicationdata);

        return $himpun_deduplicationdata;
    }
    public function deduplicationReport(){
        $alldeduplication=$this->getDeduplicationData();
        $tbname='data_deduplication_table_result';
        $deduplicationdashboard = DB::table($tbname)
            ->select(
                DB::raw("substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9) as kolom"),
                DB::raw("COUNT(IF(measure_value=0,1, NULL)) as duplicated"),
                DB::raw("COUNT(IF(measure_value=1,1, NULL)) as probably_duplicated"),
                DB::raw("COUNT(IF(measure_value IS NULL,1, NULL)) as uniquee")

            )
            // ->groupBy(DB::raw("id_running"))
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        //pengkategorian di chart 
        $deduplicationdata=array(['KOLOM','UNIQUE','DUPLICATED','PROBABLY DUPLICATED']);
        foreach ($deduplicationdashboard as $row){
            $deduplicationdata[] =[$row->kolom,$row->uniquee,$row->duplicated,$row->probably_duplicated];
        }

        // mengambil informasi sumber data
        $table1=$alldeduplication[0]->tab1;
        $table2=$alldeduplication[0]->tab2;
        $database_name=$alldeduplication[0]->db_name;

        // kategori data similar/probably/uniquee
        $duplicateddatas = DB::table($tbname)
            ->select("*")
            ->where("measure_value","=","0")
            ->get();

        $probablydatas = DB::table($tbname)
            ->select("*")
            ->where("measure_value","=","1")
            ->get();

        $uniqueedatas = DB::table($tbname)
            ->select("*")
            ->whereNull("measure_value")
            ->get();

        // menghitung jumlah per kategori
        $totalduplicated=DB::table($tbname)
            ->select(
                DB::raw("COUNT(IF(measure_value=0,1, NULL)) as jumlah_duplicated")
            )
            ->get();
        $totalprobably=DB::table($tbname)
            ->select(
                DB::raw("COUNT(IF(measure_value=1,1, NULL)) as jumlah_probably")
            )
            ->get();
        $totaluniquee=DB::table($tbname)
            ->select(
                DB::raw("COUNT(IF(measure_value IS NULL,1, NULL)) as jumlah_uniquee")
            )
            ->get();

        $jumlahduplciated=0;
        $jumlahprobably=0;
        $jumlahuniquee=0;

        foreach ($totalduplicated as $row){
            $jumlahduplciated=$row->jumlah_duplicated;
        }
        foreach ($totalprobably as $row){
            $jumlahprobably=$row->jumlah_probably;
        }
        foreach ($totaluniquee as $row){
            $jumlahuniquee=$row->jumlah_uniquee;
        }
        
        $data=json_decode($deduplicationdashboard);
        $e=count($data);

        // Pie Chart Back End
        // Duplicated Data Pie
        $duplicatedpiedata = DB::table($tbname)
            ->select(
                DB::raw("CONCAT(  
                                \" - TAB1: \",substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8),
                                \" - TAB2: \",substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8),
                                \" - COL1.1: \",substring(datasource_detail, locate('\"col1a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1a\":',datasource_detail))-locate('\"col1a\":',datasource_detail)-9),
                                \" - COL1.2: \",substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9),
                                \" - COL2.1: \",substring(datasource_detail, locate('\"col2a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2a\":',datasource_detail))-locate('\"col2a\":',datasource_detail)-9),
                                \" - COL2.2: \",substring(datasource_detail, locate('\"col2b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2b\":',datasource_detail))-locate('\"col2b\":',datasource_detail)-9),
                                \" - DB : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),
                                \" - PORT : \",substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8)
                        ) as data"),
                DB::raw("COUNT(id) as jumlah_duplicatedpie")
            )
            ->where("measure_value","=","0")
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        $duplicatedpiedatachart=array(['SOURCE DETAIL','DUPLICATED DATA COUNT']);
        foreach ($duplicatedpiedata as $row){
            $duplicatedpiedatachart[]=[$row->data,$row->jumlah_duplicatedpie];
        }
        // Probably Duplicated Data Pie
        $probablypiedata = DB::table($tbname)
            ->select(
                DB::raw("CONCAT(  
                                \" - TAB1: \",substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8),
                                \" - TAB2: \",substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8),
                                \" - COL1.1: \",substring(datasource_detail, locate('\"col1a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1a\":',datasource_detail))-locate('\"col1a\":',datasource_detail)-9),
                                \" - COL1.2: \",substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9),
                                \" - COL2.1: \",substring(datasource_detail, locate('\"col2a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2a\":',datasource_detail))-locate('\"col2a\":',datasource_detail)-9),
                                \" - COL2.2: \",substring(datasource_detail, locate('\"col2b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2b\":',datasource_detail))-locate('\"col2b\":',datasource_detail)-9),
                                \" - DB : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),
                                \" - PORT : \",substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8)
                        ) as data"),
                DB::raw("COUNT(id) as jumlah_probablypie")
            )
            ->where("measure_value","=","1")
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        $probablypiedatachart=array(['SOURCE DETAIL','PROBABLY DUPLICATED DATA COUNT']);
        foreach ($probablypiedata as $row){
            $probablypiedatachart[]=[$row->data,$row->jumlah_probablypie];
        }

        // Uniquee Data Pie
        $uniqueepiedata = DB::table($tbname)
            ->select(
                DB::raw("CONCAT(  
                                \" - TAB1: \",substring(datasource_detail, locate('\"tab1\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"tab1\":',datasource_detail))-locate('\"tab1\":',datasource_detail)-8),
                                \" - TAB2: \",substring(datasource_detail, locate('\"tab2\":',datasource_detail)+8,locate('\"}]',datasource_detail, locate('\"tab2\":',datasource_detail))-locate('\"tab2\":',datasource_detail)-8),
                                \" - COL1.1: \",substring(datasource_detail, locate('\"col1a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1a\":',datasource_detail))-locate('\"col1a\":',datasource_detail)-9),
                                \" - COL1.2: \",substring(datasource_detail, locate('\"col1b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col1b\":',datasource_detail))-locate('\"col1b\":',datasource_detail)-9),
                                \" - COL2.1: \",substring(datasource_detail, locate('\"col2a\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2a\":',datasource_detail))-locate('\"col2a\":',datasource_detail)-9),
                                \" - COL2.2: \",substring(datasource_detail, locate('\"col2b\":',datasource_detail)+9,locate('\",\"',datasource_detail, locate('\"col2b\":',datasource_detail))-locate('\"col2b\":',datasource_detail)-9),
                                \" - DB : \",substring(datasource_detail, locate('\"db_name\":',datasource_detail)+11,locate('\",\"',datasource_detail, locate('\"db_name\":',datasource_detail))-locate('\"db_name\":',datasource_detail)-11),
                                \" - PORT : \",substring(datasource_detail, locate('\"port\":',datasource_detail)+8,locate('\",\"',datasource_detail, locate('\"port\":',datasource_detail))-locate('\"port\":',datasource_detail)-8)
                        ) as data"),
                DB::raw("COUNT(id) as jumlah_uniqueepie")
            )
            ->whereNull("measure_value")
            ->groupBy(DB::raw("datasource_detail"))
            ->get();
        
        $uniqueepiedatachart=array(['SOURCE DETAIL','UNIQUEE DATA COUNT']);
        foreach ($uniqueepiedata as $row){
            $uniqueepiedatachart[]=[$row->data,$row->jumlah_uniqueepie];
        }
        

        JavaScript::put([
            'deduplicationdashboard'=>$deduplicationdata,
            'duplicatedpiedatachart'=>$duplicatedpiedatachart,
            'probablypiedatachart'=>$probablypiedatachart,
            'uniqueepiedatachart'=>$uniqueepiedatachart,
        ]);

        return view('monitoring.deduplicationReport')
            ->with(array(
                'alldeduplication'=>$alldeduplication,
                'database_name'=>$database_name,
                'table1'=>$table1,
                'table2'=>$table2,
                'duplicateddatas'=>$duplicateddatas,
                'probablydatas'=>$probablydatas,
                'uniqueedatas'=>$uniqueedatas,
                'jumlahduplciated'=>$jumlahduplciated,
                'jumlahprobably'=>$jumlahprobably,
                'jumlahuniquee'=>$jumlahuniquee,
            ));
    }
}