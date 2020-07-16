<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;


Auth::routes();

//coba buka halaman list editing
Route::get('/testing/{id}', 'ClusteringController@testing');
Route::post('/testing/{id}', 'ClusteringController@updateTesting');

//Auth
Auth::routes();

//Session
Route::get('/createSession', 'SessionController@create')->middleware('auth');
Route::get('/destroySession', 'SessionController@destroy');

//Dasboard
Route::get('/home', 'HomeController@test')->middleware('auth','admin')->name('home');
Route::get('/createSession', 'HomeController@indexManager')->middleware('auth');

//Monitoring manager
Route::get('/dashboardManager', 'HomeController@indexManager')->middleware('auth');
Route::get('/monitoringManager', 'MonitoringController@indexMonitorManager')->middleware('auth');

//DataSource
Route::get('/dataSource', 'DataSourceController@index')->middleware('auth');
Route::get('/dataClustering', 'ClusteringController@index')->middleware('auth');

//MonitoringAdmin
Route::get('/monitoringAdmin', 'MonitoringController@index')->middleware('auth');
Route::post('/saveMonitoring', 'MonitoringController@store');

//ListNull
Route::get('/listNull', 'ShowNullController@index');

//MonitoringView - Dummy
Route::get('/monitoring', 'MonitoringViewController@index');

Route::get('/', function () {
    // return view('login');
    return redirect('login');
});
Route::get('/import', 'ImportDataController@index')->middleware('auth')->name('import');
Route::post('/importcsv', 'ImportDataController@importCsv')->middleware('auth');
Route::get('/importResult', 'ImportDataController@showImportData')->middleware('auth');
Route::get('/importResult/{name}', 'ImportDataController@showImportDetail')->middleware('auth');

Route::get('/sourceView/{data_name}', 'DataSourceController@sourceView')->middleware('auth');
Route::post('/externalSourceView', 'DataSourceController@externalSourceView')->middleware('auth');

Route::get('/masterdata', 'MasterDataController@index')->middleware('auth');
Route::get('/dataTest', 'MasterDataController@dataSample')->middleware('auth');

//Pentaho
Route::get('/pentaho/cardinalities', 'PentahoLogicController@runCardinalities')->name('cardinalities');
Route::post('/pentaho/cardinalities/process', 'PentahoLogicController@processCardinalities');


Route::get('/pentaho/pattern', 'PentahoLogicController@runPattern')->name('pattern')->middleware('auth','admin');
Route::post('/pentaho/pattern/process', 'PentahoLogicController@processPattern')->middleware('auth','admin');
Route::get('/pentaho/pattern/view', 'PentahoLogicController@viewPattern')->name('patternView')->middleware('auth','admin');

Route::get('/pentaho/valueDistribution', 'PentahoLogicController@runValueDistribution')->name('valueDistribution')->middleware('auth','admin');
Route::post('/pentaho/valueDistribution/process', 'PentahoLogicController@processValueDistribution')->middleware('auth','admin');
Route::get('/pentaho/valueDistribution/view', 'PentahoLogicController@viewValueDistribution')->name('valueDistributionView')->middleware('auth','admin');

Route::get('/pentaho/valueSimilarity', 'PentahoLogicController@runValueSimilarity')->name('valueSimilarity')->middleware('auth','admin');
Route::post('/pentaho/valueSimilarity/process', 'PentahoLogicController@processValueSimilarity')->middleware('auth','admin');
Route::get('/pentaho/valueSimilarity/view', 'PentahoLogicController@viewValueSimilarity')->name('valueSimilarityView')->middleware('auth','admin');

Route::get('/pentaho/dataCompleteness', 'PentahoLogicController@runDataCompleteness')->name('dataCompleteness')->middleware('auth','admin');
Route::post('/pentaho/dataCompleteness/process', 'PentahoLogicController@processDataCompleteness')->middleware('auth','admin');
Route::get('/pentaho/dataCompleteness/view', 'PentahoLogicController@viewDataCompleteness')->name('dataCompletenessView')->middleware('auth','admin');

