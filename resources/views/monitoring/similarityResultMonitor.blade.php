@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-bar-chart"></em> Monitoring</li>
        <li class="active">Value Similarity</li>
        <li class="active">Value Similarity Result</li>
    </ol>

<div class="row">
    <div class="col-lg-12">
        <div class="bs-callout bs-callout-success">
            <h4>Result & Information</h4>
<pre>
  ID Running : {{ $id_running }}
  Host Name : {{ $datasource_detail['host'] }}
  Database Name : {{ $datasource_detail['db_name'] }}
  User Name : {{ $datasource_detail['db_username'] }}
  Port : {{ $datasource_detail['port'] }}
  First Table name : {{ $datasource_detail['tab1'] }}
  First Column Name : {{ $datasource_detail['col1'] }}
  Second Table name : {{ $datasource_detail['tab2'] }}
  Second Column Name : {{ $datasource_detail['col2'] }}

  > Measured Value Information
  0/Empty : There is no similar data for that value
  1 : The data is similar for that value
  Higher number means data is more similiar
</pre>
        </div>
    </div>
</div>
    
      
<hr>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
          <thead>
            <tr>
              <th>ID</th>
              <th>Column 1</th>
              <th data-sortable="true">Measured Value</th>
              <th>Column 2</th>
            </tr>
          </thead>
          @foreach($results as $row)
          @if(($loop->first) && (!empty($_GET['done'])))
          <tr class="success">
            @else
            <tr>
              @endif
              <td>{{$row->id}}</td>
              <td>{{$row->column_1}}</td>
              <td>{{$row->measure_value}}</td>
              <td>{{$row->column_2}}</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
        {{-- <a href="{{route('similarityMonitorView')}}"<button type="button" class="btn btn-success btn-blok">Back</button></a> --}}
    </div>
  </div>
</div>

</div><!--/.row-->

@endsection