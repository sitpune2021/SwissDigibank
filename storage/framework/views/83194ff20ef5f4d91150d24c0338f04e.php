<?php $__env->startSection('content'); ?>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h4 class="h4 mb-1">33,215.00 USD</h4>
                <p>
                    Total Balance from all accounts
                    <span class="font-semibold text-primary">USD</span>
                </p>
            </div>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 flex flex-col gap-4 md:col-span-7 lg:col-span-8 xxl:gap-6">
                <!-- Statistics -->
                <div
                    class="xxl:box grid grid-cols-6 p-0 max-xxl:gap-4 xxl:divide-x-2 xxl:divide-dashed xxl:p-4 xxl:dark:divide-n500 4xl:p-8 xxl:ltr:divide-n30 xxl:rtl:divide-x-reverse">
                    <div
                        class="max-xxl:box col-span-6 flex items-center justify-between gap-3 overflow-x-hidden sm:col-span-3 md:col-span-6 lg:col-span-3 xxl:col-span-2 xxl:px-4 xxl:ltr:first:pl-0 xxl:last:ltr:pr-0">
                        <div>
                            <p class="mb-4 font-medium">Total Income</p>
                            <div class="flex items-center gap-2">
                                <h4 class="h4">$2500</h4>
                                <span class="flex items-center gap-1 text-sm text-primary">
                                    <i class="las la-arrow-up text-base"></i> 50.8%
                                </span>
                            </div>
                        </div>
                        <div class="max-w-[200px]">
                            <div class="style2-stats-chart"></div>
                        </div>
                    </div>
                    <div
                        class="max-xxl:box col-span-6 flex items-center justify-between gap-3 overflow-x-hidden sm:col-span-3 md:col-span-6 lg:col-span-3 xxl:col-span-2 xxl:px-4 xxl:ltr:first:pl-0 xxl:last:ltr:pr-0">
                        <div>
                            <p class="mb-4 font-medium">Total Spending</p>
                            <div class="flex items-center gap-2">
                                <h4 class="h4">$3500</h4>
                                <span class="flex items-center gap-1 text-sm text-primary">
                                    <i class="las la-arrow-up text-base"></i> 50.8%
                                </span>
                            </div>
                        </div>
                        <div class="max-w-[200px]">
                            <div class="style2-stats-chart"></div>
                        </div>
                    </div>
                    <div
                        class="max-xxl:box col-span-6 flex items-center justify-between gap-3 overflow-x-hidden sm:col-span-3 md:col-span-6 lg:col-span-3 xxl:col-span-2 xxl:px-4 xxl:ltr:first:pl-0 xxl:last:ltr:pr-0">
                        <div>
                            <p class="mb-4 font-medium">Total Transactions</p>
                            <div class="flex items-center gap-2">
                                <h4 class="h4">$8500</h4>
                                <span class="flex items-center gap-1 text-sm text-primary">
                                    <i class="las la-arrow-up text-base"></i> 50.8%
                                </span>
                            </div>
                        </div>
                        <div class="max-w-[200px]">
                            <div class="style2-stats-chart"></div>
                        </div>
                    </div>
                </div>
                <!-- Income and expences -->
                <div class="box overflow-x-hidden">
                    <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-3 pb-4 lg:mb-6 lg:pb-6">
                        <h4 class="h4">Income and Expenses</h4>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="">Sort By : </span>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="income-chart"></div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-5 lg:col-span-4">
                <div class="box">
                    <h4 class="h4 bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">My Wallet</h4>
                    <div class="mb-6 flex items-center justify-center gap-3 lg:mb-8 xxl:gap-4">
                        <button
                            class="prev-wallet h-8 w-8 shrink-0 rounded-full border border-primary bg-n0 text-primary duration-300 hover:bg-primary hover:text-n0 dark:bg-bg4 dark:hover:bg-primary xxl:h-10 xxl:w-10">
                            <i class="las la-angle-left text-lg rtl:rotate-180"></i>
                        </button>
                        <div class="swiper walletSwiper" dir="ltr">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="flex justify-center">
                                        <img src="<?php echo e(asset('assets/images/my-wallet-1.png')); ?>" width="296"
                                            class="rounded-xl" height="200" alt="card img" />
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="flex justify-center">
                                        <img src="<?php echo e(asset('assets/images/my-wallet-2.png')); ?>" width="296"
                                            class="rounded-xl" height="200" alt="card img" />
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="flex justify-center">
                                        <img src="<?php echo e(asset('assets/images/my-wallet-3.png')); ?>" width="296"
                                            class="rounded-xl" height="200" alt="card img" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button
                            class="next-wallet h-8 w-8 shrink-0 rounded-full border border-primary bg-n0 text-primary duration-300 hover:bg-primary hover:text-n0 dark:bg-bg4 dark:hover:bg-primary xxl:h-10 xxl:w-10">
                            <i class="las la-angle-right text-lg rtl:rotate-180"></i>
                        </button>
                    </div>
                    <h5 class="mb-6 text-lg font-medium md:text-xl">
                        Quick Transfer
                    </h5>
                    <form>
                        <div
                            class="mb-5 flex items-center rounded-[32px] border border-n30 bg-primary/5 p-1 dark:border-n500 dark:bg-bg3">
                            <select name="card" id="card"
                                class="card nc-select dark:!bg-bg4 w-[120px] !min-w-max rtl:!pl-6">
                                <option value="visa">Visa</option>
                                <option value="mastercard">MasterCard</option>
                                <option value="payonneer">Payoneer</option>
                            </select>
                            <input type="text"
                                class="w-full border-none bg-transparent pr-5 focus:border-none focus:outline-none"
                                placeholder="Account Number..." name="card" />
                        </div>
                        <div
                            class="mb-6 flex items-center rounded-[32px] border border-n30 bg-primary/5 p-1 dark:border-n500 dark:bg-bg3 lg:mb-8">
                            <select name="card" id="currency"
                                class="card nc-select dark:!bg-bg4 w-16 !min-w-max rtl:!pl-6">
                                <option value="dollar">$</option>
                                <option value="frack">€</option>
                                <option value="yen">¥</option>
                                <option value="gbp">£</option>
                            </select>
                            <input type="number" class="w-full border-none bg-transparent pr-5"
                                placeholder="Enter Amount..." name="amount" />
                        </div>
                        <button type="submit" class="btn-primary flex w-full justify-center">
                            Send Money
                        </button>
                    </form>
                </div>
            </div>

            <!-- Latest Transactions -->
            <div class="col-span-12">
                <div class="box col-span-12 lg:col-span-6">
                    <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 lg:mb-6 lg:pb-6">
                        <h4 class="h4">Latest Transaction</h4>
                        <div class="flex items-center gap-4">
                            <form
                                class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                                <input type="text" placeholder="Search"
                                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                                <button
                                    class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                    <i class="las la-search text-lg"></i>
                                </button>
                            </form>
                            <div class="flex items-center gap-3 whitespace-nowrap">
                                <span>Sort By : </span>
                                <select class="nc-select green !rounded-3xl">
                                    <option value="day">Last 15 Days</option>
                                    <option value="week">Last 1 Month</option>
                                    <option value="year">Last 6 Month</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="w-[50px] px-6 text-start">
                                        <input name="select-all" type="checkbox" id="selectAllCheckbox"
                                            class="accent-secondary focus:border-none focus:shadow-none focus:outline-none" />
                                    </th>
                                    <th class="min-w-[330px] cursor-pointer px-6 py-5 text-start">
                                        <div class="flex items-center gap-1">Title</div>
                                    </th>
                                    <th class="min-w-[120px] py-5 text-start">Invoice</th>
                                    <th class="min-w-[120px] cursor-pointer py-5 text-start">
                                        <div class="flex items-center gap-1">Medium</div>
                                    </th>
                                    <th class="min-w-[120px] cursor-pointer py-5 text-start">
                                        <div class="flex items-center gap-1">Transaction</div>
                                    </th>
                                    <th class="cursor-pointer py-5 text-start">
                                        <div class="flex items-center gap-1">Status</div>
                                    </th>
                                    <th class="p-5 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/10 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/10 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/10 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                                <tr class="even:bg-secondary/5 dark:even:bg-bg3">
                                    <td class="px-6 text-start">
                                        <input type="checkbox" class="accent-secondary" name="checkbox1" />
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo e(asset('assets/images/paypal.png')); ?>" width="32"
                                                height="32" class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Hooli INV-79820</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">#521452</td>
                                    <td class="py-2">Paypal</td>
                                    <td class="py-2">$1,121,212</td>
                                    <td class="py-2">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-36">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="py-2">
                                        <div class="flex justify-center">
                                            <!-- Add your action elements here -->
                                            <?php echo $__env->make('partials._vertical-options', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a class="group mt-6 inline-flex items-center gap-1 font-semibold text-primary" href="#">
                        See More
                        <i class="las la-arrow-right duration-300 group-hover:pl-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\swiss_bank\resources\views\dashboard\index2.blade.php ENDPATH**/ ?>