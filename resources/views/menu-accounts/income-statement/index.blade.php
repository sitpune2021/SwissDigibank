@extends('layout.main')

@section('content')

    <div class="container">
        <div class="flex flex-wrap items-center justify-between gap-4 px-4 lg:mb-4">
            <h3 class=" flex text-lg  uppercase font-semibold">
                INCOME STATEMENT
            </h3>

        </div>


        {{-- Branch Filter --}}
        <div class="box mt-5">
            <form class="mb-4 text-center">
                <select name="branch_id"
                    class="form-control w-64 border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                    <option value="">ALL BRANCH</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->branch_name }}
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-primary rounded-10 text-sm">GET</button>
            </form>
        </div>
    </div>

    <div class="card shadow box mt-5">
        <div class="flex justify-end gap-4">
            <a href="" class="btn-primary uppercase rounded-10 text-sm py-2">
                <i class="las la-print"></i>
                Print
            </a>
            <a href="" class="btn-error uppercase rounded-10 text-sm py-2">
                <i class="las la-download"></i>
                download xls
            </a>
        </div>

        <div class="card-body mt-5">
            <div class="flex justify-start gap-5">
                <div class=" w-full">

                    {{-- REVENUES --}}
                    <h5 class="text-lg uppercase bg-secondary/5 py-2 px-2 rounded-10">Revenues</h5>

                    @foreach($revenues as $rev)
                        <div class="border-b flex justify-between px-2 mt-3">
                            <span>{{ $rev['name'] }}</span>
                            <span>{{ number_format($rev['amount'], 2) }}</span>
                        </div>
                    @endforeach

                    <div class="border-b flex justify-between px-2 mt-3">
                        <span class="font-semibold">TOTAL REVENUES</span>
                        <span class="font-semibold">{{ number_format($totalRevenue, 2) }}</span>
                    </div>
                </div>



                {{-- EXPENSES --}}
                <div class="text-start w-full">
                    <h5 class="text-lg uppercase bg-secondary/5 py-2 px-2 rounded-10">Expenses</h5>

                    @foreach($expenses as $exp)
                        <div class="border-b flex justify-between px-2 mt-3">
                            <span>{{ $exp['name'] }}</span>
                            <span>{{ number_format($exp['amount'], 2) }}</span>
                        </div>
                    @endforeach

                    <div class=" border-b flex justify-between px-2 mt-3">
                        <span class="font-semibold">TOTAL EXPENSES</span>
                        <span class="font-semibold">{{ number_format($totalExpense, 2) }}</span>
                    </div>

                </div>
            </div>


            <div class=" w-full flex  justify-between">
                {{-- NET PROFIT / LOSS --}}
                <div class=" w-full  px-3 mt-5 flex  justify-between ">
                    <span class="font-semibold ">
                        {{ $netProfit >= 0 ? 'NET PROFIT' : 'NET LOSS' }}
                    </span>
                    <span class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }} px-2  font-semibold">
                        {{ number_format($netProfit, 2) }}
                    </span>
                </div>
                 <div class=" w-full  px-3 mt-5 flex  justify-between "></div>
               
            </div>

        </div>
    </div>

    </div>

@endsection