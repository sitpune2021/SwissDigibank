@extends('layout.main')
@extends('layout.tablestyle')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl
            flex items-center justify-center shrink-0
            shadow-lg"
            style="
                background: linear-gradient(135deg,#facc15,#f97316,#dc2626);
                min-width: 44px;
                min-height: 44px;
            ">

            <i class="las la-chart-pie text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight">

                Promoters Share Holding Details

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage allocated shares, holdings & ownership records

            </p>

        </div>

    </div>

    <!-- RIGHT SIDE BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
    @if($isSuperAdmin || in_array('shareholding.create', $permissions))
        <a href="{{ route('shareholding.create') }}"
            class="inline-flex items-center gap-2
            px-4 sm:px-5 py-2.5
            rounded-xl text-xs sm:text-sm font-bold uppercase
            shadow-lg transition-all duration-300 hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

            <span>Allocate Share</span>

        </a>
    @endif
@endsection

@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <div class="mb-3">
        <x-searchbox />
    </div>

    <!-- TABLE -->
    <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">

        <table class="w-full whitespace-nowrap overflow-x-auto  select-all-table " id="transactionTable1">
            
            <thead class="bg-gradient-to-r from-amber-50 via-white to-amber-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-[11px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-gray-700">

                    <!-- SR NO -->
                    <th class="px-3 sm:px-5 py-4 text-center min-w-[90px]">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-hashtag text-sm sm:text-base text-black"></i>
                            </div>

                            <span class="text-black whitespace-nowrap">SR NO</span>

                        </div>

                    </th>

                    <!-- PROMOTERS -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <i class="las la-users text-blue-600 text-sm"></i>
                            </div>

                            <span>PROMOTERS</span>

                        </div>

                    </th>

                    <!-- FIRST DISTINCTIVE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                                <i class="las la-sort-numeric-up text-green-600 text-sm"></i>
                            </div>

                            <span>FIRST DISTINCTIVE NO.</span>

                        </div>

                    </th>

                    <!-- LAST DISTINCTIVE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                <i class="las la-sort-numeric-down text-red-600 text-sm"></i>
                            </div>

                            <span>LAST DISTINCTIVE NO.</span>

                        </div>

                    </th>

                    <!-- TOTAL SHARE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[200px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">
                                <i class="las la-chart-pie text-yellow-600 text-sm"></i>
                            </div>

                            <span>TOTAL SHARES HELD</span>

                        </div>

                    </th>

                    <!-- NOMINAL VALUE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[200px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                                <i class="las la-coins text-purple-600 text-sm"></i>
                            </div>

                            <span>SHARE NOMINAL VAL.</span>

                        </div>

                    </th>

                    <!-- TOTAL VALUE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[180px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0">
                                <i class="las la-wallet text-cyan-600 text-sm"></i>
                            </div>

                            <span>TOTAL VAL.</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="text-center py-4 px-3 sm:px-5 min-w-[150px] whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-cog text-gray-700 text-sm"></i>
                            </div>

                            <span>ACTION</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>
                @forelse($share_holdings as $index => $share)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">

                    <!-- SR NO -->
                    <td class="px-6 py-5 text-center font-semibold text-gray-700">

                        {{ $loop->iteration }}

                    </td>
                    
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">

                            <div>
                                <a href="{{ $share?->promotor?->id ? route('promotor.show', base64_encode($share->promotor->id)) : '#' }}"
                                class="font-semibold text-green-600 hover:text-green-700 transition">

                                    {{ $share->promotor->first_name }} {{ $share->promotor->last_name }}
                                </a>

                                <p class="text-xs text-gray-400">
                                    CUSTOMER NO: 000{{ $share->promotor->id }}
                                </p>
                            </div>

                        </div>
                    </td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->first_share }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->share_no }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->total_share_held ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->nominal_value ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->total_share_value ?? '-' }}</td>
                    <!-- <td class="px-6 py-4">{{ \Carbon\Carbon::parse($share->allotment_date)->format('d-m-Y') }}</td> -->
                    <td class="px-4 py-3 text-center">

                        <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('shareholding.show', $permissions))
                            <a href="{{ route('shareholding.show', base64_encode($share->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye text-sm"></i>

                                <span>View</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if($isSuperAdmin || in_array('shareholding.edit', $permissions))
                            <a href="{{ route('shareholding.edit', base64_encode($share->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit text-sm"></i>

                                <span>Edit</span>

                            </a>
                            @endif

                        </div>

                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">No records found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        <x-pagination :paginator="$share_holdings"/>
    </div>

</div>

<div class="flex items-center mt-5 justify-center gap-4 xxl:gap-6">
    <div class="col-span-12 lg:col-span-7 xxl:col-span-8">
        <div class="box xl:p-8">
            <h4 class="h4 bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                Select Promoter who's Shares need to split for New Membership Registrations
            </h4>
            @php
            $field = [
            'dynamic' => true,
            'options_key' => 'promoter',
            ];
            $name = 'is_transfer'; 
            @endphp
            <form action="{{ route('shareholding.transfer') }}" method="POST" class="flex items-center justify-center gap-4 xl:gap-6">
                @csrf
                @include('fields.inputs', [
                'id' => 'transfer',
                'label' => 'Promoter',
                'required' => true,
                'type' => 'select',
                'name' => $name,
                'value' => isset($transfoer) ? $transfoer->id : '',
                'field' => $field,
                ])

                @error($name)
                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
                @if($isSuperAdmin || in_array('shareholding.transfer', $permissions))
                <button class="btn-primary rounded-10 " type="submit"> UPDATE </button>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionTable1').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100]
        });
    });
</script>
<script>
    document.getElementById('transaction-search').addEventListener('input', function() {
        if (this.value === '') {
            this.form.submit();
        }
    });
</script>
@endpush