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

                <button class="callon" value="{{{$hand->id}}}">{{{$hand->name}}}</button>
                {{{$hand->created_at->diffForHumans()}}}
                <br>
              @else
                {{{$hand->name}}} ({{{$hand->created_at->diffForHumans()}}})
                @if($name==$hand->name)
                  <button class="unraise" value="{{{$hand->id}}}">Unraise</button>
                  <button class="transfer" value="{{{$hand->id}}}">Transfer</button>
                @endif
                <br>
              @endif
            @endforeach
          </td>
        <td>
          @foreach($handsfollow AS $hand)
            @if($moderator)
              <button class="callon" value="{{{$hand->id}}}">{{{$hand->name}}}</button>
              {{{$hand->created_at->diffForHumans()}}}
              <br>
            @else
              {{{$hand->name}}} ({{{$hand->created_at->diffForHumans()}}})
              @if($name==$hand->name)
                <button class="unraise" value="{{{$hand->id}}}">Unraise</button>
                <button class="transfer" value="{{{$hand->id}}}">Transfer</button>
              @endif
              <br>
            @endif
          @endforeach
        </td>
      </tr>
      </tbody>
    </table>
