@extends('adminlte::page')

@section('title', '単語登録')

@section('content_header')
    <h1>単語登録</h1>
@stop

@section('content')
    <!-- 戻るボタン -->
    <div class="input-group-append">
    <a href="{{ route('word.index') }}" class="btn btn-default">戻る</a>
    </div>
    <br>
    <!-- 登録フォーム -->
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="card card-primary">
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">単語</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="単語">
                        </div>

                        <div class="form-group">
                            <label for="type">品詞</label>
                            <select name="type">
                            <option value="動詞">動詞</option>
                            <option value="名詞">名詞</option>
                            <option value="形容詞">形容詞</option>
                            <option value="副詞">副詞</option>
                            <option value="前置詞">前置詞</option>
                            <option value="接続詞">接続詞</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">意味</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="意味">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
