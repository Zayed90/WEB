@extends('mdm_template.mdm_templat')
@section('contentMDM')
<div class="bs-callout bs-callout-success">
    <div class="row">
      <br>
      <div class="col-lg-12">
        <div class="panel panel-blue">
          <div class="panel-heading">
            <h3  style="margin-top: 10px; color: white">Master Data Management Dashboard</h3>
          </div>
        </div>
      </div>      
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-body">
                <p>Last Lookup</p>
                <button style="font-size: 15px;" type="button" disabled="true" class="btn btn-sm btn-default">@foreach($lastlook as $las)   {{ $las->created_at }}@endforeach</button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-orange" style="margin-top: 10px;">
            <div class="panel-body">
                <p>Last Data Input</p>
                <button style="font-size: 15px;" type="button" disabled="true" class="btn btn-sm btn-default">@foreach($lastins as $las){{ $las->created_at }}@endforeach</button>
            </div>
        </div>
    </div><!--/.col-->
    <div class="col-md-3">
        <div class="panel panel-teal" style="margin-top: 10px;">
            <div class="panel-body">
                <p>Total Company</p>
                <button style="font-size: 15px;" type="button" disabled="true" class="btn btn-sm btn-default">@foreach($toCom as $to){{ $to->total }}@endforeach</button>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-blue" style="margin-top: 10px;">
            <div class="panel-body">
                <p>Data Uniqueness</p>
                <button style="font-size: 15px;" type="button" disabled="true" class="btn btn-sm btn-default">@foreach($cntDup as $cnt){{ number_format(100-(($cnt->total)/$toDC)*100,2) }}%@endforeach</button>
            </div>
        </div>
    </div>
</div>
<div class="bs-callout bs-callout-success">
 

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Data Accuracy
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
          <div class="panel-body">
            <div class="row">
                <div class="col-sm-8">
                <p>Master Data Accuracy</p>
                </div>
                <div class="col-sm-4">
                    <button style="font-size: 15px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{ $accuracy }} %</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                <p style="margin-top: 10px;">Asrot Data Accuracy</p>
                </div>
                <div class="col-sm-4">
                <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{$aAsrot}} %</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                <p style="margin-top: 10px;">Ereg Data Accuracy</p>
                </div>
                <div class="col-sm-4">
                    <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{$aEreg}} %</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                <p style="margin-top: 10px;">Etrack DN Data Accuracy</p>
                </div>
                <div class="col-sm-4">
                    <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{$aDn}} %</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                <p style="margin-top: 10px;">Etrack LN Data Accuracy</p>
                </div>
                <div class="col-sm-4">
                    <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{$aLn}} %</button>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Data Completeness
            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-8">
                    <p>Master Data Completeness</p>
                    </div>
                    <div class="col-sm-4">
                    <button style="font-size: 15px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{$persen}} %</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                    <p style="margin-top: 10px;">Asrot Data Completeness</p>
                    </div>
                    <div class="col-sm-4">
                        <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{ $pNAsrot }} %</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                    <p style="margin-top: 10px;">Ereg Data Completeness</p>
                    </div>
                    <div class="col-sm-4">
                        <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{ $pNEreg }} %</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                    <p style="margin-top: 10px;">Etrack DN Data Completeness</p>
                    </div>
                    <div class="col-sm-4">
                        <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{ $pNDn }} %</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                    <p style="margin-top: 10px;">Etrack LN Data Completeness</p>
                    </div>
                    <div class="col-sm-4">
                        <button style="font-size: 15px; margin-top: 10px;" type="button" disabled="true" class="btn btn-sm btn-primary">{{ $pNLn }} %</button>
                    </div>
                </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Monthly Master Data
            <span class="pull-right clickable panel-toggle panel-button-tab-left">
              <em class="fa fa-toggle-up"></em>
            </span>
          </div>
          <div class="panel-body">
            <div id="deduplicationchart" style="width: 100%; min-height: 300px">
                {!! $chart->html() !!}
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Master Data Distribution
            <span class="pull-right clickable panel-toggle panel-button-tab-left">
              <em class="fa fa-toggle-up"></em>
            </span>
          </div>
          <div class="panel-body">
            <div id="deduplicationchart" style="width: 100%; min-height: 250px">
                {!! $pie->html() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Percentage Total Data Match
              <span class="pull-right clickable panel-toggle panel-button-tab-left">
                <em class="fa fa-toggle-up"></em>
              </span>
            </div>
            <div class="panel-body">
              <div id="deduplicationchart" style="width: 100%; min-height: 250px">
                {!! $pieCha->html() !!}       
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
                Percentage Total Data Not Match
              <span class="pull-right clickable panel-toggle panel-button-tab-left">
                <em class="fa fa-toggle-up"></em>
              </span>
            </div>
            <div class="panel-body">
              <div id="deduplicationchart" style="width: 100%; min-height: 250px">
                {!! $piee->html() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    
  </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-white">
                <div class="panel-body">
                    <div class="row">
                    </div>
                </div>
                {!! Charts::scripts() !!}
                {!! $chart->script() !!}
                {!! $pie->script() !!}
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-white">
                <div class="panel-body">
                    <div class="row">
                    </div>
                </div>
                {!! Charts::scripts() !!}
                {!! $pieCha->script() !!}
                {!! $piee->script() !!}
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-6">

                <iframe src="http://localhost:8000/chart" height="550px" width="1100"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection()


