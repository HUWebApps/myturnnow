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
