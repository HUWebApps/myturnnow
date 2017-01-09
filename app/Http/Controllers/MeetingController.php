<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Meeting;
use App\Hand;

class MeetingController extends Controller
{
    //
    public function newsession(){
      return view('initiate');
    }

    public function postNewSession(Request $request){
      $meetingname=$request->input('meeting');
      $moderator=$request->input('moderator');
      $meeting=new Meeting;
      $meeting->name=$meetingname;
      $meeting->moderator=$moderator;
      $meeting->save();
      $request->session()->put('meeting',$meeting);
      $request->session()->put('moderator', True);
      return redirect()->route('main');
    }

    public function main(Request $request){
      if (!($request->session()->has('meeting'))) {
          return "no session started";
        };
      $meeting=$request->session()->get('meeting');
      //dd($meeting);
      $moderator=$request->session()->get('moderator');
      $name=$request->session()->get('name');
      $handsnew=$meeting->hands()
          ->where('raised',1)
          ->where('calledon',0)
          ->where('followup',0)
          ->get();
      $handsfollow=$meeting->hands()
          ->where('raised',1)
          ->where('calledon',0)
          ->where('followup',1)
          ->get();
      return view('main',
        ['handsnew'=>$handsnew,
        'handsfollow'=>$handsfollow,
        'meeting'=>$meeting,
        'moderator'=>$moderator,
        'name'=>$name]);
    }
}
