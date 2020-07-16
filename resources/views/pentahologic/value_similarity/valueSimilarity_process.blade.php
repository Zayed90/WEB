@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('/pentaho/valueSimilarity')}}">Value Similarity</a></li>
    <li class="active">Process</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Processing Value Similarity</h1>
  </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
  <h4>Result</h4>
  <hr>
  <pre>
    @if($isDataExist1 && $isDataExist2)
    @php
    ini_set('max_execution_time', 600);
    set_time_limit(0);
    $exec = 'C:\Pentaho\design-tools\data-integration\pan.bat /file:"C:\xampp\htdocs\PersatuanDQMxMDM-master\pentaho file\New_Currently_Using\web_val_similarity.ktr" /param:"col1='.$column1.'" /param:"tab1='.$table1.'" /param:"col2='.$column2.'" /param:"tab2='.$table2.'" /param:"host='.$host.'" /param:"db_name='.$db_name.'" /param:"db_username='.$db_username.'" /param:"db_password='.$db_password.'" /param:"port='.$port.'" /param:"label= '.$label.'"';
    printf(shell_exec($exec));
    echo $exec;
    @endphp
     @else
     Ops, your database info is not correct
     @endif
  </pre>
  <br>
  @if($isDataExist1 && $isDataExist2)
  <a href="{{route('valueSimilarity',['done'=>'1'])}}"<button type="button" class="btn btn-success">See Result</button></a>
  @else
  <a href="{{route('valueSimilarity')}}"<button type="button" class="btn btn-primary">Back</button></a>
  @endif
</div>


<!--/.row-->
@endsection