Route::get('/pentaho/dataDeduplication', 'PentahoLogicController@runDataDeduplication')->name('dataDeduplication')->middleware('auth','admin');
Route::post('/pentaho/dataDeduplication/process', 'PentahoLogicController@processDataDeduplication')->middleware('auth','admin');
Route::get('/pentaho/dataDeduplication/view', 'PentahoLogicController@viewDataDeduplication')->name('dataDeduplicationView')->middleware('auth','admin');

Route::get('/pentaho/shownull', 'PentahoLogicController@runShownull')->name('shownull')->middleware('auth','admin');
Route::post('/pentaho/shownull/process', 'PentahoLogicController@processShownull')->middleware('auth','admin');
Route::get('/pentaho/shownull/view', 'PentahoLogicController@viewShownull')->name('shownullView')->middleware('auth','admin');

Route::get('/pentaho/clustering', 'PentahoLogicController@runClustering')->name('clustering')->middleware('auth','admin');
Route::post('/pentaho/clustering/process', 'PentahoLogicController@processClustering')->middleware('auth','admin');
Route::get('/pentaho/clustering/view', 'PentahoLogicController@viewClustering')->name('clusteringView')->middleware('auth','admin');

Route::get('/pentaho/outlier', 'PentahoLogicController@runOutlier')->name('outlier')->middleware('auth','admin');
Route::post('/pentaho/outlier/process', 'PentahoLogicController@processOutlier')->middleware('auth','admin');
Route::get('/pentaho/outlier/view', 'PentahoLogicController@viewOutlier')->name('outlierView')->middleware('auth','admin');

Route::get('/database', 'DatabaseConnectionController@index')->name('database')->middleware('auth','admin');
Route::post('/databaseUpdate', 'DatabaseConnectionController@update')->name('databaseUpdate')->middleware('auth','admin');

Route::get('/multiproccess', 'MultiProccessController@index')->name('multiproccess')->middleware('auth','admin');
Route::post('/multiproccess/excute', 'MultiProccessController@proccess')->name('multiproccess-exec')->middleware('auth','admin');
Route::get('/multiproccess/result', 'MultiProccessController@viewResult')->name('multiproccessView')->middleware('auth','admin');

//Cleansing
Route::get('/cleansing/pattern', 'CleansingController@runPatternCleansing')->name('pattern_cleansing')->middleware('auth','admin');
Route::post('/cleansing/pattern/choose-pattern', 'CleansingController@choosePattern')->name('choose_pattern')->middleware('auth','admin');
Route::post('/cleansing/pattern/process', 'CleansingController@processPatternCleansing')->name('pattern_cleansing_process')->middleware('auth','admin');
Route::get('/cleansing/pattern/view', 'CleansingController@viewPattern')->name('pattern_cleansing_view')->middleware('auth','admin');

Route::get('/cleansing/null', 'CleansingController@runNullCleansing')->name('cleansing_null')->middleware('auth','admin');
Route::post('/cleansing/null/process', 'CleansingController@processNullCleansing')->name('cleansing_null_process')->middleware('auth','admin');
Route::get('/cleansing/null/view', 'CleansingController@viewNull')->name('cleansing_null_view')->middleware('auth','admin');
//=======
Route::get('/pentaho/pattern', 'PentahoLogicController@runPattern')->name('pattern');
Route::post('/pentaho/pattern/process', 'PentahoLogicController@processPattern');
Route::get('/pentaho/pattern/view', 'PentahoLogicController@viewPattern')->name('patternView');

Route::get('/pentaho/valueDistribution', 'PentahoLogicController@runValueDistribution')->name('valueDistribution');
Route::post('/pentaho/valueDistribution/process', 'PentahoLogicController@processValueDistribution');
Route::get('/pentaho/valueDistribution/view', 'PentahoLogicController@viewValueDistribution')->name('valueDistributionView');

Route::get('/pentaho/valueSimilarity', 'PentahoLogicController@runValueSimilarity')->name('valueSimilarity');
Route::post('/pentaho/valueSimilarity/process', 'PentahoLogicController@processValueSimilarity');
Route::get('/pentaho/valueSimilarity/view', 'PentahoLogicController@viewValueSimilarity')->name('valueSimilarityView');

