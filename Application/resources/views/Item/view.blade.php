@extends('layouts.app')
@section('title')
    Manage Item
@endsection
@section('content')
 <div class="container margin-20t">
<div class="row">
  <div class="col-md-8">

<div class="message-box">
<div class="message-title">
  {{ $item->subject }}
  <div class="pull-right">
                         by {{ $item->name }}
                </div>
</div>
<div class="message-content">
   <div class="message-padding">   <div class="message clearfix">
           <img src="{{ $userAvatar }}" alt="" width="40" height="40">


          <div class="message-recontent clearfix">

            <span class="time">{{  date('F d, Y h:m A', strtotime($item->created_at)) }}</span>


            <p>  {{ nl2br($item->message) }} </p>

          </div> <!-- end message-content -->

        </div>
        </div>

 <hr>

 @foreach($reply as $post)
                  @if ($post->staff != 0)
    <div class="message-padding oddone">
@else
    <div class="message-padding">
@endif

    <div class="message clearfix">
              @if ($post->name == $item->name)
          <img src="{{ $userAvatar }}" alt="" width="40" height="40">

                                                          @else


                                                           @foreach($staffAvatar as $sa => $k)
                                                           @if ($sa == $post->staff)

                                                              <img src=" {{ $k }}" alt="" width="40" height="40">

                                                           @endif
                                                            @endforeach


                                                @endif


          <div class="message-recontent clearfix">

            <span class="time">{{  date('F d, Y h:m A', strtotime($post->created_at)) }}</span>

            <h5>{{ $post->name }}</h5>

            <p>  {{ $post->message }}</p>

          </div> <!-- end message-content -->

        </div>
        </div>

 <hr>
  @endforeach
      <div class="message-padding">
  {{ $reply->render() }}


   <form class="ui reply form" method="POST" action="{{ url('item/'.$item->tid) }}">
   {{ csrf_field() }}
   <input type="hidden" name="name" value="{{ $item->name }}">
   <input type="hidden" name="tid" value="{{ $item->tid }}">
    <div>
      <textarea id="message" style="width:100%;" name="message" class="form-control" placeholder="Message"></textarea>
    </div>
    <br>
    <div class="">
    <button type="submit" class="btn btn-primary">
     Add Reply
    </button>


    </div>
  </form>
  </div>
</div>


</div>
</div>
  <div class="col-md-4">
    <div class="thumbnail">
      <p class="item-info">Item ID: <b class="pull-right">{{ $item->tid }}</b></p>
      <p class="item-info"> Created on: <b class="pull-right">{{  date('F d, Y h:m A', strtotime($item->created_at)) }}</b></p>
      <p class="item-info"> Priority: <b class="pull-right">{{ $item->priority }}</b></p>
      <p class="item-info"> Department: <b class="pull-right">{{ $item->department }}</b></p>
      <p class="item-info"> Status: <b class="pull-right">@if ($item->status == 0)  <a class="color--olive ">   Open
          </a>
      @else
                <a class="color--gray">  Closed      </a>
      @endif</b></p>





        <div class="row">
  <div class="col-md-6"><a href="#message" class="btn  btn-block btn-primary">    <i class="fa fa-comment"></i>   Reply </a></div>
      @if ($item->status == 1)
          <div class="col-md-6"><a href="{{ url('item/open/'.$item->tid) }}" class="btn btn-block  btn-primary">    <i class="fa fa-retweet"></i>   Open </a>
      @else
          <div class="col-md-6"><a href="{{ url('item/close/'.$item->tid) }}" class="btn btn-block  btn-primary">    <i class="fa fa-close"></i>   Close </a>

      @endif

  </div>
</div>
        <input id="text" type="text" hidden value="{{ url('item/'.$item->tid) }}" style="width:80%" /><br />
        <div style=" position: inherit; margin-left: 30%;" id="qrcode"></div>
        <a  style="margin-top: 10px;" id='qrdl' class="btn btn-block  btn-primary">    <i class="fa fa-download"></i>   Download </a>
    </div>
  </div>
</div>
 </div>

@endsection
