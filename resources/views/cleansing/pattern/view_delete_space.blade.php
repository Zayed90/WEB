@extends('template')
@section('content')
<div class="row">
<ol class="breadcrumb">
  <li class="active"><a href="{{url('/home')}}"><em class="fa fa-home"></em> Dashboard</a></li>
    <li><a href="{{url('/cleansing/pattern/index')}}">Choose Modul</a></li>
    <li><a href="{{url('/cleansing/pattern')}}">Choose Pattern</a></li>
    <li><a href="{{url('/cleansing/pattern/pattern_punctuation')}}">Punctuation</a></li>
    <li><a href="{{url('/cleansing/pattern/pattern_change')}}">Change Pattern</a></li>
    <li>Delete Space</a></li>
  </ol>
</div><!--/.row-->
<div class="bs-callout bs-callout-success">
<a class="" href="{{url('cleansing/pattern/pattern_change')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 back btn-lg active"><i class="fa fa-angle-double-left" style="font-size:25px;color:#000000"></i> &nbsp Back</button></a> &nbsp&nbsp
<a class="" href="{{url('cleansing/pattern/delete_space')}}"><button data-toggle="modal" data-target=".bd-example-modal-lg" type="button"class="bt1 skip btn-lg active"> Next to Delete Space &nbsp <i class="fa fa-angle-double-right" style="font-size:25px;color:#000000"></i></button></a> &nbsp&nbsp

<br><br>
  <button formaction="#" class="bt2 caw">  ID Running : <strong>{{ $id_running }}</strong></button>
  <button formaction="#" class="bt2 caw">  Host Name  : <strong> {{ $datasource_detail['host'] }}</strong></button>
  <button formaction="#" class="bt2 caw">  Database Name : <strong>{{ $datasource_detail['db_name'] }}</strong></button>
  <button formaction="#" class="bt2 caw">  User Name : <strong> {{ $datasource_detail['db_username']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Port : <strong> {{ $datasource_detail['port']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Table name : <strong> {{ $datasource_detail['tab']}}</strong></button>
  <button formaction="#" class="bt2 caw">  Column Name : <strong> {{ $datasource_detail['col'] }}</strong></button>
  <hr>
        <form method="post" action="{{ url('/cleansing/pattern/delete_space_process') }}">
          {{ csrf_field() }}
        <div>
              <div class="form-group">
                <label style="margin-left:20px;" >Available Pattern</label><br>
                <div class="select">

                <select style="width:50%; opacity:1;border:dashed 1px #0690A8;margin-left:20px;"name="pattern" id="selectDB" onclick="selectDatabase()">
                    @foreach($pattern as $i=>$p)
                  <option value={{$p->NOMOR_PATTERN_BARU}}>{{$p->NOMOR_PATTERN_BARU}}</option>
                    @endforeach
                </select><br></div>
                <small style="margin-left:20px;" class="form-text text-muted" id="small">Settings Database Connection <a href="{{ url('/database') }}">Here</a></small>
              <br>
              </div><div>
                    <!-- <input class="w3-input  w3-animate-input" placeholder="String to Clean " name="old_string" type="text" style="width:50%">
                  <input type="hidden" class="form-control" name="id_running" value="{{$id_running}}"><br>
                        <input class="w3-input  w3-animate-input" placeholder="New Pattern"  name="new_string" type="text" style="width:50%">                         -->                  
                          <small class="form-text text-muted">.</small>
                          <br><br>
                          <input class="bt1 siti"  type="button" style="width:40%;margin-left:90px;" class="form-control" name="id_running" value="You Are Deleting the Punctuation With Id Running: {{$id_running}}"><br><br>
                          <br><br><input style="margin-left:20px;" type="checkbox" name="cleansed" value="cleansed"> &nbsp&nbsp&nbsp<strong>Accept to change the pattern</strong><br>
                          <br><br><button style="width:50%;margin-left:20px;" data-toggle="modal" data-target=".bd-example-modal-lg" class="bt1 bita">Execution</button>
                      </div>
                    </form>
                  </div>
        </div>
        
        <div class="panel panel-default">     
        <div class="panel-body">
          <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th>NIE Default</th>
                <th>Pattern Not Cleansed</th>
                <th>Pattern Changed</th>
                <th>Data Cleansed</th>
                <th>Status</th>
              </tr>
            </thead>
            @foreach($results as $i=>$row)
            @if(($loop->first) && (!empty($_GET['done'])))
            <tr class="success">
              @else
              <tr>
                @endif
                <td>{{$row->NOMOR_NIE}}</td>
              <td>{{$row->PATTERN_LAMA}}</td>
              <td>{{$row->NOMOR_PATTERN_BARU}}</td>
            
              <td>
                <p id="p{{$i}}" onClick="editData(event,'{{$i}}','{{$row->id}}')">{{$row->nomor_cleansed}}</p>
                    <input id="p-input{{$i}}" style="display:none;" type="text" value={{$row->nomor_cleansed}}>
                </td>
                <td>
                    @if($row->status)
                    <p id="op{{$i}}" onClick="statusData(event,'{{$i}}','{{$row->id}}')">
                    Data Cleansed</p>
                    <select id="op-input{{$i}}" style="display:none;" size="2">
                      <option value="Data Cleansed">Data Cleansed</option>
                      <option value="Not Cleansed">Not Cleansed</option>
                    </select>
                    @else
                    <p id="op{{$i}}" onClick="statusData(event,'{{$i}}','{{$row->id}}')">
                      Not Cleansed</p>
                      <select id="op-input{{$i}}" style="display:none;" size="2">
                        <option value="Not Cleansed">Not Cleansed</option>
                        <option value="Data Cleansed">Data Cleansed</option>
                      </select>
                    @endif
                </td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
function editData(e,i,id) {
  e.currentTarget.style.display = 'none';
  var input = document.getElementById("p-input"+i);
  input.style.display = 'block';
  input.addEventListener("keypress", function(ev) {
    if ( ev.keyCode === 13) {
    
    input.style.display = 'none';
    var p = document.getElementById("p"+i);
    p.innerHTML = input.value;
    p.style.display = 'block';
    $.ajax({
      type: 'GET',
      url: 'http://localhost:8000/cleansing/pattern/update?id='+id+"&data="+input.value,
    });
    // alert(i);
    }
  });
}

function statusData(e,i,id) {
  e.currentTarget.style.display = 'none';
  var input = document.getElementById("op-input"+i);
  input.style.display = 'block';
  $(input).click(function(ev) {
    input.style.display = 'none';
    var p = document.getElementById("op"+i);
    p.innerHTML = input.value;
    p.style.display = 'block';
    $.ajax({
      type: 'GET',
      url: 'http://localhost:8000/cleansing/pattern/status?id='+id+"&data="+input.value,
    });
  });
}
$(function() {
  var f = function() {
    $(this).next().text($(this).is(':checked') ? ':checked' : ':not(:checked)');
  };
  $('input').change(f).trigger('change');
});
</script>
  <!--/.row-->
  @endsection