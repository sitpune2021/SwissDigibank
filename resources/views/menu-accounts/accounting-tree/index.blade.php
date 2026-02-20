@extends('layout.main')

@section('content')

<div class="container">

    <h3 class="mb-4">ACCOUNTING TREE</h3>

    {{-- Branch Filter --}}
    <form class="mb-4">
        <select name="branch_id" class="form-control w-25 d-inline">
            <option value="">ALL BRANCH</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-primary">GET</button>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">

            <ul style="list-style-type:none; padding-left:0;">

                <li>
                    <strong>ACCOUNTING</strong>

                    <ul style="list-style-type:none; margin-left:20px;">

                        @foreach($tree as $type => $ledgers)

                            <li class="mt-3">
                                <strong>{{ $type }}</strong>

                                <ul style="list-style-type:none; margin-left:20px;">

                                    @foreach($ledgers as $ledger)

                                        <li class="d-flex justify-content-between border-bottom py-1">

                                            <span>
                                                {{ $ledger['name'] }}
                                                ( {{ $ledger['system'] }} )
                                            </span>

                                            <span>
                                                {{ number_format($ledger['amount'],2) }}
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>
                            </li>

                        @endforeach

                    </ul>

                </li>

            </ul>

        </div>
    </div>

</div>

@endsection