Route::get('/pentaho/dataCompleteness', 'PentahoLogicController@runDataCompleteness')->name('dataCompleteness');
Route::post('/pentaho/dataCompleteness/process', 'PentahoLogicController@processDataCompleteness');
Route::get('/pentaho/dataCompleteness/view', 'PentahoLogicController@viewDataCompleteness')->name('dataCompletenessView');

Route::get('/pentaho/dataDeduplication', 'PentahoLogicController@runDataDeduplication')->name('dataDeduplication');
Route::post('/pentaho/dataDeduplication/process', 'PentahoLogicController@processDataDeduplication');
Route::get('/pentaho/dataDeduplication/view', 'PentahoLogicController@viewDataDeduplication')->name('dataDeduplicationView');

Route::get('/pentaho/shownull', 'PentahoLogicController@runShownull')->name('shownull');
Route::post('/pentaho/shownull/process', 'PentahoLogicController@processShownull');
Route::get('/pentaho/shownull/view', 'PentahoLogicController@viewShownull')->name('shownullView');

Route::get('/pentaho/clustering', 'PentahoLogicController@runClustering')->name('clustering');
Route::post('/pentaho/clustering/process', 'PentahoLogicController@processClustering');
Route::get('/pentaho/clustering/view', 'PentahoLogicController@viewClustering')->name('clusteringView');

Route::get('/pentaho/outlier', 'PentahoLogicController@runOutlier')->name('outlier');
Route::post('/pentaho/outlier/process', 'PentahoLogicController@processOutlier');
Route::get('/pentaho/outlier/view', 'PentahoLogicController@viewOutlier')->name('outlierView');

Route::get('/database', 'DatabaseConnectionController@index')->name('database')->middleware('auth');
Route::post('/databaseUpdate', 'DatabaseConnectionController@update')->name('databaseUpdate')->middleware('auth');

//Cleansing
Route::get('/cleansing/pattern', 'CleansingController@runPatternCleansing')->name('pattern_cleansing')->middleware('auth','admin');
Route::post('/cleansing/pattern/choose-pattern', 'CleansingController@choosePattern')->name('choose_pattern')->middleware('auth','admin');
Route::post('/cleansing/pattern/process', 'CleansingController@processPatternCleansing')->name('pattern_cleansing_process')->middleware('auth','admin');
//baru cleansing
Route::post('/cleansing/pattern/choose-pattern2', 'CleansingModul@choosePattern')->name('choose_pattern2')->middleware('auth','admin');
Route::post('/cleansing/pattern/process', 'CleansingModul@processPatternCleansing')->name('pattern_cleansing_process2')->middleware('auth','admin');
Route::get('/cleansing/pattern/view_delete_spaces', 'CleansingModul@viewPattern2')->name('view_delete_space')->middleware('auth','admin');
Route::get('/cleansing/pattern/view_choose_patterns', 'CleansingModul@viewPattern3')->name('view_choose_pattern')->middleware('auth','admin');
Route::get('/cleansing/pattern/view_punctuation', 'CleansingModul@viewPattern4')->name('view_punctuation_pattern')->middleware('auth','admin');
Route::get('/cleansing/pattern/view_change', 'CleansingModul@viewPattern')->name('view_change_pattern')->middleware('auth','admin');
Route::get('/cleansing/pattern/view_all_cleansed', 'CleansingModul@viewPattern5')->name('view_all_cleansed')->middleware('auth','admin');


Route::get('/cleansing/null', 'CleansingController@runNullCleansing')->name('cleansing_null')->middleware('auth','admin');
Route::post('/cleansing/null/process', 'CleansingController@processNullCleansing')->name('cleansing_null_process')->middleware('auth','admin');
Route::get('/cleansing/null/view', 'CleansingController@viewNull')->name('cleansing_null_view')->middleware('auth','admin');
//=======
Route::get('/pentaho/pattern', 'PentahoLogicController@runPattern')->name('pattern');
Route::post('/pentaho/pattern/process', 'PentahoLogicController@processPattern');
Route::get('/pentaho/pattern/view', 'PentahoLogicController@viewPattern')->name('patternView');

