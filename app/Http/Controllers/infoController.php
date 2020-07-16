<?php

namespace App\Http\Controllers;

use App\dim_fact_mdm;
use App\dim_lookup;
use App\dim_application;
use App\Master_Data_Company;
use App\Md1_Lookup_Result;
use ConsoleTVs\Charts\Facades\Charts;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class infoController extends Controller
{
    public function index(Request $request){
        //Data Completeness
        $dcAll = DB::table('dim_companies')->count();
        $nullDim = DB::table('dim_companies')->where('address','IS NULL')->count();
        $ereg = DB::table('dim_companies')->where('id_app',1)->count();
        $nullEreg = DB::table('dim_companies')->where('address','IS NULL')->where('id_app',1)->count();
        $asrot = DB::table('dim_companies')->where('id_app',2)->count();
        $nullAsrot = DB::table('dim_companies')->where('address','IS NULL')->where('id_app',2)->count();
        $dn = DB::table('dim_companies')->where('id_app',3)->count();
        $nullDn = DB::table('dim_companies')->where('address','IS NULL')->where('id_app',3)->count();
        $ln = DB::table('dim_companies')->where('id_app',4)->count();
        $nullLn = DB::table('dim_companies')->where('address','IS NULL')->where('id_app',4)->count();
        $persen = number_format(100-($nullDim/$dcAll)*100,2);
        $pNEreg = number_format(100-($nullEreg/$ereg)*100,2);
        $pNAsrot = number_format(100-($nullAsrot/$asrot)*100,2);
        $pNDn = number_format(100-($nullDn/$dn)*100,2);
        $pNLn = number_format(100-($nullLn/$ln)*100,2);
        // Last Lookup
        $lastlook = DB::select("select max(created_at) as created_at from dim_times");
        //Last Insert
        $lastins = DB::select("select max(created_at) as created_at from master_data_companies");
        // Total Company
        $toCom = DB::select("select count(distinct(company_name)) as total from md1_lookup_results ");
        // Data Uniqueness
        $cntDup = DB::select("select count(*) as total from (select company_name from dim_companies group by company_name having count(company_name) > 1) as X");
        $toDC = DB::table('dim_companies')->count();



        // Data Accuracy
        $presen = DB::table('md1_lookup_results')->where('status','Not match')->count();
        $total = DB::table('md1_lookup_results')->count();
        $accuracy = number_format(($presen/$total)*100,2);
        $pAsrot = DB::table('md1_lookup_results')->where('status','Not match')->where('data_source','asrot')->count();
        $tAsrot = DB::table('md1_lookup_results')->where('data_source','asrot')->count();
        $aAsrot = number_format(($pAsrot/$tAsrot)*100,2);
        $pEreg = DB::table('md1_lookup_results')->where('status','Not match')->where('data_source','ereg')->count();
        $tEreg = DB::table('md1_lookup_results')->where('data_source','ereg')->count();
        $aEreg = number_format(($pEreg/$tEreg)*100,2);
        $pDn = DB::table('md1_lookup_results')->where('status','Not match')->where('data_source','etrack_dn')->count();
        $tDn = DB::table('md1_lookup_results')->where('data_source','etrack_dn')->count();
        $aDn = number_format(($pDn/$tDn)*100,2);
        $pLn = DB::table('md1_lookup_results')->where('status','Not match')->where('data_source','etrack_ln')->count();
        $tLn = DB::table('md1_lookup_results')->where('data_source','etrack_ln')->count();
        $aLn = number_format(($pLn/$tLn)*100,2);



        $masterCnt = DB::select("select count(distinct(company_name)) as total from master_data_companies ");
        $users = Master_Data_Company::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))->get();
        $chart = Charts::database($users, 'bar', 'google')
            ->title(' ')
            ->elementLabel("Total Data")
            ->dimensions(550, 300)
            ->responsive(false)
            ->groupByMonth(date('Y'), true);


        $chr = Master_Data_Company::select(DB::raw('count(*) as total'), 'source')->groupBy('source')->get();
        $pie  =	 Charts::create('pie', 'google')
            ->title(' ')
            ->dimensions(550,300)
            ->colors(['#ff0000', '#00FFFF','#C5CAE9', '#808080'])
            ->labels($chr->pluck('source'))
            ->values($chr->pluck('total'))
            ->responsive(false);

        $chrr = dim_fact_mdm::select('total_notMatch', 'id_app')->where('id_lookup' , dim_lookup::max('id_lookup'))->groupBy('id_app')->get();
        $piee  =	Charts::create('pie', 'google')
            ->title(' ')
            ->dimensions(525,300)
            ->colors(['#ff0000', '#00FFFF','#C5CAE9', '#808080'])
            ->labels($chrr->pluck('id_app'))
            ->labels(['Ereg','Asrot','Etrack_dn','Etrack_ln'])
            ->values($chrr->pluck('total_notMatch'))
            ->responsive(false);
    
        $mat = dim_fact_mdm::where('id_lookup' , dim_lookup::max('id_lookup'))->groupBy('id_app')->get();
        $pieCha  = Charts::create('pie', 'google')
            ->title(' ')
            ->dimensions(525,300)
            ->colors(['#ff0000', '#00FFFF','#C5CAE9', '#808080'])
            ->labels($mat->pluck('id_app'))
            ->labels(['Ereg','Asrot','Etrack_dn','Etrack_ln'])
            ->values($mat->pluck('total_match'))
            ->responsive(false);
        return view('panel.home',compact('persen','lastlook','toCom','lastins','cntDup','toDC','accuracy','chart','pie','masterCnt','aAsrot','aEreg','aDn','aLn','pNEreg','pNAsrot','pNLn','pNDn','piee','pieCha'));
    }


}
