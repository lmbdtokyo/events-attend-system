<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント申込フォーム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
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
    </style>
</head>
<body>


    <div class="container">

        <?php if($eventbasic->image): ?>
                <img src="<?php echo e(asset('storage/' . $eventbasic->image)); ?>" alt="イベント画像" style="max-width: 100%; height: auto;">
        <?php endif; ?>

        <h1><?php echo e($eventbasic->title); ?></h1>

        <h2><?php echo e($eventbasic->overview_title); ?></h2>

        <p>
            <?php echo e($eventbasic->overview_text); ?> 
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
                    <?php echo e($eventDate->date); ?>: <?php echo e($eventDate->starttime); ?> - <?php echo e($eventDate->endtime); ?>

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
                        <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo e($eventsetting->name_placeholder); ?>" <?php if($eventsetting->name_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->furigana_flg): ?>
                    <div class="form-group">
                        <label for="furigana"><?php echo e($eventsetting->furigana_display_name); ?> <?php if($eventsetting->furigana_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="furigana" name="furigana" class="form-control" placeholder="<?php echo e($eventsetting->furigana_placeholder); ?>" <?php if($eventsetting->furigana_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->company_flg): ?>
                    <div class="form-group">
                        <label for="company"><?php echo e($eventsetting->company_display_name); ?> <?php if($eventsetting->company_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="company" name="company" class="form-control" placeholder="<?php echo e($eventsetting->company_placeholder); ?>" <?php if($eventsetting->company_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->division_flg): ?>
                    <div class="form-group">
                        <label for="division"><?php echo e($eventsetting->division_display_name); ?> <?php if($eventsetting->division_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="division" name="division" class="form-control" placeholder="<?php echo e($eventsetting->division_placeholder); ?>" <?php if($eventsetting->division_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->post_flg): ?>
                    <div class="form-group">
                        <label for="post"><?php echo e($eventsetting->post_display_name); ?> <?php if($eventsetting->post_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="post" name="post" class="form-control" placeholder="<?php echo e($eventsetting->post_placeholder); ?>" <?php if($eventsetting->post_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->postal_code_flg): ?>
                    <div class="form-group">
                        <label for="postal_code"><?php echo e($eventsetting->postal_code_display_name); ?> <?php if($eventsetting->postal_code_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="<?php echo e($eventsetting->postal_code_placeholder); ?>" <?php if($eventsetting->postal_code_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->address1_flg): ?>
                    <div class="form-group">
                        <label for="address1"><?php echo e($eventsetting->address1_display_name); ?> <?php if($eventsetting->address1_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="address1" name="address1" class="form-control" placeholder="<?php echo e($eventsetting->address1_placeholder); ?>" <?php if($eventsetting->address1_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->address2_flg): ?>
                    <div class="form-group">
                        <label for="address2"><?php echo e($eventsetting->address2_display_name); ?> <?php if($eventsetting->address2_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="address2" name="address2" class="form-control" placeholder="<?php echo e($eventsetting->address2_placeholder); ?>" <?php if($eventsetting->address2_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->address3_flg): ?>
                    <div class="form-group">
                        <label for="address3"><?php echo e($eventsetting->address3_display_name); ?> <?php if($eventsetting->address3_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="address3" name="address3" class="form-control" placeholder="<?php echo e($eventsetting->address3_placeholder); ?>" <?php if($eventsetting->address3_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->tel_flg): ?>
                    <div class="form-group">
                        <label for="tel"><?php echo e($eventsetting->tel_display_name); ?> <?php if($eventsetting->tel_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="text" id="tel" name="tel" class="form-control" placeholder="<?php echo e($eventsetting->tel_placeholder); ?>" <?php if($eventsetting->tel_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->birth_flg): ?>
                    <div class="form-group">
                        <label for="birth"><?php echo e($eventsetting->birth_display_name); ?> <?php if($eventsetting->birth_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <input type="date" id="birth" name="birth" class="form-control" placeholder="<?php echo e($eventsetting->birth_placeholder); ?>" <?php if($eventsetting->birth_required_flg): ?> required <?php endif; ?>>
                    </div>
                <?php endif; ?>

                <?php if($eventsetting->section_flg): ?>
                    <div class="form-group">
                        <label for="section"><?php echo e($eventsetting->section_display_name); ?> <?php if($eventsetting->section_required_flg): ?> <span style="color: red;">*</span> <?php endif; ?></label>
                        <select id="section" name="section" class="form-control" <?php if($eventsetting->section_required_flg): ?> required <?php endif; ?>>
                            <?php $__currentLoopData = $eventsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($section->id); ?>"><?php echo e($section->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>

                <h2>ログイン情報設定</h2>

                <div class="form-group">
                    <label for="mail">メールアドレス <span style="color: red;">*</span></label>
                    <input type="email" id="mail" name="mail" class="form-control" placeholder="メールアドレスを入力してください" required>
                </div>

                <div class="form-group">
                    <label for="login_id">ログインID（英数字） <span style="color: red;">*</span></label>
                    <input type="text" id="login_id" name="login_id" class="form-control" placeholder="ログインIDを入力してください" required>
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