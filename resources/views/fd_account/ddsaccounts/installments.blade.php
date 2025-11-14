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
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">CREATED AT</th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">UPDATED AT</th>
                            <th class="px-4 py-3 text-start text-lg  md:text-base font-bold text-gray-700">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($installments as $inst)
                            <tr>
                                <td class="px-3 py-2">{{ $inst['number'] }}</td>
                                <td class="px-3 py-2">{{ $inst['amount'] }}</td>
                                <td class="px-3 py-2">{{ $inst['due_date'] }}</td>
                                <td class="px-3 py-2">
                                    @if ($inst['state'] === 'PAID')
                                        <span class="badge bg-success">PAID</span>
                                    @else
                                        <span class="badge bg-success"></span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">{{ $inst['paid_on'] }}</td>
                                <td class="px-3 py-2">{{ $inst['created_at'] }}</td>
                                <td class="px-3 py-2">{{ $inst['updated_at'] }}</td>
                                <td class="px-3 py-2">
                                    @if ($inst['state'] === 'PAID')
                                        <a href="{{ route('dds.installment.receipt', $ddaccount->id) }}" target="_blank"
                                            class="btn btn-sm btn-primary">
                                            Print
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
<x-pagination :paginator="$installments" />

        </div>
    </div>
@endsection
