<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usersorganization;

class OrganizationController extends Controller
{
    public function index () 
    {
        $Usersorganizations = Usersorganization::all();
        return view('organization.index', compact('Usersorganizations'));
    }

    public function create()
    {
        return view('organization.create');
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|unique:usersorganization,name',
        ], [
            'name.required' => '組織名は必須です。',
            'name.unique' => 'この組織名は既に存在します。',
        ]);

        // リクエストからデータを取得
        $data = $request->only(['name']);

        // データベースに新しい組織を作成
        Usersorganization::create($data);

        // リダイレクト
        return redirect()->route('organization.index');
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|unique:usersorganization,name',
        ], [
            'name.required' => '組織名は必須です。',
            'name.unique' => 'この組織名は既に存在します。',
        ]);

        // リクエストからデータを取得
        $data = $request->only(['name']);

        // データベースから組織を更新
        $organization = Usersorganization::find($id);
        $organization->update($data);

        // リダイレクト
        return redirect()->route('organization.index');
    }

    public function edit($id)
    {
        $organization = Usersorganization::find($id);
        return view('organization.edit', compact('organization'));
    }

    public function destroy($id)
    {
        $organization = Usersorganization::find($id);
        $organization->delete();

        return redirect()->route('organization.index');
    }
}
