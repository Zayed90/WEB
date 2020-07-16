<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\DataSource;
use App\ShowNull;
use App\EregMPabrik;
use App\EregMTrader;
use App\CardinalitiesTableResult;
use App\PatternTableResult;
use App\ValueDistributionTableResult;
use App\ValueSimilarityTableResult;
use App\DataCompletenessTableResult;
use App\DataDeduplicationTableResult;
use App\ShownullTableResult;
use App\ClusteringTableResult;

class MasterDataController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {

    $rows_cardinalities = CardinalitiesTableResult::count();
    $cols_cardinalities = count(DB::select('desc cardinalities_table_result'));
    $rows_pattern = PatternTableResult::count();
    $cols_pattern = count(DB::select('desc pattern_table_result'));
    $rows_valuedistribution = ValueDistributionTableResult::count();
    $cols_valuedistribution = count(DB::select('desc val_distribution_table_result'));
    $rows_valuesimilarity = ValueSimilarityTableResult::count();
    $cols_valuesimilarity = count(DB::select('desc val_similarity_table_result'));
    $rows_datacompleteness = DataCompletenessTableResult::count();
    $cols_datacompleteness = count(DB::select('desc data_completeness_table_result'));
    $rows_datadeduplication = DataDeduplicationTableResult::count();
    $cols_datadeduplication = count(DB::select('desc data_deduplication_table_result'));
    $rows_shownull = ShownullTableResult::count();
    $cols_shownull = count(DB::select('desc shownull_table_result'));
    $rows_clustering = ClusteringTableResult::count();
    $cols_clustering = count(DB::select('desc clustering_table_result'));

    $rows_eregmpabrik = EregMPabrik::count();
    $cols_eregmpabrik = count(DB::select('desc ereg_m_pabrik'));
    $rows_eregmtrader = EregMTrader::count();
    $cols_eregmtrader = count(DB::select('desc ereg_m_trader'));

    // $jml_clusteringFalse = DataSource::where('STATUS','=','FALSE')->get()->count();
    // $jml_clusteringTrue = DataSource::where('STATUS','=','TRUE')->get()->count();
    // $jml_clusteringSelect = DataSource::where('STATUS','=','SELECTED')->get()->count();
    // $jml_null = ShowNull::all()->count();

    return view('masterdata')->with(array(
      // 'clusteringFalse' => $jml_clusteringFalse,
      // 'clusteringTrue' => $jml_clusteringTrue,
      // 'clusteringSelect' => $jml_clusteringSelect,
      // 'null' => $jml_null,
      'rows_cardinalities' => $rows_cardinalities,
      'cols_cardinalities' => $rows_cardinalities,
      'rows_pattern' => $rows_pattern,
      'cols_pattern' => $cols_pattern,
      'rows_valuedistribution' => $rows_valuedistribution,
      'cols_valuedistribution' => $cols_valuedistribution,
      'rows_valuesimilarity' => $rows_valuesimilarity,
      'cols_valuesimilarity' => $cols_valuesimilarity,
      'rows_datacompleteness' => $rows_datacompleteness,
      'cols_datacompleteness' => $cols_datacompleteness,
      'rows_datadeduplication' => $rows_datadeduplication,
      'cols_datadeduplication' => $cols_datadeduplication,
      'rows_shownull' => $rows_shownull,
      'cols_shownull' => $cols_shownull,
      'rows_clustering' => $rows_clustering,
      'cols_clustering' => $cols_clustering,
      'rows_eregmpabrik' => $rows_eregmpabrik,
      'cols_eregmpabrik' => $cols_eregmpabrik,
      'rows_eregmtrader' => $rows_eregmtrader,
      'cols_eregmtrader' => $cols_eregmtrader
    ));;
  }

  public function dataSample(){

    $rows_eregmpabrik = EregMPabrik::count();
    $cols_eregmpabrik = count(DB::select('desc ereg_m_pabrik'));
    $rows_eregmtrader = EregMTrader::count();
    $cols_eregmtrader = count(DB::select('desc ereg_m_trader'));

    return view('dataTest')->with(array(
      // 'clusteringFalse' => $jml_clusteringFalse,
      // 'clusteringTrue' => $jml_clusteringTrue,
      // 'clusteringSelect' => $jml_clusteringSelect,
      // 'null' => $jml_null,
      'rows_eregmpabrik' => $rows_eregmpabrik,
      'cols_eregmpabrik' => $cols_eregmpabrik,
      'rows_eregmtrader' => $rows_eregmtrader,
      'cols_eregmtrader' => $cols_eregmtrader
    ));;

  }
}
