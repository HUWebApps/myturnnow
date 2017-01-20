@extends('layouts.master')

@section('title', 'My Turn Now')

@section('headstuff')
<script>
$(document).ready(function() {
 $( ".somebutton" ).click(function() {
   $.ajax({
             url: '{{route('ajax')}}',
             type: 'GET',
             data: {noise: "fart", meeting_id: 5, val: $(this).val()}, // An object with the key 'submit' and value 'true;
             success: function (result) {
               //alert("Your bookmark has been saved"+result);
               $("#results").html(result['html']);
               $("#session").html(result['session'])
             }
         });
});
});
</script>

@endsection

@section('content')
<button class='somebutton' value='first button'>button 1</button>
<button class='somebutton' value='second button'>button 2</button>
<div id='results'></div>
<div id='session'></div>
<script src="//js.pusher.com/3.0/pusher.min.js"></script>
<script>
var pusher = new Pusher("{{env("PUSHER_KEY")}}");
var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  $.ajax({
            url: '{{route('ajax')}}',
            type: 'GET',
            data: {noise: "fart", meeting_id: 5, val: 'hi'}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#results").html(result['html']);
              $("#session").html(result['session'])
            }
        });
});
</script>
@endsection
