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

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
            MATURITY REPORT
        </h3>
    </div>
    @if(session('success'))
    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
        {{-- {{ session('success') }} --}}
    </div>
    @endif


 <div class="p-4 box">

<!-- Tabs -->
<ul class="flex border-b font-semibold" id="reportTabs">
    <li><button class="tab px-4 py-2 border-b-2 border-blue-600 text-primary" data-tab="all">ALL</button></li>
    <li><button class="tab px-4 py-2" data-tab="rd">RD</button></li>
    <li><button class="tab px-4 py-2" data-tab="dd">DD</button></li>
    <li><button class="tab px-4 py-2" data-tab="fd">FD</button></li>
    <li><button class="tab px-4 py-2" data-tab="mis">MIS</button></li>
</ul>



<!-- ================= RD ================= -->
<div data-content="rd" class="report-block">
<div class="max-w-3xl mx-auto mt-6 overflow-x-auto">
<table class="w-full border border-gray-300 text-center">
<tr>
<td rowspan="2" class="font-semibold border p-3 w-[30%]">
Summary (RD) <br>(Active & Matured)
</td>
<td class="border p-3">Total Accounts</td>
<td class="border p-3">Total Maturity</td>
<td class="border p-3">Total Current Balance</td>
</tr>
<tr class="font-semibold">
<td class="border p-3">{{ $rdTotalAccounts ?? 0 }}</td>
<td class="border p-3">{{ number_format($rdTotalMaturity ?? 0,2) }}</td>
<td class="border p-3">{{ number_format($rdTotalBalance ?? 0,2) }}</td>
</tr>
</table>
</div>
</div>



<!-- ================= DD ================= -->
<div data-content="dd" class="report-block">
<div class="max-w-3xl mx-auto mt-6 overflow-x-auto">
<table class="w-full border border-gray-300 text-center">
<tr>
<td rowspan="2" class="font-semibold border p-3 w-[30%]">
Summary (DD) <br>(Active & Matured)
</td>
<td class="border p-3">Total Accounts</td>
<td class="border p-3">Total Maturity</td>
<td class="border p-3">Total Current Balance</td>
</tr>
<tr class="font-semibold">
<td class="border p-3">{{ $ddTotalAccounts ?? 0 }}</td>
<td class="border p-3">{{ number_format($ddTotalMaturity ?? 0,2) }}</td>
<td class="border p-3">{{ number_format($ddTotalBalance ?? 0,2) }}</td>
</tr>
</table>
</div>
</div>



<!-- ================= FD ================= -->
<div data-content="fd" class="report-block">
<div class="max-w-3xl mx-auto mt-6 overflow-x-auto">
<table class="w-full border border-gray-300 text-center">
<tr>
<td rowspan="2" class="font-semibold border p-3 w-[30%]">
Summary (FD) <br>(Active & Matured)
</td>
<td class="border p-3">Total Accounts</td>
<td class="border p-3">Total Maturity</td>
<td class="border p-3">Total Current Balance</td>
</tr>
<tr class="font-semibold">
<td class="border p-3">{{ $fdTotalAccounts ?? 0 }}</td>
<td class="border p-3">{{ number_format($fdTotalMaturity ?? 0,2) }}</td>
<td class="border p-3">{{ number_format($fdTotalBalance ?? 0,2) }}</td>
</tr>
</table>
</div>
</div>



<!-- ================= MIS ================= -->
<div data-content="mis" class="report-block">
<div class="max-w-3xl mx-auto mt-6 overflow-x-auto">
<table class="w-full border border-gray-300 text-center">
<tr>
<td rowspan="2" class="font-semibold border p-3 w-[30%]">
Summary (MIS) <br>(Active & Matured)
</td>
<td class="border p-3">Total Accounts</td>
<td class="border p-3">Total Maturity</td>
<td class="border p-3">Total Current Balance</td>
</tr>
<tr class="font-semibold">
<td class="border p-3">{{ $misTotalAccounts ?? 0 }}</td>
<td class="border p-3">{{ number_format($misTotalMaturity ?? 0,2) }}</td>
<td class="border p-3">{{ number_format($misTotalBalance ?? 0,2) }}</td>
</tr>
</table>
</div>
</div>



<!-- ================= GRAND TOTAL ================= -->
<div class="max-w-3xl mx-auto mt-6 overflow-x-auto">
<table class="w-full border border-gray-300 text-center font-semibold">
<tr>
<td class="border p-3 w-[30%]">GRAND TOTAL</td>
<td class="border p-3">{{ $grandAccounts ?? 0 }}</td>
<td class="border p-3">{{ number_format($grandMaturity ?? 0,2) }}</td>
<td class="border p-3">{{ number_format($grandBalance ?? 0,2) }}</td>
</tr>
</table>
</div>



<!-- Alert -->
<div class="mt-6 max-w-3xl mx-auto">
<div class="bg-red-500 text-white px-4 py-3 rounded">
<strong class="block mb-1">Alert!</strong>
Don't select long dates while viewing all, it will slow the system.
</div>
</div>

</div>
</div>



<!-- ================= TAB SCRIPT ================= -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    const tabs = document.querySelectorAll(".tab");
    const blocks = document.querySelectorAll(".report-block");

    function activateTab(tab){

        /* reset tab style */
        tabs.forEach(t=>{
            t.classList.remove("border-blue-600","text-blue-600","border-b-2");
        });

        /* active style */
        document.querySelector(`[data-tab="${tab}"]`)
            .classList.add("border-blue-600","text-blue-600","border-b-2");

        /* toggle sections */
        blocks.forEach(block=>{
            if(tab === "all"){
                block.classList.remove("hidden");
            } else {
                block.dataset.content === tab
                    ? block.classList.remove("hidden")
                    : block.classList.add("hidden");
            }
        });
    }

    tabs.forEach(btn=>{
        btn.addEventListener("click", ()=>activateTab(btn.dataset.tab));
    });

    activateTab("all"); // default
});
</script>



@endsection