Route::get('/pentaho/valueDistribution', 'PentahoLogicController@runValueDistribution')->name('valueDistribution');
Route::post('/pentaho/valueDistribution/process', 'PentahoLogicController@processValueDistribution');
Route::get('/pentaho/valueDistribution/view', 'PentahoLogicController@viewValueDistribution')->name('valueDistributionView');

Route::get('/pentaho/valueSimilarity', 'PentahoLogicController@runValueSimilarity')->name('valueSimilarity');
Route::post('/pentaho/valueSimilarity/process', 'PentahoLogicController@processValueSimilarity');
Route::get('/pentaho/valueSimilarity/view', 'PentahoLogicController@viewValueSimilarity')->name('valueSimilarityView');

Route::get('/pentaho/dataCompleteness', 'PentahoLogicController@runDataCompleteness')->name('dataCompleteness');
Route::post('/pentaho/dataCompleteness/process', 'PentahoLogicController@processDataCompleteness');
Route::get('/pentaho/dataCompleteness/view', 'PentahoLogicController@viewDataCompleteness')->name('dataCompletenessView');

Route::get('/pentaho/dataDeduplication', 'PentahoLogicController@runDataDeduplication')->name('dataDeduplication');
Route::post('/pentaho/dataDeduplication/process', 'PentahoLogicController@processDataDeduplication');
Route::get('/pentaho/dataDeduplication/view', 'PentahoLogicController@viewDataDeduplication')->name('dataDeduplicationView');

Route::get('/pentaho/shownull', 'PentahoLogicController@runShownull')->name('shownull');
Route::post('/pentaho/shownull/process', 'PentahoLogicController@processShownull');
Route::get('/pentaho/shownull/view', 'PentahoLogicController@viewShownull')->name('shownullView');

Route::get('/pentaho/clustering', 'PentahoLogicController@runClustering')->name('clustering');
Route::post('/pentaho/clustering/process', 'PentahoLogicController@processClustering');
Route::get('/pentaho/clustering/view', 'PentahoLogicController@viewClustering')->name('clusteringView');

Route::get('/pentaho/outlier', 'PentahoLogicController@runOutlier')->name('outlier');
Route::post('/pentaho/outlier/process', 'PentahoLogicController@processOutlier');
Route::get('/pentaho/outlier/view', 'PentahoLogicController@viewOutlier')->name('outlierView');

Route::get('/database', 'DatabaseConnectionController@index')->name('database')->middleware('auth');
Route::post('/databaseUpdate', 'DatabaseConnectionController@update')->name('databaseUpdate')->middleware('auth');


//MULTIPROCESS
Route::get('/multiproccess', 'MultiProccessController@index')->name('multiproccess')->middleware('auth');
Route::post('/multiproccess/excute', 'MultiProccessController@proccess')->name('multiproccess-exec')->middleware('auth');
Route::get('/multiproccess/result', 'MultiProccessController@viewResult')->name('multiproccessView')->middleware('auth');

//MONITORING
Route::get('/monitoring/shownull','MonitoringController@showNullMonitoring')->name('nullMonitorView');
Route::get('/monitoring/nullmonitoringdata','MonitoringController@getNullData')->name('nullMonitorData');
Route::get('/monitoring/shownull/view', 'MonitoringController@viewShownull')->name('nullViewDGPO');
Route::get('/report/null','ReportController@nullReport')->name('nullreport');

Route::get('/monitoring/pattern','MonitoringController@showPatternMonitoring')->name('patternMonitorView');
Route::get('/monitoring/patternmonitoringdata','MonitoringController@getPatternData')->name('patternMonitorData');
Route::get('/monitoring/pattern/view', 'MonitoringController@viewPattern')->name('patternViewDGPO');
Route::get('/report/pattern','ReportController@patternReport')->name('patternreport');

Route::get('/monitoring/completenessmonitoringdata','MonitoringController@getCompletenessData')->name('completenessMonitorData');
Route::get('/monitoring/completeness','MonitoringController@showCompletenessMonitoring')->name('completenessMonitorView');
Route::get('/monitoring/completeness/view', 'MonitoringController@viewDataCompleteness')->name('completenessViewDGPO');
Route::get('/report/completeness','ReportController@completenessReport')->name('completenessreport');


