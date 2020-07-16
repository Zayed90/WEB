@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Value Similarity</li>
    </ol>
</div>
<div class="row">
    {{-- Card yang di Atas --}}
    <div class="col-md-3">
        <div class="panel panel-red" style="margin-top: 20px;">
            <div class="panel-body">
                <p>Data Similar</p>
                <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#similarModal">
                    {{$jumlahsimilar}} Data
                </button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-orange" style="margin-top: 20px;">
            <div class="panel-body">
                <p>Data with High Similarity</p>
                <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#highsimilarModal" >
                    {{$jumlahhighsimiar}} Data
                </button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-blue" style="margin-top: 20px;">
            <div class="panel-body">
                <p>Uniquee Data</p>
                <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#uniqueeModal" >
                    {{$jumlahuniquee}} Data
                </button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-default" style="margin-top: 20px;" >
            <div class="alert bg-danger" role="alert">
                <h4><b>Data Quality Status</b></h4>
                <em class="fa fa-lg fa-warning">&nbsp;</em>Still Not Meeting the KPI
            </div>
        </div>
    </div><!--/.col-->

    {{-- Overview Chart --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">Bar Chart</a></li>
                        <li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false">Pie Chart</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab1">
                            <div class="panel-heading">
                                Similarity Overview (Bar Chart)
                                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                            <div class="panel-body">
                                <div id="similaritychart"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2">
                            <div class="panel-heading">
                                Similarity Overview (Pie Chart)
                                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                            <div class="panel-body">
                                <div id="#"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pie Chart --}}
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Similar Data Distribution
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="similarpiechart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Highly Similar Data Distribution
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="highlysimilarpiechart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Unique Data Distribution
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="uniqueepiechart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel di Bawah --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Value Similarity Profiling Running
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th>Id Running</th>
                            <th>Database</th>
                            <th>Port</th>
                            <th>Table1</th>
                            <th>Column1</th>
                            <th>Table2</th>
                            <th>Column2</th>
                            <th>Total Data</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        {{-- disini adalah tr isinya --}}
                        @foreach($allsimilarity as $row)
                            @if(($loop->first) && (!empty($_GET['done'])))
                                <tr class="success">
                            @else
                                <tr>
                                    @endif
                                    <td>{{$row->id_running}}</td>
                                    <td>{{$row->db_name}}</td>
                                    <td>{{$row->port}}</td>
                                    <td>{{$row->tab1}}</td>
                                    <td>{{$row->col1}}</td>
                                    <td>{{$row->tab2}}</td>
                                    <td>{{$row->col2}}</td>
                                    <td>{{$row->totalrecord}}</td>
                                    <td>{{$row->tanggal}}</td>
                                    <td>
                                        <a href="{{route('similarityView',['id'=>$row->id_running])}}">
                                            See Result
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}

    {{-- Modal Similar Data --}}
    <div class="row">
        <div class="modal panel-default" id="similarModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%; height: 75%" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <br>
                        <h3 class="modal-title" id="exampleModalLabel">Similar Data on Database (Redudant)</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close" style="font-size:18px;color:red"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p>
                                Database Name : {{$database_name}} <br>
                                Table Name 1 : {{$table1}} <br>
                                Table Name 2 : {{$table2}} <br>
                            </p>
                        <hr>
                        <div class="row">
                            <div role="tabpanel">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <h4>Similar Data Records</h4>
                                    <div role="tabpanel" class="tab-pane active" id="valid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Running</th>
                                                <th>Column 1</th>
                                                <th>Column 2</th>
                                                <th>Measure Value</th>
                                            </tr>
                                            </thead>
                                            @foreach($similardatas as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->id_running}}</td>
                                                        <td>{{$row->column_1}}</td>
                                                        <td>{{$row->column_2}}</td>
                                                        <td>{{$row->measure_value}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal High Similarity Data --}}
    <div class="row">
        <div class="modal panel-default" id="highsimilarModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%; height: 75%;" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <br>
                        <h3 class="modal-title" id="exampleModalLabel">Data with High Similarity (Probably Duplicated)</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close" style="font-size:18px;color:red"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Database Name : {{$database_name}} <br>
                            Table Name 1 : {{$table1}} <br>
                            Table Name 2 : {{$table2}} <br>
                        </p>
                        <hr>
                        <div class="row">
                            <div role="tabpanel">
                                
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <h4>Highly Similar Data Records</h4>
                                    <div role="tabpanel" class="tab-pane active" id="valid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Running</th>
                                                <th>Column 1</th>
                                                <th>Column 2</th>
                                                <th>Measure Value</th>
                                            </tr>
                                            </thead>
                                            @foreach($highsimilardatas as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->id_running}}</td>
                                                        <td>{{$row->column_1}}</td>
                                                        <td>{{$row->column_2}}</td>
                                                        <td>{{$row->measure_value}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Uniquee Data --}}
    <div class="row">
        <div class="modal panel-default" id="uniqueeModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%; height: 75%" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <br>
                        <h3 class="modal-title" id="exampleModalLabel">Uniquee Data on Database</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close" style="font-size:18px;color:red"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Database Name : {{$database_name}} <br>
                            Table Name 1 : {{$table1}} <br>
                            Table Name 2 : {{$table2}} <br>
                        </p>
                        <hr>
                        <div class="row">
                            <div role="tabpanel">
                                
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <h4>Uniquee Data Records</h4>
                                    <div role="tabpanel" class="tab-pane active" id="valid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Running</th>
                                                <th>Column 1</th>
                                                <th>Column 2</th>
                                                <th>Measure Value</th>
                                            </tr>
                                            </thead>
                                            @foreach($uniqueedatas as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->id_running}}</td>
                                                        <td>{{$row->column_1}}</td>
                                                        <td>{{$row->column_2}}</td>
                                                        <td>{{$row->measure_value}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable(windowvar.patterndashboard);

      var options = {
        title: 'My Daily Activities'
      };

      var chart = new google.visualization.PieChart(document.getElementById('patternchart'));

      chart.draw(data, options);
    }
  </script>

  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.load('current', {'packages':['bar']});

    // Set On Load Chart MCP SIL
    google.charts.setOnLoadCallback(drawSimilarityChart);
    google.charts.setOnLoadCallback(drawSimilarityPieChart);
    google.charts.setOnLoadCallback(drawHighlySimilarPieChart);
    google.charts.setOnLoadCallback(drawUniqueePieChart);

    // SIL
    function drawSimilarityChart() {
      var data = google.visualization.arrayToDataTable(windowvar.similaritybarchart);

      var options = {
          'title': 'Profiling - Value Similarity',
          'height' : 300
      };

      var chart = new google.charts.Bar(document.getElementById('similaritychart'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    
    function drawSimilarityPieChart() {
        $(document).ready(function () {
            var data = google.visualization.arrayToDataTable(windowvar.similarpiedatachart);
            var options = {
                title: 'Similar Data Distribution'
            };
            var chart = new google.visualization.PieChart(document.getElementById('similarpiechart'));
            chart.draw(data, options);
        })
    }

    function drawUniqueePieChart() {
        $(document).ready(function () {
            var data = google.visualization.arrayToDataTable(windowvar.uniqueepiedatachart);
            var options = {
                title: 'Uniquee Data Distribution'
            };
            var chart = new google.visualization.PieChart(document.getElementById('uniqueepiechart'));
            chart.draw(data, options);
        })
    }

    function drawHighlySimilarPieChart() {
        $(document).ready(function () {
            var data = google.visualization.arrayToDataTable(windowvar.highlysimilarpiedatachart);
            var options = {
                title: 'Highly Similar Data Distribution'
            };
            var chart = new google.visualization.PieChart(document.getElementById('highlysimilarpiechart'));
            chart.draw(data, options);
        })
    }

    $(window).resize(function(){
      // SIL
      drawSimilarityChart();
      drawSimilarityPieChart();
      drawHighlySimilarPieChart();
      drawUniqueePieChart();
    });
  </script>

@endsection