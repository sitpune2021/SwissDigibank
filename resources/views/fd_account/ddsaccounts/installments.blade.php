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
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-xl font-semibold">DD- {{ $ddaccount->id ?? 'N/A' }}Installments</h1>


                <div class="">
                    <a href="" class="text-sm text-gray-500 ">Daily Deposits</a> >
                    <a href="" class="text-sm text-gray-500">DDA03621 </a> >
                    <a href="" class="text-sm text-gray-500">Installments</a>
                </div>
            </div>


        </div>
        <div class="col-span-12 lg:col-span-12">
            <div class="my-4">
                <a href="" class="uppercase text-sm rounded-10 btn-warning">Re-generate Installment Chart</a>
            </div>

            <div class="shadow-lg rounded-lg box overflow-x-auto">
                <table class="w-full divide-y bg-secondary/5">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">INSTALLMENT NO
                            </th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">AMOUNT</th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">DUE DATE</th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">STATE</th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">PAID ON</th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">ACTIONS</th>
                        </tr>
                    </thead>
                   <tbody>
                @foreach ($installments as $inst)
                    <tr>
                        <td class="px-3 py-2">{{ $inst['number'] }}</td>
                        <td class="px-3 py-2">{{ number_format((float) $inst['amount'], 2) }}</td>
                        <td class="px-3 py-2">
                            @if ($inst['due_date'])
                                {{ \Carbon\Carbon::createFromFormat('d/m/Y', $inst['due_date'])->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if ($inst['state'] === 'PAID')
                                <span class="badge bg-success">PAID</span>
                            @else
                                <span class="badge bg-warning text-dark">PENDING</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if ($inst['paid_on'])
                                {{ \Carbon\Carbon::createFromFormat('d/m/Y', $inst['paid_on'])->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if ($inst['state'] === 'PAID')
                                <button class="btn btn-sm btn-secondary" onclick="window.print()">Print</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
{{-- @extends('layout.main')
@section('content')
    <div class="container py-4">
        <h3 class="mb-3">Installments for DD - {{ $ddaccount->id  ?? 'N/A' }}</h3>

        <table class="table table-bordered table-hover align-middle" style="font-size: 0.9rem;">
            <thead class="table-success text-white" style="background-color: #28a745;">
                <tr>
                    <th scope="col" class="text-start px-3 py-2" style="min-width: 110px; cursor: pointer;">Installment No
                    </th>
                    <th scope="col" class="px-3 py-2">Amount</th>
                    <th scope="col" class="px-3 py-2">Due Date</th>
                    <th scope="col" class="px-3 py-2">State</th>
                    <th scope="col" class="px-3 py-2">Paid On</th>
                    <th scope="col" class="px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installments as $inst)
                    <tr>
                        <td class="px-3 py-2">{{ $inst['number'] }}</td>
                        <td class="px-3 py-2">{{ number_format((float) $inst['amount'], 2) }}</td>
                        <td class="px-3 py-2">
                            @if ($inst['due_date'])
                                {{ \Carbon\Carbon::createFromFormat('d/m/Y', $inst['due_date'])->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if ($inst['state'] === 'PAID')
                                <span class="badge bg-success">PAID</span>
                            @else
                                <span class="badge bg-warning text-dark">PENDING</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if ($inst['paid_on'])
                                {{ \Carbon\Carbon::createFromFormat('d/m/Y', $inst['paid_on'])->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if ($inst['state'] === 'PAID')
                                <button class="btn btn-sm btn-secondary" onclick="window.print()">Print</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
