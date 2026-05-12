@extends('layout.main')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT TITLE AREA -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div
            class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0"
            style="
                background: linear-gradient(135deg,#f59e0b,#dc2626);
                box-shadow:
                    0 8px 20px rgba(239,68,68,.25),
                    inset 0 1px 0 rgba(255,255,255,.35);
            "
        >

            <i class="las la-users text-white text-xl sm:text-2xl"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Promoters Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage promoters details, shares & records

            </p>

        </div>

    </div>

    <!-- RIGHT BADGE -->
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
    @if($isSuperAdmin || in_array('branch.create', $permissions))
        <a href="{{ route('promotor.create') }}"
            class="inline-flex items-center gap-2
            px-4 sm:px-5 py-2.5
            rounded-xl text-xs sm:text-sm font-bold uppercase
            shadow-lg transition-all duration-300 hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

            <span>Add Promoter</span>
        </a>
    @endif
@endsection

<style>

/* =========================
    TABLE ROW ANIMATION
========================= */

@keyframes fadeRow{
    from{
        opacity:0;
        transform:translateY(10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.table-row{
    animation:fadeRow .4s ease forwards;
    transition:.25s ease;
}

.table-row:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(0,0,0,.06);
}

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

.action-view{
    background:linear-gradient(135deg,#2563eb,#06b6d4);
}

.action-edit{
    background:linear-gradient(135deg,#f59e0b,#f97316);
}

.action-delete{
    background:linear-gradient(135deg,#ef4444,#dc2626);
}

/* DELETE FORM FIX */

.delete-form{
    margin:0 !important;
    display:flex;
    align-items:center;
}

/* =========================
    MOBILE RESPONSIVE TABLE
========================= */

@media(max-width:768px){

    .box{
        padding:0 !important;
        background:transparent !important;
        box-shadow:none !important;
    }

    /* TABLE SCROLL */
    .table-wrapper{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;

        border-radius:18px;
    }

    /* TABLE WIDTH */
    #transactionTable1{
        min-width:950px;
        width:100%;
        border-collapse:collapse;
    }

    /* HEADINGS */
    #transactionTable1 thead th{

        font-size:11px !important;

        padding:14px 12px !important;

        white-space:nowrap;
    }

    /* TABLE DATA */
    #transactionTable1 tbody td{

        padding:14px 12px !important;

        white-space:nowrap;

        font-size:13px;
    }

    /* PROMOTER NAME */
    #transactionTable1 tbody td:first-child{

        min-width:260px;
    }

    /* ACTION BUTTONS */
    .action-group{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;

        flex-wrap:nowrap;
    }

    .action-btn{

        min-width:78px;
        height:34px;

        padding:0 10px;

        font-size:12px;

        border-radius:10px;
    }

    /* SEARCH */
    .search-box,
    form{
        width:100% !important;
        max-width:100% !important;
    }

    /* REMOVE HOVER */
    .table-row:hover{
        transform:none;
        box-shadow:none;
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

    <div class="mb-3">
        <x-searchbox />
    </div>

    <!-- TABLE -->
    <div class="table-wrapper w-full overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm table-premium">

        <table class="w-full" id="transactionTable1">

            <!-- TABLE HEAD -->
            <thead class="bg-gradient-to-r from-slate-100 via-white to-slate-100 border-b border-gray-200">

                <tr class="text-[11px] sm:text-xs lg:text-sm uppercase tracking-wider font-bold text-black">

                    <!-- PROMOTER -->
                    <th class="px-3 sm:px-5 py-4 text-left whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">

                                <i class="las la-user text-primary text-sm sm:text-base"></i>

                            </div>

                            <span>Promoter Name</span>

                        </div>

                    </th>

                    <!-- GENDER -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-pink-100 flex items-center justify-center shrink-0">

                                <i class="las la-venus-mars text-pink-600 text-sm sm:text-base"></i>

                            </div>

                            <span>Gender</span>

                        </div>

                    </th>

                    <!-- SENIOR -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">

                                <i class="las la-user-shield text-yellow-600 text-sm sm:text-base"></i>

                            </div>

                            <span>Senior Citizen</span>

                        </div>

                    </th>

                    <!-- ENROLLMENT -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">

                                <i class="las la-calendar text-blue-600 text-sm sm:text-base"></i>

                            </div>

                            <span>Enrollment Date</span>

                        </div>

                    </th>

                    <!-- KYC -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center shrink-0">

                                <i class="las la-id-card text-green-600 text-sm sm:text-base"></i>

                            </div>

                            <span>KYC Status</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="px-3 sm:px-5 py-4 text-center whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">

                                <i class="las la-cogs text-gray-700 text-sm sm:text-base"></i>

                            </div>

                            <span>Actions</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($promotors as $promotor)

                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- NAME -->
                    <td class="px-5 py-4" data-label="Promoter">

                        <div class="flex items-center gap-3">

                            <!-- NAME + CUSTOMER NO IN SINGLE LINE -->
                            <div class="flex flex-col">

                                <a href="{{ route('promotor.show', base64_encode($promotor->id)) }}"
                                    class="font-semibold text-primary hover:underline text-sm sm:text-base">

                                    {{ trim(implode(' ', array_filter([
                                        $promotor->first_name,
                                        $promotor->middle_name,
                                        $promotor->last_name
                                    ]))) }}

                                    <span class="text-gray-500 font-medium ml-2">
                                        | Customer No: {{ $promotor->folio_no }}
                                    </span>

                                </a>

                            </div>

                        </div>

                    </td>

                    <!-- GENDER -->
                    <td class="px-5 py-4 text-center"
                        data-label="Gender">

                        {{ $promotor->gender ?? '-' }}

                    </td>

                    <!-- SENIOR -->
                    <td class="px-5 py-4 text-center"
                        data-label="Senior Citizen">

                        @if(($promotor->is_senior ?? '') === 'Yes')

                        <span class="px-4 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                            Yes
                        </span>

                        @else

                        <span class="px-4 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                            No
                        </span>

                        @endif

                    </td>

                    <!-- ENROLLMENT -->
                    <td class="px-5 py-4 text-center"
                        data-label="Enrollment Date">

                        {{ $promotor->enrollment_date ? \Carbon\Carbon::parse($promotor->enrollment_date)->format('d-m-Y') : '-' }}

                    </td>

                    <!-- KYC -->
                    <td class="px-5 py-4 text-center"
                        data-label="KYC Status">

                        @if(optional($promotor->kyc)->kyc_status == 'completed')

                        <span class="uppercase text-primary font-semibold">
                            Completed
                        </span>

                        @else

                        <span class="uppercase text-warning font-semibold">
                            {{ optional($promotor->kyc)->kyc_status ?? 'Pending' }}
                        </span>

                        @endif

                    </td>

                    <!-- ACTION -->
                    <td class="px-5 py-4 text-center align-middle"
                        data-label="Actions">

                        <div class="flex items-center justify-center gap-2 action-group">

                            <!-- VIEW -->
                            @if($isSuperAdmin || in_array('promotor.show', $permissions))
                            <a href="{{ route('promotor.show', base64_encode($promotor->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>

                            </a>
                            @endif

                            <!-- EDIT -->
                            @if($isSuperAdmin || in_array('promotor.edit', $permissions))
                            <a href="{{ route('promotor.edit', base64_encode($promotor->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit"></i>
                                <span>EDIT</span>

                            </a>
                            @endif

                            <!-- DELETE -->
                            @if(in_array('promotor.destroy', $permissions))
                            <form action="{{ route('promotor.destroy', base64_encode($promotor->id)) }}"
                                method="POST"
                                class="delete-form"
                                onsubmit="return confirm('Delete this promoter?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="action-btn action-delete">

                                    <i class="las la-trash"></i>
                                    <span>DELETE</span>

                                </button>

                            </form>
                            @endif

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="py-10 text-center text-gray-500">

                        No promoter records found.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="mt-5">
        <x-pagination :paginator="$promotors"/>
    </div>

</div>

@endsection