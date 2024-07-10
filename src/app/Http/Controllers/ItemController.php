<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items =
        Item::where('is_purchased', false)->get();

        return response()->json([
            'itemData' => $items,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のバリデーション
        ]);

        $user = Auth::user();

        // 画像の保存
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['img_url'] = $imagePath;
        } else {
            return response()->json(['message' => 'Image upload failed'], 400);
        }

        // 商品を作成
        $item = Item::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'brand' => $validatedData['brand'],
            'price' => $validatedData['price'],
            'img_url' => $validatedData['img_url'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'condition_id' => $validatedData['condition_id'],
        ]);

        return response()->json([
            'message' => 'Item successfully created',
            'data' => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::with('category', 'condition')->find($id);

        return response()->json([
            'data' => $item
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }

    //出品アイテムの表示
    public function userItems()
    {
        // 現在ログインしているユーザーのIDを取得
        $userId = Auth::id();

        // ユーザーが出品した商品を取得するクエリ
        $userItems = Item::where('user_id', $userId)->get();

        return response()->json([
            'userItems' => $userItems,
        ], 200);
    }
}
