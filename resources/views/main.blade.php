@extends('layouts.master')

@section('title', 'My Turn Now')



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
    <p>The link for others to join is {{{route('signin',[$meeting->id])}}}</p>
@endif
    <table class='table table-bordered'>
      <thead>
        <tr>
          <th>New topics</th>
          <th>Follow ups</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            @foreach($handsnew AS $hand)
              @if($moderator)
                <a href="{{{action('HandController@callon',[$hand->id])}}}">{{{$hand->name}}} ({{{$hand->created_at->diffForHumans()}}})</a><br/>
              @else
                {{{$hand->name}}} ({{{$hand->created_at->diffForHumans()}}})
                @if($name==$hand->name)
                  <a href="{{{action('HandController@unraise', [$hand->id])}}}">Unraise</a>
                  <a href="{{{action('HandController@transfer', [$hand->id])}}}">transfer</a>
                @endif
                <br>
              @endif
            @endforeach
          </td>
        <td>
          @foreach($handsfollow AS $hand)
            @if($moderator)
              <a href="{{{action('HandController@callon',[$hand->id])}}}">{{{$hand->name}}} ({{{$hand->created_at->diffForHumans()}}})</a><br/>
            @else
              {{{$hand->name}}} ({{{$hand->created_at->diffForHumans()}}})
              @if($name==$hand->name)
                <a href="{{{action('HandController@unraise', [$hand->id])}}}">Unraise</a>
                <a href="{{{action('HandController@transfer', [$hand->id])}}}">transfer</a>
              @endif
              <br>
            @endif
          @endforeach
        </td>
      </tr>
      </tbody>
    </table>
@endsection
