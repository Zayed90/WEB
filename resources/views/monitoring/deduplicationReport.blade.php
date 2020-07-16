@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Data Deduplication</li>
    </ol>
</div>
<div class="row">

    {{-- Card yang di atas --}}
    <div class="col-md-3">
        <div class="panel panel-red" style="margin-top: 20px;">
            <div class="panel-body">
                <p>All Duplicated Data</p>
                <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#duplicatedModal">
                   {{$jumlahduplciated}} Data
                </button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-orange" style="margin-top: 20px;">
            <div class="panel-body">
                <p>All Probably Duplicated Data</p>
                <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#probablyModal" >
                    {{$jumlahprobably}} Data
                </button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-blue" style="margin-top: 20px;">
            <div class="panel-body">
                <p>All Unique Data</p>
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

    {{--  Line Chart --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="true">Line Chart</a></li>
                        {{-- <li class=""><a href="#tab2" data-toggle="tab" aria-expanded="false">Bar Chart</a></li> --}}
                        <li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false">Pie Chart</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab1">
                            <div class="panel-heading">
                                Data Deduplication Overview (Line Chart)
                                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                            <div class="panel-body">
                                <div id="deduplicationchart"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel-heading">
                                        Data Deduplication Overview (Pie Chart)
                                        <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                                    <div class="panel-body">
                                        <div id="deduplicationpiechart"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-heading">
                                        {{-- Data Deduplication Overview (Pie Chart) --}}
                                        <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                                    <div class="panel-body">
                                        <h3>Description</h3>
                                        <p>
                                            0.0 : Duplicatied <br>
                                            1.0 : Probably Duplicated <br>
                                            NULL : Unique (Not match with any of other column's value) <br>
                                        </p>
                                        <div id="deduplicationpiechart"></div>
                                    </div>
                                </div>
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
                    Duplicated Data Distribution
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="duplicatedpiechart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Probably Duplicated Data Distribution
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="probablypiechart"></div>
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

    {{-- Tabel yang di bawah --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Data Deduplication Profiling Running
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th>Id Running</th>
                            <th>Database</th>
                            <th>Port</th>
                            <th>Table1</th>
                            <th>Column1.1</th>
                            <th>Column1.2</th>
                            <th>Table2</th>
                            <th>Column2.1</th>
                            <th>Column2.2</th>
                            <th>Total Data</th>
                            <th>Date Created</th>
                            <th>Action</th>
                            {{-- <th>Date Created</th> --}}
                        </tr>
                        </thead>
                        {{-- disini adalah tr isinya --}}
                        @foreach($alldeduplication as $row)
                        @if(($loop->first) && (!empty($_GET['done'])))
                            <tr class="success">
                        @else
                            <tr>
                                @endif
                                <td>{{$row->id_running}}</td>
                                <td>{{$row->db_name}}</td>
                                <td>{{$row->port}}</td>
                                <td>{{$row->tab1}}</td>
                                <td>{{$row->col1a}}</td>
                                <td>{{$row->col1b}}</td>
                                <td>{{$row->tab2}}</td>
                                <td>{{$row->col2a}}</td>
                                <td>{{$row->col2b}}</td>
                                <td>{{$row->total}}</td>
                                <td>{{$row->tanggal}}</td>
                                <td>
                                    <a href="{{route('deduplicationView',['id'=>$row->id_running])}}">
                                        See Result
                                    </a></td>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}

    {{-- Modal Duplicated Data --}}
    <div class="row">
        <div class="modal panel-default" id="duplicatedModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%; height: 75%" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <br>
                        <h3 class="modal-title" id="exampleModalLabel">Duplicated Data on Database</h3>
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
                                    <h4>Duplicated Data Records</h4>
                                    <div role="tabpanel" class="tab-pane active" id="valid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Running</th>
                                                <th>Column 1</th>
                                                <th>Match Value</th>
                                                <th>Measure Value</th>
                                            </tr>
                                            </thead>
                                            @foreach($duplicateddatas as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->id_running}}</td>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal Probably Duplicated Data --}}
    <div class="row">
        <div class="modal panel-default" id="probablyModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%; height: 75%" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <br>
                        <h3 class="modal-title" id="exampleModalLabel">Probably Duplicated Data on Database</h3>
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
                                    <h4>Probably Duplicated Data Records</h4>
                                    <div role="tabpanel" class="tab-pane active" id="valid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Id Running</th>
                                                <th>Column 1</th>
                                                <th>Match Value</th>
                                                <th>Measure Value</th>
                                            </tr>
                                            </thead>
                                            @foreach($probablydatas as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->id_running}}</td>
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
                                                <th>Match Value</th>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.load('current', {'packages':['line']});
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawDeduplicationChart);
    google.charts.setOnLoadCallback(drawDeduplicationPieChart);
    google.charts.setOnLoadCallback(drawDuplicatedPieChart);
    google.charts.setOnLoadCallback(drawProbablyPieChart);
    google.charts.setOnLoadCallback(drawUniqueePieChart);
    google.charts.setOnLoadCallback(drawDeduplicationBarChart);

    function drawDeduplicationChart() {
      var data = google.visualization.arrayToDataTable(windowvar.deduplicationdashboard);

      var options = {
          'title': 'Profiling - Data Deduplication',
          'height' : 300
      };

      var chart = new google.charts.Line(document.getElementById('deduplicationchart'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }

    // SIL
    function drawDeduplicationBarChart() {
      var data = google.visualization.arrayToDataTable(windowvar.deduplicationbarchart);

      var options = {
          'title': 'Profiling - Value Similarity',
          'height' : 300
      };

      var chart = new google.charts.Bar(document.getElementById('dedupbarchart'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawDuplicatedPieChart() {
        $(document).ready(function () {
            var data = google.visualization.arrayToDataTable(windowvar.duplicatedpiedatachart);
            var options = {
                title: 'Duplicated Data Distribution'
            };
            var chart = new google.visualization.PieChart(document.getElementById('duplicatedpiechart'));
            chart.draw(data, options);
        })
    }
    function drawProbablyPieChart() {
        $(document).ready(function () {
            var data = google.visualization.arrayToDataTable(windowvar.probablypiedatachart);
            var options = {
                title: 'Probably Duplicated Data Distribution'
            };
            var chart = new google.visualization.PieChart(document.getElementById('probablypiechart'));
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

    $(window).resize(function(){
      drawDeduplicationChart();
      drawDuplicatedPieChart();
      drawUniqueePieChart();
      drawDeduplicationPieChart();
      drawDeduplicationBarChart();
    });
</script>

@endsection