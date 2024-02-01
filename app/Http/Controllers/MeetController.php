<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Meetuser;
use App\Post;
use App\Comment;
use DB;
use App\helper\functions;
use Response;
use Session;
use Carbon\Carbon;
session_start();
class MeetController extends Controller
{
    public function index(Request $request)
    {
    	$this->check_auth();
        $user_id =  Session::get('user_id');
        $users = Meetuser::findOrFail($user_id);
        $userIds = $users->followees()->pluck('follow_id')->toArray();
        
        $posts = Post::whereIn('user_id', $userIds)->orWhere('user_id', $user_id)->orderBy('created_at', 'DESC')->simplePaginate(5);
        // if ($request->ajax()) {
        //     return Response::json(view('front.home.posts',['posts'=>$posts])->render());
        // }
        return view('front.home.index',['user'=>$users,'posts'=>$posts]);
    }

    public function activity()
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $users = Meetuser::findOrFail($user_id);
        $userIds = $users->followees()->pluck('follow_id')->toArray();
        foreach ($userIds as $value) {
            $followees[] = Meetuser::findOrFail($value);
        }
        //$activity = DB::table('users_activity')->where('user_id',$user_id)->get();

        $activity = DB::table('users_activity')
                        ->join('activities','users_activity.activity_id','activities.activity_id')
                        ->join('locations', 'locations.location_id', '=', 'activities.location_id')
                        ->where('users_activity.user_id','=', $user_id)
                        ->get();

