<div class="relative">
    <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
    <ul class="horiz-option popover-content">
    <?php if(isset($viewRoute)): ?>
    <li>
      <a href="<?php echo e(route($viewRoute, $id)); ?>" class="single-option">
        View
      </a>
    </li>
    <?php endif; ?>
    <?php if(isset($editRoute)): ?>
    <li>
      <a href="<?php echo e(route($editRoute, $id)); ?>" class="single-option">
        Edit
      </a>
    </li>
    <?php endif; ?>
    <!-- <li>
      <span
        class="single-option">
        Delete
      </span>
    </li> -->
  </ul>
</div>
<?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views/partials/_vertical-options.blade.php ENDPATH**/ ?>