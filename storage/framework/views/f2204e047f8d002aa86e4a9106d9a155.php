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
            <!-- <h2 class="h2">Manage Promotors</h2> -->
            <div>
                <h1 class="text-xl font-semibold">Manage Share Transfer History</h1>
                <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                    <li><a href="<?php echo e(url('/dashboard')); ?>" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><a href="<?php echo e(url('/manage-Share Transfer History')); ?>" class="text-blue-600 hover:underline">Share Transfer History</a></li>
                    <li class="text-gray-500">Manage Share Transfer History</li>
                </ol>
            </div>
            <a href="<?php echo e(route('share-transfer-histories.create')); ?>" class="btn-primary">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Add Share Transfer History
            </a>
        </div>

        <!-- Latest Transactions -->
        <div class="box col-span-12 lg:col-span-6">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                <!-- <h4 class="h4">Share Transfer History</h4> -->
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
                                    Business Type
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Transferor
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[150px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Transferee
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[140px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Share Range
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Nominal Val.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    No. Of Shares
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[140px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Transfer Date
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    New Share
                                </div>
                            </th>
                            <th class="text-center !py-5" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\share-transfer-histories\index.blade.php ENDPATH**/ ?>