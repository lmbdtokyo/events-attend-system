<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Usersorganization;
use App\Models\Usersauthmaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;

class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->type == 'master') {
            $users = User::orderBy('created_at', 'desc')->paginate(15);
            $auths = \DB::table('usersauthmaster')->get();
            $organizations = \DB::table('usersorganization')->get();
            return view('user.index', compact('users', 'auths', 'organizations'));
        }else{


            $userAuthMaster = \DB::table('usersauthmaster')->find($user->auth);
            if ($userAuthMaster->id == 1) {

                $userOrganization = $user->organization;
                $users = User::where('organization', $userOrganization)->paginate(15);
                $auths = \DB::table('usersauthmaster')->get();
                $organizations = \DB::table('usersorganization')->where('id', $userOrganization)->get();
                return view('user.index', compact('users', 'auths', 'organizations'));
                
            }else{

                return redirect('dashboard');

            }
        }

        
    }

    public function edit($id)
    {

        $authUser = Auth::user();
        $user = User::find($id);
        $auths = \DB::table('usersauthmaster')->get();
        
        if ($authUser->type == 'master') {
            $organizations = \DB::table('usersorganization')->get();
        } else {
            $organizations = \DB::table('usersorganization')->where('id', $authUser->organization)->get();
        }
        
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

        $user = Auth::user();
        $auths = \DB::table('usersauthmaster')->get();
        if ($user->type == 'master') {
            
            $organizations = \DB::table('usersorganization')->get();
            
        }else{

            $userAuthMaster = \DB::table('usersauthmaster')->find($user->auth);
            if ($userAuthMaster->id == 1) {

                $userOrganization = $user->organization;
                $organizations = \DB::table('usersorganization')->where('id', $userOrganization)->get();
                
            }else{

                return redirect('dashboard');

            }

            
            
        }

        return view('user.create', compact('auths', 'organizations'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
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
            'password.regex' => 'パスワードは大文字小文字英数字を含む必要があります。',
            'auth.required' => '権限は必須です。',
            'type.required' => '種別は必須です。',
            'organization.required' => '所属組織は必須です。',
        ]);

        // リクエストからデータを取得
        $data = $request->only(['name', 'email', 'password', 'auth', 'type', 'organization']);
        $data['password'] = bcrypt($data['password']);

        $temporaryPassword = $request->password;

        // $dataをUserモデルのインスタンスに変換
        $new_user = new User($data);

        // データベースに新しいユーザーを作成
        User::create($data);

        // メール送信
        Mail::to($request->email)->send(new UserCreated($new_user, $temporaryPassword));

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
