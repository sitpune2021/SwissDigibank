<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10">
    <h2 class="text-xl font-semibold mb-4">Forgot Your Password?</h2>

    <?php if(session('status')): ?>
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>

        <label for="email" class="block text-sm font-medium">Email</label>
        <input id="email" type="email" name="email" required
            class="mt-1 w-full border border-gray-300 p-2 rounded">

        <button type="submit"
            class="mt-4 w-full bg-primary text-white py-2 px-4 rounded">
            Send Password Reset Link
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\authentication\password\email.blade.php ENDPATH**/ ?>