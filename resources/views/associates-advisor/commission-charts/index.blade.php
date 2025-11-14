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

        @if(session('success'))
            <div 
                id="successMessage" 
                class="max-w-md mx-auto mt-4 bg-green-100 border border-green-300 text-green-800 text-center px-4 py-3 rounded-lg shadow-md transition-opacity duration-500 ease-in-out"
            >
                {{ session('success') }}
            </div>

            <script>
                // Auto hide after 30 seconds (30000 ms)
                setTimeout(() => {
                    const msg = document.getElementById('successMessage');
                    if (msg) {
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500); // smooth fade-out
                    }
                }, 30000);
            </script>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Commission Charts
            </h3>
            <div class="flex flex-col md:flex-row  lg:flex-row gap-3">
                <a href="{{ route('associates-advisor.commission-charts.add-chart') }}" class=" block flex btn-primary justify-center uppercase ">
                    add
                </a>

            </div>

        </div>
        <div class="col-span-12 box lg:col-span-12">


            <div class="tab-content p-4">
                <!-- Tab 1 -->
                <div id="tab1" class="tab-pane block">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            NAME	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                          TYPE
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            TENURE (MONTHS)	
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                           ACTIONS
                                        </div>
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($charts as $chart)
                                <tr class="border-b">

                                    {{-- NAME --}}
                                    <td class="text-start !py-5 px-6 min-w-[100px]">
                                        <div class="flex items-center gap-1 uppercase">
                                            <a href="{{ route('associates-advisor.commission-charts.view', $chart->id) }}" class="text-primary">
                                                {{ $chart->chart_name }}
                                            </a>
                                        </div>
                                    </td>

                                    {{-- TYPE --}}
                                    <td class="text-start !py-5 px-6 min-w-[100px]">
                                        <div class="flex items-center gap-1 Capitalize">
                                            {{ $chart->chart_type }}
                                        </div>
                                    </td>

                                    {{-- TENURE (MONTHS) --}}
                                    <td class="text-start !py-5 px-6 min-w-[100px]">
                                        <div class="flex items-center gap-1">
                                            {{ $chart->tenure_months }}
                                        </div>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-start !py-5 px-6 min-w-[100px]">
                                        <div class="flex items-center gap-1">
                                            <div class="relative">
                                                <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                                <ul class="horiz-option popover-content">
                                                    <li><a href="{{ route('associates-advisor.commission-charts.view', $chart->id) }}" class="single-option uppercase">View</a></li>
                                                    <li><a href="{{ route('associates-advisor.commission-charts.edit', $chart->id) }}" class="single-option uppercase">Edit</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
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