@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-bar-chart"></em> Monitoring</li>
        <li class="active">Data Deduplication</li>
        <li class="active">Data Deduplication Result</li>
    </ol>
</div>
<div class="row">
  <div class="col-lg-12">
    <h2>Data Deduplication Result</h2>
  </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="panel-heading">Running Information</div>
            <div class="bs-callout bs-callout-success">
    <pre>
        ID Running : {{ $id_running }}
        Host Name : {{ $datasource_detail['host'] }}
        Database Name : {{ $datasource_detail['db_name'] }}
        User Name : {{ $datasource_detail['db_username'] }}
        Port : {{ $datasource_detail['port'] }}
        First Table name : {{ $datasource_detail['tab1'] }}
        Second Table name : {{ $datasource_detail['tab2'] }}
        First Column Name(First Table) : {{ $datasource_detail['col1a'] }}
        Second Column Name(First Table) : {{ $datasource_detail['col1b'] }}
        First Column Name(Second Table) : {{ $datasource_detail['col2a'] }}
        Second Column Name(Second Table) : {{ $datasource_detail['col2b'] }}
    
        > Measured Value Information
        EMPTY : There is no duplicate
        0 : There is a duplicate or same data
        1 : There is a probability of duplicate
      </pre>
          </div>
          </div>
        </div>
    </div>
    
    <div class="col-lg-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="panel-heading">
            Running Overview Chart
          </div>
          <div class="bs-callout bs-callout-success">
            <br>
            <div id="deduplicationpiechart"></div>
          </div>
          <br>
        </div>
      </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="panel-heading">Deduplication Profiling Results</div>
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
                <tr>
                  <th>Id</th>
                  <th>Column Value</th>
                  <th>Matched Value</th>
                  <th>Measured Value</th>
                </tr>
              </thead>
                @foreach($results as $row)
                @if(($loop->first) && (!empty($_GET['done'])))
                <tr class="success">
                  @else
                  <tr>
                    @endif
                    <td>{{$row->id}}</td>
                    <td>{{$row->column_name_1}}</td>
                    <td>{{$row->match_value}}</td>
                    <td>{{$row->measure_value}}</td>
                  </tr>
                  @endforeach
          </table>
        </div>
      </div>
    </div>
</div>

{{-- buat chart --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawDeduplicationPieChart);

  function drawDeduplicationPieChart() {
    console.log(windowvar)
        $(document).ready(function () {
            var data = google.visualization.arrayToDataTable(windowvar.allpiedatachart);
            var options = {
                title: 'Deduplication Overview',
                'height' : 300

            };
            var chart = new google.visualization.PieChart(document.getElementById('deduplicationpiechart'));
            chart.draw(data, options);
        })
    }

</script>

@endsection