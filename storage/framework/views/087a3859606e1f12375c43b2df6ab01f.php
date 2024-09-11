

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
                <table class="table table-bordered">
                    <tr>
                        <th><label for="company_display_name">項目</label></th>
                        <th>表示名</th>
                        <th>有効</th>
                        <th>必須</th>
                        <th>仮表示</th>
                    </tr>
                    <tr>
                        <td><label for="company_display_name">会社名</label></td>
                        <td><input type="text" id="company_display_name" name="company_display_name" class="form-control" value="<?php echo e($eventsetting->company_display_name); ?>"></td>
                        <td><input type="checkbox" id="company_flg" name="company_flg" <?php echo e($eventsetting->company_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="company_required_flg" name="company_required_flg" <?php echo e($eventsetting->company_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="company_placeholder" name="company_placeholder" class="form-control" value="<?php echo e($eventsetting->company_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="division_display_name">部門表示名</label></td>
                        <td><input type="text" id="division_display_name" name="division_display_name" class="form-control" value="<?php echo e($eventsetting->division_display_name); ?>"></td>
                        <td><input type="checkbox" id="division_flg" name="division_flg" <?php echo e($eventsetting->division_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="division_required_flg" name="division_required_flg" <?php echo e($eventsetting->division_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="division_placeholder" name="division_placeholder" class="form-control" value="<?php echo e($eventsetting->division_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="post_display_name">役職表示名</label></td>
                        <td><input type="text" id="post_display_name" name="post_display_name" class="form-control" value="<?php echo e($eventsetting->post_display_name); ?>"></td>
                        <td><input type="checkbox" id="post_flg" name="post_flg" <?php echo e($eventsetting->post_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="post_required_flg" name="post_required_flg" <?php echo e($eventsetting->post_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="post_placeholder" name="post_placeholder" class="form-control" value="<?php echo e($eventsetting->post_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="postal_code_display_name">郵便番号表示名</label></td>
                        <td><input type="text" id="postal_code_display_name" name="postal_code_display_name" class="form-control" value="<?php echo e($eventsetting->postal_code_display_name); ?>"></td>
                        <td><input type="checkbox" id="postal_code_flg" name="postal_code_flg" <?php echo e($eventsetting->postal_code_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="postal_code_required_flg" name="postal_code_required_flg" <?php echo e($eventsetting->postal_code_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="postal_code_placeholder" name="postal_code_placeholder" class="form-control" value="<?php echo e($eventsetting->postal_code_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address1_display_name">住所1表示名</label></td>
                        <td><input type="text" id="address1_display_name" name="address1_display_name" class="form-control" value="<?php echo e($eventsetting->address1_display_name); ?>"></td>
                        <td><input type="checkbox" id="address1_flg" name="address1_flg" <?php echo e($eventsetting->address1_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="address1_required_flg" name="address1_required_flg" <?php echo e($eventsetting->address1_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="address1_placeholder" name="address1_placeholder" class="form-control" value="<?php echo e($eventsetting->address1_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address2_display_name">住所2表示名</label></td>
                        <td><input type="text" id="address2_display_name" name="address2_display_name" class="form-control" value="<?php echo e($eventsetting->address2_display_name); ?>"></td>
                        <td><input type="checkbox" id="address2_flg" name="address2_flg" <?php echo e($eventsetting->address2_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="address2_required_flg" name="address2_required_flg" <?php echo e($eventsetting->address2_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="address2_placeholder" name="address2_placeholder" class="form-control" value="<?php echo e($eventsetting->address2_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="address3_display_name">住所3表示名</label></td>
                        <td><input type="text" id="address3_display_name" name="address3_display_name" class="form-control" value="<?php echo e($eventsetting->address3_display_name); ?>"></td>
                        <td><input type="checkbox" id="address3_flg" name="address3_flg" <?php echo e($eventsetting->address3_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="address3_required_flg" name="address3_required_flg" <?php echo e($eventsetting->address3_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="address3_placeholder" name="address3_placeholder" class="form-control" value="<?php echo e($eventsetting->address3_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="tel_display_name">電話番号表示名</label></td>
                        <td><input type="text" id="tel_display_name" name="tel_display_name" class="form-control" value="<?php echo e($eventsetting->tel_display_name); ?>"></td>
                        <td><input type="checkbox" id="tel_flg" name="tel_flg" <?php echo e($eventsetting->tel_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="tel_required_flg" name="tel_required_flg" <?php echo e($eventsetting->tel_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="tel_placeholder" name="tel_placeholder" class="form-control" value="<?php echo e($eventsetting->tel_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="birth_display_name">生年月日表示名</label></td>
                        <td><input type="text" id="birth_display_name" name="birth_display_name" class="form-control" value="<?php echo e($eventsetting->birth_display_name); ?>"></td>
                        <td><input type="checkbox" id="birth_flg" name="birth_flg" <?php echo e($eventsetting->birth_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="birth_required_flg" name="birth_required_flg" <?php echo e($eventsetting->birth_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="birth_placeholder" name="birth_placeholder" class="form-control" value="<?php echo e($eventsetting->birth_placeholder); ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="section_display_name">セクション表示名</label></td>
                        <td><input type="text" id="section_display_name" name="section_display_name" class="form-control" value="<?php echo e($eventsetting->section_display_name); ?>"></td>
                        <td><input type="checkbox" id="section_flg" name="section_flg" <?php echo e($eventsetting->section_flg ? 'checked' : ''); ?>></td>
                        <td><input type="checkbox" id="section_required_flg" name="section_required_flg" <?php echo e($eventsetting->section_required_flg ? 'checked' : ''); ?>></td>
                        <td><input type="text" id="section_placeholder" name="section_placeholder" class="form-control" value="<?php echo e($eventsetting->section_placeholder); ?>"></td>
                    </tr>
                </table>

                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/resources/views/events/detail/form.blade.php ENDPATH**/ ?>