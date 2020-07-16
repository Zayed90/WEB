@include('monitoring.dashboardvar')
@extends('template')
@section('content')
  <div class="bs-callout bs-callout-success">
    <div class="row">
      <br>
      <div class="col-lg-12">
        {{-- <h1 class="page-header">Data Quality Management Dashboard</h1> --}}
        <div class="panel panel-default">
          <div class="panel-body">
            <h3 class="page-header">Data Quality Dashboard</h3>
            <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
          </div>
        </div>
      </div>      
    </div>
  </div>

  <div class="bs-callout bs-callout-success">
  
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            Pattern
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
          <div class="panel-body" >
            <div id="patternchart" style="width: 100%; min-height: 250px;"></div>
            <a href="/report/pattern">See Detail</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            Show Null
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
          <div class="panel-body">
            <div id="shownullchart" style="width: 100%; min-height: 250px;"></div>
            <a href="/report/null">See Detail</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            Clustering
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
          <div class="panel-body">
            <div id="clusteringchart" style="width: 100%; min-height: 250px;"></div>
            <a href="/report/clustering">See Detail</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            Data Completeness
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
          <div class="panel-body">
            <div id="completenesschart" style="width: 100%; min-height: 250px;"></div>
            <a href="/report/completeness">See Detail</a>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            Value Distribution
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
            <div class="panel-body">
            <div id="distributionchart" style="width: 100%; min-height: 250px;"></div>
            <a href="/report/distribution">See Detail</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            Value Similarity
            <span class="pull-right clickable panel-toggle panel-button-tab-left">
              <em class="fa fa-toggle-up"></em>
            </span>
          </div>
          <div class="panel-body">
            <div id="similaritychart" style="width: 100%; min-height: 250px"></div>
            <a href="/report/similarity">See Detail</a>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            Data Deduplication
            <span class="pull-right clickable panel-toggle panel-button-tab-left">
              <em class="fa fa-toggle-up"></em>
            </span>
          </div>
          <div class="panel-body">
            {{-- idnya dimasukin javascript --}}
            <div id="deduplicationchart" style="width: 100%; min-height: 250px"></div>
            <a href="/report/deduplication">See Detail</a>
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
    google.charts.setOnLoadCallback(drawPatternChart);
    google.charts.setOnLoadCallback(drawShownullChart);
    google.charts.setOnLoadCallback(drawClusteringChart);
    google.charts.setOnLoadCallback(drawCompletenessChart);
    google.charts.setOnLoadCallback(drawDistributionChart);
    // Set On Load Chart MCP SIL
    google.charts.setOnLoadCallback(drawSimilarityChart);
    google.charts.setOnLoadCallback(drawDeduplicationChart);

    function drawPatternChart() {
      $(document).ready(function () {
        console.log(windowvar.patterndashboard);
        var data = google.visualization.arrayToDataTable(windowvar.patterndashboard);
        var options = {
          title: 'Profiling Pattern Score'
        };
        var chart = new google.visualization.PieChart(document.getElementById('patternchart'));
        chart.draw(data, options);
      })
    }

    function drawShownullChart() {
      $(document).ready(function () {
        // console.log(windowvar.patterndashboard);
        var data = google.visualization.arrayToDataTable(windowvar.shownulldashboard);
        var options = {
          title: 'Profiling - Show Null',
        };
        var chart = new google.visualization.PieChart(document.getElementById('shownullchart'));
        chart.draw(data, options);
      })
    }

    function drawClusteringChart() {
      $(document).ready(function () {
        var data = google.visualization.arrayToDataTable(windowvar.clusteringdashboard);
        var options = {
          title: 'Profiling - Clustering'
        };
        var chart = new google.visualization.PieChart(document.getElementById('clusteringchart'));
        chart.draw(data, options);
      })
    }

    function drawCompletenessChart() {
      var data = google.visualization.arrayToDataTable(windowvar.completenessdashboard);

      var options = {
        chart: {
          title: 'Profiling - Data Completeness'
        }
      };

      var chart = new google.charts.Bar(document.getElementById('completenesschart'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    // SIL
    function drawSimilarityChart() {
      var data = google.visualization.arrayToDataTable(windowvar.similaritydashboard);

      var options = {
        chart: {
          title: 'Profiling - Value Similarity'
        }
      };

      var chart = new google.charts.Bar(document.getElementById('similaritychart'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    function drawDeduplicationChart() {
      var data = google.visualization.arrayToDataTable(windowvar.deduplicationdashboard);

      var options = {
        chart: {
          title: 'Profiling - Data Deduplication'
        }
      };

      var chart = new google.charts.Bar(document.getElementById('deduplicationchart'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    // 

    function drawDistributionChart() {
      var data = google.visualization.arrayToDataTable(windowvar.distributiondashboard);

      var options = {
        chart: {
          title: 'Profiling - Value Distribution'
        }
      };

      var chart = new google.charts.Bar(document.getElementById('distributionchart'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    $(window).resize(function(){
      drawPatternChart();
      drawShownullChart();
      drawCompletenessChart();
      drawClusteringChart();
      drawDistributionChart();
      drawShownullChart();
      // SIL
      drawSimilarityChart();
      drawDeduplicationChart();
    });
  </script>
{{-- {!! Charts::scripts() !!}
{!! $chart->script() !!} --}}
  @endsection
