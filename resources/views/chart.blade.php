
<head>

    <!-- external libs from cdnjs -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.css">
    <!-- PivotTable.js libs from ../dist -->
    <link rel="stylesheet" type="text/css" src="{{asset( 'pivot.css')}}">


    <style>
        body {
            font-family: Verdana, serif;}
    </style>

    <!-- optional: mobile support with jqueryui-touch-punch -->


    <script src="https://cdn.plot.ly/plotly-basic-latest.min.js"></script>

</head>
<body>

{{--<div class="container-fluid">--}}
{{--    <div class="animate fadeIn">--}}
        <div class="row">
            <div class="col-6">

                <div id="output" style="margin: 10px;"></div>
            </div>
        </div>
{{--    </div>--}}
{{--</div>--}}
</body>




<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/c3_renderers.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/export_renderers.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.6.0/tips_data.min.js"></script>

<script type="text/javascript">


    $(function(){
        $.getJSON('http://localhost:8000/monitoring/monitor', function(mps) {
            $("#output").pivotUI(mps, {
                aggregatorName: "Minimum",
                rendererName: "Bar Chart",
                rows: ["ApplicationName"],
                vals: ["total_notMatch"],
                rowOrder: "value_a_to_z", colOrder: "value_z_to_a",
                renderers: $.extend(
                    $.pivotUtilities.renderers,
                    $.pivotUtilities.c3_renderers,
                    $.pivotUtilities.plotly_renderers

                )
            });
        });
    });
</script>







