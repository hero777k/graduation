<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;


class WordController extends Controller
{
    /**
         * 単語暗記一覧
         */
        public function memorize($id)
        {
            $word = Word::findOrFail($id);
            $word->is_memorized = true;
            $word->save();
        
            return redirect()->route('words.index');
        }
        
        public function memorizedWords()
        {
            $words = Word::where('is_memorized', true)->get();
            return view('words.memorized', compact('words'));
        }
}
