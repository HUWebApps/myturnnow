<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Meeting;
use App\Hand;

use Vinkla\Pusher\Facades\Pusher;

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
      if ($moderator==''){
        $moderator=0;
      };
      $name=$request->session()->get('name');
      if ($name==''){
        $name="none";
      };
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
      $v= view('formattedajax',
          ['handsnew'=>$handsnew,
          'handsfollow'=>$handsfollow,
          'meeting'=>$meeting,
          'moderator'=>$moderator,
          'name'=>$name]);
      $returnhtml=$v->render();
      //dd($returnhtml);
      return view('main',
        ['handsnew'=>$handsnew,
        'handsfollow'=>$handsfollow,
        'meeting'=>$meeting,
        'moderator'=>$moderator,
        'name'=>$name,
        'html'=>$returnhtml]);
    }

    public function pusher(){
      Pusher::trigger('my-channel', 'my-event', ['message' => 'it has been updated']);
      return "done";
    }

    public function pusherclient(){
      return view('pusher');
    }

    public function javascriptest(){
      return view('testjquery');
    }

    public function ajaxtest(Request $request){
      $noise=$request->input('noise');
      $meeting_id=$request->input('meeting_id');
      $val=$request->input('val');
      $meeting=Meeting::findOrFail($meeting_id);
      $noise.="hithere";
      $str=$meeting->name." $val";
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
    $v= view('formattedajax',
        ['handsnew'=>$handsnew,
        'handsfollow'=>$handsfollow,
        'meeting'=>$meeting,
        'moderator'=>True,
        'name'=>'Andy']);
    $returnhtml=$v->render();
    $name=$request->session()->get('name');
    return response()->json(array('html'=>$returnhtml,'session'=>"session ".$name));
    //return $returnhtml;

    }

    public function ajax(Request $request){
      $name=$request->input('name');
      //$name='SF';
      $moderator=$request->input('moderator');
    //  $moderator=1;
      $meeting_id=$request->input('meeting_id');
      $meeting=Meeting::findOrFail($meeting_id);
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
      $v= view('formattedajax',
          ['handsnew'=>$handsnew,
          'handsfollow'=>$handsfollow,
          'meeting'=>$meeting,
          'moderator'=>$moderator,
          'name'=>$name]);
      $returnhtml=$v->render();
      $name=$request->session()->get('name');
      return response()->json(array('html'=>$returnhtml));
    //return $returnhtml;

    }

    public function chart($meeting_id){
      $meeting=Meeting::findOrFail($meeting_id);
      $hands=$meeting->hands;
      $details=[];
      foreach ($hands as $hand) {
        if(!(array_key_exists($hand->name,$details))) {
          $details[$hand->name]=["count"=>0, "lowered"=>0,"calledon"=>0];
        };
        $details[$hand->name]["count"]++;
        if (!($hand->raised)) {
          $details[$hand->name]["lowered"]++;
          $details[$hand->name]["loweredtime"][]=$hand->created_at->diff($hand->updated_at)->m;
        };
        if ($hand->calledon) {
          $details[$hand->name]["calledon"]++;
          $details[$hand->name]["calledontime"][]=$hand->created_at->diff($hand->updated_at)->m;
        }
      }
      foreach ($details as $name => $detail) {
        if (!(array_key_exists("loweredtime",$detail))) {
          $details[$name]["loweredtime"]=[0];
        }
        if (!(array_key_exists("calledontime",$detail))) {
          $details[$name]["calledontime"]=[0];
        }
      }
      ksort($details);
      return view('chart',
        ['meeting'=>$meeting,
        'hands'=>$hands,
        'details'=>$details]);
    }
}
