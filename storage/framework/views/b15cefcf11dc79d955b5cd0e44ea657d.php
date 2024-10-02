<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/style.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <title><?php echo e($eventbasic->title); ?></title>
    <style>
        .container {
            max-width: 1300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 50px 100px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;

        }
        h1 {
            text-align: center;
            color: #333;
        }

        h2{
            padding: 0.5em;/*文字周りの余白*/
            color: #010101;/*文字色*/
            background: #eaf3ff;/*背景色*/
            border-bottom: solid 3px #516ab6;/*下線*/
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }

        ul{
            list-style: none;
            padding: 0px;            
        }
    </style>
</head>
<body>

    <div class="container">

        <?php if($eventbasic->image): ?>
                <img src="<?php echo e(Storage::url($eventbasic->image)); ?>" alt="イベント画像" style="max-width: 100%; height: auto;">
        <?php endif; ?>

        <h1><?php echo e($eventbasic->title); ?></h1>

        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <p><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>


        <h2><?php echo e($eventbasic->overview_title); ?></h2>

        <p>
            <?php echo $eventbasic->overview_text; ?> 
        </p>

        <h2>開催情報</h2>

        <p>場所: <?php echo e($event->place); ?></p>
        <p>開催日</p>
        <ul>
            <?php
                $eventDates = json_decode($event->event_date);
            ?>

            <?php $__currentLoopData = $eventDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php echo e($eventDate->date); ?>: <?php echo e(\Carbon\Carbon::parse($eventDate->starttime)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($eventDate->endtime)->format('H:i')); ?>

                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <?php
            $currentDate = \Carbon\Carbon::now();
        ?>

        <?php if($currentDate->between($eventbasic->start, $eventbasic->end)): ?>
            <h2>お申込みフォーム</h2>


                
            <form action="<?php echo e(route('eventform.store', $event->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <?php if($eventsetting->name_flg): ?>
                    <div class="form-group">
                        <label for="name"><?php echo e($eventsetting->name_display_name); ?> <?php if($eventsetting->name_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo e($eventsetting->name_placeholder); ?>" value="<?php echo e(old('name')); ?>" <?php if($eventsetting->name_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->furigana_flg): ?>
                    <div class="form-group">
                        <label for="furigana"><?php echo e($eventsetting->furigana_display_name); ?> <?php if($eventsetting->furigana_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="furigana" name="furigana" class="form-control" placeholder="<?php echo e($eventsetting->furigana_placeholder); ?>" value="<?php echo e(old('furigana')); ?>" <?php if($eventsetting->furigana_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->company_flg): ?>
                    <div class="form-group">
                        <label for="company"><?php echo e($eventsetting->company_display_name); ?> <?php if($eventsetting->company_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="company" name="company" class="form-control" placeholder="<?php echo e($eventsetting->company_placeholder); ?>" value="<?php echo e(old('company')); ?>" <?php if($eventsetting->company_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->division_flg): ?>
                    <div class="form-group">
                        <label for="division"><?php echo e($eventsetting->division_display_name); ?> <?php if($eventsetting->division_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="division" name="division" class="form-control" placeholder="<?php echo e($eventsetting->division_placeholder); ?>" value="<?php echo e(old('division')); ?>" <?php if($eventsetting->division_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->post_flg): ?>
                    <div class="form-group">
                        <label for="post"><?php echo e($eventsetting->post_display_name); ?> <?php if($eventsetting->post_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="post" name="post" class="form-control" placeholder="<?php echo e($eventsetting->post_placeholder); ?>" value="<?php echo e(old('post')); ?>" <?php if($eventsetting->post_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->postal_code_flg): ?>
                    <div class="form-group">
                        <label for="postal_code"><?php echo e($eventsetting->postal_code_display_name); ?> <?php if($eventsetting->postal_code_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="<?php echo e($eventsetting->postal_code_placeholder); ?>" value="<?php echo e(old('postal_code')); ?>" <?php if($eventsetting->postal_code_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->address1_flg): ?>
                    <div class="form-group">
                        <label for="address1"><?php echo e($eventsetting->address1_display_name); ?> <?php if($eventsetting->address1_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="address1" name="address1" class="form-control" placeholder="<?php echo e($eventsetting->address1_placeholder); ?>" value="<?php echo e(old('address1')); ?>" <?php if($eventsetting->address1_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->address2_flg): ?>
                    <div class="form-group">
                        <label for="address2"><?php echo e($eventsetting->address2_display_name); ?> <?php if($eventsetting->address2_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="address2" name="address2" class="form-control" placeholder="<?php echo e($eventsetting->address2_placeholder); ?>" value="<?php echo e(old('address2')); ?>" <?php if($eventsetting->address2_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>


            <?php if($eventsetting->address3_flg): ?>
                <div class="form-group">
                    <label for="address3"><?php echo e($eventsetting->address3_display_name); ?> <?php if($eventsetting->address3_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                    <input type="text" id="address3" name="address3" class="form-control" placeholder="<?php echo e($eventsetting->address3_placeholder); ?>" value="<?php echo e(old('address3')); ?>" <?php if($eventsetting->address3_required_flg): ?> required <?php endif; ?>>
                </div>
            <?php endif; ?>

            <?php if($eventsetting->tel_flg): ?>
                <div class="form-group">
                    <label for="tel"><?php echo e($eventsetting->tel_display_name); ?> <?php if($eventsetting->tel_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                    <input type="text" id="tel" name="tel" class="form-control" placeholder="<?php echo e($eventsetting->tel_placeholder); ?>" value="<?php echo e(old('tel')); ?>" <?php if($eventsetting->tel_required_flg): ?> required <?php endif; ?>>
                </div>
            <?php endif; ?>

            <?php if($eventsetting->birth_flg): ?>
                <div class="form-group">
                    <label for="birth"><?php echo e($eventsetting->birth_display_name); ?> <?php if($eventsetting->birth_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                    <input type="date" id="birth" name="birth" class="form-control" placeholder="<?php echo e($eventsetting->birth_placeholder); ?>" value="<?php echo e(old('birth')); ?>" <?php if($eventsetting->birth_required_flg): ?> required <?php endif; ?>>
                </div>
            <?php endif; ?>

            <?php if($eventsetting->section_flg && $eventsections->isNotEmpty()): ?>
                <div class="form-group">
                    <label for="section"><?php echo e($eventsetting->section_display_name); ?> <?php if($eventsetting->section_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                    <select id="section" name="section" class="form-control" <?php if($eventsetting->section_required_flg): ?> required <?php endif; ?>>
                        <?php $__currentLoopData = $eventsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($section->id); ?>" <?php echo e(old('section') == $section->id ? 'selected' : ''); ?>><?php echo e($section->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            <?php endif; ?>

            <h2>ログイン情報設定</h2>

            <div class="form-group">
                <label for="mail">メールアドレス <span style="color: red;">*</span></label>
                <input type="email" id="mail" name="mail" class="form-control" placeholder="メールアドレスを入力してください" value="<?php echo e(old('mail')); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">パスワード <span style="color: red;">*</span></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="パスワードを入力してください" required>
            </div>

            <?php if($event->approval == 1): ?>
                <input type="hidden" name="approval" value="0">
            <?php else: ?>
                <input type="hidden" name="approval" value="1">
            <?php endif; ?>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="terms_agree" style="font-weight: bold;">
                    <input type="checkbox" id="terms_agree" name="terms_agree" required style="margin-right: 5px; width:auto; padding: 0px; border: none; border-radius: 0px;">
                    利用規約に同意します <span style="color: red;">*</span> <a href="#" onclick="openPopup(); return false;">[規約を確認]</a>
                    <script>
                        function openPopup() {
                            const popup = document.createElement('div');
                            popup.style.position = 'fixed';
                            popup.style.left = '50%';
                            popup.style.top = '50%';
                            popup.style.transform = 'translate(-50%, -50%)';
                            popup.style.backgroundColor = 'white';
                            popup.style.border = '1px solid #ccc';
                            popup.style.padding = '20px';
                            popup.style.zIndex = '1000';
                            popup.innerHTML = '<?php echo $eventbasic->terms; ?><button onclick="closePopup()">閉じる</button>';
                            document.body.appendChild(popup);
                        }

                        function closePopup() {
                            const popup = document.querySelector('div[style*="position: fixed"]');
                            if (popup) {
                                document.body.removeChild(popup);
                            }
                        }
                    </script>
                </label>
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="privacy_agree" style="font-weight: bold;">
                    <input type="checkbox" id="privacy_agree" name="privacy_agree" required style="margin-right: 5px; width:auto; padding: 0px; border: none; border-radius: 0px;">
                    個人情報の取り扱いについて同意します <span style="color: red;">*</span>
                    <a href="#" onclick="openPrivacyPopup(); return false;">[個人情報の取り扱いを確認]</a>
                </label>
            </div>
            <script>
                function openPrivacyPopup() {
                    const popup = document.createElement('div');
                    popup.style.position = 'fixed';
                    popup.style.left = '50%';
                    popup.style.top = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.backgroundColor = 'white';
                    popup.style.border = '1px solid #ccc';
                    popup.style.padding = '20px';
                    popup.style.zIndex = '1000';
                    popup.innerHTML = '<?php echo $eventbasic->privacy; ?><button onclick="closePopup()">閉じる</button>';
                    document.body.appendChild(popup);
                }

                function closePopup() {
                    const popup = document.querySelector('div[style*="position: fixed"]');
                    if (popup) {
                        document.body.removeChild(popup);
                    }
                }
            </script>

            <button type="submit" class="btn">申込</button>
        </form>
            
        <?php else: ?>
            <div class="alert alert-danger">
                <p>現在、申込期間外です。申込期間は<?php echo e($eventbasic->start); ?>から<?php echo e($eventbasic->end); ?>までです。</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH /data/resources/views/events/user/form.blade.php ENDPATH**/ ?>