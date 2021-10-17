@extends('layouts.app')

@section('content')
<div class="main">
<div class="container">
    <div class="row">
    <h3>Manage Items</h3>
    </div>
   </div>
</div>

<div class="container">
    <div class="row">



                 <table class="ui table">
  <thead>
    <tr>
      <th>Subject</th>
      <th>Date</th>
      <th>Last Reply</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>



     @foreach($items as $item)
       <tr>
       <td>{{ $item->subject }}</td>
       <td>{{  date('F d, Y h:m A', strtotime($item->created_at)) }}</td>
       <td>
           @foreach($replies as $reply => $v)
               @foreach($v as $data)
                 @if ($item->tid == $data->tid)
                    {{ $data->name }}
                  @endif
                @endforeach
              @endforeach
             </td>
       <td>@if ($item->status == 0)
       <a class="color--olive ">
            <i class="item icon"></i>  Open
          </a>
           @else
            <a class="color--gray">
            <i class="item icon"></i>  Closed
          </a>

       @endif</td>
       <td>
         <a href="{{ url('admin/item/'.$item->tid) }}" class="btn btn-primary btn-sm">View</a>
         @if ($item->status == 1)
         <a href="{{ url('item/open/'.$item->tid) }}" target="_blank" class="btn btn-primary btn-sm">Open</a>
        @else
         <a href="{{ url('item/close/'.$item->tid) }}" target="_blank" class="btn btn-primary btn-sm">Close</a>

         @endif
         <a href="{{ url('manage/item/delete/'.$item->tid) }}" class="btn btn-danger btn-sm">Delete</a>


       </td>
       </tr>
     @endforeach

     @if (count($items) ==0)
     <tr> <td colspan="5"> There is no open items.</td> </tr>
     @endif


  </tbody>
</table>



{{ $items->render() }}



    </div>
</div>
@endsection