Route::get('/monitoring/distributionmonitoringdata','MonitoringController@getDistributionData')->name('distributionMonitorData');
Route::get('/monitoring/distribution','MonitoringController@showDistributionMonitoring')->name('distributionMonitorView');
Route::get('/monitoring/distribution/view', 'MonitoringController@viewValueDistribution')->name('distributionViewDGPO');
Route::get('/report/distribution','ReportController@distributionReport')->name('distributionreport');


Route::get('/monitoring/clusteringmonitoringdata','MonitoringController@getClusteringData')->name('clusteringMonitorData');
Route::get('/monitoring/clustering','MonitoringController@showClusteringMonitoring')->name('clusteringMonitorView');
Route::get('/monitoring/clustering/view', 'MonitoringController@viewClustering')->name('clusteringViewDGPO');
Route::get('/report/clustering','ReportController@clusteringReport')->name('clusteringreport');

// MCP SIL
Route::get('/monitoring/similarity', 'MonitoringController@showSimilarityMonitoring')->name('similarityMonitorView');//blm beres
Route::get('/monitoring/similaritymonitoringdata', 'MonitoringController@getSimilarityData')->name('similarityMonitorData');//blm beres
Route::get('/monitoring/similarity/view','MonitoringController@viewSimilarity')->name('similarityView');//blm beres
Route::get('/report/similarity','ReportController@similarityReport')->name('similarityreport');

Route::get('/monitoring/deduplication','MonitoringController@showDeduplicationMonitoring')->name('deduplicationMonitorView');//blm beres
Route::get('/monitoring/deduplicationmonitoringdata', 'MonitoringController@getDeduplicationData')->name('deduplicationMonitorData');//blm beres
Route::get('/monitoring/deduplication/view','MonitoringController@viewDeduplication')->name('deduplicationView');//blm beres
Route::get('/report/deduplication','ReportController@deduplicationReport')->name('deduplicationReport');
// end

Route::get('/report/clusterdata','ReportController@clusteringReportJson')->name('csvrespon');

// CAHYA
Route::get('/cleansing/dedup', 'CleansingController@runDedupCleansing')->name('dedup_cleansing')->middleware('auth','admin');
Route::post('/cleansing/dedup/choose-dedup', 'CleansingController@chooseDedup')->name('choose_dedup')->middleware('auth','admin');
Route::post('/cleansing/dedup/process', 'CleansingController@processDedupCleansing')->name('dedup_cleansing_process')->middleware('auth','admin');
Route::get('/cleansing/dedup/view', 'CleansingController@viewDedup')->name('dedup_cleansing_view')->middleware('auth','admin');
Route::post('/cleansing/dedup/runDedup', 'CleansingController@runDedup')->name('runDedup')->middleware('auth','admin');

Route::post('/cleansing/dedup/manualProcess', 'CleansingController@processDedupCleansingManual')->name('dedup_cleansing_process_manual')->middleware('auth');
Route::get('/cleansing/dedup/update', 'CleansingController@changeDedup')->name('dedup_update');
Route::get('/cleansing/dedup/status', 'CleansingController@statusDedup')->name('dedup_status');


Route::get('/cleansing/clustering', 'CleansingController@runClusteringCleansing')->name('clustering_cleansing')->middleware('auth','admin');
Route::post('/cleansing/clustering/choose-clustering', 'CleansingController@chooseClustering')->name('choose_clustering')->middleware('auth','admin');
Route::post('/cleansing/clustering/process', 'CleansingController@processClusteringCleansing')->name('clustering_cleansing_process')->middleware('auth','admin');
Route::get('/cleansing/clustering/view', 'CleansingController@viewClustering')->name('clustering_cleansing_view')->middleware('auth','admin');
Route::post('/cleansing/clustering/runClustering', 'CleansingController@runClustering')->name('runClustering')->middleware('auth','admin');

