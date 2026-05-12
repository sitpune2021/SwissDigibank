@extends('layout.main')

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

<style>
/* =========================
    ACTION BUTTONS
========================= */

.action-btn{

    height:36px;
    min-width:82px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:0 12px;

    border-radius:10px;

    font-size:13px;
    font-weight:600;

    color:#fff;

    transition:.25s ease;
}

.action-btn:hover{
    transform:translateY(-1px);
}

/* VIEW */

.action-view{
    background:linear-gradient(135deg,#2563eb,#06b6d4);
}

/* EDIT */

.action-edit{
    background:linear-gradient(135deg,#f59e0b,#f97316);
}

/* MOBILE */

@media(max-width:768px){

    .action-btn{

        min-width:70px;
        height:32px;

        padding:0 10px;

        font-size:12px;

        border-radius:8px;
    }
}
</style>

<style>

/* =========================
    PAGE ENTRY ANIMATION
========================= */

@keyframes pageReveal{

    0%{
        opacity:0;
        transform:scale(.985) translateY(16px);
        filter:blur(8px);
    }

    60%{
        opacity:1;
        transform:scale(1.005) translateY(-2px);
        filter:blur(0);
    }

    100%{
        opacity:1;
        transform:scale(1) translateY(0);
        filter:blur(0);
    }
}

/* MAIN BOX PREMIUM EFFECT */

.bank-page-animate{

    animation:pageReveal .75s cubic-bezier(.22,1,.36,1);

    transform-origin:top center;
}

/* =========================
    TABLE POPUP EFFECT
========================= */

@keyframes popupRow{

    0%{
        opacity:0;
        transform:perspective(1000px) rotateX(-12deg) translateY(18px);
    }

    100%{
        opacity:1;
        transform:perspective(1000px) rotateX(0deg) translateY(0);
    }
}

.table-row{

    opacity:0;

    animation:popupRow .55s cubic-bezier(.22,1,.36,1) forwards;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}

/* PREMIUM HOVER */

.table-row:hover{

    transform:translateY(-3px) scale(1.004);

    box-shadow:
        0 10px 24px rgba(15,23,42,.08),
        0 4px 10px rgba(59,130,246,.08);

    background:#fcfdff;
}

/* =========================
    TABLE WRAPPER GLASS EFFECT
========================= */

.table-premium{

    position:relative;

    overflow:hidden;

    border-radius:24px;

    background:
        linear-gradient(
            180deg,
            rgba(255,255,255,.95),
            rgba(248,250,252,.96)
        );

    border:1px solid rgba(226,232,240,.9);

    box-shadow:
        0 10px 30px rgba(15,23,42,.06),
        inset 0 1px 0 rgba(255,255,255,.7);
}

/* TOP SHINE EFFECT */

.table-premium::before{

    content:"";

    position:absolute;

    top:0;
    left:-120%;

    width:60%;
    height:100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.45),
            transparent
        );

    transform:skewX(-25deg);

    animation:shineMove 4.5s infinite;
}

@keyframes shineMove{

    100%{
        left:150%;
    }
}

/* =========================
    HEADER ANIMATION
========================= */

thead tr{

    animation:headerDrop .5s ease;
}

@keyframes headerDrop{

    from{
        opacity:0;
        transform:translateY(-10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* =========================
    MOBILE OPTIMIZATION
========================= */

@media(max-width:768px){

    .bank-page-animate{
        animation-duration:.55s;
    }

    .table-row:hover{
        transform:none;
    }

    .table-premium{
        border-radius:18px;
    }
}

</style>

@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
        
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
          
        </form>

        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
            <form action="{{ route('shareholding.index') }}"
                class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] ">
                <input type="text" name="search" id="transaction-search" placeholder="Search"
                    value="{{ request('search') }}"
                    class="bg-transparent  border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                <button
                    class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
                @if (request('search'))
                <a href="{{ route('shareholding.index') }}"
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

    <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

        <table class="w-full whitespace-nowrap overflow-x-auto  select-all-table " id="transactionTable1">
            
            <thead class="bg-gradient-to-r from-amber-50 via-white to-amber-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-[11px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-gray-700">

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
                @if(in_array('shareholding.transfer', $permissions))
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