@extends('adminlte::page')

@section('title', '単語編集')

@section('content_header')
    <h1>単語編集・削除
    </h1>
@stop

@section('content')
    <!-- 戻るボタン -->
    <div class="input-group-append">
    <a href="{{ route('item.index') }}" class="btn btn-default">戻る</a>
    </div>
    <br>
    <!-- 編集フォーム -->
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
            <form action="{{ route('item.update', $item->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirmUpdate();">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <label for="id">ID:</label>
                    <span class="id-display">{{ $item->id }}</span>

                    <div class="form-group">
                        <label for="name">単語</label>
                        <input type="text" name="name" id="name" value="{{ $item->name }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="type">品詞</label>
                        <select name="type" id="type" class="form-control">
                            <option value="動詞" {{ $item->type == "動詞" ? "selected" : "" }} >動詞</option>
                            <option value="名詞" {{ $item->type == "名詞" ? "selected" : "" }} >名詞</option>
                            <option value="形容詞" {{ $item->type == "形容詞" ? "selected" : "" }} >形容詞</option>
                            <option value="副詞" {{ $item->type == "副詞" ? "selected" : "" }} >副詞</option>
                            <option value="前置詞" {{ $item->type == "前置詞" ? "selected" : "" }} >前置詞</option>
                            <option value="接続詞" {{ $item->type == "接続詞" ? "selected" : "" }} >接続詞</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="detail">意味</label>
                        <input type="text" class="form-control" id="detail" name="detail" value="{{ $item->detail }}">
                    </div>
                </div>
        </div>

            <!-- 更新ボタン -->
            <div class="input-group-append">
                <button type="submit" class="btn btn btn-primary">更新</button>
            </div>
        </form>

        <script>
            function confirmUpdate() {
                return confirm('本当に更新しますか？');
            }
        </script>

        <!-- 削除ボタン -->
        <form action="{{ route('item.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDeletion();">
            @csrf
            @method('DELETE')
            <div class="input-group-append">
                <button type="submit" class="btn btn-danger">削除</button>
            </div>
        </form>

        <script>
            function confirmDeletion() {
                return confirm('本当に削除しますか？');
            }
        </script>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop