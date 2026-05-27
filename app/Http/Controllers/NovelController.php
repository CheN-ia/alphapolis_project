<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;

class NovelController extends Controller
{
    public function index()
    {
            // お問い合わせのレコードをすべて取得
        $works = Novel::all();
        $user = Auth::user();
        return view('novels.index', compact('works','user'));
    }

    public function search()
    {

    }
}
