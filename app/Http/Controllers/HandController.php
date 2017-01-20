<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Meeting;
use App\Hand;

use Vinkla\Pusher\Facades\Pusher;

class HandController extends Controller
{
    //
    public function test(){
      return 'made it to test';
    }

    public function getSignIn($meeting_id){
      $meeting=Meeting::findOrFail($meeting_id);
      //dd($meeting);
      return view('participantsignup',
        ['meeting'=>$meeting]);
    }

    public function postSignIn(Request $request, $meeting_id){
      $meeting=Meeting::findOrFail($meeting_id);
      $name=$request->input('name');
      $request->session()->put('moderator', False);
      $request->session()->put('meeting', $meeting);
      $request->session()->put('name', $name);
      return redirect()->route('main');
    }

    public function raisehand($follow){
      //dd('made it');

      if (!(session()->has('meeting'))) {
          return "no session started";
        };
      if (!(session()->has('name'))) {
        return "you haven't given your name yet";
      };
      $meeting=session()->get('meeting');
      $hand=new Hand;
      $hand->name=session()->get('name');
      $hand->raised=True;
      $hand->followup=$follow;
      $meeting->hands()->save($hand);
      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      return redirect()->route('main');

    }

    public function callon($hand_id){
      if (session()->get('moderator')){
        $hand=Hand::findOrFail($hand_id);
        $hand->calledon=True;
        $hand->save();
        Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
        return redirect()->route('main');
      };
      return "oops";
    }

    public function unraise($hand_id){
      $hand=Hand::findOrFail($hand_id);
      $hand->raised=False;
      $hand->save();

      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      return redirect()->route('main');
    }

    public function transfer($hand_id){
      $hand=Hand::findOrFail($hand_id);
      $follow=!($hand->followup);
      $hand->followup=$follow;
      $hand->save();

      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      return redirect()->route('main');
    }
}
