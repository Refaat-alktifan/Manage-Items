@extends('layouts.app')

@section('content')
<div class="main">

<div class="container">
    <div class="row">
    <h3>Manage Item</h3>
    </div>
   </div>
</div>

<div class="container">
    <div class="row">
        <form method="POST" action="{{ url('additem') }}">
        {{ csrf_field() }}

    <div class="form-group">
    <div class="row">
    <label for="name" class="col-md-4 control-label">Name</label>
    <div class="col-md-8"><input id="name" name="name" value="" required="required" autofocus="autofocus" class="form-control" placeholder="Your name" type="text"></div></div></div>


        <div class="form-group">  <div class="row">
    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
    <div class="col-md-8"><input id="email" name="email" value="" required="required" placeholder="Your Email" class="form-control" type="email"></div></div></div>


     <div class="form-group">  <div class="row">
    <label for="department" class="col-md-4 control-label">Department</label>
    <div class="col-md-8">
    <select name="department" class="form-control" id="department" required="">

      @foreach($departments as  $department)
            <option value="{{ $department }}">{{ $department }}</option>

      @endforeach
     </select>
    </div></div></div>


     <div class="form-group">  <div class="row">
    <label for="priority" class="col-md-4 control-label">Priority</label>
    <div class="col-md-8">
    <select name="priority" class="form-control" id="priority" required="">
    <option value="High">High</option>
    <option value="Medium" selected="">Medium</option>
    <option value="Low">Low</option>
     </select>
    </div></div></div>



        <div class="form-group">  <div class="row">
    <label for="subject" class="col-md-4 control-label">Subject</label>
    <div class="col-md-8"><input id="subject" name="subject" value="" required="required" placeholder="Subject" class="form-control" type="text"></div></div></div>

      <div class="form-group">  <div class="row">
    <label for="message" class="col-md-4 control-label">Message</label>
    <div class="col-md-8"><textarea id="message" name="message" required="required" class="form-control" placeholder="Your message">

    </textarea></div></div></div>

<div class="form-group pull-right">
<input type="submit" class="btn btn-primary" value="Submit">
</div>


    </form>



    </div>
</div>
@endsection
