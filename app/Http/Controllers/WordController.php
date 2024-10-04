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
}
