@extends('layouts.master')

@section('title', 'My Turn Now 2.0')

@section('headstuff')


<script src="//js.pusher.com/3.0/pusher.min.js"></script>
<script>
$(document).ready(function() {
  var pusher = new Pusher("{{env("PUSHER_KEY")}}");
var channel = pusher.subscribe('my-channel');
var phpmeetingid={{{$meeting->id}}};
var phpname="{{{$name}}}";
var moderator={{{$moderator}}};
channel.bind('my-event', function(data) {
  // $.ajax({
  //           url: '{{route('ajaxactual')}}',
  //           type: 'GET',
  //           data: {meeting_id: {{{$meeting->id}}}, name: '{{{$name}}}', moderator: {{{$moderator}}}}, // An object with the key 'submit' and value 'true;
  //           success: function (result) {
  //             //alert("Your bookmark has been saved"+result);
  //             $("#mainstuff").html(result['html']);
  //           //  $("#jsontest").html(data['hands']);
  //
  //
  //             //alert('made it');
  //           }
  //       });
        var h="";
        var newtopics="<ul class='list-group'>";
        var followups="<ul class='list-group'>";
        var json=JSON.parse(data['hands']);
        //$("#jsontest").html(json[1]);

        json.forEach(function(obj)
          {if (obj.followup) {
            followups+="<li class='list-group-item'>";
            if(moderator){
              followups+="<button class=\"callon\" value=\""+obj.id+"\">"+obj.name+"</button>";
            } else {
              followups+=obj.name;
            }
            followups+=" ("+obj.when+") ";
            if(obj.name===phpname){
              followups+="<button class=\"unraise\" value=\""+obj.id+"\">Unraise</button><button class=\"transfer\" value=\""+obj.id+"\">Transfer</button>";
            }
            followups+="</li>";
          }
          else {
            newtopics+="<li class='list-group-item'>";
            if(moderator){
              newtopics+="<button class=\"callon\" value=\""+obj.id+"\">"+obj.name+"</button>";
            } else {
              newtopics+=obj.name;
            }
            newtopics+=" ("+obj.when+") ";
            if(obj.name===phpname){
              newtopics+="<button class=\"unraise\" value=\""+obj.id+"\">Unraise</button><button class=\"transfer\" value=\""+obj.id+"\">Transfer</button>";;
            }
            newtopics+="</li>";
          }});
        followups+="</ul>";
        newtopics+="</ul>";
        $("#jsonnewtopics").html(newtopics);
        $("#jsonfollow").html(followups);
});
$( document ).on('click','.callon', function() {
  $.ajax({
            url: '{{action('HandController@callon')}}',
            type: 'GET',
            data: {hand_id: $(this).val()}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#mainstuff").html(result['html']);
            }
        });
});

$( document ).on('click','.transfer', function() {
  $.ajax({
            url: '{{action('HandController@transfer')}}',
            type: 'GET',
            data: {hand_id: $(this).val()}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#mainstuff").html(result['html']);
            }
        });
});

$( document ).on('click','.unraise', function() {
  $.ajax({
            url: '{{action('HandController@unraise')}}',
            type: 'GET',
            data: {hand_id: $(this).val()}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#mainstuff").html(result['html']);
            }
        });
});

$( document ).on('click','.raise', function() {
  $.ajax({
            url: '{{action('HandController@raisehand')}}',
            type: 'GET',
            data: {follow: $(this).val(), meeting_id: {{{$meeting->id}}}, name: '{{{$name}}}'}, // An object with the key 'submit' and value 'true;
            success: function (result) {
              //alert("Your bookmark has been saved"+result);
              $("#mainstuff").html(result['html']);
            }
        });
});

});
</script>
<style>
.raise{
  background-color: #4CAF50;
  width: 40%;
  height: 10%;
  border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 24px;

}


</style>
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
    <div class="col-md-6">
          <button class='raise' value='0'>New Topic</button>
      </div>
      <div class="col-md-6">
          <button class='raise' value='1' style='background-color:4c50af'>Follow up</button>
        </div>
  </div>
@else
  <div>
    <p>This is {{{$meeting->name}}} hosted by you, {{{$meeting->moderator}}}</p>
    <p>The link for others to join is  {{{route('signin',[$meeting->id])}}}</p>
@endif
    <div id='mainstuff'>

            <div id='jsonnewtopics' class="col-md-6">json here</div>

            <div id='jsonfollow' class="col-md-6">2nd json here</div>



    </div>


@endsection
