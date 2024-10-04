@extends('adminlte::page')

@section('title', '登録単語一覧')

@section('content_header')
    <h1>登録単語一覧</h1>
@stop

@section('content')

        <!-- 絞り込み・フリーワード検索フォーム -->
        <form method="GET" action="{{ route('word.index') }}" class="mb-3">
                <div class="input-group-append">
                    <div class="col-md-3">
                        <label for="type" class="label-text">品詞</label>
                        <br>
                        <select name="type" id="type" class="form-select">
                            <option value="">全て</option>
                            @foreach($types as $t)
                                <option value="{{ $t->type }}" {{ $selectedType == $t->type ? 'selected' : '' }}>
                                    {{ $t->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-words-end">
                        <button type="submit" class="btn btn-primary">絞り込む</button>
                    </div>

                    <div class="col-md-3">
                        <label for="keyword" class="label-text">フリーワード</label>
                        <input type="text" name="keyword" id="keyword" class="form-control" value="{{ request('keyword') }}">
                    </div>

                    <div class="col-md-3 d-flex align-words-end">
                        <button type="submit" class="btn btn-primary">絞り込む</button>
                    </div>
                </div>
            </form> 

    <div class="row">
        <div class="col-12">
            <form>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">登録単語一覧&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">選択した単語を送信</button>
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('words/add') }}" class="btn btn-default">単語登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>単語</th>
                                <th>品詞</th>
                                <th>意味</th>
                                <th>覚えた!</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($words as $word)
                                <tr>
                                    <td>{{ $word->id }}</td>
                                    <td>{{ $word->name }}</td>
                                    <td>{{ $word->type }}</td>
                                    <td>{{ $word->detail }}</td>
                                    <td>
                                        <input type="checkbox" name="words[]" value="{{ $word->memorized }}">
                                    </td>
                                    <td><a href="{{ route('word.edit', $word->id) }}" class="btn btn-default"> 編集 / 削除 </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
