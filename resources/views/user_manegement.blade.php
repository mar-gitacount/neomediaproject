@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card" class="col-sm-offset-2 col-sm-8">
            <!-- user_name user_email change start controller内でデータベースのuser情報を呼び出す。-->
            <div class="card-body"><i class="fa fa-trash">{{ __('このページはユーザー情報を編集、または削除する事ができます。') }}</i></div>
            <!-- actionでUser_ManegementControllerのupdateを使う。 -->
            <div class="card-body">
                <form method="post" action="{{ route('update')}}">
                    <div class="form-group">
                        <label for="img">
                           画像
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="name">
                            名前
                        </label>
                        <div>
                            <input type="text" name="name" class="form-control" value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">
                            メール
                        </label>
                        <div>
                            <input type="text" name="email" class="form-control" value="{{$user->email}}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-lg">{{__('ユーザー情報を変更する')}}</button>
                    {{ csrf_field() }}
                </form>
            </div>
            <!-- end -->
            <div class="card-body">
                <form action="{{ route('user_delete')}}" method="post" id="user_delete_form">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Okボタンを押すとすべてのユーザー情報を削除してしまい、復活もできません。よろしいですか？')">
                        <i class="fa fa-trash">{{ __('ユーザー情報を削除する。') }}</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
