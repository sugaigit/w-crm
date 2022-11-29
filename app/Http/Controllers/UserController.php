<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate();

        $search = $request->input('search');

        $query = User::query();

        // if ($search !== null) {

        //     $spaceConversion = mb_convert_kana($search, 's');

        //     $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


        //     foreach($wordArraySearched as $value) {
        //         $query->where('name', 'like', '%'.$value.'%');
        //     }

        //     $users = $query->paginate();

        // }

        // ビューにusersとsearchを変数として渡す
        return view('users.index')
            ->with([
                'users' => $users,
            ]);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
         $user = auth()->user();
        $this->authorize('viewAny', $user);  // Policy をチェック
        $users = \App\Models\User::get(); // 社員一覧を取得
        return view('users.index', compact('users')); // users.index.bldae を呼出し、 usersを渡す

    }
}
