@extends('layout.main')

@section('content')

<div class="container">

        <div class="mt-5">
            <form>
                <div class="flex justify-center box gap-3">
                    <div class="">
                        <select name="branch_id" class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            <option value="">ALL BRANCH</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->branch_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <button type="submit" class="btn-warning rounded-10  text-sm">
                            GET
                        </button>
                    </div>
                </div>
            </form>
        </div>


    <div class="box mt-5">
        <div class="text-end  mb-3 no-print">
            <a href="{{ route('balance.sheet.print',['branch_id'=>$branchId]) }}" 
                target="_blank"
                class="btn btn-dark btn-primary text-sm rounded-10 px-4 py-2 uppercase">
                <i class="las la-print"></i> Print
            </a>
        </div>

        <h3 class="mb-4 text-center text-lg uppercase mt-5">
            Balance Sheet as on {{ $today->format('d-m-Y') }}
        </h3>

    <div class="card ">
        <div class="card-body p-0">

            <div class="table-responsive" id="printArea">
                <table class="w-full table table-bordered table-striped mb-0">

                    <thead class="table-dark text-center">
                        <tr class="bg-secondary/5 ">
                            <th class="text-start px-4 py-2">ASSETS</th>
                            <th class="text-start px-4 py-2">LIABILITIES & EQUITY</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $maxRows = max(
                                count($assets),
                                count($liabilities) + count($equities) + 1
                            );
                        @endphp

                        @for($i = 0; $i < $maxRows; $i++)
                            <tr class="border-b">

                                {{-- ASSETS COLUMN --}}
                                <td class="text-start px-4 py-2">
                                    @if(isset($assets[$i]))
                                        <div class="d-flex justify-content-between">
                                            <span class="uppercase">{{ $assets[$i]['name'] }}</span>
                                            <span>{{ number_format($assets[$i]['amount'],2) }}</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- LIABILITIES + EQUITY COLUMN --}}
                                <td class="text-start px-4 py-2">

                                    {{-- Liabilities --}}
                                    @if(isset($liabilities[$i]))
                                        <div class="d-flex justify-content-between">
                                            <span class="uppercase">{{ $liabilities[$i]['name'] }}</span>
                                            <span>{{ number_format($liabilities[$i]['amount'],2) }}</span>
                                        </div>
                                    @endif

                                    {{-- Equity --}}
                                    @if(isset($equities[$i - count($liabilities)]))
                                        <div class="d-flex justify-content-between">
                                            <span class="uppercase">{{ $equities[$i - count($liabilities)]['name'] }}</span>
                                            <span>{{ number_format($equities[$i - count($liabilities)]['amount'],2) }}</span>
                                        </div>
                                    @endif

                                    {{-- Current Profit --}}
                                    @if($i == count($liabilities) + count($equities))
                                        <div class="d-flex justify-content-between fw-semibold">
                                            <span>Current Year Profit</span>
                                            <span>{{ number_format($netProfit,2) }}</span>
                                        </div>
                                    @endif

                                </td>

                            </tr>
                        @endfor

                        {{-- TOTAL ROW --}}
                        <tr class="fw-bold table-secondary border-b">
                            <td class="text-start px-4 py-2">
                                <div class="d-flex justify-content-between">
                                    <span>Total Assets</span>
                                    <span>{{ number_format($totalAssets,2) }}</span>
                                </div>
                            </td>
                            <td class="text-start ">
                                <div class="d-flex px-4 justify-content-between">
                                    <span>Total Liabilities & Equity</span>
                                    <span>{{ number_format($totalLiabilities + $totalEquity,2) }}</span>
                                </div>
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>

        </div>
    </div>
    
    {{-- Difference Alert --}}
    @if($difference != 0)
        <div class="alert alert-danger mt-5 text-center">
            ⚠ Balance Sheet Not Matching. Difference:
            {{ number_format($difference,2) }}
        </div>
    @else
        <div class="alert alert-success mt-5 text-center">
            ✅ Balance Sheet Matched Perfectly
        </div>
    @endif

</div>
   </div>




@endsection
