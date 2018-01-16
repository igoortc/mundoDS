<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Comment;
use App\CommentVote;
use App\CommentSpam;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    
    /**
     * Get Comments for pageId
     *
     * @return Comments
     */
    public function index($pageId)
    {
        //
        $comments = Comment::where('page_id',$pageId)->get();

        $commentsData = [];
        
        
        foreach ($comments as $key) {
            $user = User::find($key->users_id);
            $name = $user->name;
            $replies = $this->replies($key->id);
            $photo = $user->photo;
            $reply = 0;
            $vote = 0;
            $voteStatus = 0;
            $spam = 0;
            if(Auth::user()){
                $voteByUser = CommentVote::where('comment_id',$key->id)->where('user_id',Auth::user()->id)->first();
                $spamComment = CommentSpam::where('comment_id',$key->id)->where('user_id',Auth::user()->id)->first();
                
                if($voteByUser){
                    $vote = 1;
                    $voteStatus = $voteByUser->vote;
                }

                if($spamComment){
                    $spam = 1;
                }
            }
            
            if(sizeof($replies) > 0){
                $reply = 1;
            }

            if(!$spam){
                array_push($commentsData,[
                    "name" => $name,
                    "photo_url" => $photo,
                    "commentid" => $key->id,
                    "comment" => $key->comment,
                    "votes" => $key->votes,
                    "reply" => $reply,
                    "votedByUser" =>$vote,
                    "vote" =>$voteStatus,
                    "spam" => $spam,
                    "replies" => $replies,
                    "date" => $key->created_at->toDateTimeString()
                ]);
            }    
            
        }
        $collection = collect($commentsData);
        return $collection->sortBy('votes');
    }

    protected function replies($commentId)
    {
        $comments = Comment::where('reply_id',$commentId)->get();
        $replies = [];
        

        foreach ($comments as $key) {
            $user = User::find($key->users_id);
            $name = $user->name;
            $photo = $user->photo;
            $vote = 0;
            $voteStatus = 0;
            $spam = 0;    
            
            if(Auth::user()){
                $voteByUser = CommentVote::where('comment_id',$key->id)->where('user_id',Auth::user()->id)->first();
                $spamComment = CommentSpam::where('comment_id',$key->id)->where('user_id',Auth::user()->id)->first();

                if($voteByUser){
                    $vote = 1;
                    $voteStatus = $voteByUser->vote;
                }

                if($spamComment){
                    $spam = 1;
                }
            }
            if(!$spam){
                
                array_push($replies,[
                    "name" => $name,
                    "photo_url" => $photo,
                    "commentid" => $key->id,
                    "comment" => $key->comment,
                    "votes" => $key->votes,
                    "votedByUser" => $vote,
                    "vote" => $voteStatus,
                    "spam" => $spam,
                    "date" => $key->created_at->toDateTimeString()
                ]);
            }
            
        
        }
        
        $collection = collect($replies);
        return $collection->sortBy('votes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'comment' => 'required',
        'reply_id' => 'filled',
        'page_id' => 'filled',
        'users_id' => 'required',
        ]);
        $comment = Comment::create($request->all());
        // dd($comment); 
        if($comment)
            return [ "status" => "true","commentId" => $comment->id ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $commentId
     * @param  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $commentId,$type)
    {
        if($type == "vote"){
            
            $this->validate($request, [
            'vote' => 'required',
            'users_id' => 'required',
            ]);

            $comments = Comment::find($commentId);
            $data = [
                "comment_id" => $commentId,
                'vote' => $request->vote,
                'user_id' => $request->users_id,
            ];

            if($request->vote == "up"){
                $comment = $comments->first();
                $vote = $comment->votes;
                $vote++;
                $comments->votes = $vote;
                $comments->save();
            }

            if($request->vote == "down"){
                $comment = $comments->first();
                $vote = $comment->votes;
                $vote--;
                $comments->votes = $vote;
                $comments->save();
            }

            if(CommentVote::create($data))
                return "true";
        }

        if($type == "spam"){
            
            $this->validate($request, [
                'users_id' => 'required',
            ]);

            $comments = Comment::find($commentId);
            
            $comment = $comments->first();
            $spam = $comment->spam;
            $spam++;
            $comments->spam = $spam;
            $comments->save();

            $data = [
                "comment_id" => $commentId,
                'user_id' => $request->users_id,
            ];

            if(CommentSpam::create($data))
                return "true";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSpam()
    {
        $spams = Comment::where('spam', '1')
                ->get();

        return $spams;
    }

    public function notSpam($id)
    {
        $comment = Comment::find($id);
        dd($comment);
        $comment->spam = 0;

        return response()->json([
            'message' => 'Comment not spam successfully!'
        ], 200);
    }

    public function destroySpam($id)
    {
        $commentSpam = CommentSpam::where('comment_id', $id);
        $commentSpam->delete();

        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'message' => 'Spam destroyed successfully!'
        ], 200);
    }
}