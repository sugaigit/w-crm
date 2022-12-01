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