Route::post('/cleansing/clustering/manualProcess', 'CleansingController@processClusteringCleansingManual')->name('dedup_cleansing_process_manual')->middleware('auth');
Route::get('/cleansing/clustering/update', 'CleansingController@changeClustering')->name('dedup_update');
Route::get('/cleansing/clustering/status', 'CleansingController@statusClustering')->name('dedup_status');

//end cahya

//CLEANSING haidar
Route::get('/cleansing/pattern/', 'CleansingController@runPatternCleansing')->name('pattern_cleansing')->middleware('auth');
Route::post('/cleansing/pattern/choose-pattern', 'CleansingModul@choosePattern2')->name('choose_pattern')->middleware('auth');
Route::post('/cleansing/pattern/choose-pattern2', 'CleansingModul@choosePattern')->name('choose_pattern2')->middleware('auth');

Route::post('/cleansing/pattern/process', 'CleansingController@processPatternCleansing')->name('pattern_cleansing_process')->middleware('auth');
Route::post('/cleansing/pattern/manualProcess', 'CleansingController@processPatternCleansingManual')->name('pattern_cleansing_process_manual')->middleware('auth');
Route::post('/cleansing/pattern/manualProcessSub', 'CleansingController@processPatternCleansingManualSub')->name('pattern_cleansing_process_manual_sub')->middleware('auth');

Route::post('/cleansing/pattern/process2', 'CleansingModul@processPatternCleansing')->name('pattern_cleansing_process2')->middleware('auth');
Route::post('/cleansing/pattern/manualProcess', 'CleansingModul@processPatternCleansingManual')->name('pattern_cleansing_process_manual2')->middleware('auth');
Route::post('/cleansing/pattern/manualProcess2', 'CleansingModul@processPatternCleansingManual2')->name('pattern_cleansing_process_manual2')->middleware('auth');

//cleansing baru
Route::get('/cleansing/pattern/index', 'CleansingModul@index');
Route::get('/cleansing/pattern/pattern_change', 'CleansingModul@runPatternCleansing');
Route::get('/cleansing/pattern/delete_space', 'CleansingModul@runPatternCleansing2');
Route::get('/cleansing/pattern/pattern_punctuation', 'CleansingModul@runPatternCleansing3');
Route::get('/cleansing/pattern/result_choose_pattern', 'CleansingModul@runPatternCleansing4');
Route::get('/cleansing/pattern/all_cleansed', 'CleansingModul@runPatternCleansing5');
Route::post('/cleansing/pattern/change_pattern_process', 'CleansingModul@change_process')->name('pattern_cleansing_process_manual_sub')->middleware('auth');
Route::post('/cleansing/pattern/punctuation_pattern_process', 'CleansingModul@punctuation_process')->name('pattern_cleansing_process_manual_sub2')->middleware('auth');
Route::post('/cleansing/pattern/delete_space_process', 'CleansingModul@delete_process')->name('delete_space_process')->middleware('auth');

Route::get('/cleansing/pattern/update', 'CleansingController@changePattern')->name('pattern_update');
Route::get('/cleansing/pattern/status', 'CleansingController@statusPattern')->name('pattern_status');
Route::get('/cleansing/pattern/update_delete', 'CleansingController@deleteSpace')->name('delete_space_update');
Route::get('/cleansing/pattern/', 'CleansingModul@viewtable2')->name('cleansing_view_table2')->middleware('auth','admin');

Route::get('/cleansing/null/index', 'CleansingModul@indexnull');
Route::get('/cleansing/null', 'CleansingController@runNullCleansing')->name('cleansing_null')->middleware('auth');
Route::post('/cleansing/null/process', 'CleansingController@processNullCleansing')->name('cleansing_null_process')->middleware('auth');
Route::get('/cleansing/null/viewtable', 'CleansingModul@viewtable')->name('cleansing_view_table')->middleware('auth','admin');
Route::post('/cleansing/null/next_process', 'CleansingModul@nextprocess')->name('cleansing_null')->middleware('auth','admin');
Route::get('/cleansing/null/viewresult', 'CleansingModul@viewresult')->name('cleansing_view_result')->middleware('auth','admin');

