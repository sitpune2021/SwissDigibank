<?php $__env->startSection('content'); ?>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="h2">Transfer Shares</h3>
        </div>
        <?php if(session('success')): ?>
            <div id="success-alert"
                style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Success:</strong> <?php echo e(session('success')); ?>

                <span onclick="document.getElementById('success-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div id="error-alert"
                style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Error:</strong> <?php echo e(session('error')); ?>

                <span onclick="document.getElementById('error-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
            </div>
        <?php endif; ?>

        <div class="box mb-4 xxxl:mb-6">
            <form id="shareholders_form" action="<?php echo e($route); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                <?php echo csrf_field(); ?>
                

                <?php $__currentLoopData = $formFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'];
                        $id = $field['id'] ?? $field['name'];
                        $required = $field['required'] ?? false;
                        $value = old($name, $branch[$name] ?? ($field['default'] ?? ''));
                    ?>
                    <div class="col-span-2 md:col-span-1">
                        <label for="<?php echo e($id); ?>" class="md:text-lg font-medium block mb-4">
                            <?php echo e($label); ?> <?php if($required): ?>
                                <span class="text-red-500">*</span>
                            <?php endif; ?>
                        </label>
                        <?php if($type === 'select'): ?>
                            <select name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
                                class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                <?php echo e($required ? 'required' : ''); ?>>
                                <option value="">-- Select <?php echo e($label); ?> --</option>

                                <?php if(!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']])): ?>
                                    <?php $__currentLoopData = $dynamicOptions[$field['options_key']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionValue => $optionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($optionValue); ?>" <?php echo e($value == $optionValue ? 'selected' : ''); ?>>
                                            <?php echo e($optionLabel); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php elseif(!empty($field['options'])): ?>
                                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionValue => $optionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($optionValue); ?>"
                                            <?php echo e($value == $optionValue ? 'selected' : ''); ?>>
                                            <?php echo e($optionLabel); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        <?php elseif($type === 'radio'): ?>
                            <div class="flex gap-4">
                                <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionValue => $optionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="<?php echo e($name); ?>" value="<?php echo e($optionValue); ?>"
                                            <?php echo e($value == $optionValue ? 'checked' : ''); ?>>
                                        <span><?php echo e($optionLabel); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <input type="<?php echo e($type); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
                                value="<?php echo e($value); ?>"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter <?php echo e(strtolower($label)); ?>" />
                        <?php endif; ?>

                        <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    <button class="btn-primary" type="submit">
                        <?php echo e($method === 'PUT' ? 'Update' : 'Save'); ?> Branch
                    </button>
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Reset
                    </button>
                </div>
            </form>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\shares-holdings\create.blade.php ENDPATH**/ ?>