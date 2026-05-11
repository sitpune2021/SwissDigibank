@extends('layout.main')

@section('action-button')
<a href="{{ route('branch.create') }}"
    class="px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition-all duration-200
    hover:scale-105"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
    ADD BRANCH
</a>
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

                    Branch Management

                </h2>

                <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">

                    Manage all branch records, status & operations

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

<style>

/* =========================
    TOGGLE SWITCH
========================= */

.sr-only{
    position:absolute;
    width:1px;
    height:1px;
    padding:0;
    margin:-1px;
    overflow:hidden;
    clip:rect(0,0,0,0);
    white-space:nowrap;
    border:0;
}

.blocks{
    width:56px;
    height:32px;
    border-radius:9999px;
    background:#9ca3af;
    transition:.3s;
}

.dot{
    position:absolute;
    top:4px;
    left:4px;
    width:24px;
    height:24px;
    border-radius:9999px;
    background:#fff;
    transition:.3s;
    box-shadow:0 2px 5px rgba(0,0,0,.2);
}

input[type="checkbox"].slider-toggle:checked + div .blocks{
    background:#228cc5;
}

input[type="checkbox"].slider-toggle:checked + div .dot{
    transform:translateX(24px);
}

/* =========================
    TABLE ROW EFFECT
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

.action-group{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    flex-wrap:nowrap;
}

.action-group form{
    margin:0 !important;
    padding:0 !important;
    display:flex;
    align-items:center;
}

.action-btn{
    height:36px;
    min-width:90px;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:0 14px;

    border:none;
    outline:none;

    border-radius:10px;

    font-size:13px;
    font-weight:600;
    line-height:1;

    color:#fff;

    white-space:nowrap;

    transition:all .2s ease;
}

.action-btn i{
    font-size:15px;
    line-height:1;
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

/* DELETE */
.action-delete{
    background:linear-gradient(135deg,#ef4444,#dc2626) !important;
    color:#fff !important;
}

/* MOBILE */

@media(max-width:768px){

    .action-group{
        flex-wrap:wrap;
    }

    .action-btn{
        width:100%;
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

<div class="col-span-12 box lg:col-span-6 bank-page-animate">

    <div class="mb-3">
        <x-searchbox />
    </div>

    @include('fields.errormessage')

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-x-auto table-premium">

        <table class="w-full min-w-[1100px]" id="transactionTable1">

            <thead class="bg-gradient-to-r from-slate-100 via-white to-slate-100 text-black border-b border-gray-200">

                <tr class="text-xs sm:text-sm uppercase tracking-wider font-bold">

                    <th class="px-3 sm:px-5 py-4 text-left">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-building text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="whitespace-nowrap text-black">Branch Name</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-city text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">City</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-map-marked-alt text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">State</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-calendar text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="whitespace-nowrap text-black">Opened On</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-users text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">Customers</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-toggle-on text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">Status</span>
                        </div>
                    </th>

                    <th class="px-3 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                                <i class="las la-cog text-sm sm:text-base text-black"></i>
                            </div>
                            <span class="text-black">Actions</span>
                        </div>
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($branches as $branch)

                <tr class="table-row border-b border-gray-100"
                    style="animation-delay:{{ $loop->index * 0.05 }}s">

                    <!-- BRANCH -->
                    <td class="px-6 py-5" data-label="Branch">

                        <div class="flex items-center gap-3">

                            <!-- <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center">
                                <i class="las la-building text-primary text-xl"></i>
                            </div> -->

                            <div>

                                <a href="{{ route('branch.show', base64_encode($branch->id)) }}"
                                    class="font-semibold text-primary hover:underline">

                                    {{ $branch->branch_name }}

                                </a>

                                <p class="text-xs text-gray-500 mt-1">
                                    Branch Code : {{ $branch->branch_code }}
                                </p>

                            </div>

                        </div>

                    </td>

                    <!-- CITY -->
                    <td class="px-6 py-5 text-center"
                        data-label="City">

                        {{ $branch->city ?? '-' }}

                    </td>

                    <!-- STATE -->
                    <td class="px-6 py-5 text-center"
                        data-label="State">

                        {{ $branch->State?->name ?? '-' }}

                    </td>

                    <!-- OPEN DATE -->
                    <td class="px-6 py-5 text-center"
                        data-label="Opened On">

                        {{ $branch->open_date ? \Carbon\Carbon::parse($branch->open_date)->format('d-m-Y') : '-' }}

                    </td>

                    <!-- MEMBERS -->
                    <td class="px-6 py-5 text-center"
                        data-label="Customers">

                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                        bg-blue-100 text-blue-700">

                            {{ $branch->Member->count() }}

                        </span>

                    </td>

                    <!-- STATUS -->
                    <td class="px-6 py-5 text-center"
                        data-label="Status">

                        <div class="flex justify-center">

                            <label class="inline-flex items-center cursor-pointer">

                                <input type="checkbox"
                                    class="sr-only slider-toggle"
                                    data-id="{{ $branch->id }}"
                                    {{ $branch->active === 'Yes' ? 'checked' : '' }}>

                                <div class="relative">
                                    <div class="blocks"></div>
                                    <div class="dot"></div>
                                </div>

                            </label>

                        </div>

                    </td>

                    <!-- ACTIONS -->
                    <td class="px-6 py-5 text-center align-middle" data-label="Actions">

                        <div class="action-group">

                            <!-- VIEW -->
                            <a href="{{ route('branch.show', base64_encode($branch->id)) }}"
                                class="action-btn action-view">

                                <i class="las la-eye"></i>
                                <span>VIEW</span>
                                
                            </a>

                            <!-- EDIT -->
                            <a href="{{ route('branch.edit', base64_encode($branch->id)) }}"
                                class="action-btn action-edit">

                                <i class="las la-edit"></i> 
                                <span>EDIT</span>                            

                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('branch.destroy', base64_encode($branch->id)) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this branch?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="action-btn action-delete">

                                    <i class="las la-trash"></i>
                                    <span>DELETE</span>
                                    
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7"
                        class="py-10 text-center text-gray-500">

                        No branch records found.

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">
        <x-pagination :paginator="$branches"/>
    </div>

</div>

<script>

document.addEventListener('change', function(e){

    if(!e.target.classList.contains('slider-toggle')) return;

    let checkbox = e.target;
    let id = checkbox.dataset.id;

    fetch("{{ route('branch.toggle.status') }}", {

        method:"POST",

        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":
            document.querySelector('meta[name="csrf-token"]').content
        },

        body:JSON.stringify({id:id})

    })

    .then(res => res.json())

    .then(res => {

        if(!res.success){

            checkbox.checked = !checkbox.checked;

            alert("Status update failed");

        }

    })

    .catch(() => {

        checkbox.checked = !checkbox.checked;

        alert("Server error");

    });

});

</script>

@endsection