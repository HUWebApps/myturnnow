@extends('layouts.master')

@section('title', 'My Turn Now')

@section('headstuff')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['timeline']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'President' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
          @foreach($hands as $hand)
            ['{{$hand->name}}', new Date('{{$hand->created_at->toW3cString()}}'), new Date('{{$hand->updated_at->toW3cString()}}')],
          @endforeach
        ]);

        chart.draw(dataTable);
      }
    </script>
  @endsection
@section('content')
    <h1>{{$meeting->name}}</h1>
    <div>
      held on {{$meeting->created_at->toRfc850String()}}, hosted by {{$meeting->moderator}}.

    <div id="timeline" style="height: 100%;"></div>
@endsection
