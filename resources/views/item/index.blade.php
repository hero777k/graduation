@extends('adminlte::page')

@section('title', '登録単語一覧')

@section('content_header')
    <h1>登録単語一覧</h1>
@stop

@section('content')

        <!-- 絞り込み・フリーワード検索フォーム -->
        <form method="GET" action="{{ route('item.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <label for="type" class="label-text">品詞</label>
                        <select name="type" id="type" class="form-select">
                            <option value="">全て</option>
                            @foreach($types as $t)
                                <option value="{{ $t->type }}" {{ $selectedType == $t->type ? 'selected' : '' }}>
                                    {{ $t->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">絞り込む</button>
                    </div>

                    <div class="col-md-3">
                        <label for="keyword" class="label-text">フリーワード</label>
                        <input type="text" name="keyword" id="keyword" class="form-control" value="{{ request('keyword') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">絞り込む</button>
                    </div>
                </div>
            </form> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">登録単語一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">単語登録</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->detail }}</td>
                                    <!-- 暗記ボタン -->
                                    <td>
                                        <form action="{{ route('words.memorize', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="checkbox" name="is_memorized" value="1" {{ $item->is_memorized ? 'checked' : '' }} onchange="this.form.submit()">
                                        </form>
                                    <td>
                                    <td><a href="{{ route('item.edit', $item->id) }}" class="btn btn-default"> 編集 / 削除 </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
