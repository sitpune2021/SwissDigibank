@extends('layout.main')


@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
   @if($isSuperAdmin || in_array('users.create', $permissions))
        <a href="{{route('users.create')}}"
            class="px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition-all duration-200
            hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
            ADD USER
        </a>
    @endif
@endsection

@section('page-title')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <!-- LEFT SIDE -->
        <div class="flex items-center gap-3">

            <!-- ICON BOX -->
            <div
                class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0"
                style="
                    background: linear-gradient(135deg,#06b6d4,#2563eb);
                    box-shadow:
                        0 8px 18px rgba(37,99,235,.28),
                        inset 0 1px 0 rgba(255,255,255,.35);
                "
            >

                <i class="las la-code-branch text-white text-[22px]"></i>

            </div>

            <!-- TITLE -->
            <div>

                <h2 class="text-xl sm:text-2xl font-extrabold uppercase tracking-wide
                    text-gray-800 leading-tight">

                    USER MANAGEMENT

                </h2>

                <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">

                    Manage all user, status & operations

                </p>

            </div>

        </div>

        <!-- RIGHT SIDE OPTIONAL BADGE -->
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

@section('content')

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

/* =========================
    TABLE ROW ANIMATION
========================= */

.table-row{

    position: relative;

    opacity: 0;

    transform: translateY(18px) scale(.98);

    animation: rowReveal .65s cubic-bezier(.22,1,.36,1) forwards;

    will-change: transform, opacity;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background-color .25s ease;
}

@keyframes rowReveal{

    0%{
        opacity:0;
        transform:translateY(22px) scale(.96);
    }

    60%{
        opacity:1;
        transform:translateY(-2px) scale(1.01);
    }

    100%{
        opacity:1;
        transform:translateY(0) scale(1);
    }
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
    TABLE WRAPPER PREMIUM
========================= */

.table-premium{

    position: relative;

    overflow-x: auto;
    overflow-y: visible;

    border-radius: 24px;

    background:
        linear-gradient(
            180deg,
            rgba(255,255,255,.95),
            rgba(248,250,252,.96)
        );

    border: 1px solid rgba(226,232,240,.9);

    box-shadow:
        0 10px 30px rgba(15,23,42,.06),
        inset 0 1px 0 rgba(255,255,255,.7);

    -webkit-overflow-scrolling: touch;
}

/* TABLE FIX */

.select-all-table{

    width: 100%;
    min-width: 950px;

    border-collapse: separate;
    border-spacing: 0 10px;
}

/* =========================
    PREMIUM ROW ANIMATION
========================= */

.table-row{

    opacity: 0;

    transform: perspective(1000px)
               rotateX(-10deg)
               translateY(18px)
               scale(.98);

    animation: popupRow .65s cubic-bezier(.22,1,.36,1) forwards;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background .25s ease;

    will-change: transform, opacity;
}

@keyframes popupRow{

    0%{
        opacity:0;
        transform:
            perspective(1000px)
            rotateX(-10deg)
            translateY(22px)
            scale(.96);
    }

    60%{
        opacity:1;
        transform:
            perspective(1000px)
            rotateX(2deg)
            translateY(-2px)
            scale(1.01);
    }

    100%{
        opacity:1;
        transform:
            perspective(1000px)
            rotateX(0)
            translateY(0)
            scale(1);
    }
}

/* PREMIUM HOVER */

.table-row:hover{

    transform:
        translateY(-4px)
        scale(1.01);

    box-shadow:
        0 14px 30px rgba(15,23,42,.10),
        0 6px 14px rgba(59,130,246,.10);

    background:
        linear-gradient(
            180deg,
            #ffffff,
            #f8fbff
        );
}

/* TABLE CELL STYLE */

.table-row td{

    background: white;

    padding-top: 16px;
    padding-bottom: 16px;

    border-top: 1px solid #edf2f7;
    border-bottom: 1px solid #edf2f7;
}

/* FIRST CELL */

.table-row td:first-child{

    border-left: 1px solid #edf2f7;

    border-top-left-radius: 18px;
    border-bottom-left-radius: 18px;
}

/* LAST CELL */

.table-row td:last-child{

    border-right: 1px solid #edf2f7;

    border-top-right-radius: 18px;
    border-bottom-right-radius: 18px;
}

/* =========================
    ACTION BUTTON FIX
========================= */

.action-btn{

    height: 38px;

    min-width: 88px;

    padding: 0 14px;

    flex-shrink: 0;

    white-space: nowrap;

    border-radius: 12px;

    font-size: 13px;
    font-weight: 700;

    transition: .25s ease;
}

.action-btn:hover{

    transform: translateY(-2px) scale(1.03);
}

/* =========================
    MOBILE RESPONSIVE
========================= */

@media(max-width:768px){

    .table-premium{

        border-radius: 18px;
    }

    .select-all-table{

        min-width: 780px;
    }

    .table-row:hover{

        transform:none;
    }

    .action-btn{

        min-width: 74px;

        height: 34px;

        padding: 0 10px;

        font-size: 12px;

        border-radius: 10px;
    }

    thead th{

        font-size: 11px;
    }
}

</style>


    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6 bank-page-animate">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6"
            style="flex-direction: row-reverse;">
            <x-alert />
        </div>

        <div class="overflow-x-auto table-premium">

            <table class="select-all-table" id="transactionTable1">

                <thead class="sticky top-0 z-10 bg-white dark:bg-bg3 border-b border-gray-200 dark:border-gray-700 shadow-sm">

                    <tr class="text-[11px] md:text-xs lg:text-sm font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-200">

                        <!-- USER NAME -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[180px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-user-circle text-base text-primary"></i>

                                <span>USER NAME</span>

                            </div>

                        </th>

                        <!-- EMAIL -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[220px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-envelope text-base text-blue-600"></i>

                                <span>EMAIL</span>

                            </div>

                        </th>

                        <!-- CONTACT -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[150px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-phone text-base text-green-600"></i>

                                <span>CONTACT</span>

                            </div>

                        </th>

                        <!-- ACTIVE -->
                        <th class="text-start py-4 px-3 md:px-5 min-w-[120px]">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                <i class="las la-toggle-on text-base text-emerald-600"></i>

                                <span>ACTIVE</span>

                            </div>

                        </th>

                        <!-- ACTION -->
                        <th class="text-center py-4 px-3 md:px-5 min-w-[130px]">

                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                <i class="las la-cogs text-base text-red-500"></i>

                                <span>ACTION</span>

                            </div>

                        </th>

                    </tr>

                </thead>

                <tbody>
                    @forelse ($users as $index => $user)
                    <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                        style="animation-delay: {{ $loop->index * 0.05 }}s">

                        <td class="px-3 py-2">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-green-800">
                                    {{ $user->fname }} {{ $user->lname }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4  ">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->mobile ?? 'N/A' }}</td>
                        {{-- <td class="px-6 py-4">{{ $user->user_active ?? 'N/A' }}</td> --}}
                        <td class="px-6 py-4 ">
                            @if ($user->user_active == 1)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>

                            @elseif ($user->user_active == 0)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                            @else
                            N/A
                            @endif
                        </td>
                         <td class="px-4 py-3 text-center">

                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                <!-- VIEW -->
                                @if($isSuperAdmin || in_array('users.show', $permissions))
                                <a href="{{ route('users.show', base64_encode($user->id)) }}"
                                    class="action-btn action-view">

                                    <i class="las la-eye text-sm"></i>

                                    <span>View</span>

                                </a>
                                @endif

                                <!-- EDIT -->
                                @if($isSuperAdmin || in_array('users.edit', $permissions))
                                <a href="{{ route('users.edit', base64_encode($user->id)) }}"
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="mt-3">
            <x-pagination :paginator="$users" />
        </div>

    </div>

</div>

@endsection