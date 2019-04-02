<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use JWTAuth;
use App\Like;
use App\Interest;
use App\Comment;

class DataController extends Controller
{
    public function storeEvent(Request $request) 
            {
                 if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['message' =>'user_not_found' , 'code' => 404]);
                            }
                $event = new Event;
                $event->title = $request->event_title;
                $event->lat = $request->lat;
                $event->long = $request->lon;
                $event->location = $request->address;
                $event->start_date = $request->start_date;
                $event->end_date = $request->end_date;
                $img = base64_decode($request->profile);
                $event->profile = $img;
                $event->user_id = $user->id;
                $event->save();
                return response()->json(['message' => 'added event' , 'code' => 200]);

            }

            public function closed() 
            {
                $data = "Only authorized users can see this";
                return response()->json(compact('data'),200);
            }

            public function getPosts(){
                $events = Event::with('user')->withCount('likes' , 'comments')->get();
                $user = JWTAuth::parseToken()->authenticate();
                $events->map(function($value) use ($user){
                    if($value->user){
                        if($value->likedata->first()){
                            $like = $value->likedata->where('user_id' , $user->id)->first();
                            if($like){
                                $value->like = true;
                            }
                        }
                        if($value->interest->first()){
                            $interest = $value->interest->where('user_id' , $user->id)->first();
                            if($interest){
                                $value->interestval = true;
                            }
                        }
                    $value->timeago =$value->created_at->diffForHumans();
                    }
                });
                return response()->json(['data' => $events , 'code' => 200]);
            }

            public function likeset($id){
                $user = JWTAuth::parseToken()->authenticate();
                $like = Like::where('user_id' , $user->id)->where('post_id' , $id)->first();
                if($like){
                    $like->delete();
                    return response()->json('matched');
                }
                else{
                    $like = new Like;
                    $like->post_id  = $id;
                    $like->user_id = $user->id;
                    $like->save();
                    return response()->json('notmatched');
                }
            }

            public function interestSet($id){
                $user = JWTAuth::parseToken()->authenticate();
                $interest = Interest::where('user_id' , $user->id)->where('post_id' , $id)->first();
                if($interest){
                    $interest->delete();
                    return response()->json('matched');
                }
                else{
                    $interest = new Interest;
                    $interest->post_id  = $id;
                    $interest->user_id = $user->id;
                    $interest->save();
                    return response()->json('notmatched');
                }
            }

            public function postDetail($id){
                $events = Event::with('user' , 'commentsdata.user')->withCount('likes' , 'comments')->find($id);
                $user = JWTAuth::parseToken()->authenticate();
                return response()->json(['data' => $events , 'user' =>$user ,  'code' => 200]);
            }

            public function commentSave(Request $request){
                $comment = new Comment;
                $user = JWTAuth::parseToken()->authenticate();
                $comment->user_id = $user->id;
                $comment->post_id = $request->postid;
                $comment->comment = $request->comment;
                $comment->save();
                $events = Event::with('user' , 'commentsdata.user')->withCount('likes' , 'comments')->find($request->postid);
                return response()->json(['data' => $events , 'code' => 200]);
            }

}
