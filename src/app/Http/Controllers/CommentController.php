<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $comments = Comment::where('item_id', $id)->get();

        return response()->json([
            'comments' => $comments
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $comment = [
            'item_id' => $request->item_id,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ];
        Comment::create($comment);
        return response()->json([
            "message" => "Successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $comment = Comment::find($id);

        if (!$comment || $comment->user_id != $user->id) {
            return response()->json([
                "message" => "Unauthorized or comment not found"
            ], 403);
        }

        $comment->delete();

        return response()->json([
            "message" => "Comment deleted successfully"
        ], 200);
    }
}
