<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $purchases = Purchase::where('user_id', $user->id)->with('item')->get();


        return response()->json([
            'purchases' => $purchases
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
        try {
            // 現在のユーザーを取得
            $user = Auth::user();

            // 新しい購入レコードを作成
            $purchase = new Purchase();
            $purchase->user_id = $user->id;
            $purchase->item_id = $request->item_id;
            $purchase->payment_id = $request->payment_id;
            $purchase->save();

            // 購入された商品のフラグを更新
            $product = Item::findOrFail($request->item_id);
            $product->is_purchased = true;
            $product->save();

            // 成功レスポンスを返す
            return response()->json([
                'success' => true,
                'message' => '購入が完了しました',
            ]);
        } catch (\Exception $e) {
            // エラーレスポンスを返す
            return response()->json([
                'success' => false,
                'message' => '購入に失敗しました: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
