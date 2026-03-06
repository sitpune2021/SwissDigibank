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

        <style>
        #printArea table{
        width:100%;
        table-layout: fixed;
        }

        #printArea th,
        #printArea td{
        padding:10px;
        font-size:15px;
        }

        .card{
        width:100%;
        }

        .card-body{
        padding:0;
        }

        /* Highlight headings */
        .section-head{
        background:#343a40;
        color:#fff;
        font-weight:bold;
        font-size:16px;
        }

        /* Highlight totals */
        .total-row{
        background:#e9ecef;
        font-weight:bold;
        }
        </style>

        <div class="card w-100">
            <div class="card-body">

            <div class="table-responsive" id="printArea">
            <table class="table table-bordered mb-0 w-100">

            <thead class="table-light">
            <tr>
            <th class="px-4 py-2">PARTICULARS</th>
            <th class="text-end px-4 py-2">AMOUNT</th>
            </tr>
            </thead>

            <tbody>

            {{-- EQUITY --}}
            <tr class="section-head">
            <td colspan="2">EQUITY</td>
            </tr>

            @foreach($equities as $equity)
            <tr>
            <td class="px-4">{{ strtoupper($equity['name']) }}</td>
            <td class="text-end px-4">{{ number_format($equity['amount'],2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
            <td class="px-4">CURRENT YEAR PROFIT</td>
            <td class="text-end px-4">{{ number_format($netProfit,2) }}</td>
            </tr>

            <tr class="total-row">
            <td class="px-4">TOTAL EQUITY</td>
            <td class="text-end px-4">{{ number_format($totalEquity,2) }}</td>
            </tr>


            {{-- LIABILITIES --}}
            <tr class="section-head">
            <td colspan="2">LIABILITIES</td>
            </tr>

            @foreach($liabilities as $liability)
            <tr>
            <td class="px-4">{{ strtoupper($liability['name']) }}</td>
            <td class="text-end px-4">{{ number_format($liability['amount'],2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
            <td class="px-4">TOTAL LIABILITIES</td>
            <td class="text-end px-4">{{ number_format($totalLiabilities,2) }}</td>
            </tr>


            {{-- ASSETS --}}
            <tr class="section-head">
            <td colspan="2">ASSETS</td>
            </tr>

            @foreach($assets as $asset)
            <tr>
            <td class="px-4">{{ strtoupper($asset['name']) }}</td>
            <td class="text-end px-4">{{ number_format($asset['amount'],2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
            <td class="px-4">TOTAL ASSETS</td>
            <td class="text-end px-4">{{ number_format($totalAssets,2) }}</td>
            </tr>

            </tbody>

            </table>
            </div>

            </div>
        </div>
    
    </div>

</div>


@endsection
