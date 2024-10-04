<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
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

        $query = Item::query();

        if (!empty($selectedType)) {
            $query->where('type', $selectedType);
        }

        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%') 
                  ->orWhere('detail', 'like', '%' . $keyword . '%');
                });
        }

        $items = $query->get();

        $types = Item::select('type')->distinct()->get();

        return view('item.index', compact('items', 'types', 'selectedType'));
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
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    /**
     * 単語編集画面
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('item.edit', compact('item'));
    }

    /**
     * 単語更新処理
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id); 

        $item->name = $request->input('name');
        $item->type = $request->input('type');
        $item->detail = $request->input('detail');

        $item->save();

        return redirect()->route('item.index');
    }        

    /**
         * 単語削除
         */

    public function destroy($id)
        {
            $item = Item::findOrFail($user_id);
            $item->delete();
            return redirect()->route('item.index');
        }
}
