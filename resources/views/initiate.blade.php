@extends('layouts.master')

@section('title', 'My Turn Now: new session')



@section('content')
    <form action="{{{url('meeting/new')}}}" method="post">
      {{ csrf_field() }}
      Meeting name: <input type='text' name='meeting'><br/>
      your name: <input type='text' name='moderator'><br/>
      <input type='submit' name='submit'>
    </form>
@endsection
