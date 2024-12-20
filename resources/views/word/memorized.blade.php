@extends('adminlte::page')

@section('title', '暗記単語一覧')

@section('content_header')
    <h1>暗記単語一覧</h1>
@stop

@section('content')

        <!-- 絞り込み・フリーワード検索フォーム -->
        <form method="GET" action="{{ route('memorized.words') }}">
            <div class="input-group-append">
                <div class="col-md-3">
                    <label for="type" class="label-text">品詞</label>
                    <br>
                    <select name="type">
                        <option value="">全て</option>
                        @foreach($types as $type)
                            <option value="{{ $type->type }}" {{ $selectedType == $type->type ? 'selected' : '' }}>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary">絞り込む</button>
                </div>

                <div class="col-md-3">
                    <label for="keyword" class="label-text">フリーワード</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" value="{{ old('keyword', $keyword) }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary">絞り込む</button>
                </div>
            </div>
        </form>

        @if($words->isEmpty())
            <p>覚えた単語はありません。</p>
        @endif
    <br>    

    <div class="row">
        <div class="col-12">
            <form action="{{route('memorized.words')}}" method="get">
            @csrf
            @method('GET')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">暗記単語一覧</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap fixed-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>単語</th>
                                <th>品詞</th>
                                <th style="width: 200px;">意味</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($words as $word)
                                <tr>
                                    <td>{{ $word->id }}</td>
                                    <td>{{ $word->name }}</td>
                                    <td>{{ $word->type }}</td>
                                    <td class="text-truncate" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $word->detail }}</td>
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