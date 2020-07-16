@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Pattern Profiling</li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-red" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Pattern Paling Banyak</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#mostModal">{{$mostpattern}} Pattern</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-blue" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Pattern Paling Sedikit</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#leastModal">{{$leastpattern}} Pattern</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Pattern Passing Score</p>
                    <button style="font-size: 25px;" type="button" disabled="true" class="btn btn-sm btn-default">{{$patternscore[0]}}</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Pattern Fail Score</p>
                    <button style="font-size: 25px;" type="button" disabled="true" class="btn btn-sm btn-default">{{$patternscore[1]}}</button>
                </div>
            </div>
        </div><!--/.col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pattern Terbanyak Tiap Kolom
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="mostpatternchart" style="width: 100%; min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pattern Format Check
                </div>
                    {{--<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>--}}
                <div class="panel-body">
                    <div id="patternformatchart"></div>
                    {{--<div id="mostpatternchart" style="width: 100%; min-height: 300px;"></div>--}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Pattern Running
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>TANGGAL</th>
                                <th>KOLOM</th>
                                <th>TABEL</th>
                                <th>DATABASE</th>
                                <th>JUMLAH</th>
                            </tr>
                            </thead>
                            @foreach($allpattern as $row)
                                @if(($loop->first) && (!empty($_GET['done'])))
                                    <tr class="success">
                                @else
                                    <tr>
                                        @endif
                                        {{--<td>{{$row->id_running}}</td>--}}
                                        <td>{{$row->tanggal}}</td>
                                        <td>{{$row->kolom}}</td>
                                        <td>{{$row->tabel}}</td>
                                        <td>{{$row->nama_database}}</td>
                                        <td>{{$row->jumlah_pattern}}</td>
                                    </tr>
                                    @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--FOR MODAL ONLY--}}
    <div class="row">
        <div class="modal panel-default" id="mostModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%;" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Kolom Dengan Jumlah Pattern Paling Banyak</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close" style="font-size:18px;color:red"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <pre>
ID Running : {{ $id_running_most }}
Host Name : {{ $datasource_most['host'] }}
Database Name : {{ $datasource_most['db_name'] }}
User Name : {{ $datasource_most['db_username'] }}
Port : {{ $datasource_most['port'] }}
Table name : {{ $datasource_most['tab'] }}
Column Name : {{ $datasource_most['col'] }}
                        </pre>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Pattern</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsmost as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->column_pattern}}</td>
                                                        <td>{{$row->total_each_pattern}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
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
        <div class="modal panel-default" id="leastModal" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width: 75%;" class="modal-dialog" role="banner">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Kolom Dengan Jumlah Pattern Paling Sedikit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close" style="font-size:18px;color:red"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <pre>
ID Running : {{ $id_running_least }}
Host Name : {{ $datasource_least['host'] }}
Database Name : {{ $datasource_least['db_name'] }}
User Name : {{ $datasource_least['db_username'] }}
Port : {{ $datasource_least['port'] }}
Table name : {{ $datasource_least['tab'] }}
Column Name : {{ $datasource_least['col'] }}
                        </pre>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Pattern</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsleast as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->column_pattern}}</td>
                                                        <td>{{$row->total_each_pattern}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
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
@endsection
@section('jspivot')
    <script type="text/javascript">
        console.log(windowvar.country);
        console.log(windowvar.jumlahrow);
        console.log(windowvar.countryresult);

        google.charts.load('current', {'packages':['bar']});
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawMostPatternChart);
        google.charts.setOnLoadCallback(drawPatternCheckChart);

        function drawMostPatternChart() {
            $(document).ready(function () {
                var data = google.visualization.arrayToDataTable(windowvar.mostpatternchart);
                var options = {
                    title: 'Profiling - Pattern'
                };
                var chart = new google.visualization.PieChart(document.getElementById('mostpatternchart'));
                chart.draw(data, options);
            })
        }
        function drawPatternCheckChart() {
            var data = google.visualization.arrayToDataTable(windowvar.patternformat);

            var options = {
                chart: {
                    title: 'Pattern Format Check (dalam %)'
                }
            };

            var chart = new google.charts.Bar(document.getElementById('patternformatchart'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
        $(window).resize(function(){
           drawMostPatternChart();
           drawPatternCheckChart();
        });
        console.log(windowvar.a);
    </script>
@endsection