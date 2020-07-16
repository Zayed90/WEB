@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')

@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Value Distribution</li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-red" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Distribusi Paling Banyak</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#mostModal"> {{$distributionterbanyak}} Data</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-blue" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Distribusi Paling Sedikit</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#leastModal"> {{$distributiontersedikit}} Data</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Nilai Ratio Paling Tinggi</p>
                    <button type="button" class="btn btn-sm btn-default">{{$maxratio}}</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Nilai Ratio Paling Rendah</p>
                    <button type="button" class="btn btn-sm btn-default">{{$minratio}}</button>
                </div>
            </div>
        </div><!--/.col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Value Distribution Data
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="distributionchart" style="width: 100%; height: 100%;" ></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Data Completeness Running
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
                                <th>JUMLAH VALUE</th>
                            </tr>
                            </thead>
                            @foreach($alldistribution as $row)
                                @if(($loop->first) && (!empty($_GET['done'])))
                                    <tr class="success">
                                @else
                                    <tr>
                                        @endif
                                        <td>{{$row->tanggal}}</td>
                                        <td>{{$row->kolom}}</td>
                                        <td>{{$row->tabel}}</td>
                                        <td>{{$row->nama_database}}</td>
                                        <td>{{$row->total_value}}</td>
                                    </tr>
                                    @endforeach
                        </table>
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
        console.log(windowvar.b);
        console.log(windowvar.distributiondata);
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawAllDistribution);

        function drawAllDistribution() {
            var data = google.visualization.arrayToDataTable(windowvar.distributiondata);

            var options = {
                title: 'Comparison of all Value Distribution based on the ratio value',
                hAxis: {title: 'Total Data'},
                vAxis: {title: 'Ratio'},
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

            var chart = new google.visualization.BubbleChart(document.getElementById('distributionchart'));

            chart.draw(data, options);
        }
        $(window).resize(function(){
            drawAllDistribution();
        })
    </script>
@endsection