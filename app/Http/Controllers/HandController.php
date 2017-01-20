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

    public function raisehand(Request $request){
      //dd('made it');

      $meeting_id=$request->input('meeting_id');
      $meeting=Meeting::findOrFail($meeting_id);
      $name=$request->input('name');
      $hand=new Hand;
      $hand->name=$name;
      $hand->raised=True;
      $follow=$request->input('follow');
      $hand->followup=$follow;
      $meeting->hands()->save($hand);
      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      //return redirect()->route('main');

    }

    public function callon(Request $request){

      $hand_id=$request->input('hand_id');
      $hand=Hand::findOrFail($hand_id);
      $hand->calledon=True;
      $hand->save();
      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      //return redirect()->route('main');

      //return "oops";
    }

    public function unraise(Request $request){
      $hand_id=$request->input('hand_id');
      $hand=Hand::findOrFail($hand_id);
      $hand->raised=False;
      $hand->save();

      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      //return redirect()->route('main');
    }

    public function transfer(Request $request){
      $hand_id=$request->input('hand_id');
      $hand=Hand::findOrFail($hand_id);
      $follow=!($hand->followup);
      $hand->followup=$follow;
      $hand->save();

      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      //return redirect()->route('main');
    }
}
