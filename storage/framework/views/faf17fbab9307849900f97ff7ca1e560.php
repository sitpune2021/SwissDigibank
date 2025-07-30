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

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }
</style>

<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 lg:mb-5">
        <h4 class="h2">Schemes</h4>
        <a class="btn-primary" href="<?php echo e(route('schemes.create')); ?>">
            <i class=" text-base md:text-lg"></i>
            Add
        </a>
    </div>

    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-2 mb-4">
                <label for="perPage" class="text-sm">Show</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()"
                    class="border rounded px-2 py-1 text-sm">
                    <option value="10" <?php echo e(request('perPage') == 10 ? 'selected' : ''); ?>>10</option>
                    <option value="25" <?php echo e(request('perPage') == 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e(request('perPage') == 50 ? 'selected' : ''); ?>>50</option>
                    <option value="100" <?php echo e(request('perPage') == 100 ? 'selected' : ''); ?>>100</option>
                </select>
                <span class="text-sm">entries</span>
            </form>

            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form method="GET" action="<?php echo e(route('schemes.index')); ?>"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-full px-4 py-1 min-w-[200px] xl:max-w-[319px]">

                    <input type="text" name="search" placeholder="Search" value="<?php echo e(request('search')); ?>"
                        class="bg-transparent border-none text-sm text-gray-800 dark:text-white focus:outline-none w-full placeholder:text-gray-400" />

                    <button type="submit"
                        class="w-7 h-7 bg-primary hover:bg-primary/90 text-white rounded-full flex items-center justify-center transition duration-200">
                        <i class="las la-search text-lg"></i>
                    </button>

                    <?php if(request('search')): ?>
                    <a href="<?php echo e(route('schemes.index')); ?>"
                        class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                        title="Clear Search">
                        <i class="las la-times text-lg"></i>
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-2 px-3">Sr No</th>
                        <th class="text-start !py-2 px-3">Code</th>
                        <th class="text-start !py-2 px-3">Scheme Name</th>
                        <th class="text-start !py-2 px-3">Min. Amt. To Open A/c</th>
                        <th class="text-start !py-2 px-3">Min. Balance/Month</th>
                        <th class="text-start !py-2 px-3">Lock In Amt.</th>
                        <th class="text-start !py-2 px-3">Interest Rate (%)</th>
                        <th class="text-start !py-2 px-3">Interest Payout</th>
                        <th class="text-start !py-2 px-3">Active</th>
                        <th class="text-center !py-5">Action</th>
                <tbody>
                    <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6"><?php echo e($loop->iteration); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->scheme_code); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->scheme_name); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->min_opening_balance, 2); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->min_monthly_avg_balance, 2); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->lock_in_amount, 2); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->annual_int_rate); ?></td>
                        <td class="py-5 px-6"><?php echo e($scheme->interest_pay_cycle); ?></td>
                        <!-- <td class="py-5 px-6"><?php echo e($scheme->active); ?></td> -->
                        <td class="py-5 px-6">
                            <?php if($scheme->active == 1): ?>
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                            <?php else: ?>
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                               No
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                <?php echo $__env->make('partials._vertical-options', [
                                'id' => $scheme->id,
                                'viewRoute' => 'schemes.show',
                                'editRoute' => 'schemes.edit'
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views/schemes/index.blade.php ENDPATH**/ ?>