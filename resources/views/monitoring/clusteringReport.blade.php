@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')

@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Data Clustering</li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-red" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Cluster Paling Banyak</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#mostModal">{{$clusterterbanyak}} Cluster</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-blue" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Cluster Paling Sedikit</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#leastModal">{{$clustertersedikit}} Cluster</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Cluster dengan ration paling tinggi</p>
                    <button type="button" class="btn btn-sm btn-default">{{$z}}</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Cluster dengan ration paling rendah</p>
                    <button type="button" class="btn btn-sm btn-default">{{$y}}</button>
                </div>
            </div>
        </div><!--/.col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Clustering
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="container" style="width: 100%; height: 100%;" ></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Profiling - Clustering
                </div>
                {{--<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>--}}
                <div class="panel-body">
                    <div id="clusteringchart"></div>
                    {{--<div id="mostpatternchart" style="width: 100%; min-height: 300px;"></div>--}}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Clustering Running
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
                            @foreach($allcluster as $row)
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
                                        <td>{{$row->jumlah_cluster}}</td>
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
                                                <th>Name New</th>
                                                <th>Fingerprint</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsmost as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->name_new}}</td>
                                                        <td>{{$row->fingerprint}}</td>
                                                        <td>{{$row->total}}</td>
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
                                                <th>Name New</th>
                                                <th>Fingerprint</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsleast as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->name_new}}</td>
                                                        <td>{{$row->fingerprint}}</td>
                                                        <td>{{$row->total}}</td>
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
    <script>
        console.log(windowvar.clusteringdashboard);
        console.log(windowvar.a);

    </script>
        <script type="text/javascript">
        console.log(windowvar.clusterscore);
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawAllClusteringChart);
        google.charts.setOnLoadCallback(drawClusteringChart);

        function drawAllClusteringChart() {
            var data = google.visualization.arrayToDataTable(windowvar.a);

            var options = {
                title: 'Perbandingan ratio seluruh hasil clustering',
                hAxis: {title: 'Total Data'},
                vAxis: {title: 'Clustering Ratio'},
                bubble: {
                    textStyle: {
                        fontSize: 12,
                        fontName: 'Times-Roman',
                        color: 'green',
                        bold: true,
                        italic: true
                    }
                }
            };

            var chart = new google.visualization.BubbleChart(document.getElementById('container'));

            chart.draw(data, options);
        }
        function drawClusteringChart() {
            $(document).ready(function () {
                var data = google.visualization.arrayToDataTable(windowvar.countcluster);
                var options = {
                    title: 'Profiling - Clustering'
                };
                var chart = new google.visualization.PieChart(document.getElementById('clusteringchart'));
                chart.draw(data, options);
            })
        }
        $(window).resize(function(){
            drawClusteringChart();
            drawAllClusteringChart();
        });
        console.log(windowvar.z);
    </script>

@endsection