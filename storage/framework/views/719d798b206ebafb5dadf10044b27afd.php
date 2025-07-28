

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
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
            <h4 class="h2">Share Holdings</h4>
            <a class="btn-primary" href="<?php echo e(route('shares-holdings.create')); ?>">
                <i class="text-base md:text-lg"></i>
                Add
            </a>
        </div>

        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
            <form method="GET" action="<?php echo e(route('shares-holdings.index')); ?>"
                class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                <input type="text" id="transaction-search" name="search" placeholder="Search"
                    value="<?php echo e(request('search')); ?>"
                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                <button type="submit"
                    class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('shares-holdings.index')); ?>"
                        class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                        title="Clear Search">
                        <i class="las la-times text-lg"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6">Sr No</th>
                        <th class="text-start !py-5 px-6">Branch</th>
                        <th class="text-start !py-5 px-6">Member</th>
                        <th class="text-start !py-5 px-6">Share Range</th>
                        <th class="text-start !py-5 px-6">Total Shares Held</th>
                        <th class="text-start !py-5 px-6">Nominal Val.</th>
                        <th class="text-start !py-5 px-6">Total Share Val.</th>
                        <th class="text-start !py-5 px-6">Allotment Date</th>
                        <th class="text-start !py-5 px-6">Transfer Date</th>
                        <th class="text-start !py-5 px-6">Cert. No</th>
                        <th class="text-start !py-5 px-6">Surrendered</th>
                        <th class="text-center !py-5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sharesholdings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sharesholding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->member?->branch->branch_name?? 'N/A'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->member?->member_info_first_name ??'N/A'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding?->first_share."-".$sharesholding->shareholding?->share_no ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding?->total_share_held ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding?->nominal_value ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding->total_share_value ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->allotment_date ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->transfer_date ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding->certificate_no ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->surrendered ? 'Yes' : 'No'); ?></td>
                            <td class="py-2 px-6">
                                <div class="flex justify-center">
                                    <?php echo $__env->make('partials._vertical-options', [
                                        'id' => base64_encode($sharesholding->id),
                                        'viewRoute' => 'shares-holdings.show',
                                        'editRoute' => 'shares-holdings.edit',
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="12" class="text-center py-4 text-gray-500">No shareholding records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/shares-holdings/index.blade.php ENDPATH**/ ?>