<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserData::all();

        return response()->json([
            'data' => $data
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $userData = UserData::where('user_id', $user->id)->first();

        if ($userData) {
            return response()->json([
                'data' => $userData
            ]);
        } else {
            return response()->json([
                'message' => 'User data not found.'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserData $userData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserData $userData)
    {
        //
    }

    //住所変更
    public function updateAddress(Request $request)
    {
        $request->validate([
            'post_number' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $userData = $user->userData; // ユーザーに関連するUserDataモデルを取得

        $userData->update([
            'post_number' => $request->post_number,
            'address' => $request->address,
            'building_name' => $request->building_name,
        ]);

        return response()->json(['message' => '住所が更新されました。'], 200);
    }
}
