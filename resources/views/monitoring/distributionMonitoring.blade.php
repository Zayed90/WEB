@extends('monitoring.monitoringTemplate')
@section('content')
<div class="row">
    <ol class="breadcrumb" style="margin-left: 15px;">
        <li class="active"><em class="fa fa-bar-chart"></em>Monitoring</li>
        <li class="active">Value Distribution</li>
    </ol>
</div>
<div class="bs-callout bs-callout-success">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Value Distribution Monitoring</h4>
                    <div id="output"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bs-callout bs-callout-success">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Pattern Result</h4>
                    <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th data-field="id" data-sortable="true">Running At</th>
                            <th>Result</th>
                        </tr>
                        </thead>
                        @foreach($results as $row)
                            @if(($loop->first) && (!empty($_GET['done'])))
                                <tr class="success">
                            @else
                                <tr>
                                    @endif
                                    <td>{{$row->id_running}}</td>
                                    <td>{{$row->created_at}}</td>
                                    <td><a href="{{route('distributionViewDGPO',['id'=>$row->id_running])}}"<button type="button" class="btn btn-success">See Result</button></a></td>
                                </tr>
                                @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--/.main-->
@endsection
@section('jspivot')
<script type="text/javascript">
    $(function(){
        var derivers = $.pivotUtilities.derivers;
        $.getJSON("http://127.0.0.1:8000/monitoring/distributionmonitoringdata", function(mps)
        {
            $("#output").pivotUI(mps,
                {
                    rows: ["column_value"],
                    vals:["column_value_distribution"],
                    aggregatorName: "Sum",
                    rendererName: "Bar Chart",
                    renderers: $.extend(
                        $.pivotUtilities.renderers,
                        $.pivotUtilities.c3_renderers
                    )
                });
        });
    });
</script>
@endsection
