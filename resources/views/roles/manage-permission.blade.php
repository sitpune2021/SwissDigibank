@extends('layout.main')

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
   @if($isSuperAdmin || in_array('roles.create', $permissions))
        <a href="{{ route('roles.create') }}"
            class="px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition-all duration-200
            hover:scale-105"
            style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
            ALLOW PERMISSION
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

                    PERMISSIONS / ROLES

                </h2>

                <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">

                    Manage all role, status & operations

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

<div class="col-span-12 box lg:col-span-6 bank-page-animate">

    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

        <table class="w-full whitespace-nowrap select-all-table border-separate border-spacing-y-2"
            id="transactionTable1">

            <thead class="sticky top-0 z-10 bg-white dark:bg-bg3 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <tr class="text-[11px] md:text-xs lg:text-sm font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-200">

                    <!-- SR NO -->
                    <th class="text-start py-4 px-3 md:px-5 min-w-[80px]">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <i class="las la-hashtag text-base text-primary"></i>
                            <span>SR NO</span>
                        </div>
                    </th>

                    <!-- ROLE NAME -->
                    <th class="text-start py-4 px-3 md:px-5 min-w-[160px]">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <i class="las la-user-shield text-base text-primary"></i>
                            <span>ROLE NAME</span>
                        </div>
                    </th>

                    <!-- POSITION -->
                    <th class="text-start py-4 px-3 md:px-5 min-w-[130px]">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <i class="las la-layer-group text-base text-primary"></i>
                            <span>POSITION</span>
                        </div>
                    </th>

                    <!-- ACTIVE -->
                    <th class="text-start py-4 px-3 md:px-5 min-w-[120px]">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <i class="las la-toggle-on text-base text-green-600"></i>
                            <span>ACTIVE</span>
                        </div>
                    </th>

                    <!-- USERS -->
                    <th class="text-start py-4 px-3 md:px-5 min-w-[120px]">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <i class="las la-users text-base text-blue-600"></i>
                            <span>USERS</span>
                        </div>
                    </th>

                    <!-- ASSOCIATE -->
                    <th class="text-start py-4 px-3 md:px-5 min-w-[140px]">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            <i class="las la-user-friends text-base text-orange-500"></i>
                            <span>ASSOCIATE</span>
                        </div>
                    </th>

                    <!-- ACTION -->
                    <th class="text-center py-4 px-3 md:px-5 min-w-[120px]">
                        <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                            <i class="las la-cogs text-base text-red-500"></i>
                            <span>ACTIONS</span>
                        </div>
                    </th>

                </tr>
            </thead>
            {{-- Table body should be rendered here with roles data --}}
            <tbody>
                @forelse($roles as $key => $role)
                    <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                        style="animation-delay: {{ $loop->index * 0.05 }}s">

                        <td class="px-6 py-4">
                            {{ $key + 1 }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->role->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->role_position ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if($role->active == 'Yes')
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->role_id ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $role->permission_id ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-center">

                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                <!-- VIEW -->
                                @if($isSuperAdmin || in_array('roles.show', $permissions))
                                <a href="{{ route('roles.show', $role->id) }}"
                                    class="action-btn action-view">

                                    <i class="las la-eye text-sm"></i>

                                    <span>View</span>

                                </a>
                                @endif

                                <!-- EDIT -->
                                @if($isSuperAdmin || in_array('roles.edit', $permissions))
                                <a href="{{ route('roles.edit', $role->id) }}"
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
                        <td colspan="7" class="text-center py-4">
                            No Roles Found
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection

@push('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionTable1').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            searching: false // Disable default DataTable search as you have your own search form
        });
    });

    document.getElementById('transaction-search').addEventListener('input', function() {
        if (this.value === '') {
            this.form.submit();
        }
    });
</script>
@endpush