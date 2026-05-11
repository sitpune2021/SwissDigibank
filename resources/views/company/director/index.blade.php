@extends('layout.main')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl
            flex items-center justify-center shrink-0 shadow-lg"
            style="
                background: linear-gradient(135deg,#2563eb,#06b6d4,#0ea5e9);
                min-width:44px;
                min-height:44px;
            ">

            <i class="las la-user-tie text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                Directors Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage directors, appointments & signatory details

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


@section('action-button')

<a href="{{ route('director.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5
    rounded-xl text-xs sm:text-sm font-bold uppercase
    shadow-lg transition-all duration-300 hover:scale-105"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

    <span>Add Director</span>

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

    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">

            <thead class="bg-gradient-to-r from-orange-50 via-white to-orange-50 border-b border-gray-200 sticky top-0 z-10">

                <tr class="text-[11px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-gray-700">

                    <!-- CUSTOMER NAME -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <i class="las la-user text-blue-600 text-sm"></i>
                            </div>

                            <span>Customer Name</span>

                        </div>

                    </th>

                    <!-- NAME -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[200px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-cyan-100 flex items-center justify-center shrink-0">
                                <i class="las la-user-tie text-cyan-600 text-sm"></i>
                            </div>

                            <span>DIRECTOR NAME</span>

                        </div>

                    </th>

                    <!-- DIN -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[140px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">
                                <i class="las la-id-card text-yellow-600 text-sm"></i>
                            </div>

                            <span>DIN</span>

                        </div>

                    </th>

                    <!-- APPOINTMENT DATE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[210px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                                <i class="las la-calendar-plus text-green-600 text-sm"></i>
                            </div>

                            <span>Appointment Date</span>

                        </div>

                    </th>

                    <!-- RESIGNATION DATE -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[210px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                <i class="las la-calendar-times text-red-600 text-sm"></i>
                            </div>

                            <span>Resignation Date</span>

                        </div>

                    </th>

                    <!-- AUTHORIZED SIGNATORY -->
                    <th class="text-start py-4 px-3 sm:px-5 min-w-[220px] whitespace-nowrap">

                        <div class="flex items-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
                                <i class="las la-signature text-indigo-600 text-sm"></i>
                            </div>

                            <span>Authorized Signatory</span>

                        </div>

                    </th>

                    <!-- ACTION -->
                    <th class="text-center py-4 px-3 sm:px-5 min-w-[150px] whitespace-nowrap">

                        <div class="flex items-center justify-center gap-2">

                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-cogs text-gray-700 text-sm"></i>
                            </div>

                            <span>Action</span>

                        </div>

                    </th>

                </tr>

            </thead>

            <tbody>
                @forelse ($directors as $index => $director)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <!-- {{-- <td class="px-6 py-4">{{ $director->member?->member_info_first_name ?? 'N/A' }}</td> --}} -->
                    <td class="px-4 py-3">
                        @if ($director->member)
                        <div class="flex items-center gap-2">

                            <div>
                                <a href="{{ route('member.show', $director->member->id) }}"
                                class="text-green-600 font-medium hover:underline">
                                    {{ $director->member->member_info_first_name }} {{ $director->member->member_info_last_name }}
                                </a>
                            </div>

                        </div>
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ $director?->id ? route('director.show', base64_encode($director->id)) : '#' }}" class="text-primary  hover:underline">
                            {{ $director?->director_name ?? '' }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-1">
                             {{ $director?->din_no??'' }}
                        </span>
                       
                    </td>
                    <td class="px-6 py-4">
                    <span class="px-2">
                        {{ $director->appointment_date?->format('d-m-Y') ?? 'N/A' }}
                    </span>
                    </td>
                    <td class="px-6 py-4">
                       <span class="px-2">
                         {{ $director->resignation_date?->format('d-m-Y') ?? 'N/A' }}
                       </span>
                    </td>
                    <!-- <td class="px-6 py-4">{{ $director->authorized_signatory ? 'Yes' : 'No' }}</td> -->
                    <td class="py-2 px-6">
                        @if ($director->authorized_signatory == 'Yes')
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                            Yes
                        </span>
                        @else
                        <span
                            class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                            {{ $director->authorized_signatory }}
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">

                        <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                            <!-- VIEW -->
                            <a href="{{ route('director.show', base64_encode($director->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye text-sm"></i>

                                <span>View</span>

                            </a>

                            <!-- EDIT -->
                            <a href="{{ route('director.edit', base64_encode($director->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit text-sm"></i>

                                <span>Edit</span>

                            </a>

                        </div>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">No record found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        <x-pagination :paginator="$directors"/>
    </div>

</div>
@endsection