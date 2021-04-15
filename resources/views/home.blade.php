


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" class="col-sm-offset-2 col-sm-8">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">{{ Auth::user()->name }}</div>
                <div class="pic">
                    <img src="/storage/user_images/{{$user->user_prf}}" alt="プロフィール写真">        
                </div>
                
                <div class="card-body">{{ Auth::user()->email }}</div>
                <div class="card-body">{{ Auth::user()->id }}</div>
		        <?php
                   $iptest = $_SERVER['REMOTE_ADDR'];
		           echo "あなたのIPアドレスは". $iptest . "ですよ。";
                ?>
                <!-- ここにユーザーの記事一覧を表示する。 -->
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('article') }}</th>
                    </tr>
                    <!-- ログイン中のユーザー=user その中のarticles -->
                    @foreach($user -> articles as $article)
                        <tr>
                            <td>
                                <!-- usernameを出力する -->
                                {{$user->name}}
                            </td> 
                            
                            <td>
                                <div class="img">img</div>
                            </td>
                            <td>
                                <!-- articleテーブルのarticletitleに変更 --> 
				                <?php
                                    $articleresult = $article->article;
                                    $string_dot = "..";
                                    //articleの文字列を0～5まで指定して切り取り代入
                                    $string_mb_substr = mb_substr($articleresult,0,10);
                                    $string_mb_substr = $string_mb_substr.$string_dot;
                                ?>
                                <a href = "{{ route('article_display', ['id' => $article->id])}}">{{$string_mb_substr}}</a><br>		                    <div class = "row">
                                <a href="{{ route('article_update_page_show', ['id' => $article->id])}}"><img src="public/storage/icon_edit.png" class="icon-image"></a>
                                <form action="{{ route('article_delete' , ['id' => $article->id])}}" method="post">
                                    @method('DELETE')
                                    @csrf           
                                    <input type="image" src="public/storage/icon_trash.png" class="icon-image">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </thead>
                </table>

                <a  href="{{ url('/') }}">
                    <button type="submit" class="btn btn-light">みんなの記事一覧へ飛ぶ</button>
                </a>
                <a href="{{route('article')}}"><button type="submit" class="btn btn-light">記事作成ページへ移動する。</button></a>
                <a href="{{route('user_manegemet')}}"><button type="submit" class="btn btn-secondary active">ユーザー情報を編集、管理はこちら</button></a>
                <!-- ユーザー情報を削除ボタン押したらtopに戻る。補足:できればパスワードを要求するusercontrolerを使うか?homeからできるならやる -->
                <!-- 削除ボタンを作る -->
                <!-- actionでurl指定している。ユーザーのidを表示できる-->
                <!-- ボタンを押すと画面が遷移できるので処理はrouteは呼べているが、削除ができない。 -->
                <!-- ここのuseridはコントローラのuseridを示している -->
                <form action="{{ route('user_delete')}}" method="post" id="user_delete_form">
                    @method('DELETE')
                    @csrf                
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Okボタンを押すとすべてのユーザー情報を削除してしまい、復活もできません。よろしいですか？')">
                    <i class="fa fa-trash">{{ __('ユーザー情報を削除する。(直ぐ消えます)') }}</i>       
                    </button>
                </form>
                <!--  -->
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('ログインされています。') }}
                </div>
            </div>
        </div>      
    </div>
    <div class="d-flex justify-content-center mb-5">{{$user->articles->links()}}</div>
</div>
@endsection
