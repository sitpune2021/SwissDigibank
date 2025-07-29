<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h2 class="h2">Manage Director</h2> -->
        <h4 class="h2">Director</h4>
        <a class="btn-primary" href="<?php echo e(route('director.create')); ?>">
            <i class=" md:text-lg"></i>
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
            

    <!-- Latest Transactions -->
    <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
        <form method="GET" action="<?php echo e(route('director.index')); ?>"
            class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
            <input type="text" id="transaction-search" name="search" placeholder="Search"
                value="<?php echo e(request('search')); ?>"
                class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
            <button type="submit"
                class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                <i class="las la-search text-lg"></i>
            </button>
            <?php if(request('search')): ?>
            <a href="<?php echo e(route('director.index')); ?>"
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
                        Designation
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Member
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Name
                    </div>
                </th>
                <th class="text-start !py-5 min-w-[100px]" data-sortable="false">Gender</th>
                <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        DIN
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Appointment Date
                    </div>
                </th>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Resignation Date
                    </div>
                </th>
                <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        Authorized Signatory
                    </div>
                </th>
                </th>
                <th class="text-center !py-5" data-sortable="false">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $directors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $director): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-6 py-4"><?php echo e($director->designation ?? 'N/A'); ?></td>
                <td class="px-6 py-4"><?php echo e($director->member->id ?? 'N/A'); ?></td>
                <td class="px-6 py-4"><?php echo e($director->member->member_info_first_name ?? 'N/A'); ?></td>
                <td class="px-6 py-4"><?php echo e($director->member->member_info_gender ?? 'N/A'); ?></td>
                <td class="px-6 py-4"><?php echo e($director->din_no); ?></td>
                <td class="px-6 py-4"><?php echo e($director->appointment_date?->format('d-m-Y') ?? 'N/A'); ?></td>
                <td class="px-6 py-4"><?php echo e($director->resignation_date?->format('d-m-Y') ?? 'N/A'); ?></td>
                <!-- <td class="px-6 py-4"><?php echo e($director->authorized_signatory ? 'Yes' : 'No'); ?></td> -->
                <td class="py-2">
                    <?php if($director->authorized_signatory == 'Yes'): ?>
                    <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                        Yes
                    </span>
                    <?php else: ?>
                    <span
                        class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                        <?php echo e($director->authorized_signatory); ?>

                    </span>
                    <?php endif; ?>
                </td>
                <td class="py-2 px-6">
                    <div class="flex justify-center">
                        <?php echo $__env->make('partials._vertical-options', [
                        'id' =>base64_encode($director->id),
                        'viewRoute' => 'director.show',
                        'editRoute' => 'director.edit'
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
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Office_Work_2025\new_swiss\resources\views/company/director/index.blade.php ENDPATH**/ ?>