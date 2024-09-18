<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/home') }}" class="brand-link">
        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
        <span class="brand-text font-weight-light"><b>Admin</b>LTE</span>
    </a>
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                @if (!request()->is('events/*')  || request()->is('events/create'))
                @if(Auth::user() && Auth::user()->auth == 1)
                <li class="nav-header">管理者メニュー</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-user"></i>
                        <p>管理アカウント <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/users') }}">
                                <i class="fas fa-fw fa-list"></i>
                                <p>一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/users/create') }}">
                                <i class="fas fa-fw fa-plus"></i>
                                <p>作成</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif


                @if(Auth::user() && Auth::user()->type == 'master')
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-building"></i>
                        <p>所属組織 <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/organization') }}">
                                <i class="fas fa-fw fa-list"></i>
                                <p>一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/organization/create') }}">
                                <i class="fas fa-fw fa-plus"></i>
                                <p>作成</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif


                
                <li class="nav-header">イベント</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/events') }}">
                        <i class="fas fa-fw fa-star"></i>
                        <p>一覧</p>
                    </a>
                </li>


                <li class="nav-header">アカウント設定</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/profile') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <p>アカウント編集</p>
                    </a>
                </li>

                @endif

                @if (request()->is('events/*') && !request()->is('events/create'))
                <li class="nav-header">{{ Str::limit($event->name, 30) }}</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/events/' . $event->id) }}">
                        <i class="fas fa-fw fa-bars"></i>
                        <p>イベント詳細</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/events/' . $event->id . '/edit') }}">
                        <i class="fas fa-fw fa-check"></i>
                        <p>イベント情報修正</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/events/' . $event->id . '/form') }}" target="_blank">
                        <i class="fas fa-fw fa-arrow-right"></i>
                        <p>イベント申込フォーム表示</p>
                    </a>
                </li>
                <li class="nav-header">イベントメニュー</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-caret-right"></i>
                        <p>事前設定 <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/basic') }}">
                                <p>申込フォーム基本設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/formsetting') }}">
                                <p>申込フォーム表示設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/section') }}">
                                <p>受付区分設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/mypagebasic') }}">
                                <p>マイページ基本設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/finish') }}">
                                <p>申込完了画面設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/finishmail') }}">
                                <p>申込完了メール設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/entrymail') }}">
                                <p>受付時本人メール（入場）</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/exitmail') }}">
                                <p>受付時本人メール（退場）</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/generateqr') }}">
                                <p>空QRコード発行</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/pdf') }}">
                                <p>来場証PDF</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/survey') }}">
                                <p>アンケート項目設定</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-caret-right"></i>
                        <p>各種機能 <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/scan/1') }}">
                                <p>入場時スキャン</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/scan/2') }}">
                                <p>退場時スキャン</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/events/' . $event->id . '/totals') }}">
                                <p>申込・来場者一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <p>アンケート集計</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <p>ユーザー承認</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a class="nav-link" href="{{ url('/dashboard') }}">
                        <i class="fas fa-fw fa-arrow-left"></i>
                        <p>全体ダッシュボードへ戻る</p>
                    </a>
                </li>

                @endif





            </ul>
        </nav>
    </div>
</aside>