@extends('layout.main')

@section('content')

<div class="container">
    <div class="flex flex-wrap items-center justify-between gap-4 px-4 lg:mb-4">
        <h3 class=" flex text-lg  uppercase font-semibold">
            Trial Balance

        </h3>

    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 md-4">
        <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
            <form method="GET" class="row mb-3">

                <div class="col-md-2 mt-5">
                    <input type="date" name="from"  value="{{ $from }}" class="form-control w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                </div>

                <div class="col-md-2  mt-5">
                    <input type="date" name="to" value="{{ $to }}" class="form-control w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                </div>

                <div class="col-md-2 mt-5"> 
                    <select name="type" class="form-control w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                        <option value="ALL" {{ $type=='ALL' ?'selected':'' }}>ALL</option>
                        <option value="Asset" {{ $type=='Asset' ?'selected':'' }}>ASSETS</option>
                        <option value="Liability" {{ $type=='Liability' ?'selected':'' }}>LIABILITIES</option>
                        <option value="Equity" {{ $type=='Equity' ?'selected':'' }}>EQUITY</option>
                        <option value="Expense" {{ $type=='Expense' ?'selected':'' }}>EXPENSES</option>
                        <option value="Revenue" {{ $type=='Revenue' ?'selected':'' }}>REVENUE</option>
                    </select>
                </div>

                <div class="col-md-2 mt-5">
                    <select name="branch_id" class="form-control w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                        <option value="">ALL BRANCH</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id')==$branch->id ? 'selected' : '' }}>
                            {{ $branch->branch_name }}
                        </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-3 mt-5">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search..." class="form-control w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                </div>

                <div class="col-md-2 mt-5 text-center">
                    <button class="w-100 btn-primary rounded-10 ">Filter</button>
                </div>

            </form>
        </div>
    </div>
  <div class="box mt-4">
      <div class="table-responsive pb-4 overflow-x-auto lg:pb-6 ">
        <table class="table table-bordered table-striped w-full whitespace-nowrap select-all-table">

            <thead class="table-dark text-center">
                <tr class="bg-secondary/5">
                    <th class="px-5 py-3 text-start uppercase">Code</th>
                    <th class="px-5 py-3 text-start uppercase">Name</th>
                    <th class="px-5 py-3 text-start uppercase">System Name</th>
                    <th class="px-5 py-3 text-start uppercase">Group</th>
                    <th class="px-5 py-3 text-start uppercase">Type</th>
                    <th class="px-5 py-3 text-start uppercase">Opening</th>
                    <th class="px-5 py-3 text-start uppercase">Debit</th>
                    <th class="px-5 py-3 text-start uppercase">Credit</th>
                    <th class="px-5 py-3 text-start uppercase">Balance</th>
                </tr>
            </thead>

            <tbody>

                @foreach($data as $row)

                <tr class="border-b">
                    <td class="px-5 py-3 text-start uppercase" >{{ $row['code'] }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ $row['name'] }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ $row['system_name'] }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ $row['group'] }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ $row['type'] }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ number_format($row['opening'],2) }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ number_format($row['balance_debit'],2) }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ number_format($row['balance_credit'],2) }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ number_format($row['balance'],2) }}</td>
                </tr>

                @endforeach

                <tr class="fw-bold table-secondary">
                    <td colspan="7" class="px-5 py-3 text-start uppercase font-semibold" >GRAND TOTAL</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ number_format($totalDebit,2) }}</td>
                    <td class="px-5 py-3 text-start uppercase" >{{ number_format($totalCredit,2) }}</td>
                </tr>


            </tbody>
        </table>
    </div>
  </div>

</div>

@endsection