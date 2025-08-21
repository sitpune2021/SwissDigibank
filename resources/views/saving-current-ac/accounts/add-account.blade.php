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
                    @error('member_name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

            </div>

            {{-- Member Address --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_address" class="font-medium block mb-4">Member Address</label>
                <input type="text" readonly name="member_address" id="member_address"
                    value="{{ old('member_address', $account->member_address ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Member address">
                @error('member_address') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                </div>

            {{-- Member Mobile --}}
            <div class="col-span-2 md:col-span-1">
                <label for="member_mobile" class="font-medium block mb-4">Member Mobile No.</label>
                <input type="text" name="member_mobile" readonly id="member_mobile"
                    value="{{ old('member_mobile', $account->member_mobile ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Mobile number">
                @error('member_mobile') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                </div>

            {{-- Minor --}}
            <div class="col-span-2 md:col-span-1">
                <label for="minor_id" class="font-medium block mb-4">Minor</label>
                <select name="minor_id" id="minor_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
                   <option>-- Select Minor --</option>
                </select>
            @error('minor_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

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

                @error('branch_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

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
                @error('advisor_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

            </div>

            {{-- Scheme --}}
            <div class="col-span-2 md:col-span-1">
                <label for="scheme_id" class="font-medium block mb-4">Scheme <span class="text-red-500">*</span></label>
               <select name="scheme_id" id="scheme_id" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
                    <option value="">-- Select Scheme --</option>
                    @foreach($schemes as $id => $name)
                        <option value="{{ $id }}" {{ old('scheme_id', $account->scheme_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('scheme_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                {{-- Minimum amount note --}}
                <span class="text-gray-500 text-xs mt-1 block" style="color:green" id="minAmountNote"></span>

                

            </div>

            {{-- Open Date --}}
            <div class="col-span-2 md:col-span-1">
                <label for="open_date" class="font-medium block mb-4">Open Date <span class="text-red-500">*</span></label>
                <input type="text" readonly name="open_date" id="open_date"
                    value="{{ date('D M d Y h:i:s A') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
            @error('open_date') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

            </div>

            {{-- Amount --}}
            <div class="col-span-2 md:col-span-1">
                <label for="amount" class="font-medium block mb-4">Amount Deposit <span class="text-red-500">*</span></label>
                <input type="number" name="amount" id="amount"
                    value="{{ old('amount', $account->amount ?? '') }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >

                @error('amount') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
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
                                {{ old('account_holder_type', $account->account_holder_type ?? 'single') === 'single' ? 'checked' : '' }}>
                            Single
                        </label>
                        <label>
                            <input type="radio" name="account_holder_type" value="joint"
                                {{ old('account_holder_type', $account->account_holder_type ?? '') === 'joint' ? 'checked' : '' }}>
                            Joint A/C
                        </label>
                        @error('account_holder_type') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                    </div>
                </div>

               
            <div class="col-span-2 md:col-span-1"></div>

    <!-- // Hidden  section-->
            {{-- Joint A/c Member 1 --}}
            <div class="col-span-2 md:col-span-1 hidden jointAccountSection1" >
                <label for="member_id_one_one" class="font-medium block mb-4">Joint A/c Member 1 <span class="text-red-500"></span></label>
                <select name="member_id_one" id="member_id_one_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                      <option value="{{ $member->id }}" {{ old('member_id_one', $account->member_id ?? '') == $member->id ? 'selected' : '' }}>
                                {{ "MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name }}
                        </option>

                    @endforeach
                </select>
                @error('member_id_one') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>
            

            {{-- Joint A/c Member 2 --}}
            <div class="col-span-2 md:col-span-1 hidden jointAccountSection2">
                <label for="member_id_two" class="font-medium block mb-4">Joint A/c Member 2 <span class="text-red-500"></span></label>
                 <select name="member_id_two" id="member_id_two_main" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" >
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                      <option value="{{ $member->id }}" {{ old('member_id_two', $account->member_id ?? '') == $member->id ? 'selected' : '' }}>
                                {{ "MEM -". $member->id . ' - ' . $member->member_info_first_name . ' ' . $member->member_info_last_name }}
                        </option>

                    @endforeach
                </select>
                @error('member_id_two') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Mode of Operation --}}
            <div class="col-span-2 md:col-span-1 hidden jointAccountSection3" id="mode-operation">
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
                @error('mode_of_operation') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

            </div>
  

<!-- // Hidden  section-->
            
<!-- ------------------nominees-------------------- -->
 <div class="col-span-2">
                <hr class="my-4">
            </div>
       <div class="col-span-2 md:col-span-1">
    <label class="font-medium block mb-4">Nominee <span class="text-red-500">*</span></label>
    <div class="flex gap-5">
        <label>
            <input type="radio" name="nominee" value="no"
                {{ (old('nominee', $account->nominee ?? null) === 'no' || old('nominee', $account->nominee ?? null) === null) ? 'checked' : '' }}>
            No
        </label>
        <label>
            <input type="radio" name="nominee" value="yes"
                {{ old('nominee', $account->nominee ?? null) === 'yes' ? 'checked' : '' }}>
            Yes
        </label>
        @error('nominee') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

    </div>
</div>

<div id="nomineeDetails" class="{{ (old('nominee', $account->nominee ?? null) === 'yes') ? '' : 'hidden' }}">
    <div class="col-span-2 md:col-span-1 mt-4">
        <label class="font-medium block mb-2">Relation <span class="text-red-500">*</span></label>
        <select name="nominee_relation" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">
            <option value="">Select Relation</option>
            <option value="father" {{ old('nominee_relation', $account->nominee_relation ?? '') === 'father' ? 'selected' : '' }}>Father</option>
            <option value="mother" {{ old('nominee_relation', $account->nominee_relation ?? '') === 'mother' ? 'selected' : '' }}>Mother</option>
            <option value="spouse" {{ old('nominee_relation', $account->nominee_relation ?? '') === 'spouse' ? 'selected' : '' }}>Spouse</option>
            <option value="child" {{ old('nominee_relation', $account->nominee_relation ?? '') === 'child' ? 'selected' : '' }}>Child</option>
            <!-- Add more as needed -->
        </select>
        @error('nominee_relation') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

    </div>

    <div class="col-span-2 md:col-span-1 mt-4">
        <label class="font-medium block mb-2">Name <span class="text-red-500">*</span></label>
        <input type="text" name="nominee_name" value="{{ old('nominee_name', $account->nominee_name ?? '') }}"
            class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Enter Nominee Name">
        @error('nominee_name') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

        </div>

    <div class="col-span-2 md:col-span-1 mt-4">
        <label class="font-medium block mb-2">Address <span class="text-red-500">*</span></label>
        <textarea name="nominee_address" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Enter Nominee Address">{{ old('nominee_address', $account->nominee_address ?? '') }}</textarea>
        @error('nominee_address') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="col-span-2 mt-4">
        <button type="button" id="addMoreNominee" class="btn-outline">+ ADD MORE NOMINEE</button>
    </div>

    <div id="additionalNominees" class="col-span-2 mt-4"></div>
</div>


<!-- -----------------------nominees--------------- -->

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
                            {{ (old('payment_mode', $account->payment_mode ?? '') === 'cash' || old('payment_mode', $account->payment_mode ?? '') === '') ? 'checked' : '' }}>
                        Cash
                    </label>

                    <!-- <label>
                        <input type="radio" name="payment_mode" value="online"
                            {{ old('payment_mode', $account->payment_mode ?? '') === 'online' ? 'checked' : '' }}>
                        Online Tr.
                    </label>
                    <label>
                        <input type="radio" name="payment_mode" value="cheque"
                            {{ old('payment_mode', $account->payment_mode ?? '') === 'cheque' ? 'checked' : '' }}>
                        Cheque
                    </label> -->
                </div>
            </div>

            {{-- Transaction Date --}}
            <div class="col-span-2 md:col-span-1">
                <label for="transaction_date" class="font-medium block mb-4"><span class="text-red-500">*</span>Transaction Date</label>
                
                <input type="text" name="transaction_date" id="date2"
                    value="{{ old('transaction_date', date('Y-m-d')) }}"
                    class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3">

                    @error('transaction_date') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Buttons --}}
            <div class="col-span-2 flex gap-4 mt-4">
                <button class="btn-primary" type="submit">{{ $method === 'PUT' ? 'Update' : 'Open' }} Account</button>
                <button class="btn-outline" type="reset">Reset</button>
                <button class="btn-outline" type="button" onclick="window.location.href='{{ route('accounts.index') }}'">Back</button>
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
                'address' => ($member->address)->member_address_line_1 ?? '',
                'minors' => $member->minors->map(function ($minor) {
                    return [
                        'id' => $minor->id,
                        'first_name' => $minor->first_name,
                        'last_name' => $minor->last_name,
                    ];
                })->toArray(),
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
                    
            const schemeMinimums = @json($schemeMinimums);

            $('#scheme_id').on('change', function () 
            {
                const selectedId = $(this).val();

                const minAmount = schemeMinimums[selectedId];

                if (minAmount) {
                    $('#minAmountNote').text('Minimum required amount is ₹' + minAmount);
                } else {
                    $('#minAmountNote').text('');
                }
            });

            // Trigger on page load if already selected (e.g., in edit mode or after validation error)
            $('#scheme_id').trigger('change');

                    // Autofill when member is selected
                    $('#member_id_main').on('change', function () 
                    {

                        const memberId = $(this).val();
                        const member = membersData[memberId];

                        console.log(member);

                        if (member) 
                        {
                            $('#member_name').val(member.first_name + ' ' + member.last_name);
                            $('#member_mobile').val(member.mobile);
                            $('#branch_id').val(member.branch_id); // auto-select branch
                            $('#member_address').val(member.address);

                                const $minorSelect = $('#minor_id');
                                    $minorSelect.empty().append('<option value="">-- Select Minor --</option>');

                                    if (member?.minors?.length) 
                                    {
                                        member.minors.forEach(minor => {
                                        $minorSelect.append(
                                        `<option value="${minor.id}">${minor.first_name} ${minor.last_name}</option>`);
                                    });
                                }

                            
                        } else {
                            $('#member_name').val('');
                            $('#member_address').val('');
                            $('#member_mobile').val('');
                            $('#branch_id').val('');
                        }
                    });

                    // Trigger on page load to auto-fill if editing
                    $('#member_id_main').trigger('change');

                    function toggleFirmName() 
                    {
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

                    // ============================

                    function jointHolderFields() 
                    {
                        var selectedType = $('input[name="account_holder_type"]:checked').val();

                        if (selectedType === 'single') 
                        {
                                $('.jointAccountSection1').hide();
                                $('.jointAccountSection2').hide();
                                $('.jointAccountSection3').hide();
                        } else if (selectedType === 'joint') 
                        {
                        
                            $('input[name="mode_of_operation"][value="single"]').prop('checked', true);

                            $('.jointAccountSection1').show();
                            $('.jointAccountSection2').show();
                            $('.jointAccountSection3').show();
                                
                                $("#firm_d").val("");
                                // $("#member_id_main").val("");
                                // $("#member_name").val("");
                                // $("#member_address").val("");
                                // $("#member_mobile").val("");
                        }
                    }

                    // Initial toggle on page load
                    jointHolderFields();

                    // Toggle on change
                    $('input[name="account_holder_type"]').on('change', jointHolderFields);

                    // Fade out alerts after 5 seconds
                    setTimeout(function () {
                        $('#success-alert').fadeOut();
                        $('#error-alert').fadeOut();
                    }, 5000);




                    // Toggle nominee details based on radio selection
                $('input[name="nominee"]').on('change', function () {
                    if ($(this).val() === 'yes') {
                        $('#nomineeDetails').removeClass('hidden');
                    } else {
                        $('#nomineeDetails').addClass('hidden');
                        // Optionally clear fields
                        $('#nomineeDetails').find('input, select, textarea').val('');
                        $('#additionalNominees').empty();
                    }
                });

                // Handle Add More Nominee button
                $('#addMoreNominee').on('click', function () {
                    const index = $('#additionalNominees .nominee-block').length;

                    const nomineeBlock = `
                    <div class="nominee-block border border-gray-300 rounded p-4 mb-4">
                        <label class="font-medium block mb-2">Relation <span class="text-red-500">*</span></label>
                        <select name="additional_nominee_relation[]" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3 mb-3">
                            <option value="">Select Relation</option>
                            <option value="father">Father</option>
                            <option value="mother">Mother</option>
                            <option value="spouse">Spouse</option>
                            <option value="child">Child</option>
                            <!-- Add more as needed -->
                        </select>
                        <label class="font-medium block mb-2">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="additional_nominee_name[]" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3 mb-3" placeholder="Enter Nominee Name">
                        <label class="font-medium block mb-2">Address <span class="text-red-500">*</span></label>
                        <textarea name="additional_nominee_address[]" class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-3" placeholder="Enter Nominee Address"></textarea>
                        <button type="button" class="removeNominee btn-outline mt-2">Remove</button>
                    </div>
                    `;

                    $('#additionalNominees').append(nomineeBlock);
                });

                // Remove additional nominee block
                $(document).on('click', '.removeNominee', function () {
                    $(this).closest('.nominee-block').remove();
                });
        });

      


</script>


