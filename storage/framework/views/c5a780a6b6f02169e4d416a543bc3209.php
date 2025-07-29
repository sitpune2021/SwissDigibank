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
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-center gap-2">
            <h1 class="text-xl font-semibold">Schemes</h1>
            <a href="<?php echo e(route('schemes.create')); ?>"
               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                <i class="las la-plus text-lg"></i>
            </a>
        </div>
    </div>

    <div class="box col-span-12 lg:col-span-6">
        <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
            <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-2 mb-4">
                <label for="perPage" class="text-sm">Show</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
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

                    <input type="text" name="search" placeholder="Search"
                           value="<?php echo e(request('search')); ?>"
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
                        <th class="text-start !py-5 px-6">Sr No</th>
                        <th class="text-start !py-5 px-6">Code</th>
                        <th class="text-start !py-5 px-6">Scheme Name</th>
                        <th class="text-start !py-5 px-6">Min. Amt. To Open A/c</th>
                        <th class="text-start !py-5 px-6">Min. Balance/Month</th>
                        <th class="text-start !py-5 px-6">Lock In Amt.</th>
                        <th class="text-start !py-5 px-6">Interest Rate (%)</th>
                        <th class="text-center !py-5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                            <td class="py-5 px-6"><?php echo e(($schemes->currentPage() - 1) * $schemes->perPage() + $loop->iteration); ?></td>
                            <td class="py-5 px-6"><?php echo e($scheme->code); ?></td>
                            <td class="py-5 px-6"><?php echo e($scheme->name); ?></td>
                            <td class="py-5 px-6"><?php echo e(number_format($scheme->min_open_amt, 2)); ?></td>
                            <td class="py-5 px-6"><?php echo e(number_format($scheme->min_monthly_bal, 2)); ?></td>
                            <td class="py-5 px-6"><?php echo e(number_format($scheme->lock_in_amt, 2)); ?></td>
                            <td class="py-5 px-6"><?php echo e($scheme->interest_rate); ?>%</td>
                            <td class="py-5 px-6">
                                <div class="flex justify-center gap-2">
                                    <a href="<?php echo e(route('schemes.show', $scheme->id)); ?>"
                                       class="border-green-500 text-green-500 hover:bg-green-500 hover:text-white rounded-full transition duration-150">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('schemes.edit', $scheme->id)); ?>"
                                       class="border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-full transition duration-150">
                                        <i class="las la-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <?php if($schemes->lastPage() > 1): ?>
            <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap mt-4">
                <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">
                    
                    <?php if($schemes->onFirstPage()): ?>
                        <li><button class="border w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300" disabled><i class="las la-angle-left text-lg"></i></button></li>
                    <?php else: ?>
                        <li><a href="<?php echo e($schemes->previousPageUrl()); ?>" class="hover:bg-primary text-primary border w-8 h-8 flex items-center justify-center rounded-full"><i class="las la-angle-left text-lg"></i></a></li>
                    <?php endif; ?>

                    
                    <?php for($i = 1; $i <= $schemes->lastPage(); $i++): ?>
                        <?php if($i == $schemes->currentPage()): ?>
                            <li><button class="bg-primary text-white border w-8 h-8 flex items-center justify-center rounded-full"><?php echo e($i); ?></button></li>
                        <?php else: ?>
                            <li><a href="<?php echo e($schemes->url($i)); ?>" class="hover:bg-primary text-primary border w-8 h-8 flex items-center justify-center rounded-full"><?php echo e($i); ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    
                    <?php if($schemes->hasMorePages()): ?>
                        <li><a href="<?php echo e($schemes->nextPageUrl()); ?>" class="hover:bg-primary text-primary border w-8 h-8 flex items-center justify-center rounded-full"><i class="las la-angle-right text-lg"></i></a></li>
                    <?php else: ?>
                        <li><button class="border w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300" disabled><i class="las la-angle-right text-lg"></i></button></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\schemes\index.blade.php ENDPATH**/ ?>