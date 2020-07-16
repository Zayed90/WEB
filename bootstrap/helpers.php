<?php

use Zttp\Zttp;
use Illuminate\Support\Facades\Session;

function requestToPentaho(array $queryParams)
{
  $args = func_get_args();

  if (!empty($args[1])) {
    $credentials = base64_encode(env('CREDENTIAL_PENTAHO'));
    $res = Zttp::withHeaders([
    'Authorization' => ['Basic '. $credentials],
  ])->get(env('URL_PENTAHO') . "executeJob/", $queryParams);
  }
  else {
    $credentials = base64_encode(env('CREDENTIAL_PENTAHO'));
    $res = Zttp::withHeaders([
    'Authorization' => ['Basic '. $credentials],
  ])->get(env('URL_PENTAHO') . "executeTrans/", $queryParams);
  }
  // dd($res,env('URL_PENTAHO'),$args);


    // $credentials = base64_encode(env('CREDENTIAL_PENTAHO'));
    // $res = Zttp::withHeaders([
    //   'Authorization' => ['Basic '. $credentials],
    // ])->get(env('URL_PENTAHO'), $queryParams);
    
    if($res->isOK()) {
        Session::flash('success', 'Success');
      }else {
        Session::flash('error', 'Error');
      }

}