<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;

class WordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 単語一覧
     */
    public function index(Request $request)
    {
        // 絞り込み機能
        $selectedType = $request->input('type');
        $keyword = $request->input('keyword'); 

        $query = word::query();

        if (!empty($selectedType)) {
            $query->where('type', $selectedType);
        }

        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%') 
                  ->orWhere('detail', 'like', '%' . $keyword . '%');
                });
        }

        $words = $query->get();

        $types = word::select('type')->distinct()->get();

        return view('word.index', compact('words', 'types', 'selectedType'));
    }

    /**
     * 単語登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'detail' => 'required|max:65535'
            ]);

            // 単語登録
            word::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/words');
        }

        return view('word.add');
    }

    /**
     * 単語編集画面
     */
    public function edit($id)
    {
        $word = word::find($id);
        return view('word.edit', compact('word'));
    }

    /**
     * 単語更新処理
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'detail' => 'required|max:65535'
        ]);

        $word = word::findOrFail($id); 

        $word->name = $request->input('name');
        $word->type = $request->input('type');
        $word->detail = $request->input('detail');

        $word->save();

        return redirect()->route('word.index');
    }        

    /**
         * 単語削除
         */

    public function destroy($id)
        {
            $word = word::findOrFail($id);
            $word->delete();
            return redirect()->route('word.index');
        }

    /**
         * チェックボックス更新
         */
    public function memorized(Request $request)
    {
        $words = $request->input('words',[]);
        foreach ($words as $wordId => $memorizedValue) {
            // "1"または'0'をbooleanに変換
            $isMemorized = $memorizedValue === "1" || $memorizedValue === '1';

            // 単語を更新
            Word::where('id', $wordId)->update(['memorized' => $isMemorized]);
        }
        return redirect()->route('word.index');
    }

    /**
         * 覚えた単語を表示
         */

    public function showMemorizedWords(Request $request)
    {
        // 覚えた単語を取得
        $memorizedWords = Word::where('memorized', true);

        // 絞り込み機能
        $selectedType = $request->input('type');
        $keyword = $request->input('keyword');

        if (!empty($selectedType)) {
            $memorizedWords->where('type', $selectedType);
        }

        if (!empty($keyword)) {
            $memorizedWords->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('detail', 'like', '%' . $keyword . '%');
            });
        }

        // 絞り込んだ単語を取得
        $memorizedWords = $memorizedWords->get();

        // タイプの取得
        $types = Word::select('type')->distinct()->get();

        // ビューに渡す
        return view('word.memorized', [
            'words' => $memorizedWords,
            'types' => $types,
            'selectedType' => $selectedType,
            'keyword' => $keyword
        ]);
    }

    /**
         * 覚えてない単語を表示
         */

    public function showUnmemorizedWords(Request $request)
    {
        // 覚えていない単語を取得
        $query = Word::where('memorized', false);

        // 絞り込み機能
        $selectedType = $request->input('type');
        $keyword = $request->input('keyword');

        if (!empty($selectedType)) {
            $query->where('type', $selectedType);
        }

        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('detail', 'like', '%' . $keyword . '%');
            });
        }

        // 絞り込んだ単語を取得
        $unmemorizedWords = $query->get();

        // タイプの取得
        $types = Word::select('type')->distinct()->get();

        // ビューに渡す
        return view('word.unmemorized', [
            'words' => $unmemorizedWords,
            'types' => $types,
            'selectedType' => $selectedType,
            'keyword' => $keyword
        ]);
    }
}
