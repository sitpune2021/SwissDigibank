@extends('layout.main')
@section('page-title', 'PROMOTERS MANAGEMENT')

@section('action-button')
<a class="btn-primary uppercase btns-add-index" href="{{ route('promotor.create') }}" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
    ADD PROMOTER
</a>
@endsection

<style>

@keyframes fadeRow{
0%{
opacity:0;
transform:translateY(10px);
}
100%{
opacity:1;
transform:translateY(0);
}
}

.table-row{
animation:fadeRow .4s ease forwards;
}

/* hover animation */

.table-row:hover{
transform:scale(1.01);
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:all .25s ease;
}

</style>

@section('content')

<div class="box col-span-12 lg:col-span-6">
    
    <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
        
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
            
        </form>

        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
            <form method="GET" action="{{ route('promotor.index') }}"
                class="relative flex items-center gap-2 bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xl:max-w-[319px]">
                <input type="text" id="transaction-search" name="search" placeholder="Search"
                    value="{{ request('search') }}"
                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                <button type="submit"
                    class="w-7 h-7 bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
                @if (request('search'))
                <a href="{{ route('promotor.index') }}"
                    class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                    title="Clear Search">
                    <i class="las la-times text-lg"></i>
                </a>
                @endif
            </form>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

            <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            NAME
                        </div>
                    </th>
                    <th class="text-end !py-5 min-w-[100px] cursor-pointer" data-sortable="false">
                        <div class="text-start">
                            GENDER
                        </div>
                    </th>

                    <th class="text-start !py-5 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            SENIOR CTZ.
                        </div>
                    </th>
                    <th class="text-start !py-5 min-w-[130px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            ENROLLMENT DATE
                        </div>
                    </th>
                    <th class="text-start !py-5 cursor-pointer">
                        <div class="flex items-center gap-1">
                            KYC STATUS
                        </div>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promotors as $promotor)
               <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">

                            <!-- Icon (Blue) -->
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full">
                                <i class="las la-user text-blue-600"></i>
                            </div>

                            <!-- Name + Link -->
                            <div>
                                <a href="{{ $promotor?->id ? route('promotor.show', base64_encode($promotor->id)) : '#' }}"
                                class="block">

                                    <!-- Name (Green) -->
                                    <p class="font-semibold text-green-600 hover:text-green-700 transition">
                                        {{ trim(implode(' ', array_filter([$promotor->first_name,$promotor->middle_name,$promotor->last_name]))) }}
                                    </p>

                                    <!-- Customer No -->
                                    <p class="text-xs text-gray-400">
                                        CUSTOMER NO: {{ $promotor->folio_no }}
                                    </p>

                                </a>
                            </div>

                        </div>
                    </td>
                    <td class="text-start !py-5 min-w-[130px] cursor-pointer">
                        <span class="px-2">
                            {{ $promotor->gender ?? '' }}
                        </span>
                    </td>
                    <td class="py-2 px-3">
                        @if (($promotor->is_senior ?? '') === 'Yes')
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                            {{ $promotor->is_senior ?? 'No' }}
                        </span>
                        @endif
                    </td>
                    <td class="py-5 px-6">{{ $promotor->enrollment_date->format('d-m-Y') ?? '' }}</td>
                    <td class="py-2">
                        @if (optional($promotor->kyc)->kyc_status == 'completed')
                        <span
                            class="text-primary uppercase">
                            {{ optional($promotor->kyc)->kyc_status ?? 'N/A' }}
                        </span>
                        @else
                        <span style=""
                            class="text-warning uppercase">
                            {{ optional($promotor->kyc)->kyc_status ?? 'N/A' }}
                        </span>
                        @endif
                    </td>
                    <td class="py-2 px-6">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => base64_encode($promotor->id),
                            'viewRoute' => 'promotor.show',
                            'editRoute' => 'promotor.edit',
                            'deleteRoute' => 'promotor.destroy',
                            ])
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        
    </div>
    
    <div class="mt-4">
        <x-pagination :paginator="$promotors"/>
    </div>

</div>
@endsection