<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
class ArticleController extends Controller
{
    
    
    public function __construct() {
        /* articleに行くときは認証判定 */
        //$this->middleware('auth');
    }
    
    
    

    public function index()
    {
      
    } 
    

    public function store(Request $request){
        $article = new Article();
        /** 
        * バリデーションを設定する。
        */
        $validator = Validator::make($request->all(), [
            /* 入力必須255文字 form のarticleのバリデーションチェック*/
            'article' => 'required|max:10000',
        ]);
        if ($validator->fails()) {
            return redirect('/article')
                ->withInput()
                ->withErrors($validator);    
        }
        /**
         * 以下はブレードファイルのarticleのnameを指定して値をとっている。
         * この処理はarticleの内容を保存している。
         * ->articleはカラム
         * articleのidが表示される。
         */  
        $article->user_id = $request->user()->id;
        /**
         * 上記の$article->user_idはarticleのユーザーid格納カラム。
         *articleのタイトルをテーブルから呼び出して$article->article_title 
        */
        $article->article = $request->article;
        /**articleが投稿された時点でidは発行されているのでそこに紐づけしたい。
         * 例:
         * "user_id" => 3
         * "article" => "ｄｄ"
         * "updated_at" => "2021-01-05 03:11:39"
         * "created_at" => "2021-01-05 03:11:39"
         * "id" => 34←これをURLにする。
         * 
        */  
        $article->save();    
        return redirect(("/home"));
    }



    public function article(){
        /**
         * 以下でarticle.blade.phpを表示している。
         * blade.phpを表示するという意味なのかblade.phpに表示するという意味なのか、、おそらく前者
         * 追加などの処理をブレードファイル内に書き加える。
         * articleの作成ページの処理。
         *  */  
        return view("article");
    } 
    
    public function show($id){
        /** 
         * return viewで投稿ページ/{投稿id}にする。
         * articleshow.blade.phpを作る。
        */
        $article = Article::findOrFail($id);
	    $articleUserResult = $article->user_id;
        $articleUser = User::find($articleUserResult);
        return view('article_display')->with('article', $article)->with( 'articleUser',$articleUser);
    }

    public function article_update_page_show($id){
        /** 
         *
         * 編集するためのページを表示、articleの値を呼び出してブレードファイルに吐き出すを呼び出す。 
         * return でブレードファイルであるarticle_update_page_showを返す。
        */
        $article = Article::findOrFail($id);
        //dd($article);
        return view('article_update_page_show' ,['article' => $article]);
        //return view('article_update_page_show')->with('article',$article);
     }

    public function update(Request $request){
        
        /** 
         * 投稿内容を編集するためのコントローラー
         * $article_form =  $request -> all();で更新した投稿内容を取得している。
         * 元のarticle→$article = Article::find($request->id);
        */
        $article = Article::find($request->id);
        //$article = $article -> article;
        /**
         * $article_formにはbladeファイルからpostで送られてきた　idが入っている。all(); 指定によって、、
         *  
         * */

        //$article->fill($request->all())->save();
        $article_form =  $request -> article;
        $article -> article = $article_form;
        $article ->save();
        return redirect('home');
        //dd($article_form);
        //dd("元:".$article."\n"."新:".$article_form); 
        //unset($article_form['_token']);
        //unset($article_form['_id']);
        //$article->fill($article_form)->save();
        //dd($article);

    } 
    
    public function delete(Request $request){
        $article = Article::find($request -> id);
        //dd($article);
        $article->delete();
        return redirect('/home');
    }

}

