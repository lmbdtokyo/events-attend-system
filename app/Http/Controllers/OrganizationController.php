<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usersorganization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrganizationController extends Controller
{
    public function index () 
    {

        if (Gate::allows('admin', Auth::user())) {
            $Usersorganizations = Usersorganization::paginate(10);
            return view('organization.index', compact('Usersorganizations'));
        }else{
            return redirect('dashboard');
        }
    }

    public function create()
    {

        if (Gate::allows('admin', Auth::user())) {
            return view('organization.create');
        }else{
            return redirect('dashboard');
        }

        
    }

    public function store(Request $request)
    {

        if (Gate::allows('admin', Auth::user())) {
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
        }else{
            return redirect('dashboard');
        }

        
    }

    public function update(Request $request, $id)
    {

        if (Gate::allows('admin', Auth::user())) {
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
        }else{
            return redirect('dashboard');
        }
    }

    public function edit($id)
    {
        if (Gate::allows('admin', Auth::user())) {
            $organization = Usersorganization::find($id);
            return view('organization.edit', compact('organization'));
        }else{
            return redirect('dashboard');
        }
    }

    public function destroy($id)
    {
        if (Gate::allows('admin', Auth::user())) {
            $organization = Usersorganization::find($id);
            $organization->delete();

            return redirect()->route('organization.index');

        }else{
            return redirect('dashboard');
        }

    }
}
