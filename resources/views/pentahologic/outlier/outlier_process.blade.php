@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/outlier')}}">Outlier</a></li>
    <li class="active">Process</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Processing Outlier</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result</h4>
  <hr>
  <pre>
    @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'C:\Pentaho\design-tools\data-integration\pan.bat /file:"C:\xampp\htdocs\PersatuanDQMxMDM-master\pentaho file\New_Currently_Using\web_outlier.ktr" /param:"col1='.$column1.'" /param:"col2='.$column2.'" /param:"col3='.$column3.'" /param:"tab='.$table.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
  </pre>
  <br>
  <a href="{{route('outlier',['done'=>'1'])}}"<button type="button" class="btn btn-success">See Result</button></a>
</div>


<!--/.row-->
@endsection
