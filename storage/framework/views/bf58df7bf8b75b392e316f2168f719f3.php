<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo e(url('/home')); ?>" class="brand-link">
        <img src="<?php echo e(asset('vendor/adminlte/dist/img/AdminLTELogo.png')); ?>" alt="Admin Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
        <span class="brand-text font-weight-light"><b>Admin</b>LTE</span>
    </a>
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <?php if(!request()->is('events/*')  || request()->is('events/create')): ?>
                <?php if(Auth::user() && Auth::user()->auth == 1): ?>
                <li class="nav-header">管理者メニュー</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-user"></i>
                        <p>管理アカウント <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/users')); ?>">
                                <i class="fas fa-fw fa-list"></i>
                                <p>一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/users/create')); ?>">
                                <i class="fas fa-fw fa-plus"></i>
                                <p>作成</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>


                <?php if(Auth::user() && Auth::user()->type == 'master'): ?>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-building"></i>
                        <p>所属組織 <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/organization')); ?>">
                                <i class="fas fa-fw fa-list"></i>
                                <p>一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/organization/create')); ?>">
                                <i class="fas fa-fw fa-plus"></i>
                                <p>作成</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>


                
                <li class="nav-header">イベント</li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/events')); ?>">
                        <i class="fas fa-fw fa-star"></i>
                        <p>一覧</p>
                    </a>
                </li>


                <li class="nav-header">アカウント設定</li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/profile')); ?>">
                        <i class="fas fa-fw fa-user"></i>
                        <p>アカウント編集</p>
                    </a>
                </li>

                <?php endif; ?>

                <?php if(request()->is('events/*') && !request()->is('events/create')): ?>
                <li class="nav-header"><?php echo e(Str::limit($event->name, 30)); ?></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/events/' . $event->id)); ?>">
                        <i class="fas fa-fw fa-user"></i>
                        <p>イベント詳細</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(url('/events/' . $event->id . '/edit')); ?>">
                        <i class="fas fa-fw fa-user"></i>
                        <p>イベント情報修正</p>
                    </a>
                </li>
                <li class="nav-header">イベントメニュー</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-user"></i>
                        <p>事前設定 <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/events/' . $event->id . '/basic')); ?>">
                                <i class="fas fa-fw fa-list"></i>
                                <p>申込フォーム基本設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>申込フォーム項目</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>マイページ基本設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>申込完了メール設定</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>受付時本人メール（入場）</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>受付時本人メール（退場）</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>空QRコード発行</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>来場証PDF</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>アンケート項目設定</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-user"></i>
                        <p>各種機能 <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>申込・来場者一覧</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>アンケート集計</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/')); ?>">
                                <p>ユーザー承認</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a class="nav-link" href="<?php echo e(url('/dashboard')); ?>">
                        <i class="fas fa-fw fa-arrow-left"></i>
                        <p>全体ダッシュボードへ戻る</p>
                    </a>
                </li>

                <?php endif; ?>





            </ul>
        </nav>
    </div>
</aside><?php /**PATH /data/resources/views/vendor/adminlte/partials/sidebar/left-sidebar.blade.php ENDPATH**/ ?>