        return view('front.activity.index',['followees'=>$followees,'activity'=>$activity]);
    }

    public function createActivity(Request $request)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $date = date('Y-m-d H:i:s');
        $activity_id = DB::table('activities')->insertGetId(
            [
             'activity_name' => $request->activity_name, 
             'location_id' => $request->location_id,
             'activity_start'=>$request->activity_start,
             'created_at'=>$date,
             'updated_at'=>$date
            ]
        );
        DB::table('users_activity')->insert(
            [
             'user_id' => $user_id, 
             'activity_id' => $activity_id
            ]
        );
        foreach ($request->friend_ids as $ids) {
            DB::table('users_invites')->insert(
                [
                 'user_id' => $ids, 
                 'activity_id' => $activity_id
                ]
            );
        }
        Session::flash('notification_type', 'success');
        Session::flash('notification_msg', 'Activity created successfully.');
        return Redirect::to('/activity');
    }

    public function findLocation(Request $request)
    {
        $locations = DB::table('locations')->where('name', 'LIKE', '%'. $request->location .'%')->
                          get();
        return response()->json(view('front.activity.locations',['locations'=>$locations])->render());
    }

    public function profile()
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $user = Meetuser::findOrFail($user_id);
        $posts = Meetuser::find($user_id)->posts()->orderBy('created_at', 'DESC')->simplePaginate(5);
        return view('front.profile.index',['user'=>$user,'posts'=>$posts]);
    }

    

    public function updateUser(Request $request)
    {
        $this->check_auth();
        $user_id = Session::get('user_id');
        $Meetuser = Meetuser::find($user_id);
        $password = $request->input('password');
        if ($password) {
            $Meetuser->password = md5($password);
        }
        $Meetuser->name = $request->input('name');
        $Meetuser->about_you = $request->input('about_you');
        $Meetuser->gender = $request->input('gender');
        $Meetuser->save();
        Session::flash('notification_type', 'success');
        Session::flash('notification_msg', 'Profile updated successfully.');
        Redirect::to('/profile')->send();
    }

    public function createPost(Request $request)
    {
        $this->check_auth();
        $post = new Post();
        $process = new functions();
        $processData = $process->process($request->body);
        $user_id = Session::get('user_id');
        $post->user_id = $user_id;
        if ($processData->feed_type == "text") {
            $post->body = $processData->feed;
            $post->post_type = "text";
        }else{
            $post->body = $processData->feed_container;
            $post->post_type = "link";
        }
        $post->save();
        $users = Meetuser::findOrFail($user_id);
        $userIds = $users->followees()->pluck('follow_id')->toArray();
        
        $posts = Post::whereIn('user_id', $userIds)->orWhere('user_id', $user_id)->orderBy('created_at', 'DESC')->simplePaginate(5);
        return response()->json(view('front.home.posts',['user'=>$users,'posts'=>$posts])->render());
    }

    public function addPost(Request $request)
    {
        $this->check_auth();
        $post = new Post();
        $user_id = Session::get('user_id');
        $post->user_id = $user_id;
        $post->body = $request->body;
        $post->save();
        $users = Meetuser::findOrFail($user_id);
        $posts = Meetuser::find($user_id)->posts()->orderBy('created_at', 'DESC')->simplePaginate(5);
        return response()->json(view('front.home.posts',['user'=>$users,'posts'=>$posts])->render());
    }

    public function uploadImage(Request $request)
    {
        $this->check_auth();

        $this->validate($request, [

            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $image = $request->file('user_photo');
        if ($image) {
            $input['user_photo'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/front/images/users');

            $image->move($destinationPath, $input['user_photo']);
            
            $user_id = Session::get('user_id');
            $Meetuser = Meetuser::find($user_id);
            $Meetuser->user_photo = $input['user_photo'];
            $Meetuser->save();
            Session::flash('notification_type', 'success');
            Session::flash('notification_msg', 'Profile photo change successfully.');
            Redirect::to('/profile')->send();
        }else{
            Session::flash('notification_type', 'error');
            Session::flash('notification_msg', 'Profile photo not change successfully.');
            Redirect::to('/profile')->send();
        }

        
    }

    public function removePost($id)
    {
         $response = Post::where('id',$id)->delete();
        // Session::flash('notification_type', 'success');
        // Session::flash('notification_msg', 'Status deleted successfully.');
        return response()->json(['success'=>$response]);
    }

    public function userProfile($id)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        if ($user_id != $id) {
            $user = Meetuser::findOrFail($id);
            $posts = Meetuser::find($id)->posts()->orderBy('created_at', 'DESC')->simplePaginate(5);;
            return view('front.users.user_profile',['user'=>$user,'posts'=>$posts]);
        }else{
            Redirect::to('/profile')->send();
        }
       
    }

    public function findUser()
    {
        $this->check_auth();
        $user_id = Session::get('user_id');
        $user = Meetuser::findOrFail($user_id);
        // GETTING THE AUTHINTCATED USER FOLLOWING IDS..
        $followingIds = $user->followees()->pluck('follow_id')->toArray();

        // GET ALL USERS ID 
        $users = Meetuser::where('id', '!=', $user_id)->pluck('id')->toArray();

        // CHECK BETWEEN DATA FROM ALL USERS AND USER FOLLWOING ..
        $filtered_users = array_diff($users, $followingIds);

        // GET ALL USERS WITHOUT THE USER FOLLOWING ..
        $users = Meetuser::whereIn('id',$filtered_users)->take(4)->get();
        return view('front.users.index',['users'=>$users]);
    }


    public function searchUser(Request $request)
    {
        $this->check_auth();
        $user_id = Session::get('user_id');
        $body = $request->search_body;
        $users = Meetuser::where('username', 'LIKE', '%'. $body .'%')->
                          Orwhere('email', 'LIKE', '%'. $body .'%')->
                          get();
        return response()->json(view('front.users.lists',['users'=>$users])->render());
    }

    public function like(Request $request)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $post_id = $request->post_id;
        $response = DB::table('likes')->insert(
            ['user_id' => $user_id, 'post_id' => $post_id]
        );
        return response()->json(['success'=>$response]);
    }
    public function dislike(Request $request)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $post_id = $request->post_id;
        $response = DB::table('likes')
        ->where(['user_id'=>$user_id,'post_id'=>$post_id])->delete();
        return response()->json(['success'=>$response]);
    }

    public function follow(Request $request)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $follow_Id = $request->user_id;
        $response = DB::table('follows')->insert(
            ['user_id' => $user_id, 'follow_Id' => $follow_Id]
        );
        return response()->json(['success'=>$response]);
    }

    public function unfollow(Request $request)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $unfollow_Id = $request->user_id;
        $response = DB::table('follows')
        ->where(['user_id'=>$user_id,'follow_id'=>$unfollow_Id])->delete();
        return response()->json(['success'=>$response]);
    }

    public function conversations()
    {
        $this->check_auth();
        return view('front.messages.conversation');
    }

    public function getConversations()
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $conversation1 = DB::table('meetusers')
                        ->join('conversations','meetusers.id','conversations.user_one')
                        ->where('conversations.user_two', '=', $user_id)->orderBy('conversations.created_at', 'desc')->get();

        $conversation2 = DB::table('meetusers')
                        ->join('conversations','meetusers.id','conversations.user_two')
                        ->Where('conversations.user_one', '=', $user_id)->orderBy('conversations.created_at', 'desc')->get();

        return array_merge($conversation1->toArray(), $conversation2->toArray());

    }

    public function getConversationMsg($id)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $update_status = DB::table('conversations')->where('id',$id)
                    ->update([
                        'status' => 0 // now read by user
                    ]);
        $userMsg = DB::table('messages')
                 ->join('meetusers', 'meetusers.id','messages.user_from')
                 ->where('messages.conversation_id', $id)->get();
        return $userMsg;
    }

    public function sendMessage(Request $request){
      $this->check_auth();
      $user_id =  Session::get('user_id');
      $conID = $request->conID;
      $msg = $request->msg;
      $checkUserId = DB::table('messages')->where('conversation_id', $conID)->get();
      if($checkUserId[0]->user_from == $user_id){
        // fetch user_to
        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
        ->get();
          $userTo = $fetch_userTo[0]->user_to;
      }else{
      // fetch user_to
        $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
           ->get();
        $userTo = $fetch_userTo[0]->user_to;
      }
        $date = date('Y-m-d H:i:s');
        // now send message
        $sendM = DB::table('messages')->insert([
          'user_to' => $userTo,
          'user_from' => $user_id,
          'msg' => $msg,
          'status' => 1,
          'conversation_id' => $conID,
          'created_at' => $date,
          'updated_at' => $date
        ]);
        if($sendM){
          $userMsg = DB::table('messages')
          ->join('meetusers', 'meetusers.id','messages.user_from')
          ->where('messages.conversation_id', $conID)->get();
          return $userMsg;
        }
    }

    public function newMessage()
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $users = Meetuser::findOrFail($user_id);
        $userIds = $users->followees()->pluck('follow_id')->toArray();
        return view('front.messages.new_message',['userIds'=>$userIds]);
    }

    public function sendNewMessage(Request $request){
        $this->check_auth();
        $msg = $request->msg;
        $date = date('Y-m-d H:i:s');
        $follow_id = $request->follow_id;
        $myID = Session::get('user_id');
        //check if conversation already started or not
        $checkCon1 = DB::table('conversations')->where('user_one',$myID)
        ->where('user_two',$follow_id)->get(); // if loggedin user started conversation
        $checkCon2 = DB::table('conversations')->where('user_two',$myID)
        ->where('user_one',$follow_id)->get(); // if loggedin recviced message first
        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());
        if(count($allCons)!=0){
          // old conversation
          $conID_old = $allCons[0]->id;
          //insert data into messages table
          $MsgSent = DB::table('messages')->insert([
            'user_from' => $myID,
            'user_to' => $follow_id,
            'msg' => $msg,
            'conversation_id' =>  $conID_old,
            'status' => 1,
            'created_at'=>$date,
            'updated_at'=>$date
          ]);
        }else {
          // new conversation
          $conID_new = DB::table('conversations')->insertGetId([
            'user_one' => $myID,
            'user_two' => $follow_id,
            'status' => 1,
            'created_at'=>$date
          ]);
          echo $conID_new;
          $MsgSent = DB::table('messages')->insert([
            'user_from' => $myID,
            'user_to' => $follow_id,
            'msg' => $msg,
            'conversation_id' =>  $conID_new,
            'status' => 1,
            'created_at'=>$date,
            'updated_at'=>$date
          ]);
        }
    }
    

    public function addComment(Request $request)
    {
        $this->check_auth();
        $user_id =  Session::get('user_id');
        $post = new Comment;
        $parent_id = $request->parent_id;
        $post_id = $request->post_id;
        $post->id = $post_id;

        $comment_text = $request->comment_text;
        $date = date('Y-m-d H:i:s');
        $response = DB::table('comments')->insert(
            ['user_id' => $user_id, 'post_id' => $post_id,'parent_id' => $parent_id,'comment_text'=>$comment_text,'created_at'=>$date,'updated_at'=>$date]
        );
        $comments = Comment::with('children')
                    ->where(['parent_id'=>0,'post_id'=>$post_id])->orderBy('id', 'desc')->simplePaginate(5);
        return response()->json(view('front.home.comments',['comments'=>$comments,'post'=>$post])->render());
        
        
    }
    // public function addReply(Request $request)
    // {
    //     $this->check_auth();
    //     $user_id =  Session::get('user_id');
    //     $post = new Comment;
    //     $post_id = $request->post_id;
    //     $parent_id = $request->parent_id;
    //     $post->id = $post_id;
    //     $post->parent_id = $parent_id;

    //     $comment_text = $request->comment_text;
    //     $date = date('Y-m-d H:i:s');
    //     $response = DB::table('comments')->insert(
    //         ['user_id' => $user_id, 'post_id' => $post_id,'parent_id' => $parent_id,'comment_text'=>$comment_text,'created_at'=>$date,'updated_at'=>$date]
    //     );
    //     $comments = Comment::with('children')
    //                 ->where(['parent_id'=>0,'post_id'=>$post_id])->orderBy('id', 'desc')->simplePaginate(5);
    //     return response()->json(view('front.home.comments',['comments'=>$comments,'post'=>$post])->render());
        
        
    // }

    private function check_auth() {
        $user_id = Session::get('user_id');
        if($user_id == NULL){
        	Session::flash('notification_type', 'error');
            Session::flash('notification_msg', 'you can not access this page!');
            Redirect::to('/')->send();
       }
    }
    public function logout() {
        Session::put('user_id','');
        Session::flash('notification_type', 'success');
        Session::flash('notification_msg', 'you are successfully logged out.');
        Redirect::to('/')->send();
    }
}
