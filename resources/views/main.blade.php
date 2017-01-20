@extends('layouts.master')

@section('title', 'My Turn Now')

@section('headstuff')


<script src="//js.pusher.com/3.0/pusher.min.js"></script>
<script>
$(document).ready(function() {
  var pusher = new Pusher("{{env("PUSHER_KEY")}}");
var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  $.ajax({
            url: '{{route('ajaxactual')}}',
            type: 'GET',
            data: {meeting_id: {{{$meeting->id}}}, name: '{{{$name}}}', moderator: {{{$moderator}}}}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#mainstuff").html(result['html']);
              //alert('made it');
            }
        });
});
});
</script>

@endsection

@section('content')
<div>
  <p>
    <a href='{{{route('main')}}}'>REFRESH</a>
  </p>
</div>
@if(!$moderator)
  <div>
    <p>Welcome {{{$name}}}. You're in {{{$meeting->name}}} hosted by {{{$meeting->moderator}}}</p>
    <p>
      <a href='{{{route('raisehand',[0])}}}'>NEW TOPIC</a> or <a href='{{{route('raisehand',[1])}}}'>FOLLOW UP OF CURRENT TOPIC</a>
  </div>
@else
  <div>
    <p>This is {{{$meeting->name}}} hosted by you, {{{$meeting->moderator}}}</p>
    <p>The link for others to join is  {{{route('signin',[$meeting->id])}}}</p>
@endif
    <div id='mainstuff'>{!! $html !!}</div>
@endsection
