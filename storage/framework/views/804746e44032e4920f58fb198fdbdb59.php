
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
        <h4 class="h2">Share Certificate</h4>
        <!-- Latest Transactions -->
        <div class="box col-span-12 lg:col-span-6">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form
                        class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                        <input type="text" id="transaction-search" placeholder="Search"
                            class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                        <button
                            class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                            <i class="las la-search text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto pb-4 lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Sr No
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Branch
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Member
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Share Range
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Certificate No.
                                </div>                              
                            </th>
                            <th class="text-center !py-5" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                     <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sharecertificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sharecertificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4"><?php echo e($index + 1); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharecertificate->member->branch->branch_name?? 'N/A'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharecertificate->member->member_info_first_name ??'N/A'); ?></td>
                            
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding->total_share_held ?? '-'); ?></td>
                            <td class="px-6 py-4"><?php echo e($sharesholding->shareholding->nominal_value ?? '-'); ?></td>
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
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss bank live code\resources\views/share-certificates/index.blade.php ENDPATH**/ ?>