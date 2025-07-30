@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">{{ isset($account) ? 'Edit' : 'Add' }} Account</h3>
    </div>

    @if (session('success'))
    <div id="success-alert"
        style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="document.getElementById('success-alert').style.display='none';"
            style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert"
        style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="document.getElementById('error-alert').style.display='none';"
            style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
    </div>
    @endif

    <div class="box mb-4 xxxl:mb-6">
        <form id="accountForm" action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf
            @if($method === 'PUT')
                @method('PUT')
            @endif

            {{-- Account Type --}}
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Account Type <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="account_type" value="saving"
                            {{ old('account_type', $account->account_type ?? 'saving') === 'saving' ? 'checked' : '' }}>
                        Saving
                    </label>
                    <label>
                        <input type="radio" name="account_type" value="current"
                            {{ old('account_type', $account->account_type ?? '') === 'current' ? 'checked' : '' }}>
                        Current
                    </label>
                </div>
            </div>

            {{-- Firm Name --}}
            <div class="col-span-2 md:col-span-1 firm-field-wrapper">
                <div id="firmNameDiv" class="hidden">
                    <label for="firm_d" class="font-medium block mb-4">Firm Name <span class="text-red-500">*</span></label>
                    <input type="text" name="firm_d" id="firm_d"
                        value="{{ old('firm_d', $account->firm_d ?? '') }}"
                        class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3"
                        placeholder="Enter firm name">
                    @error('firm_d') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Member Selection --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_id_main" class="font-medium block mb-4">Member <span class="text-red-500">*</span></label>
                <select name="member_id" id="member_id_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                      <option value="{{ $member->id }}" {{ old('member_id', $account->member_id ?? '') == $member->id ? 'selected' : '' }}>
                                {{ "MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name }}
                        </option>

                    @endforeach
                </select>
                @error('member_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Member Name --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_name" class="font-medium block mb-4">Member Name</label>
                <input type="text" readonly name="member_name" id="member_name"
                    value="{{ old('member_name', $account->member_name ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Member name">
            </div>

            {{-- Member Address --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_address" class="font-medium block mb-4">Member Address</label>
                <input type="text" readonly name="member_address" id="member_address"
                    value="{{ old('member_address', $account->member_address ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Member address">
            </div>

            {{-- Member Mobile --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_mobile" class="font-medium block mb-4">Member Mobile No.</label>
                <input type="text" name="member_mobile" readonly id="member_mobile"
                    value="{{ old('member_mobile', $account->member_mobile ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Mobile number">
            </div>

            {{-- Minor --}}
            <div class="col-span-2 md:col-span-1">
                <label for="minor_id" class="font-medium block mb-4">Minor</label>
                <select name="minor_id" id="minor_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
                   <option>-- Select Minor --</option>
                </select>
            </div>

            {{-- Branch --}}
            <div class="col-span-2 md:col-span-1">
                <label for="branch_id" class="font-medium block mb-4">Branch <span class="text-red-500">*</span></label>
                    <select name="branch_id" id="branch_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                        <option value="">-- Select Branch --</option>
                            @foreach($branches as $id => $branchName)
                                <option value="{{ $id }}" {{ old('branch_id', $account->branch_id ?? '') == $id ? 'selected' : '' }}>
                                    {{ ucfirst($branchName) }}
                                </option>
                            @endforeach
                    </select>
            </div>

            {{-- Advisor/Staff --}}
            <div class="col-span-2 md:col-span-1">
                <label for="advisor_id" class="font-medium block mb-4">Advisor/Staff</label>
                <select name="advisor_id" id="advisor_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                        <option value="">-- Select Branch --</option>
                            @foreach($advisors as $id => $advisors)
                                <option value="{{ $id }}" {{ old('advisor_id', $account->advisor_id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $advisors }}
                                </option>
                            @endforeach
                    </select>
            </div>

            {{-- Scheme --}}
            <div class="col-span-2 md:col-span-1">
                <label for="scheme_id" class="font-medium block mb-4">Scheme <span class="text-red-500">*</span></label>
                <select name="scheme_id" id="scheme_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Scheme --</option>
                    <option value="1">-- Test Scheme --</option>
                    {{-- Options here --}}
                </select>
            </div>

            {{-- Open Date --}}
            <div class="col-span-2 md:col-span-1">
                <label for="open_date" class="font-medium block mb-4">Open Date <span class="text-red-500">*</span></label>
                <input type="text" readonly name="open_date" id="open_date"
                    value="{{ date('d-m-Y h:i:s A') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >


            </div>

            {{-- Amount --}}
            <div class="col-span-2 md:col-span-1">
                <label for="amount" class="font-medium block mb-4">Amount Deposit <span class="text-red-500">*</span></label>
                <input type="number" name="amount" id="amount"
                    value="{{ old('amount', $account->amount ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
            </div>

            {{-- Section Heading --}}
            <div class="col-span-2">
                <hr class="my-4">
            </div>

            {{-- Account Holder Type --}}
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Account Holder Type <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="account_holder_type" value="single"
                            {{ old('account_holder_type', $account->account_holder_type ?? '') === 'single' ? 'checked' : '' }}>
                        Single
                    </label>
                    <label>
                        <input type="radio" name="account_holder_type" value="joint"
                            {{ old('account_holder_type', $account->account_holder_type ?? '') === 'joint' ? 'checked' : '' }}>
                        Joint A/C
                    </label>
                </div>
            </div>
               
            <div class="col-span-2 md:col-span-1"></div>

            {{-- Joint A/c Member 1 --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_id_one_one" class="font-medium block mb-4">Joint A/c Member 1 <span class="text-red-500">*</span></label>
                <select name="member_id_one" id="member_id_one_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                      <option value="{{ $member->id }}" {{ old('member_id', $account->member_id ?? '') == $member->id ? 'selected' : '' }}>
                                {{ "MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name }}
                        </option>

                    @endforeach
                </select>
                @error('member_id_one') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>
            

            {{-- Joint A/c Member 2 --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_id_two" class="font-medium block mb-4">Joint A/c Member 2 <span class="text-red-500">*</span></label>
                 <select name="member_id_two" id="member_id_two_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                      <option value="{{ $member->id }}" {{ old('member_id', $account->member_id ?? '') == $member->id ? 'selected' : '' }}>
                                {{ "MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name }}
                        </option>

                    @endforeach
                </select>
                @error('member_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Mode of Operation --}}
            <div class="col-span-2 md:col-span-1" id="mode-operation">
                <label class="font-medium block mb-4">Mode of Operation <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="mode_of_operation" value="single"
                            {{ old('mode_of_operation', $account->mode_of_operation ?? '') === 'single' ? 'checked' : '' }}>
                        Single
                    </label>
                    <label>
                        <input type="radio" name="mode_of_operation" value="jointly"
                            {{ old('mode_of_operation', $account->mode_of_operation ?? '') === 'jointly' ? 'checked' : '' }}>
                        Jointly
                    </label>
                    <label>
                        <input type="radio" name="mode_of_operation" value="either_or_survivor"
                            {{ old('mode_of_operation', $account->mode_of_operation ?? '') === 'either_or_survivor' ? 'checked' : '' }}>
                        Either or Survivor
                    </label>
                </div>
            </div>

            {{-- Section Heading --}}
            <div class="col-span-2">
                <hr class="my-4">
                <h4 class="text-lg font-semibold mb-2">Nominee Info</h4>
            </div>

            {{-- Nominee --}}
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Nominee <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="nominee" value="yes"
                            {{ old('nominee', $account->nominee ?? '') === 'yes' ? 'checked' : '' }}>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="nominee" value="no"
                            {{ old('nominee', $account->nominee ?? '') === 'no' ? 'checked' : '' }}>
                        No
                    </label>
                </div>
            </div>

            {{-- Section Heading --}}
            <div class="col-span-2">
                <hr class="my-4">
                <h4 class="text-lg font-semibold mb-2">Payment Info</h4>
            </div>

            {{-- Payment Mode --}}
            <div class="col-span-2 md:col-span-1">
                <label class="font-medium block mb-4">Payment Mode <span class="text-red-500">*</span></label>
                <div class="flex gap-5">
                    <label>
                        <input type="radio" name="payment_mode" value="cash"
                            {{ old('payment_mode', $account->payment_mode ?? '') === 'cash' ? 'checked' : '' }}>
                        Cash
                    </label>
                    <label>
                        <input type="radio" name="payment_mode" value="online"
                            {{ old('payment_mode', $account->payment_mode ?? '') === 'online' ? 'checked' : '' }}>
                        Online Tr.
                    </label>
                    <label>
                        <input type="radio" name="payment_mode" value="cheque"
                            {{ old('payment_mode', $account->payment_mode ?? '') === 'cheque' ? 'checked' : '' }}>
                        Cheque
                    </label>
                </div>
            </div>

            {{-- Transaction Date --}}
            <div class="col-span-2 md:col-span-1">
                <label for="transaction_date" class="font-medium block mb-4">Transaction Date</label>
                <input type="text" name="transaction_date" id="date2"
                    value="{{ old('transaction_date', $account->transaction_date ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
            </div>

            {{-- Buttons --}}
            <div class="col-span-2 flex gap-4 mt-4">
                <button class="btn-primary" type="submit">{{ $method === 'PUT' ? 'Update' : 'Open' }} Account</button>
                <button class="btn-outline" type="reset">Reset</button>
                <button class="btn-outline" type="button" onclick="">Back</button>
            </div>
        </form>
    </div>
</div>
@php
    $membersData = $members->mapWithKeys(function($member) 
    {
        return [
            $member->id => [
                'first_name' => $member->member_info_first_name,
                'last_name' => $member->member_info_last_name,
                'mobile' => $member->member_info_mobile_no ?? '',
                'branch_id' => $member->general_branch,
                'address' => $member->address
            ],
        ];
    })->toArray();
@endphp
@endsection

<style>
    .firm-field-wrapper {
        position: relative;
        min-height: 100px;
        transition: all 0.3s ease;
    }
    .firm-field-wrapper.hidden {
        visibility: hidden;
        position: absolute;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        const membersData = @json($membersData);
        $(document).ready(function () 
    {
         // Autofill when member is selected
        $('#member_id_main').on('change', function () {
            const memberId = $(this).val();
            const member = membersData[memberId];

console.log(member);

            if (member) {
                $('#member_name').val(member.first_name + ' ' + member.last_name);
                $('#member_mobile').val(member.mobile);
                 $('#branch_id').val(member.branch_id); // auto-select branch
                $('#member_address').val(member.address);

                
            } else {
                $('#member_name').val('');
                $('#member_address').val('');
                $('#member_mobile').val('');
                 $('#branch_id').val('');
            }
        });

        // Trigger on page load to auto-fill if editing
        $('#member_id_main').trigger('change');

        function toggleFirmName() {
            var selectedType = $('input[name="account_type"]:checked').val();
            if (selectedType === 'saving') 
            {
                    $('#firmNameDiv').hide();
            } else if (selectedType === 'current') 
            {
                $('#firmNameDiv').show();
                    
                    $("#firm_d").val("");
                    $("#member_id_main").val("");
                    $("#member_name").val("");
                    $("#member_address").val("");
                    $("#member_mobile").val("");
            }
        }

        // Initial toggle on page load
        toggleFirmName();

        // Toggle on change
        $('input[name="account_type"]').on('change', toggleFirmName);

        // Fade out alerts after 5 seconds
        setTimeout(function () {
            $('#success-alert').fadeOut();
            $('#error-alert').fadeOut();
        }, 5000);
    });
</script>


