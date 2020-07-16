@extends('template')
@section('content')
<div class="row">
  <ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li >Choose Pattern</a></li>
  </ol>
</div><!--/.row-->

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><strong>Pattern View</strong></h3>
  </div>
</div><!--/.row-->
<div class="bs-callout bs-callout-success">
  <h5><strong>&nbsp Table and Column Information</strong></h5>

  <button formaction="#" class="bt1 caw"> Table Name:<strong> {{ $table }}</strong></button>
  <button formaction="#" class="bt1 ciw"> Column Name:<strong> {{ $column }}</strong></button>

  <hr>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-body">
          @if($results!=null)
          <table  class="table" data-toggle="" data-show-refresh="false" data-search="false" data-pagination="false">
            <thead>
             
            </thead>
            <h4 class="page-header"><strong>Click & Choose The Pattern Here</strong></h4>

            <form method="post">
              {{ csrf_field() }}
            @foreach($results as $row)
            
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <button type="submit" data-toggle="modal" data-target=".bd-example-modal-lg" name="pattern" value="{{$row->column_pattern}}" formaction="{{url('/cleansing/pattern/manualProcess')}}" class="pilihpattern"> {{$row->column_pattern}}</button>
              </tr>
              @endforeach
            </table>
            @else
            <h3>No Data, make sure to Profiling this Column First</h3>
            @endif
            <hr/>
            
            <div>
            {{-- <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#bulk">Next to Bulk Process</button>
           --}}
           <!-- <button type="submit" formaction="{{url('/cleansing/pattern/manualProcess')}}" class="bt1 siti">Next Process per Pattern</button> -->
          </div>
            <div class="col-xs-12 col-md-6 col-lg-6 collapse" id="bulk" style="margin-top: 10px">
              <div class="form-group">
                <label for="exampleInputEmail1">Column Filter</label>
                <input type="text" class="form-control" name="filter">
                <small class="form-text text-muted">Enter column filter to Exception in every fist line of code</small>
              </div>
            <input type="hidden" class="form-control" name="column" value="{{$column}}">
            <input type="hidden" class="form-control" name="table" value="{{$table}}">
            <input type="hidden" class="form-control" name="tipe" value="{{$tipe}}">
            <button formaction="{{ url('/cleansing/pattern/process') }}" type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target=".bd-example-modal-lg">Next</button>
        </div>
        {{-- <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top: 10px">
          <hr/>
        <!-- <button type="submit" formaction="" class="bt1 biti">Next Process per Pattern</button> -->
        </div> --}}
      </form>
      <a class="" href="{{url('cleansing/pattern')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg"  type="button"class="mantul"><i class="fa fa-angle-double-left"></i> &nbsp Back</button></a> &nbsp&nbsp
        </div></div></div></div></div>
  <!--/.row-->
  @endsection
