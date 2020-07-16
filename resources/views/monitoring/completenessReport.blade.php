@include('monitoring.dashboardvar')
@extends('monitoring.monitoringTemplate')

@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-clipboard"></em> Reporting</li>
        <li class="active">Data Completeness</li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-red" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Data Valid Paling Banyak</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#mostModal">{{$mostcompleteness}} Data</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-blue" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Kolom Dengan Jumlah Data Valid Paling Sedikit</p>
                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#leastModal">{{$leastcompleteness}} Data</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Completeness Passed Data</p>
                    <button type="button" class="btn btn-sm btn-default">{{$jumlahvalid}} Data</button>
                </div>
            </div>
        </div><!--/.col-->
        <div class="col-md-3">
            <div class="panel panel-default" style="margin-top: 20px;">
                <div class="panel-body">
                    <p>Completeness Failed Data</p>
                    <button type="button" class="btn btn-sm btn-default">{{$jumlahnotvalid}} Data</button>
                </div>
            </div>
        </div><!--/.col-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Completeness
                    <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                <div class="panel-body">
                    <div id="completenesschart"></div>
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
                    <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th>Id Running</th>
                            <th>Kolom</th>
                            <th>Tabel</th>
                            <th>Database</th>
                            <th>Total Valid Data</th>
                            <th>Total Data</th>
                        </tr>
                        </thead>
                        @foreach($allcompleteness as $row)
                            @if(($loop->first) && (!empty($_GET['done'])))
                                <tr class="success">
                            @else
                                <tr>
                                    @endif
                                    <td>{{$row->id_running}}</td>
                                    <td>{{$row->kolom}}</td>
                                    <td>{{$row->tabel}}</td>
                                    <td>{{$row->nama_database}}</td>
                                    <td>{{$row->valid}}</td>
                                    <td>{{$row->totalrecord}}</td>
                                </tr>
                                @endforeach
                    </table>
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
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#valid" aria-controls="uploadTab" role="tab" data-toggle="tab">VALID</a>

                                    </li>
                                    <li role="presentation"><a href="#notcomplete" aria-controls="browseTab" role="tab" data-toggle="tab">NOT COMPLETE</a>

                                    </li>
                                    <li role="presentation"><a href="#notindictionary" aria-controls="browseTab" role="tab" data-toggle="tab">NOT IN DICTIONARY</a>

                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="valid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Value</th>
                                                <th>Matched Dictionary Value</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsmostvalid as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->value}}</td>
                                                        <td>{{$row->match_value}}</td>
                                                        <td>{{$row->type}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="notcomplete">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Value</th>
                                                <th>Matched Dictionary Value</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsmostnotcomplete as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->value}}</td>
                                                        <td>{{$row->match_value}}</td>
                                                        <td>{{$row->type}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="notindictionary">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Value</th>
                                                <th>Matched Dictionary Value</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsmostnotindictionary as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->value}}</td>
                                                        <td>{{$row->match_value}}</td>
                                                        <td>{{$row->type}}</td>
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
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#leastvalid" aria-controls="uploadTab" role="tab" data-toggle="tab">VALID</a>

                                    </li>
                                    <li role="presentation"><a href="#leastnotcomplete" aria-controls="browseTab" role="tab" data-toggle="tab">NOT COMPLETE</a>

                                    </li>
                                    <li role="presentation"><a href="#leastnotindictionary" aria-controls="browseTab" role="tab" data-toggle="tab">NOT IN DICTIONARY</a>

                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="leastvalid">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Value</th>
                                                <th>Matched Dictionary Value</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsleastvalid as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->value}}</td>
                                                        <td>{{$row->match_value}}</td>
                                                        <td>{{$row->type}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="leastnotcomplete">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Value</th>
                                                <th>Matched Dictionary Value</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsleastnotcomplete as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->value}}</td>
                                                        <td>{{$row->match_value}}</td>
                                                        <td>{{$row->type}}</td>
                                                    </tr>
                                                    @endforeach
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="leastnotindictionary">
                                        <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                                            <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Value</th>
                                                <th>Matched Dictionary Value</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            @foreach($resultsleastnotindictionary as $row)
                                                @if(($loop->first) && (!empty($_GET['done'])))
                                                    <tr class="success">
                                                @else
                                                    <tr>
                                                        @endif
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->value}}</td>
                                                        <td>{{$row->match_value}}</td>
                                                        <td>{{$row->type}}</td>
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
        console.log(windowvar.result);
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawCompletenessChart);

        function drawCompletenessChart() {
            var data = google.visualization.arrayToDataTable(windowvar.allcompletenesschart);

            var options = {
                chart: {
                    title: 'Profiling - Data Completeness'
                }
            };

            var chart = new google.charts.Bar(document.getElementById('completenesschart'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
        $(window).resize(function(){
            drawCompletenessChart()
        })
    </script>

@endsection