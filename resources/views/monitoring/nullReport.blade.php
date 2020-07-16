@php use \App\Http\Controllers\ReportController; @endphp

@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Null Profiling</li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-red" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Kosong Paling Banyak</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#mostModal">{{$mostnull}} Data Kosong</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-blue" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Kosong Paling Sedikit</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#leastModal"> {{$leastnull}} Data Kosong</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Passed Data</p>
                    <button type="button" class="btn btn-sm btn-default">{{$nullsuccess}}</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Failed Data</p>
                    <button type="button" class="btn btn-sm btn-default">{{$nullfail}}</button>
                </div>
            </div>
        </div><!--/.col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Null Data
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="nulldatachart" style="width: 100%; min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{--<div class="col-md-6">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">--}}
                    {{--Pattern Format Check--}}
                {{--</div>--}}
                {{--<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div id="patternformatchart"></div>--}}
                    {{--<div id="mostpatternchart" style="width: 100%; min-height: 300px;"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Show Null Running
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
                                <th>NULL DATA</th>
                            </tr>
                            </thead>
                            @foreach($allnulldata as $row)
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
                                        <td>{{$row->jumlah_null}}</td>
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
    Filtered By : {{ $first_result_most }}
    Host Name : {{ $datasource_most['host'] }}
    Database Name : {{ $datasource_most['db_name'] }}
    User Name : {{ $datasource_most['db_username'] }}
    Port : {{ $datasource_most['port'] }}
    Table name : {{ $datasource_most['tab'] }}
    Column Name : {{ $datasource_most['col'] }}
  </pre>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th >Id</th>
                                                @foreach($column_detail_most as $key => $value)
                                                    <th>{{ $key }}</th>
                                                @endforeach

                                            </tr>
                                            </thead>
                                            @foreach($resultsmost as $row)
                                                <tr>
                                                    <td>{{$row->id}}</td>
                                                    @php $data = ReportController::jsonReader($row->data, 'data'); @endphp
                                                    @foreach($data as $key => $value)
                                                        <td>{{ $value }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                <a href="{{route('nullMonitorView')}}"<button type="button" class="btn btn-block btn-success">Back</button></a><br>
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
                        <h4 class="modal-title" id="exampleModalLabel">Kolom Dengan Jumlah Pattern Paling Banyak</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close" style="font-size:18px;color:red"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
    <pre>
    ID Running : {{ $id_running_least }}
    Filtered By : {{ $first_result_least }}
    Host Name : {{ $datasource_least['host'] }}
    Database Name : {{ $datasource_least['db_name'] }}
    User Name : {{ $datasource_least['db_username'] }}
    Port : {{ $datasource_least['port'] }}
    Table name : {{ $datasource_least['tab'] }}
    Column Name : {{ $datasource_least['col'] }}
  </pre>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th >Id</th>
                                                @foreach($column_detail_least as $key => $value)
                                                    <th>{{ $key }}</th>
                                                @endforeach

                                            </tr>
                                            </thead>
                                            @foreach($resultsmost as $row)
                                                <tr>
                                                    <td>{{$row->id}}</td>
                                                    @php $data = ReportController::jsonReader($row->data, 'data'); @endphp
                                                    @foreach($data as $key => $value)
                                                        <td>{{ $value }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                <a href="{{route('nullMonitorView')}}"<button type="button" class="btn btn-block btn-success">Back</button></a><br>
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
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawAllNullData);
        console.log(windowvar.nullfail);
        function drawAllNullData() {
            $(document).ready(function () {
                var data = google.visualization.arrayToDataTable(windowvar.shownulldatachart);
                var options = {
                    title: 'Profiling - Show Null'
                };
                var chart = new google.visualization.PieChart(document.getElementById('nulldatachart'));
                chart.draw(data, options);
            })
        }
        $(window).resize(function(){
            drawAllNullData();
        });
        // console.log(windowvar.a);
    </script>
@endsection