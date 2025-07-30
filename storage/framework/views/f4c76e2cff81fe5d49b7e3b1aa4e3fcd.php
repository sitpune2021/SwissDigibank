<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h3 class="h2">Branches</h3>
        <a class="btn-primary" href="<?php echo e(route('branch.create')); ?>">
            <i class=" md:text-lg"></i>
            Add
        </a>
        <!-- </div> -->
    </div>

    <!-- Latest Transactions -->
    <div class="col-span-12 box lg:col-span-6">
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-4 bb-dashed lg:mb-6 lg:pb-6">
            <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-2 mb-4">
                <label for="perPage" class="text-sm">Show</label>
                <select name="perPage" id="perPage" onchange="this.form.submit()"
                    class="px-2 py-1 text-sm border rounded">
                    <option value="10" <?php echo e(request('perPage') == 10 ? 'selected' : ''); ?>>10</option>
                    <option value="25" <?php echo e(request('perPage') == 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e(request('perPage') == 50 ? 'selected' : ''); ?>>50</option>
                    <option value="100" <?php echo e(request('perPage') == 100 ? 'selected' : ''); ?>>100</option>
                </select>
                <span class="text-sm">entries</span>
            </form>
            <div class="flex flex-wrap items-center gap-4 grow sm:justify-end">
                <form method="GET" action="<?php echo e(route('branch.index')); ?>"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                    <input type="text" id="transaction-search" name="search" placeholder="Search"
                        value="<?php echo e(request('search')); ?>"
                        class="w-full py-1 text-sm bg-transparent border-none ltr:pl-4 rtl:pr-4" />
                    <button type="submit"
                        class="flex items-center justify-center rounded-full w-7 h-7 bg-primary shrink-0 lg:w-8 lg:h-8 text-n0">
                        <i class="text-lg las la-search"></i>
                    </button>
                    <?php if(request('search')): ?>
                    <a href="<?php echo e(route('branch.index')); ?>"
                        class="flex items-center justify-center transition duration-200 rounded-full w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark"
                        title="Clear Search">
                        <i class="text-lg las la-times"></i>
                    </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Branch Name
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Branch Code
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                City
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                State
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1">
                                Opening Date
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center justify-center gap-1  text-center">
                                Members
                            </div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="   flex items-center justify-center gap-1">
                               Is Active
                            </div>
                        </th>
                        <th class="text-center justify-center !py-5" data-sortable="false">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                        <td class="px-2 py-5 text-center">
                            <div>
                                <p class="mb-1 font-medium" ><?php echo e($branch->branch_name); ?></p>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center" ><?php echo e($branch->branch_code); ?></td>
                        <td class="px-6 py-5 text-center"><?php echo e($branch->city); ?></td>
                        <td class="px-6 py-5 text-center"><?php echo e($branch->State?->name); ?></td>
                        <td class="px-6 py-5 text-center">
                            <?php echo e($branch->open_date); ?>

                        </td>
                        <td class="px-7 py-5 text-center"><?php echo e($branch->members_count); ?></td>
                        <td class="px-6 py-5  text-center">
                            <?php if($branch->active == 'Yes'): ?>
                            <span  class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Yes
                            </span>
                            <?php else: ?>
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                <?php echo e($branch->active); ?>

                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-2  text-center">
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
        <div class="flex flex-wrap items-center justify-center col-span-12 gap-4 sm:justify-between">
            <ul class="flex flex-wrap items-center gap-2 md:gap-3 md:font-semibold">

                
                <?php if($branches->onFirstPage()): ?>
                <li>
                    <button
                        class="flex items-center justify-center w-8 h-8 text-gray-400 border border-gray-300 rounded-full md:w-10 md:h-10"
                        disabled>
                        <i class="text-lg las la-angle-left"></i>
                    </button>
                </li>
                <?php else: ?>
                <li>
                    <a href="<?php echo e($branches->previousPageUrl()); ?>"
                        class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 md:w-10 md:h-10 border-primary">
                        <i class="text-lg las la-angle-left"></i>
                    </a>
                </li>
                <?php endif; ?>

                
                <?php for($i = 1; $i <= $branches->lastPage(); $i++): ?>
                    <?php if($i == $branches->currentPage()): ?>
                    <li>
                        <button
                            class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-n0 bg-primary hover:text-n0 md:w-10 md:h-10 border-primary">
                            <?php echo e($i); ?>

                        </button>
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="<?php echo e($branches->url($i)); ?>"
                            class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary hover:text-n0 md:w-10 md:h-10 border-primary">
                            <?php echo e($i); ?>

                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endfor; ?>

                    
                    <?php if($branches->hasMorePages()): ?>
                    <li>
                        <a href="<?php echo e($branches->nextPageUrl()); ?>"
                            class="flex items-center justify-center w-8 h-8 duration-300 border rounded-full hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 md:w-10 md:h-10 border-primary">
                            <i class="text-lg las la-angle-right"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li>
                        <button
                            class="flex items-center justify-center w-8 h-8 text-gray-400 border border-gray-300 rounded-full md:w-10 md:h-10"
                            disabled>
                            <i class="text-lg las la-angle-right"></i>
                        </button>
                    </li>
                    <?php endif; ?>

            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views/company/branch/manage-branch.blade.php ENDPATH**/ ?>