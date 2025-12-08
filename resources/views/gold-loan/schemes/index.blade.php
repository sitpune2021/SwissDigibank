@extends('layout.main')
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
                <h1 class=" flex text-xl block font-semibold">GOLD LOAN SCHEMES</h1>
                <a href="{{route('gold-loan.schemes.create')}}" class=" block flex btn-primary uppercase ">Add
                </a>
            </div>  


        <div class="col-span-12 box lg:col-span-12">

            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    SCHEME CODE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    SCHEME NAME
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    TENURE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    MAX. LOAN AMOUNT
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    INTEREST TYPE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A. INTEREST RATE (%)
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACTIVE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACTIONS
                                </div>
                            </th>

                        </tr>
                    </thead>

                   <tbody>
                        @forelse($schemes as $scheme)
                            <tr class="dark:even:bg-bg3 border-b">
                                <td class="text-start !py-5 px-6">
                                    <div class="flex items-center gap-1 text-secondary uppercase">
                                        <a href="{{ route('gold-loan.schemes.view', $scheme->id) }}" class="single-option text-green-600 hover:text-green-800 transition">
                                            {{ $scheme->scheme_code }}
                                        </a>
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6 capitalize">
                                    <div class="flex items-center gap-1">
                                        {{ $scheme->scheme_name }}
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6">
                                    <div class="flex items-center gap-1">
                                        {{ $scheme->tenure }} Months
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6">
                                    <div class="flex items-center gap-1">
                                        {{ number_format($scheme->max_loan_amount, 2) }}
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6">
                                    <div class="flex items-center gap-1 capitalize">
                                        {{ str_replace('_',' ', $scheme->gold_loan_setting) }}
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6">
                                    <div class="flex items-center gap-1">
                                        {{ $scheme->annual_interest_rate }} %
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6">
                                    <div class="flex items-center gap-1">
                                        @if($scheme->is_active)
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                                No
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-start !py-5 px-6">
                                    <div class="flex justify-center">
                                        <div class="relative">
                                            <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li><a href="{{ route('gold-loan.schemes.view',$scheme->id) }}" class="single-option">View</a></li>
                                                <li><a href="{{ route('gold-loan.schemes.edit',$scheme->id) }}" class="single-option">Edit</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">No Schemes Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>


            </div>

            <div class="mt-4">
                <x-pagination :paginator="$schemes" />
            </div>

</div>

@endsection