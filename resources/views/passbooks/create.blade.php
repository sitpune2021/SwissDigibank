@extends('layout.main')

@section('content')
    <div class="main-inner">
        <h2 class="mb-4">Issue New Passbook</h2>

        <div class="card shadow-lg rounded-lg p-4 w-1/2 mx-auto">
            <form action="{{ route('passbooks.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Account Type *</label>
                    <select name="account_type" class="form-control" required>
                        <option value="Saving">Saving</option>
                        <option value="Current">Current</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Account No *</label>
                    <select name="account_id" class="form-control" required>
                        <option value="">-- Select Account --</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->account_no }} - {{ $account->member->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Passbook Issue Date *</label>
                    <input type="date" name="issue_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Passbook No *</label>
                    <input type="text" name="passbook_no" class="form-control" placeholder="Enter Passbook No" required>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Add Passbook</button>
                    <a href="{{ route('passbook.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
