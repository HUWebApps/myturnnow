@extends('layouts.master')

@section('title', 'My Turn Now: join session')



@section('content')
    <p>Welcome to the {{{$meeting->name}}} hosted by {{{$meeting->moderator}}}</p>
    <form action='{{{url("meeting/signup", [$meeting->id])}}}' method="post">
      {{ csrf_field() }}
      your name: <input type='text' name='name'><br/>
      <input type='submit' name='submit'>
    </form>
@endsection
