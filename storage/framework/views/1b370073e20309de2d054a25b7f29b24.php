  <?php $__currentLoopData = $section['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-span-2 md:col-span-1">
          <label for="<?php echo e($field['id']); ?>" class="md:text-lg font-medium block mb-4">
              <?php echo e($field['label']); ?>

              <?php if(!empty($field['required'])): ?>
                  <span class="text-red-500">*</span>
              <?php endif; ?>
          </label>

          <?php if($field['type'] === 'textarea'): ?>
              <textarea id="<?php echo e($field['id']); ?>" name="<?php echo e($field['name']); ?>" rows="4" <?php echo e(isset($show) && $show ? 'readonly' : ''); ?>

                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
                  placeholder="Enter <?php echo e(strtolower($field['label'])); ?>" readonly><?php echo e(old($field['name'], $company->{$field['name']} ?? '')); ?></textarea>
          <?php elseif($field['type'] === 'date'): ?>
              <input type="date" id="<?php echo e($field['id']); ?>" name="<?php echo e($field['name']); ?>"
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  value="<?php echo e(old($field['name'], $company->{$field['name']} ?? '')); ?>"
                  <?php echo e(isset($show) && $show ? 'readonly' : ''); ?> />
          <?php elseif($field['type'] === 'number'): ?>
              <input type="number" id="<?php echo e($field['id']); ?>" name="<?php echo e($field['name']); ?>"
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  placeholder="Enter <?php echo e(strtolower($field['label'])); ?>"
                  value="<?php echo e(old($field['name'], $company->{$field['name']} ?? '')); ?>"
                  <?php echo e(isset($show) && $show ? 'readonly' : ''); ?> />
          <?php else: ?>
              <input type="<?php echo e($field['type']); ?>" id="<?php echo e($field['id']); ?>" name="<?php echo e($field['name']); ?>"
                  class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                  placeholder="Enter <?php echo e(strtolower($field['label'])); ?>"
                  value="<?php echo e(old($field['name'], $company->{$field['name']} ?? '')); ?>"
                  <?php echo e(isset($show) && $show ? 'readonly' : ''); ?> />
          <?php endif; ?>
      </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\company-profile\partial\sectionLoop.blade.php ENDPATH**/ ?>