<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h2 class="h2">Branches</h2>
        <a class="btn-primary" href="<?php echo e(route('branch.create')); ?>">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add
        </a>
        <!-- </div> -->
    </div>

    <!-- Latest Transactions -->
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
                <form method="GET" action="<?php echo e(route('branch.index')); ?>"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                    <input type="text" id="transaction-search" name="search" placeholder="Search"
                        value="<?php echo e(request('search')); ?>"
                        class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                    <button type="submit"
                        class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                        <i class="las la-search text-lg"></i>
                    </button>
                    <?php if(request('search')): ?>
                    <a href="<?php echo e(route('branch.index')); ?>"
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
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Sr No
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Branch Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Branch Code
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                City
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                State
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Opening Date
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Members
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                Active
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="py-5 px-6"><?php echo e(($branches->currentPage() - 1) * $branches->perPage() + $loop->iteration); ?></td>
                        <td class="py-5 px-6">
                            <div>
                                <p class="font-medium mb-1"><?php echo e($branch->branch_name); ?></p>
                            </div>
                        </td>
                        <td class="py-5 px-6"><?php echo e($branch->branch_code); ?></td>
                        <td class="py-5 px-6"><?php echo e($branch->city); ?></td>
                        <td class="py-5 px-6"><?php echo e($branch->stateData->name); ?></td>
                        <td class="py-5 px-6">
                            <?php echo e($branch->open_date); ?>

                        </td>
                        <td class="py-5 px-6"><?php echo e($branch->members_count); ?></td>
                        <td class="py-2">
                            <?php if($branch->active == 'Yes'): ?>
                            <span  class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                            <?php else: ?>
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                <?php echo e($branch->active); ?>

                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-6">
                            <div class="flex justify-center">
                                <?php echo $__env->make('partials._vertical-options', [
                                'id' => base64_encode($branch->id),
                                'viewRoute' => 'branch.show',
                                'editRoute' => 'branch.edit'
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($branches->lastPage() > 1): ?>
        <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
            <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">

                
                <?php if($branches->onFirstPage()): ?>
                <li>
                    <button
                        class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                        disabled>
                        <i class="las la-angle-left text-lg"></i>
                    </button>
                </li>
                <?php else: ?>
                <li>
                    <a href="<?php echo e($branches->previousPageUrl()); ?>"
                        class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                        <i class="las la-angle-left text-lg"></i>
                    </a>
                </li>
                <?php endif; ?>

                
                <?php for($i = 1; $i <= $branches->lastPage(); $i++): ?>
                    <?php if($i == $branches->currentPage()): ?>
                    <li>
                        <button
                            class="hover:bg-primary text-n0 bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            <?php echo e($i); ?>

                        </button>
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="<?php echo e($branches->url($i)); ?>"
                            class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            <?php echo e($i); ?>

                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endfor; ?>

                    
                    <?php if($branches->hasMorePages()): ?>
                    <li>
                        <a href="<?php echo e($branches->nextPageUrl()); ?>"
                            class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                            <i class="las la-angle-right text-lg"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li>
                        <button
                            class="border md:w-10 md:h-10 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 border-gray-300"
                            disabled>
                            <i class="las la-angle-right text-lg"></i>
                        </button>
                    </li>
                    <?php endif; ?>

            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\branch\manage-branch.blade.php ENDPATH**/ ?>