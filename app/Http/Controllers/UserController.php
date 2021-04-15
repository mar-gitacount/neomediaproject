<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
	return view('user_manegement',['user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        /**
         * $userによる投稿を取得
         * 投稿作成日が新しい順に並べる。
         * homeに返す。できるかわからないが、、
         * articleのpagenateをユーザー自身のページを5ページ
         * */ 
        $user->articles = $user->articles()->paginate(5);
        return view('users.show', ['user' => $user]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
	$user_form = $request->all();
        $user = $request->user();
        unset($user_form['_token']);
        $user->fill($user_form)->save();
        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /**
         * $requestで-userを持ってきて、deleteコマンドで削除する。
         *redirectでhomeに戻る。
         * 
         * */     
        $user=$request->user();
        $user->delete();
        return redirect('/home');

    }
}
