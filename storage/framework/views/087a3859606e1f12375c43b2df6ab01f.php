<?php $__env->startSection('title', 'フォーム設定 | イベント来場管理システム'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>申込フォーム表示設定</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('eventform.update', $event->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="card">
            <div class="card-body">


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

                <p>
                    申込フォームの表示設定を行います。<br>フォーム表示名には、実際に表示されるテキストを入力してください。項目を有効にするとその項目がフォームに表示されます。<br>説明文には、フォーム内に表示される仮の項目を入力します。
                </p>

                <table class="table table-bordered event-setting-table">
                    <tr>
                        <th>項目名</th>
                        <th>フォーム表示名</th>
                        <th>有効</th>
                        <th>必須</th>
                        <th>説明文</th>
                    </tr>
                    <tr>
                        <td><label for="company_display_name">会社名</label></td>
                        <td><input type="text" id="company_display_name" name="company_display_name" class="form-control" value="<?php echo e($eventsetting->company_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="company_flg" name="company_flg" value="1" <?php echo e(old('company_flg', $eventsetting->company_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="company_required_flg" name="company_required_flg" value="1" <?php echo e(old('company_required_flg', $eventsetting->company_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="company_placeholder" name="company_placeholder" class="form-control" value="<?php echo e($eventsetting->company_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="division_display_name">部署名</label></td>
                        <td><input type="text" id="division_display_name" name="division_display_name" class="form-control" value="<?php echo e($eventsetting->division_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="division_flg" name="division_flg" value="1" <?php echo e(old('division_flg', $eventsetting->division_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="division_required_flg" name="division_required_flg" value="1" <?php echo e(old('division_required_flg', $eventsetting->division_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="division_placeholder" name="division_placeholder" class="form-control" value="<?php echo e($eventsetting->division_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="post_display_name">役職名</label></td>
                        <td><input type="text" id="post_display_name" name="post_display_name" class="form-control" value="<?php echo e($eventsetting->post_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="post_flg" name="post_flg" value="1" <?php echo e(old('post_flg', $eventsetting->post_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="post_required_flg" name="post_required_flg" value="1" <?php echo e(old('post_required_flg', $eventsetting->post_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="post_placeholder" name="post_placeholder" class="form-control" value="<?php echo e($eventsetting->post_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="postal_code_display_name">郵便番号</label></td>
                        <td><input type="text" id="postal_code_display_name" name="postal_code_display_name" class="form-control" value="<?php echo e($eventsetting->postal_code_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="postal_code_flg" name="postal_code_flg" value="1" <?php echo e(old('postal_code_flg', $eventsetting->postal_code_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="postal_code_required_flg" name="postal_code_required_flg" value="1" <?php echo e(old('postal_code_required_flg', $eventsetting->postal_code_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="postal_code_placeholder" name="postal_code_placeholder" class="form-control" value="<?php echo e($eventsetting->postal_code_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address1_display_name">住所1</label></td>
                        <td><input type="text" id="address1_display_name" name="address1_display_name" class="form-control" value="<?php echo e($eventsetting->address1_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="address1_flg" name="address1_flg" value="1" <?php echo e(old('address1_flg', $eventsetting->address1_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="address1_required_flg" name="address1_required_flg" value="1" <?php echo e(old('address1_required_flg', $eventsetting->address1_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="address1_placeholder" name="address1_placeholder" class="form-control" value="<?php echo e($eventsetting->address1_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address2_display_name">住所2</label></td>
                        <td><input type="text" id="address2_display_name" name="address2_display_name" class="form-control" value="<?php echo e($eventsetting->address2_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="address2_flg" name="address2_flg" value="1" <?php echo e(old('address2_flg', $eventsetting->address2_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="address2_required_flg" name="address2_required_flg" value="1" <?php echo e(old('address2_required_flg', $eventsetting->address2_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="address2_placeholder" name="address2_placeholder" class="form-control" value="<?php echo e($eventsetting->address2_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address3_display_name">住所3</label></td>
                        <td><input type="text" id="address3_display_name" name="address3_display_name" class="form-control" value="<?php echo e($eventsetting->address3_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="address3_flg" name="address3_flg" value="1" <?php echo e(old('address3_flg', $eventsetting->address3_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="address3_required_flg" name="address3_required_flg" value="1" <?php echo e(old('address3_required_flg', $eventsetting->address3_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="address3_placeholder" name="address3_placeholder" class="form-control" value="<?php echo e($eventsetting->address3_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="tel_display_name">電話番号</label></td>
                        <td><input type="text" id="tel_display_name" name="tel_display_name" class="form-control" value="<?php echo e($eventsetting->tel_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="tel_flg" name="tel_flg" value="1" <?php echo e(old('tel_flg', $eventsetting->tel_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="tel_required_flg" name="tel_required_flg" value="1" <?php echo e(old('tel_required_flg', $eventsetting->tel_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="tel_placeholder" name="tel_placeholder" class="form-control" value="<?php echo e($eventsetting->tel_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="birth_display_name">生年月日</label></td>
                        <td><input type="text" id="birth_display_name" name="birth_display_name" class="form-control" value="<?php echo e($eventsetting->birth_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="birth_flg" name="birth_flg" value="1" <?php echo e(old('birth_flg', $eventsetting->birth_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="birth_required_flg" name="birth_required_flg" value="1" <?php echo e(old('birth_required_flg', $eventsetting->birth_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="birth_placeholder" name="birth_placeholder" class="form-control" value="<?php echo e($eventsetting->birth_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="section_display_name">受付区分</label></td>
                        <td><input type="text" id="section_display_name" name="section_display_name" class="form-control" value="<?php echo e($eventsetting->section_display_name); ?>"></td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="section_flg" name="section_flg" value="1" <?php echo e(old('section_flg', $eventsetting->section_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" id="section_required_flg" name="section_required_flg" value="1" <?php echo e(old('section_required_flg', $eventsetting->section_required_flg) ? 'checked' : ''); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </td>
                        <td><input type="text" id="section_placeholder" name="section_placeholder" class="form-control" value="<?php echo e($eventsetting->section_placeholder); ?>"></td>
                    </tr>
                </table>

                <button type="submit" class="btn btn-primary" style="margin-top: 20px;">保存</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/form.blade.php ENDPATH**/ ?>