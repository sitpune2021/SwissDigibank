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
                    <form method="GET" action="<?php echo e(route('minor.index')); ?>"
                        class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                        <input type="text" id="transaction-search" name="search" placeholder="Search"
                            value="<?php echo e(request('search')); ?>"
                            class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                        <button type="submit"
                            class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                            <i class="las la-search text-lg"></i>
                        </button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('minor.index')); ?>"
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
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Sr No
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Branch
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Minor Name
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Member
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Father Name
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Enrollment Date
                                </div>
                            </th>
                            
                            <th class="text-center !py-5" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $minors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $minor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b dark:border-bg3">
                                <td class="px-6 py-4"><?php echo e($index + 1); ?></td> <!-- Sr No -->

                                <td class="px-6 py-4"><?php echo e($minor->member->branch->branch_name ?? 'N/A'); ?></td>
                                <!-- Branch -->

                                <td class="px-6 py-4"><?php echo e($minor->first_name ?? 'N/A'); ?></td> <!-- Minor Name -->

                                <td class="px-6 py-4">
                                    <?php echo e($minor->member->member_info_first_name ?? 'N/A'); ?>

                                </td> <!-- Member First Name -->

                                <td class="px-6 py-4"><?php echo e($minor->father_name ?? 'N/A'); ?></td> <!-- Father Name -->

                                <td class="px-6 py-4">
                                    <?php echo e($minor->enrollment_date); ?>

                                </td> <!-- Enrollment Date -->
                                
                                <td class="py-2 px-6">
                                    <div class="flex justify-center">
                                        <?php echo $__env->make('partials._vertical-options', [
                                            'id' => $minor->id,
                                            'viewRoute' => 'minor.show',
                                            'editRoute' => 'minor.edit',
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Office_Work_2025\new_swiss\resources\views/members/minor/index.blade.php ENDPATH**/ ?>