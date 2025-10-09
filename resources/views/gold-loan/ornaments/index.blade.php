@extends('layout.main')

@section('content')

    <head>
        <style>
            input[type="radio"] {
                width: 24px;
                height: 24px;
                accent-color: green;
                /* Modern browser support */
            }

            input[type="checkbox"] {
                width: 28px;
                height: 28px;
                accent-color: green;
                /* For modern browsers */
            }

            /* Fallback for browsers without accent-color support */
            input[type="checkbox"]:checked {
                background-color: green;
                border: none;
            }
        </style>
    </head>
    <div class="main-inner">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
            <div class="flex items-start flex-col gap-2">
                <h3 class="uppercase font-semibold">ORNAMENTS INVENTORY</h3>
            </div>
        </div>

        <div class="flex flex-col box dark:bg-bg3  justify-between mt-7 gap-5">
            <ul class="flex border-b  text-lg border-gray-200 bg-secondary/5 text-gray-800 rounded-t-lg overflow-hidden">
                <li>
                    <button class="tab-btn block px-4 py-2  font-medium rounded-t-lg transition-colors duration-300  hover:bg-gray-200 hover:text-500 text-primary font-bold"
                        onclick="showTab('overview', this)">
                        OVERVIEW
                    </button>
                </li>
                <li>
                    <button class="tab-btn block px-4 py-2  font-medium rounded-t-lg transition-colors duration-300 hover:bg-gray-200 hover:text-green-500 text-gray-800"
                        onclick="showTab('inventory', this)">
                        INVENTORY
                    </button>
                </li>
            </ul>
            <div id="overview" class="tab-content flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

                {{-- Mortgage Items --}}
                <div class="shadow rounded-lg overflow-x-auto mb-6">
                    <table class="w-full border-collapse">
                        <thead class="bg-secondary/5">
                            <tr>
                                <th colspan="6" class="text-center py-2 text-lg font-semibold text-gray-700 border-b">
                                    MORTGAGE ITEMS
                                </th>
                            </tr>
                            <tr class="text-gray-600 uppercase text-start">
                                <th class="px-2 py-1 border-b text-start">Type</th>
                                <th class="px-2 py-1 border-b text-start">Items Count</th>
                                <th class="px-2 py-1 border-b text-start">Gross Weight (gm)</th>
                                <th class="px-2 py-1 border-b text-start">Net Weight (gm)</th>
                                <th class="px-2 py-1 border-b text-start">Fine Weight (gm)</th>
                                <th class="px-2 py-1 border-b text-start">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mortgageItems ?? collect() as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-2 border-b">{{ $item->item_type }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->no_of_items }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->gross_weight }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->net_weight }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->fine_weight }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->total_value }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No Mortgage Items</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{-- mortgage_page pagination name already set in controller --}}
                        {{ $mortgageItems->links() }}
                    </div>
                </div>

                {{-- Released Items --}}
                <div class="bg-white shadow rounded-lg overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-secondary/5">
                            <tr>
                                <th colspan="6" class="text-center py-2 text-lg font-semibold text-gray-700 border-b">
                                    RELEASED ITEMS
                                </th>
                            </tr>
                            <tr class="text-gray-600 uppercase">
                                <th class="px-2 py-1 border-b">Type</th>
                                <th class="px-2 py-1 border-b">Items Count</th>
                                <th class="px-2 py-1 border-b">Gross Weight (gm)</th>
                                <th class="px-2 py-1 border-b">Net Weight (gm)</th>
                                <th class="px-2 py-1 border-b">Fine Weight (gm)</th>
                                <th class="px-2 py-1 border-b">Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($releasedItems ?? collect() as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-2 border-b">{{ $item->item_type }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->no_of_items }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->gross_weight }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->net_weight }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->fine_weight }}</td>
                                    <td class="px-2 py-2 border-b">{{ $item->total_value }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No Released Items</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $releasedItems->links() }}
                    </div>
                </div>

            </div>

            <div id="inventory" class="tab-content dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5 hidden">
                <div class="p-4 bg-white shadow rounded mb-5">
                    <form id="searchForm" method="GET" action="{{ route('gold-loan.ornaments.index') }}" class="space-y-4">
                     <div class="flex flex-col md:flex-row lg:flex-row gap-4">
                            
                            <!-- Application No -->
                            <div class="w-full">
                                <label class="block text-md font-medium text-gray-700 capitalize">
                                    Application No :
                                </label>
                                <input type="search" name="application_id" value="{{ request('application_id') }}"
                                    placeholder="Search Application No"
                                    class="mt-1 block w-full bg-secondary/5 rounded-10 border border-gray-300 px-3 py-3 text-sm dark:bg-bg3 shadow-sm">
                            </div>

                            <!-- Item Type -->
                            <div class="w-full">
                                <label class="block text-md font-medium text-gray-700 capitalize">
                                    Item Type :
                                </label>
                                <select name="item_type"
                                        class="mt-1 block w-full bg-secondary/5 rounded-10 border border-gray-300 px-3 py-3 text-sm dark:bg-bg3 shadow-sm">
                                    <option value="">Select Item Type</option>
                                    <option value="Gold Jewellery" {{ request('item_type') == 'Gold Jewellery' ? 'selected' : '' }}>Gold Jewellery</option>
                                    <option value="Gold Coin" {{ request('item_type') == 'Gold Coin' ? 'selected' : '' }}>Gold Coin</option>
                                    <option value="Gold Biscuit" {{ request('item_type') == 'Gold Biscuit' ? 'selected' : '' }}>Gold Biscuit</option>
                                    <option value="Silver Jewellery" {{ request('item_type') == 'Silver Jewellery' ? 'selected' : '' }}>Silver Jewellery</option>
                                    <option value="Silver Coin" {{ request('item_type') == 'Silver Coin' ? 'selected' : '' }}>Silver Coin</option>
                                    <option value="Silver Biscuit" {{ request('item_type') == 'Silver Biscuit' ? 'selected' : '' }}>Silver Biscuit</option>
                                    <option value="Platinum" {{ request('item_type') == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                    <option value="Diamond" {{ request('item_type') == 'Diamond' ? 'selected' : '' }}>Diamond</option>
                                    <option value="Stone" {{ request('item_type') == 'Stone' ? 'selected' : '' }}>Stone</option>
                                </select>
                            </div>

                            <!-- Item Name -->
                            <div class="w-full">
                                <label class="block text-md font-medium text-gray-700 capitalize">
                                    Item Name :
                                </label>
                                <input type="text" name="item_name" value="{{ request('item_name') }}"
                                    placeholder="Search Item Name" autocomplete="off"
                                    class="mt-1 block w-full bg-secondary/5 rounded-10 border border-gray-300 px-3 py-3 text-sm dark:bg-bg3 shadow-sm">
                            </div>

                            <!-- Status -->
                            <div class="w-full">
                                <label class="block text-md font-medium text-gray-700 capitalize">
                                    Status :
                                </label>
                                <select name="status"
                                        class="mt-1 block w-full bg-secondary/5 rounded-10 border border-gray-300 px-3 py-3 text-sm dark:bg-bg3 shadow-sm">
                                    <option value="">Select Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Mortgage</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Released</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap justify-center gap-3 pt-4">
                            <button type="submit"
                                class="flex items-center gap-2 btn-primary px-4 py-2 rounded shadow transition rounded-10">
                                <i class="las la-search text-lg"></i> SEARCH
                            </button>
                            <a href="{{ route('gold-loan.ornaments.index') }}" class="flex btn-outline rounded-10">
                                CLEAR FORM
                            </a>
                        </div>
                    </form>
                </div>

                <div class="block text-end mb-5">
                    <a href="{{ route('gold-loan.ornaments.export') }}" class="btn-primary rounded-10 uppercase">
                        <i class="las la-download"></i>
                        Download XLS
                    </a>
                </div>

                <div class="pb-4 overflow-x-auto lg:pb-6">
                    <div id="ornamentsTable">
                        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            APPLICATION NO
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            ITEM TYPE
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            ITEM NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            TOTAL ITEMS
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Value Per Gram (A)(INR)
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Gross Weight
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Net Weight (B) (gm)
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Tunch (C)(%)
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Fine Weight (D = C% of B) (gm)
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            TOTAL VALUE
                                            (A * D) (INR)
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            IMAGE
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            STATUS
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            REMARK
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            ACTIONS
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="ornamentsTable">
                                @include('gold-loan.ornaments.table', ['ornaments' => $ornaments])
                            </tbody>
                        </table>                    
                    </div>
                </div>
             </div>

          </div>

       </div>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Search Form submit hone par AJAX chalega
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        fetchData($(this).serialize());
    });

    // Pagination links ke liye bhi AJAX
    $(document).on('click', '#ornamentsTable .pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        fetchData(url.split('?')[1]);
    });

    // Function: Table reload with AJAX
    function fetchData(query) {
        $.ajax({
            url: "{{ route('gold-loan.ornaments.index') }}",
            data: query,
            success: function(data) {
                $('#ornamentsTable').html(data);
            }
        });
    }

});
</script>


    <script>

      function showTab(tabId, button) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Reset all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-primary', 'font-bold');
                btn.classList.add('text-gray-800');
            });

            // Show selected tab content
            document.getElementById(tabId).classList.remove('hidden');

            // Highlight active button
            button.classList.add('text-primary', 'font-bold');
            button.classList.remove('text-gray-800');
        }

    </script>
@endsection