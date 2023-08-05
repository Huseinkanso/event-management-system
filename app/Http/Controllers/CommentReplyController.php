<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReplyRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Reply;

class CommentReplyController extends Controller
{
    public function getEventComments(Event $event)
    {
        $comments = $event->comments;
        return response(['comments' => CommentResource::collection($comments)]);
    }
    public function storeComment(CommentRequest $request)
    {
        Comment::create($request->all());
        return response(['notify' => 'comment added succesflly']);
    }
    public function storeReply(ReplyRequest $request)
    {
        if ($request->parent_reply_id == -1) {
            Reply::create($request->except('parent_reply_id'));
        } else {
            Reply::create($request->all());
        }

        return response(['notify' => 'reply added succesfully']);
    }
    public function deleteComment(Comment $comment){
        $comment->delete();
        return response(['notify'=>'deleted successfully']);
    }
    public function deleteReply(Reply $reply){
        $reply->delete();
        return response(['notify'=>'deleted successfully']);
    }
}

