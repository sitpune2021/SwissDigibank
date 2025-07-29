<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-lg font-bold">Reset Password</h2>
    <form method="POST" action="<?php echo e(route('password.update')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <input type="email" name="email" value="<?php echo e($email ?? old('email')); ?>" class="border p-2 w-full mt-4" required>
        <input type="password" name="password" placeholder="New password" class="border p-2 w-full mt-4" required>
        <input type="password" name="password_confirmation" placeholder="Confirm new password" class="border p-2 w-full mt-4" required>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-4">Reset Password</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\authentication\password\reset.blade.php ENDPATH**/ ?>