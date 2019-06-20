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

        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({type: 'string', id: 'number'});
        dataTable.addColumn({ type: 'string', id: 'style', role: 'style' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
          @foreach($hands as $hand)
            ['{{$hand->name}}', '{{$hand->id}}',
            @if($hand->raised)
              @if($hand->followup)
                '#0000ff',
              @else
                '#00ff00',
              @endif
            @else
              @if($hand->followup)
                '#b0b0ff',
              @else
                '#b0ffb0',
              @endif
            @endif
            new Date('{{$hand->created_at->toW3cString()}}'), new Date('{{$hand->updated_at->toW3cString()}}')],
          @endforeach
        ]);

        var options = {
                timeline: { showBarLabels: false }
              };
        chart.draw(dataTable,options);
      }
    </script>
  @endsection
@section('content')
    <h1>{{$meeting->name}}</h1>
    <div>
      <table class="table-striped table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Times raised hand</th>
            <th>Times lowered hand</th>
            <th>Times called on</th>
          </tr>
        </thead>
        @foreach($details as $name=>$detail)
          <tr>
            <td>{{$name}}
            <td>{{$detail["count"]}}</td>
            <td>{{$detail["lowered"]}} ({{$detail["avglowered"]}} minutes)</td>
            <td>{{$detail["calledon"]}} ({{$detail["avgcalledon"]}} minutes)</td>
          </tr>
        @endforeach
      </table>
    </div>
    <div>
      <p>In the chart below, green indicates the hand was raised for a new topic while blue indicates is was a follow-up question.
        If the color is lighter they lowered their own hand. If it's dark they were called on. If it is of zero duration, that means they neither lowered nor
          were called on. Note that every bar can be hovered over to see details.</p>
        </div>
        </noscript>
    <div>
      held on {{$meeting->created_at->toRfc850String()}}, hosted by {{$meeting->moderator}}.

    <div id="timeline" style="height: 100%;"></div>

@endsection
