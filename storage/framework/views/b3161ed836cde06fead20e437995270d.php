<?php $__env->startSection('content'); ?>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 30px;
            text-align: center;
            line-height: 30px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(30px);
        }

        .slider .switch-on,
        .slider .switch-off {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider .switch-on {
            left: 0;
        }

        .slider .switch-off {
            right: 0;
        }
    </style>
    <div class="main-inner">

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
            <form action="<?php echo e(isset($route) && isset($method) ? $route : ''); ?>" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
                <?php echo csrf_field(); ?>
                <?php if(isset($method) && $method == 'PUT'): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                  
                <input name="member_id" id="member_id" type="hidden" value="<?php echo e(session('member_id')); ?>" />
                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionName => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($sectionName): ?>
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold text-center text-gray-800 mb-4 capitalize">
                                <?php echo e(str_replace('_', ' ', $sectionName)); ?>

                            </h3>
                        </div>
                    <?php endif; ?>

                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $name = $field['name'];
                            $type = $field['type'] ?? 'text';
                            $label = $field['label'];
                            $id = $field['id'] ?? $field['name'];
                            $required = $field['required'] ?? false;
                            $value = old($name, $minor[$name] ?? ($field['default'] ?? ''));
                        ?>
                        <div class="col-span-4 md:col-span-1">
                            <label for="<?php echo e($id); ?>" class="md:text-lg font-medium block mb-4">
                                <?php echo e($label); ?> <?php if($required): ?>
                                    <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </label>
                            <?php if($type === 'select'): ?>
                                <select name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
                                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10  px-3 md:px-6 py-2 md:py-3"
                                    <?php echo e(isset($show) ? 'readonly' : ''); ?>>
                                    <option value="">-- Select <?php echo e($label); ?> --</option>

                                    <?php if(!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']])): ?>
                                        <?php $__currentLoopData = $dynamicOptions[$field['options_key']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionValue => $optionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($optionValue); ?>"
                                                <?php echo e($value == $optionValue ? 'selected' : ''); ?>>
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
                                <div class="flex gap-2">
                                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionValue => $optionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center space-x-4 class=ml-2 gap-1">
                                            <input type="radio" name="<?php echo e($name); ?>" value="<?php echo e($optionValue); ?>"
                                                <?php echo e($value == $optionValue ? 'checked' : ''); ?>

                                                <?php echo e(isset($show) ? 'readonly' : ''); ?>>
                                            <span><?php echo e($optionLabel); ?></span>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php elseif($type === 'checkbox'): ?>
                                <label class="switch">
                                    <input type="checkbox" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
                                        value="1" <?php echo e($value ? 'checked' : ''); ?> <?php echo e(isset($show) ? 'readonly' : ''); ?>>
                                    <div class="slider round">
                                        <span class="switch-on">ON</span>
                                        <span class="switch-off">OFF</span>
                                    </div>
                                </label>
                            <?php else: ?>
                                <input type="<?php echo e($type); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>"
                                    value="<?php echo e($value); ?>"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter <?php echo e(strtolower($label)); ?>" <?php echo e(isset($show) ? 'readonly' : ''); ?> />
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    <?php if(isset($method)): ?>
                        <button class="btn-primary" type="submit">
                            <?php echo e($method === 'PUT' ? 'Update' : 'Add'); ?> Minor
                        </button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('minor.index')); ?>" class="btn-outline inline-flex items-center justify-center">
                        Back
                    </a>
                </div>
            </form>

        </div>
    </div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/minor/create.blade.php ENDPATH**/ ?>