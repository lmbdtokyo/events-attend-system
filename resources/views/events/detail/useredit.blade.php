@extends('adminlte::page')

@section('title', '申込者編集 | イベント来場管理システム')

@section('content_header')
    <h1>申込者情報の編集</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('event.users', $event) }}" class="btn btn-secondary mb-3">&laquo; 申込者一覧へ戻る</a>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('event.users.update', [$event, $eventuser]) }}" method="POST">
                @csrf
                @method('PATCH')

                @php
                    $es = optional($eventsetting);
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">{{ $es->name_display_name ?? '名前' }} <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $eventuser->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="furigana">{{ $es->furigana_display_name ?? 'フリガナ' }}</label>
                            <input type="text" id="furigana" name="furigana" class="form-control" value="{{ old('furigana', $eventuser->furigana) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company">{{ $es->company_display_name ?? '会社名' }}</label>
                    <input type="text" id="company" name="company" class="form-control" value="{{ old('company', $eventuser->company) }}">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="division">{{ $es->division_display_name ?? '部署' }}</label>
                            <input type="text" id="division" name="division" class="form-control" value="{{ old('division', $eventuser->division) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="post">{{ $es->post_display_name ?? '役職' }}</label>
                            <input type="text" id="post" name="post" class="form-control" value="{{ old('post', $eventuser->post) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postal_code">{{ $es->postal_code_display_name ?? '郵便番号' }}</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code', $eventuser->postal_code) }}">
                </div>

                <div class="form-group">
                    <label for="address1">{{ $es->address1_display_name ?? '住所1' }}</label>
                    <input type="text" id="address1" name="address1" class="form-control" value="{{ old('address1', $eventuser->address1) }}">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address2">{{ $es->address2_display_name ?? '住所2' }}</label>
                            <input type="text" id="address2" name="address2" class="form-control" value="{{ old('address2', $eventuser->address2) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address3">{{ $es->address3_display_name ?? '住所3' }}</label>
                            <input type="text" id="address3" name="address3" class="form-control" value="{{ old('address3', $eventuser->address3) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tel">{{ $es->tel_display_name ?? '電話番号' }}</label>
                            <input type="text" id="tel" name="tel" class="form-control" value="{{ old('tel', $eventuser->tel) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birth">{{ $es->birth_display_name ?? '生年月日' }}</label>
                            <input type="date" id="birth" name="birth" class="form-control" value="{{ old('birth', $eventuser->birth) }}">
                        </div>
                    </div>
                </div>

                @if($eventsections->isNotEmpty())
                    <div class="form-group">
                        <label for="section">{{ $es->section_display_name ?? '受付区分' }}</label>
                        <select id="section" name="section" class="form-control">
                            <option value="">選択してください</option>
                            @foreach($eventsections as $section)
                                <option value="{{ $section->id }}" {{ old('section', $eventuser->section) == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="form-group">
                    <label for="mail">メールアドレス <span class="text-danger">*</span></label>
                    <input type="email" id="mail" name="mail" class="form-control" value="{{ old('mail', $eventuser->mail) }}" required>
                </div>

                <div class="form-group">
                    <label for="password">パスワード変更（変更しない場合は空欄）</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="8文字以上">
                </div>

                <div class="form-group">
                    <label>承認ステータス</label>
                    <p class="form-control-plaintext mb-0">
                        @if($eventuser->approval == 0)
                            下書き
                        @elseif($eventuser->approval == 1)
                            承認済み
                        @elseif($eventuser->approval == 2)
                            却下
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">更新</button>
                    <a href="{{ route('event.users', $event) }}" class="btn btn-secondary">キャンセル</a>
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteConfirmModal">
                        削除
                    </button>
                </div>
            </form>

            {{-- 削除確認モーダル --}}
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteConfirmModalLabel">削除の確認</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            この申込者を削除しますか？この操作は取り消せません。
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                            <form action="{{ route('event.users.destroy', [$event, $eventuser]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除する</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
