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
    public function index($itemId)
    {
        // 特定の商品に対するコメントと関連するユーザー情報を取得
        $comments = Comment::with('userData')->where('item_id', $itemId)->get();

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

        $comment = Comment::create([
            'user_id' => $user->id,
            'item_id' => $request->item_id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load('user') // 新しいコメントとユーザー情報を含める
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
