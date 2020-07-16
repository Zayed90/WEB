@extends('master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="icon-refresh"></i>
                    </div>
                    @foreach($lastlook as $las)
                    <div class="h4 mb-0">{{ $las->created_at }}</div>

                    @endforeach
                    <small class="text-muted text-uppercase font-weight-bold">Last Lookup</small>

                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="icon-info"></i>
                    </div>
                    @foreach($lastins as $las)
                        <div class="h4 mb-0">{{ $las->created_at }}</div>

                        @endforeach
                    <small class="text-muted text-uppercase font-weight-bold">Last Data Input</small>

                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="icon-briefcase"></i>
                        </div>
                        <div class="h4 mb-0">@foreach($toCom as $to){{ $to->total }}@endforeach</div>
                        <small class="text-muted text-uppercase font-weight-bold">Total Company</small>

                    </div>
                </div>
            </div>
        </div>  
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card text-dark bg-warning">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-0">
                        <i class="icon-chart"></i>
                    </div>
                    <small class="text-muted text-uppercase font-weight-bold">Data Completeness</small>
                    <div class="h4 mb-2">{{ $persen }}%</div>
                    
                    <a style="color: black" data-toggle="collapse" href="#collapse-complete" aria-expanded="true" aria-controls="collapse-complete" id="heading-complete" class="d-block">
                        <i class="fa fa-chevron-circle-down pull-right"></i>
                        See Details
                    </a>
                    <div id="collapse-complete" class="collapse" aria-labelledby="heading-complete">
                        <div class="card-body">
                            <small class="text-muted text-uppercase font-weight-bold">Asrot Data Completeness</small>
                            <div class="h4 mb-0">{{ $pNAsrot }}%</div>
                            <small class="text-muted text-uppercase font-weight-bold">Ereg Data Completeness</small>
                            <div class="h4 mb-1">{{ $pNEreg }}%</div>
                            <small class="text-muted text-uppercase font-weight-bold">Etrack DN Data Completeness</small>
                            <div class="h4 mb-1">{{ $pNDn }}%</div>
                            <small class="text-muted text-uppercase font-weight-bold">Etrack LN Data Completeness</small>
                            <div class="h4 mb-1">{{ $pNLn }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="icon-pie-chart"></i>
                    </div>
                    @foreach($cntDup as $cnt)
                    <div class="h4 mb-0">{{ number_format(100-(($cnt->total)/$toDC)*100,2) }}%</div>

                    @endforeach
                    <small class="text-muted text-uppercase font-weight-bold">Data Uniqueness</small>

                </div>
            </div>
        </div>  
        <div class="col-sm-6 col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-0">
                        <i class="icon-note"></i>
                    </div>
                    <small class="text-muted text-uppercase font-weight-bold">Data Accuracy</small>
                    <div class="h4 mb-2">{{ $accuracy }}%</div>
                    <a style="color: white" data-toggle="collapse" href="#collapse-acc" aria-expanded="true" aria-controls="collapse-acc" id="heading-acc" class="d-block">
                        <i class="fa fa-chevron-circle-down pull-right"></i>
                        See Details
                    </a>
                    <div id="collapse-acc" class="collapse" aria-labelledby="heading-acc">
                        <div class="card-body">
                            <small class="text-muted text-uppercase font-weight-bold">Asrot Data Accuracy</small>
                            <div class="h4 mb-0">{{ $aAsrot }}%</div>
                            <small class="text-muted text-uppercase font-weight-bold">Ereg Data Accuracy</small>
                            <div class="h4 mb-1">{{ $aEreg }}%</div>
                            <small class="text-muted text-uppercase font-weight-bold">Etrack DN Data Accuracy</small>
                            <div class="h4 mb-1">{{ $aDn }}%</div>
                            <small class="text-muted text-uppercase font-weight-bold">Etrack LN Data Accuracy</small>
                            <div class="h4 mb-1">{{ $aLn }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
{{-- <div class="container-fluid">
    <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card text-dark bg-secondary">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-4">
                            <i class="icon-speedometer"></i>
                        </div>
                        <small class="text-muted text-uppercase font-weight-bold">Master Data Count</small>
                        @foreach($masterCnt as $cnt)
                        <div class="h4 mb-0">{{$cnt->total}}</div>
                        @endforeach
                        <br>
                    <a style="color: black" href="/history" aria-expanded="true" aria-controls="collapse-example" id="heading-example" class="d-block">
                            <i class="fa fa-chevron-circle-down pull-right"></i>
                            See Details
                        </a> 
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="h1 text-muted text-right mb-0">
                            <i class="icon-speech"></i>
                        </div>
                        <small class="text-muted text-uppercase font-weight-bold">Data Accuracy</small>
                        <div class="h4 mb-2">{{ $accuracy }}%</div>
                        <a style="color: white" data-toggle="collapse" href="#collapse-acc" aria-expanded="true" aria-controls="collapse-acc" id="heading-acc" class="d-block">
                            <i class="fa fa-chevron-circle-down pull-right"></i>
                            See Details
                        </a>
                        <div id="collapse-acc" class="collapse" aria-labelledby="heading-acc">
                            <div class="card-body">
                                <small class="text-muted text-uppercase font-weight-bold">Asrot Data Accuracy</small>
                                <div class="h4 mb-0">{{ $accuracy }}%</div>
                                <small class="text-muted text-uppercase font-weight-bold">Ereg Data Accuracy</small>
                                <div class="h4 mb-1">{{ $accuracy }}%</div>
                                <small class="text-muted text-uppercase font-weight-bold">Etrack DN Data Accuracy</small>
                                <div class="h4 mb-1">{{ $accuracy }}%</div>
                                <small class="text-muted text-uppercase font-weight-bold">Etrack LN Data Accuracy</small>
                                <div class="h4 mb-1">{{ $accuracy }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div> --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-white">
                <div class="panel-body">
                    <div class="row">
                        {!! $chart->html() !!}
                        {!! $pie->html() !!}
                        {{-- {!! $bar->html() !!} --}}
                    </div>
                </div>
                {!! Charts::scripts() !!}
                {!! $chart->script() !!}
                {!! $pie->script() !!}
                {{-- {!! $bar->script() !!} --}}
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
                        {!! $pieCha->html() !!}
                        {!! $piee->html() !!}
                        {{-- {!! $bar->html() !!} --}}
                    </div>
                </div>
                {!! Charts::scripts() !!}
                {!! $pieCha->script() !!}
                {!! $piee->script() !!}
                {{-- {!! $bar->script() !!} --}}
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
@endsection