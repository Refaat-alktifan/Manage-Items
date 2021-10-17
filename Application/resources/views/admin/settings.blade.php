@extends('layouts.app')

@section('content')
<div class="main">
<div class="container">
    <div class="row">
    <h3>Settings</h3>
    </div>
   </div>
</div>

<div class="container">
    <div class="row">

<form method="POST" action="{{ url('manage/settings') }}">

 {{ csrf_field() }}

 <div class="form-group">
    <div class="row">
    <label for="department" class="col-md-4 control-label">Deparment</label>
    <div class="col-md-8">
    <textarea class="form-control" id="department" name="department" class="form-control">{{ $data['department'] }}</textarea>
  </div></div></div>



 <div class="form-group">
    <div class="row">
    <label for="from" class="col-md-4 control-label">From email</label>
    <div class="col-md-8"><input id="from" name="from"   class="form-control" value="{{ $data['from'] }}"  type="text"></div></div></div>



 <div class="form-group">
    <div class="row">
{{--    <label hidden for="slack" class="col-md-4 control-label">Slack Webhook URL</label>--}}
{{--    <div hidden class="col-md-8"><input id="slack" name="slack"  class="form-control" value="{{ $data['slack'] }}"  type="text"></div></div></div>--}}

<div class="form-group">
  <input type="submit" class="btn btn-primary" value="Submit">
</div>

</form>

    </div>
</div>
@endsection
