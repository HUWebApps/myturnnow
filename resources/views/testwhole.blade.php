@extends('layouts.master')

@section('title', 'My Turn Now')

@section('headstuff')


<script src="//js.pusher.com/3.0/pusher.min.js"></script>
<script>
var pusher = new Pusher("{{env("PUSHER_KEY")}}");
var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  $.ajax({
            url: '{{route('ajaxactual')}}',
            type: 'GET',
            data: {meeting_id: 5, name: 'SF', moderator: 0}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#mainstuff").html(result['html']);
              alert('made it');
            }
        });
});
</script>

@endsection

@section('content')
<div id='mainstuff'>sdfds</div>
@endsection
