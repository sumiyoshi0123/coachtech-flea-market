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
        $user = Auth::user();

        // ファイルアップロード
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $request['img_url'] = Storage::url($path);
        }

        // 商品を作成
        $item = Item::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'img_url' => $request->img_url,
            'description' => $request->description,
            'category_id' => $request['category_id'],
            'condition_id' => $request['condition_id'],
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
        $item = Item::find($id);

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
}
