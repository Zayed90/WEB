@extends('template')
@section('content')
<style>
.panel:hover{
  
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
 

}
</style>

<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><em class="fa fa-home"></em>Dashboard</a></li>
    <li><a href="{{url('#')}}">Master Data</a></li>
    <li class="active">Data Result</li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Master Data</h1>
  </div>
</div><!--/.row-->


<div class="bs-callout bs-callout-success">
  <h4>Result Data</h4>
  <br>
  <div class="alert bg-teal" role="alert"><em class="fa fa-lg fa-info-circle">&nbsp;</em><i>  Table used to store the result from pentaho logic</i></div>
  <hr>

  <div class="row">
    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          cardinalities_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_cardinalities}} <br>
            Total Collumn : {{$cols_cardinalities}} <br><hr>
            <a href="{{url('sourceView/cardinalities_table_result')}}"<button type="button" class="btn btn-primary btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-success">
        <div class="panel-heading">
          pattern_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_pattern}} <br>
            Total Collumn : {{$cols_pattern}} <br><hr>
            <a href="{{url('sourceView/pattern_table_result')}}"<button type="button" class="btn btn-success btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-info">
        <div class="panel-heading">
          val_distribution_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_valuedistribution}} <br>
            Total Collumn : {{$cols_valuedistribution}} <br><hr>
            <a href="{{url('sourceView/val_distribution_table_result')}}"<button type="button" class="btn btn-primary btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-warning">
        <div class="panel-heading">
          val_similarity_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_valuesimilarity}} <br>
            Total Collumn : {{$cols_valuesimilarity}} <br><hr>
            <a href="{{url('sourceView/val_similarity_table_result')}}"<button type="button" class="btn btn-warning btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-danger">
        <div class="panel-heading">
          data_completeness_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_datacompleteness}} <br>
            Total Collumn : {{$cols_datacompleteness}} <br><hr>
            <a href="{{url('sourceView/data_completeness_table_result')}}"<button type="button" class="btn btn-danger btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-success">
        <div class="panel-heading">
          data_deduplication_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_datadeduplication}} <br>
            Total Collumn : {{$cols_datadeduplication}} <br><hr>
            <a href="{{url('sourceView/data_deduplication_table_result')}}"<button type="button" class="btn btn-success btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          shownull_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_shownull}} <br>
            Total Collumn : {{$cols_shownull}} <br><hr>
            <a href="{{url('sourceView/shownull_table_result')}}"<button type="button" class="btn btn-primary btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-4 col-lg-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          clustering_table_result
        </div>
        <div class="panel-body">
          <p>
            Total Row : {{$rows_clustering}} <br>
            Total Collumn : {{$cols_clustering}} <br><hr>
            <a href="{{url('sourceView/clustering_table_result')}}"<button type="button" class="btn btn-primary btn-block">View Data</button></a>
          </p>
        </div>
      </div>
    </div>
  </div>

</div>
<!--/.Start Lost 2-->


<!--/.End Lost 2-->
@endsection
