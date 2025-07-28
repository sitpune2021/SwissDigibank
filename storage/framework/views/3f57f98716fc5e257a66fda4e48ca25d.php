<?php
    $companyprofile = config('companyprofile_form');
?>

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-semibold">SWISS PAYMENTS-DIGITAL BANKING</h1>
                <a href="<?php echo e(route('company.edit', $company->id)); ?>"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                    <i class="las la-edit text-lg"></i>
                </a>
                <hr class="my-2 border-gray-300" />
            </div>
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
        <form action="<?php echo e($route); ?>" method="POST" class="relative">
            <?php echo csrf_field(); ?>
            <?php if(isset($method)): ?>
                <?php echo method_field($method); ?>
            <?php endif; ?>
            
            <div class="grid grid-cols-12 gap-4 xxxxxl:gap-6">
                <?php $__currentLoopData = $companyprofile; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-span-6 ">
                        <div class="box xxl:p-8 xxxl:p-10 mb-6">
                            <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6"><?php echo e($section['heading']); ?></h4>
                            <?php
                                $isForm = !isset($show) || !$show;
                            ?>
                            <?php if($isForm): ?>
                                <section class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 xxxxxl:gap-6">
                                    <?php echo $__env->make('company.company-profile.partial.sectionLoop', [
                                        'section' => $section,
                                        'company' => $company,
                                        'show' => false,
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </section>
                            <?php else: ?>
                                <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 xxxxxl:gap-6">
                                    <?php echo $__env->make('company.company-profile.partial.sectionLoop', [
                                        'section' => $section,
                                        'company' => $company,
                                        'show' => true,
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </form>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(!isset($show) || !$show): ?>
                    <div class="col-span-2 flex gap-4 md:gap-6 mt-2 absolute bottom-0 right-0">
                        <button class="btn-primary" type="submit">Update</button>
                        <a href="<?php echo e(route('company.index' )); ?>" class="btn-outline">Cancel</a>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Office_Work_2025\new_swiss\resources\views/company/company-profile/profile.blade.php ENDPATH**/ ?>