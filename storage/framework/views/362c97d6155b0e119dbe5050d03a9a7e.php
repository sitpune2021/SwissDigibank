<?php $__env->startSection('content'); ?>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h2 class="h2">Saving / Current Accounts</h2>
        <a class="btn-primary" href="<?php echo e(route('accounts.create')); ?>">
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
            <?php
                $headers = [
                               
                                "Associate",
                                "Type",
                                "Scheme",
                                "A/c No.",
                                "Joint A/C",
                                "Member Name",
                                "Balance",
                                "Action"
                            ];
            ?>
            <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th class="<?php echo e($header === 'Action' ? 'text-center' : 'text-start'); ?> py-5 px-6 min-w-[100px] cursor-pointer">
                    <div class="flex items-center gap-1">
                        <?php echo e($header); ?>

                    </div>
                </th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </thead>
    <?php
        $lastAdvisorId = null;
    ?>

    <tbody>
    <?php $__currentLoopData = $Accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $Account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="even:bg-secondary/5 dark:even:bg-bg3">
           

            
            <td class="text-start py-5 px-6">
                <?php if($lastAdvisorId !== $Account->advisor_id): ?>
                    <?php echo e($Account->users->fname . " " . $Account->users->lname ?? '-'); ?>

                    <?php $lastAdvisorId = $Account->advisor_id; ?>
                <?php else: ?>
                    
                <?php endif; ?>
            </td>

            
            <td class="text-start py-5 px-6"><?php echo e($Account->account_type ?? '-'); ?></td>

            
            <td class="text-start py-5 px-6">
                -
            </td>

            
            <td class="text-start py-5 px-6">
                <a href="<?php echo e(route('accounts.show', base64_encode($Account->id))); ?>" class="text-primary underline hover:text-primary/80">
                    <?php echo e($Account->account_no ?? '-'); ?>

                </a>
            </td>

            
           <td class="text-start py-5 px-6">
    <?php echo $Account->joint_account == 1 
        ? '<span class="block text-xs w-28 xxl:w-36 text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">YES</span>' 
        : '<span class="block text-xs w-28 xxl:w-36 text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-error/10 dark:bg-bg3 text-error">No</span>'; ?>

</td>


            
          <td class="text-start py-5 px-6">
                <?php if($Account->members): ?>
                    <a href="<?php echo e(url('member/' . $Account->members->id . '/edit')); ?>" class="text-primary hover:underline">
                        <?php echo e("Member ".$Account->members->id ." - ". $Account->members->member_info_first_name . ' ' . $Account->members->member_info_last_name); ?>

                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            
            <td class="text-start py-5 px-6"><?php echo e($Account->amount_deposit ?? '-'); ?></td>

            
            <td class="text-center py-5 px-6">
                <div class="flex justify-center">
                    <?php echo $__env->make('partials._vertical-options', [
                        'id' => base64_encode($Account->id),
                        'viewRoute' => 'accounts.show'
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views/saving-current-ac/accounts/index.blade.php ENDPATH**/ ?>