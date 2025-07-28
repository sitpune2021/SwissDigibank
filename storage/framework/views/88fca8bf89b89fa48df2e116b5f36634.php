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
        <form method="GET" action="<?php echo e($action ?? url()->current()); ?>"
            class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-[30px] p-1 min-w-[200px] xl:max-w-[319px]">
            <input type="text" id="transaction-search" name="search" placeholder="Search"
                value="<?php echo e(request('search')); ?>"
                class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
            <button type="submit"
                class="w-7 h-7 bg-primary shrink-0 rounded-full flex justify-center items-center text-n0">
                <i class="las la-search text-lg"></i>
            </button>
            <?php if(request('search')): ?>
                <a href="<?php echo e($action ?? url()->current()); ?>"
                    class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                    title="Clear Search">
                    <i class="las la-times text-lg"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>


<script>
    document.getElementById('transaction-search')?.addEventListener('input', function () {
        if (this.value === '') {
            this.form.submit();
        }
    });
</script>
<?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\components\searchbox.blade.php ENDPATH**/ ?>