@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-xl font-semibold">DD- {{ $ddaccount->id ?? 'N/A' }} INSTALLMENTS</h1>
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
                                        <span class="badge  bg-green bg-success">PAID</span>
                                    @else
                                        <span class="badge bg-warning text-dark"></span>
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