Route::get('/home_mdm','HomeMasterData@homeMDM')->name('home_mdm')->middleware('auth');
// Controller dari MDM ===========================================================================

Route::get('/monitoring/monitor','monitoring@monitor')->name('monitor');
Route::get('/showData', 'monitoring@showData')->name('showData');

Route::get('/monitoring/monitor_bmd','monitoring@monitor_bmd')->name('monitor_bmd');
Route::get('/monitoring/monitor_ijepa','monitoring@monitor_ijepa')->name('monitor_ijepa');
Route::get('/monitoring/monitor_lcgc','monitoring@monitor_lcgc')->name('monitor_lcgc');


Route::view('masterUser','masterUser');
Route::get('masterUser','showMasterController@masterUser');

Route::view('/chart', 'chart');
Route::view('/showMaster','showMaster');
Route::get('/showMaster','showMasterController@index');
Route::view('dashboard','panel.home');
Route::get('history/update/{created_at}','histoController@hisUp');
Route::get('history/insert/{created_at}','histoController@viewHis');
Route::view('history','history');
Route::get('history','histoController@index');
Route::view('meta','meta');
Route::get('viewMeta/{id}','metadataController@viewMeta');


Route::middleware('admin')->group(function() {
	Route::view('/home_mdm', 'panel.home');
	Route::get('/home_mdm', 'infoController@index');
    Route::view('showNoMatch','showNoMatch');
    Route::get('/showNoMatch','showNomatch@index');
    Route::get('showNoMatch/search','showNomatch@search');
    Route::post('insert_data', 'InsUpdController@proses_mdm');
    Route::get('c_master','createController@index');
    Route::view('/c_master', 'c_master');

    Route::post('mail', 'InsUpdController@InsertData');

    Route::view('pentaho_ins','pentaho_ins');
    Route::view('pentaho_upd','pentaho_upd');


    Route::group(['prefix' => 'laravel-crud-search-sort'], function () {
        Route::get('/home_mdm', 'showNomachController@index');

    });
    Route::group(['prefix' => 'laravel-crud-search-sort'], function () {
        Route::get('/home_mdm', 'showMasterController@index');

    });

});

Route::middleware('admin')->group(function(){
    Route::view('/app1_mdm/home_app1','panel.home');
    Route::get('/app1_mdm/home_app1', 'infoController@index');

    Route::view('bmdtp/chart','bmdtp.chart');

});

Route::middleware('admin')->group(function(){
    Route::view('/app2_mdm/home_app2','panel.home');
    Route::get('/app2_mdm/home_app2', 'infoController@index');

    Route::view('ijepa/chart','ijepa.chart');
});

Route::middleware('admin')->group(function(){
    Route::view('/app3_mdm/home_app3','panel.home');
    Route::get('/app3_mdm/home_app3', 'infoController@index');

    Route::view('lcgc/chart','lcgc.chart');

    Route::post('insert_lcgc', 'InsUpdController@proses_lcgc');
});

//Cleansing_MDM
Route::get('/cleansing_mdm/index', 'CleansingMDM@index');

Route::get('/cleansing_mdm/punctuation', 'CleansingMDM@punctuation_index')->name('punctuation');
Route::post('/cleansing_mdm/punctuation/process', 'CleansingMDM@processPunctuation');
Route::get('/cleansing_mdm/punctuation/view', 'CleansingMDM@viewPunctuation')->name('viewPunctuation');

Route::get('/cleansing_mdm/uppercase', 'CleansingMDM@uppercase_index')->name('uppercase');
Route::post('/cleansing_mdm/uppercase/process', 'CleansingMDM@processUppercase');
Route::get('/cleansing_mdm/uppercase/view', 'CleansingMDM@viewUppercase')->name('viewUppercase');


Route::get('/cleansing_mdm/whitespace', 'CleansingMDM@whitespace_index')->name('whitespace');
Route::post('/cleansing_mdm/whitespace/process', 'CleansingMDM@processWhitespace');
Route::get('/cleansing_mdm/whitespace/view', 'CleansingMDM@viewWhitespace')->name('viewWhitespace');
