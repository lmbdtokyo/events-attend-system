<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usersorganization;
use App\Models\Usersauthmaster;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        $auths = \DB::table('usersauthmaster')->get();
        $organizations = \DB::table('usersorganization')->get();
        return view('user.index', compact('users', 'auths', 'organizations'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $auths = \DB::table('usersauthmaster')->get();
        $organizations = \DB::table('usersorganization')->get();
        return view('user.edit', compact('user', 'auths', 'organizations'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->type == 'master') {
            return redirect()->route('user.index')->with('error', 'マスターアカウントは更新できません。');
        }else{
            $user->update($request->all());
            return redirect()->route('user.index');
        }
    }

    public function create()
    {
        $auths = \DB::table('usersauthmaster')->get();
        $organizations = \DB::table('usersorganization')->get();
        return view('user.create', compact('auths', 'organizations'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'auth' => 'required',
            'type' => 'required',
            'organization' => 'required',
        ], [
            'name.required' => '名前は必須です。',
            'name.unique' => 'この名前は既に存在します。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に存在します。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'auth.required' => '権限は必須です。',
            'type.required' => '種別は必須です。',
            'organization.required' => '所属組織は必須です。',
        ]);

        // リクエストからデータを取得
        $data = $request->only(['name', 'email', 'password', 'auth', 'type', 'organization']);
        $data['password'] = bcrypt($data['password']);

        // データベースに新しいユーザーを作成
        User::create($data);

        // リダイレクト
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {

        $user = User::find($id);
        if ($user->type == 'master') {
            return redirect()->route('user.index')->with('error', 'マスターアカウントは削除できません。');
        }else{
            $user->delete();
            return redirect()->route('user.index');
        }
    }
}
