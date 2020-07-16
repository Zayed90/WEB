<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 5/20/2019
 * Time: 1:51 AM
 */

namespace App\Http\Controllers;
use App\Http\Controllers\ReportController;

class ProfilingScoringController
{
    public static function patternScoring(){
        $a = ReportController::countryPatternCheck();
        $passscore = round(($a[1][1]+$a[2][1])/2);
        $failscore = round(($a[1][2]+$a[2][2])/2);
        return [$passscore,$failscore];
    }
    public static function clusteringScoring(){
//        $a = ReportController::clusteringReportJson();
//        $minratio=min(array_column($a, ''));
//        $maxratio=max(array_column($a, ''));
//        $max = -9999999; //will hold max val
//        $found_item = null; //will hold item with max val;
//
//        return [$minratio,$maxratio];
    }
}