@extends('layouts.app')

@section('content')
<div class="main">

<div class="container">
    <div class="row">
    <h3>View Item</h3>
    </div>
   </div>
</div>

<div class="container">
    <div class="row">
        <form method="POST" action="{{ url('view') }}">
        {{ csrf_field() }}


        <div class="form-group">  <div class="row">
    <label for="item" class="col-md-4 control-label">Item ID</label>
    <div class="col-md-8"><input id="item" name="item" value="" required="required" placeholder="Item ID" class="form-control" type="text"></div></div></div>


<div class="form-group pull-right">
<input type="submit" class="btn btn-primary" value="Submit">
</div>


    </form>



    </div>
</div>
@endsection
