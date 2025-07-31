<?php $__env->startSection('page-title', 'Permisions /Roles'); ?>

<?php $__env->startSection('action-button'); ?>
    <a class="btn-primary" href="<?php echo e(route('roles.create')); ?>">
        <i class=" md:text-lg"></i>
        Add
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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

            <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                <form method="GET" action="<?php echo e(url()->current()); ?>"
                    class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-full px-4 py-1 min-w-[200px] xl:max-w-[319px]">
                    <input type="text" name="search" id="transaction-search" placeholder="Search"
                        value="<?php echo e(request('search')); ?>"
                        class="bg-transparent border-none text-sm text-gray-800 dark:text-white focus:outline-none w-full placeholder:text-gray-400" />
                    <button type="submit"
                        class="w-7 h-7 bg-primary hover:bg-primary/90 text-white rounded-full flex items-center justify-center transition duration-200">
                        <i class="las la-search text-lg"></i>
                    </button>

                    <?php if(request('search')): ?>
                        <a href="<?php echo e(url()->current()); ?>"
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
                            <div class="flex items-center gap-1">Sr No</div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">Role Name</div>
                        </th>
                        <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">Position</div>
                        </th>
                        <th class="text-start !py-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">Active</div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">Users</div>
                        </th>
                        <th class="text-start !py-5 cursor-pointer">
                            <div class="flex items-center gap-1">Associates</div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#transactionTable1').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                searching: false // Disable default DataTable search as you have your own search form
            });
        });

        document.getElementById('transaction-search').addEventListener('input', function() {
            if (this.value === '') {
                this.form.submit();
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Avantika\office_work\Swiss\resources\views/roles/manage-permission.blade.php ENDPATH**/ ?>