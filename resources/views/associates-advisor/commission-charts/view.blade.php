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

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-2 lg:mb-8">
            <h3 class=" flex text-lg block  uppercase  font-semibold">
                Commission Chart - {{ $chart->chart_name }}
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class="box col-span-2 md:col-span-1">
                <div class="mb-3 flex justify-end">
                    <a href="{{ route('associates-advisor.commission-charts.edit', $chart->id) }}" class="btn-primary p-2 rounded-10">
                        <i class="las la-pencil-alt"></i>
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg ">

                    <table class="w-full whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 w-1/3 uppercase">Name</td>
                                <td class="px-4 py-3">{{ $chart->chart_name }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Chart Type</td>
                                <td class="px-4 py-3">{{ $chartTypeText }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Commission Type</td>
                                <td class="px-4 py-3">{{ $commissionTypeText }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Payout Type</td>
                                <td class="px-4 py-3">{{ strtoupper($chart->payout_type) }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-3 uppercase">Tenure (Months)</td>
                                <td class="px-4 py-3">{{ $chart->tenure_months }}</td>
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
                    <div class="overflow-x-auto rounded-lg shadow border border-gray-300">
                        <table class="w-full border-collapse border text-sm">
                            <thead class="bg-secondary/5 sticky top-0 z-10 border-b border-gray-300">
                                <tr>
                                    <th class="px-3 py-4 text-start font-semibold border-r border-gray-300">S. NO.</th>
                                    <th class="px-6 py-4 text-start font-semibold border-r border-gray-300">RANK / MONTH</th>

                                    @for($m=1; $m <= $chart->tenure_months; $m++)
                                        <th class="px-5 py-4 text-start font-semibold border-r border-gray-300">{{ $m }} M</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $months = $chart->tenure_months;
                                    $commissionSymbol = $chart->commission_type === 'inr' ? '₹' : '%';
                                    $autoTotals = array_fill(1, $months, 0);
                                @endphp

                                {{-- RANK ROWS --}}
                                @foreach($rankData as $rankId => $rankName)

                                    @php
                                        $rankEntry = $rankValues[$rankName][0] ?? [];
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition border-b border-gray-200">
                                        <td class="px-6 py-4 border border-gray-200">{{ $rankId }}</td>

                                        <td class="px-6 py-4 border border-gray-200 uppercase font-medium text-gray-700">
                                            {{ $rankName }}
                                        </td>

                                        @for($m = 1; $m <= $months; $m++)
                                            @php
                                                $value = isset($rankEntry[$m]) ? (float)$rankEntry[$m] : 0;
                                                $autoTotals[$m] += $value;
                                            @endphp

                                            <td class="px-6 py-4 border border-gray-200 text-gray-700">
                                                {{ $rankEntry[$m] ?? '' }}
                                            </td>
                                        @endfor
                                    </tr>

                                @endforeach

                                {{-- TOTAL ROW --}}
                                <tr class="bg-gray-100 font-semibold border-t border-gray-300">
                                    <td class="px-6 py-4 border border-gray-300">#</td>
                                    <td class="px-6 py-4 border border-gray-300 uppercase">TOTAL</td>

                                    @for($m = 1; $m <= $months; $m++)
                                        <td class="px-6 py-4 border border-gray-300">
                                            {{ $autoTotals[$m] }} {!! $commissionSymbol !!}
                                        </td>
                                    @endfor
                                </tr>

                                {{-- COLLECTION CHARGE ROW --}}
                                @if(isset($rankValues['Collection Charge']))

                                    @php
                                        $collection = $rankValues['Collection Charge'][0] ?? [];
                                    @endphp

                                    <tr class="bg-yellow-50 font-semibold border-t border-gray-300">
                                        <td class="px-6 py-4 border border-gray-300">#</td>
                                        <td class="px-6 py-4 border border-gray-300 uppercase">COLLECTION CHARGE</td>

                                        @for($m = 1; $m <= $months; $m++)
                                            <td class="px-6 py-4 border border-gray-300">
                                                {{ $collection[$m] ?? 0 }} {{ $commissionSymbol }}
                                            </td>
                                        @endfor
                                    </tr>

                                @endif
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