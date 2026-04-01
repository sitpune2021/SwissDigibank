@extends('layout.main')

@section('content')
    {{-- <div class="box p-4">
        <h2 class="text-lg font-bold mb-4">Complete KYC</h2>

        <form method="POST" action="{{ route('member.kyc.submit', $member->id) }}"> @csrf

            <div class="mb-3">
                <label>PAN No</label>
                <input type="text" name="member_kyc_pan_no" class="form-control">
            </div>

            <div class="mb-3">
                <label>Aadhaar No</label>
                <input type="text" name="member_kyc_aadhaar_no" class="form-control">
            </div>

            <button class="btn btn-primary">Submit KYC</button>
        </form>
    </div> --}}
@endsection
