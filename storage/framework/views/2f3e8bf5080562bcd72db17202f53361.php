<?php $__env->startSection('page-title',
    isset($shareholding)
    ? (!empty($show)
    ? 'View ' .
    $director->director_name .
    '
    Director'
    : 'Edit ' . $director->director_name . ' Director')
    : 'Add Director'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('fields.errormessage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="box mb-4 xxxl:mb-6">
        <form id="companyForm" action="<?php echo e($route); ?>" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            <?php echo csrf_field(); ?>
            <?php if($method == 'PUT'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <?php $__currentLoopData = $formFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $name = $field['name'];
                    $type = $field['type'] ?? 'text';
                    $label = $field['label'];
                    $id = $field['id'] ?? $field['name'];
                    $required = $field['required'] ?? false;
                    $value = old($name, $director[$name] ?? ($field['default'] ?? ''));

                ?>
                <div class="col-span-2 md:col-span-1">
                    <?php echo $__env->make('fields.label', [
                        'id' => $id,
                        'label' => $label,
                        'required' => $required,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('fields.inputs', [
                        'id' => $id,
                        'label' => $label,
                        'required' => $required,
                        'type' => $type,
                        'name' => $name,
                        'value' => $value,
                        'readonly' => empty($show) ? '' : 'readonly',
                        'field' => $field,
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                <?php if(empty($show)): ?>
                    <button class="btn-primary" type="submit">
                        <?php echo e($method === 'PUT' ? 'Update' : 'Save'); ?> director
                    </button>
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Reset
                    </button>
                <?php endif; ?>
                <button class="btn-outline" type="reset"
                    onclick="window.location.href='<?php echo e(route('director.index')); ?>'">Back</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Avantika\office_work\Swiss\resources\views/company/director/create.blade.php ENDPATH**/ ?>