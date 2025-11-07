@extends('layout.main')

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

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Commission Chart -ABCD
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
            <div class="box col-span-2 md:col-span-1">
                <div class="mb-3 flex justify-end">
                    <a href="" class="btn-primary p-2 rounded-10">
                        <i class="las la-pencil-alt"></i>
                    </a>
                </div>
                <div class="overflow-x-auto rounded-lg ">
                    <table class="w-full whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 w-1/3 uppercase">Name</td>
                                <td class="px-4 py-3">ABCD</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Chart Type</td>
                                <td class="px-4 py-3">Recurring Deposit (RD) (Installment Based Incentive)</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Commission Type</td>
                                <td class="px-4 py-3">INR (₹)</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Payout Type</td>
                                <td class="px-4 py-3">MLM</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Tenure (Months)</td>
                                <td class="px-4 py-3">12</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class=" col-span-2 md:col-span-1 "></div>

        </div>
        <div class="col-span-12 box mt-5 lg:col-span-12">

            <div class="tab-content p-4">
                <!-- Tab 1 -->
                <div id="tab1" class="tab-pane block">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            S. NO.
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            RANK/ MONTH
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            1M
                                        </div>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 uppercase">
                                       1
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                        FIELD HEAD OFFICER	
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                          4
                                        </div>
                                    </td>
                                </tr>
                               <tr class="border-b">
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 uppercase">
                                        #
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                           TOTAL		
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            	4 ₹
                                        </div>
                                    </td>
                                </tr>
                                   <tr class="border-b">
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 uppercase">
                                          #
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1 Capitalize">
                                            	COLLECTION CHARGE
                                        </div>
                                    </td>
                                    <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                          0 ₹	
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                // ✅ Set the first tab active by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                    tabPanes.forEach(p => p.classList.add('hidden'));

                    tabs[0].classList.add('active', 'text-primary', 'border-primary');
                    tabPanes[0].classList.remove('hidden');
                }

                // ✅ Tab switching logic
                tabs.forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();

                        // Remove active state from all tabs & hide all panes
                        tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                        tabPanes.forEach(p => p.classList.add('hidden'));

                        // Activate clicked tab and show its pane
                        tab.classList.add('active', 'text-primary', 'border-primary');
                        const targetPane = document.getElementById(tab.dataset.tab);
                        if (targetPane) targetPane.classList.remove('hidden');
                    });
                });
            });
        </script>



@endsection