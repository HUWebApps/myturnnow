@extends('layouts.master')

@section('title', 'My Turn Now')



@section('content')
<script src="//js.pusher.com/3.0/pusher.min.js"></script>
<script>
var pusher = new Pusher("{{env("PUSHER_KEY")}}")
var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  alert(data.text);
});
</script>
@endsection
