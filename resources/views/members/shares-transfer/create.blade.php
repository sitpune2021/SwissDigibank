@extends('layout.main')

@section('content')

<div class="main-inner">
    <div class="mb-6 lg:mb-8">
        <!-- <h3 class="h2">{!! (isset($show) && $show)
            ? $shareholding->promoters->first_name . ' <small class="text-sm text-gray-500">Share Holding</small>'
            : (isset($shareholding) ? 'Edit Allocated Shares' : 'Allocate New Shares to Promoter') !!}
        </h3> -->
        <h3 class="h2">Transfer Shares</h3>
    </div>

    @if (session('success'))
    <div id="success-alert" style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="document.getElementById('success-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert" style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="document.getElementById('error-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
    </div>
    @endif

    <div class="box mb-4 xxxl:mb-6">
        <form action="" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6 w-full">
            @csrf
            @if(isset($shareholding) && empty($show))
            @method('PUT')
            @endif

            @php $isView = !empty($show); @endphp
            <div class="col-span-2 md:col-span-1">
                <label for="transferor" class="md:text-lg font-medium block mb-4">Transferor<span class="text-red-500">*</span></label>
                <input type="text" name="transferor" id="transferor"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Transferor" value="{{ $promoter->promotor?->first_name ?? '' }}" readonly>
                <input type="hidden" name="transferor_id" value="{{ $promoter->promotor?->id ?? '' }}">
                @error('transferor')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div> <br>

            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">Member<span class="text-red-500">*</span></label>
                <!-- <input type="hidden" id="selectedId" value="{{ isset($shareholding) ? $shareholding->promoter : '' }}"> -->
                <input type="hidden" id="selectedId" name="selected_member_id" value="">
                <select name="member_id" id="promoterDropdown"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <!-- <option value="">Select Member</option> -->
                    
                        @if($selectedMember)
                        <option value="{{ $selectedMember->id }}" selected>
                        {{ $selectedMember->member_info_first_name }}
                        </option>
                        @else
                        <option value="">Select Member</option>
                        @foreach($members as $key => $mem)
                        <option value="{{ $key }}">
                        {{ $mem }}
                        </option>
                        @endforeach
                        @endif
                </select>
                @error('promoter')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <div id="memberSharesInfo" class="mt-2 text-sm"></div>
                <a href="{{route('member.create')}}" style="color: blue; font-size: 13px;">Add New Member</a>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="business_type" class="md:text-lg font-medium block mb-4">Business Type<span class="text-red-500">*</span></label>
                <select name="business_type" id="business_type"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select Business Type</option>
                    <option value="FD">FD / MIS</option>
                    <option value="RD">RD / DD</option>
                    <option value="Saving">Saving</option>
                    <option value="Loan">Loan</option>
                    <option value="Shares">Shares</option>
                </select>
                @error('business_type')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1 relative">
                <label for="allotment_date" class="md:text-lg font-medium block mb-4">
                    Transfer Date <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="allotment_date"
                    id="date2"
                    placeholder="Select Date"
                    value="{{ old('allotment_date', isset($shareholding->allotment_date) ? \Carbon\Carbon::parse($shareholding->allotment_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                    class="w-full text-sm bg-gray-100 border border-gray-300 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    @if($isView) disabled @endif
                    autocomplete="off">

                <i class="las la-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>

                @error('allotment_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="share_no" class="md:text-lg font-medium block mb-4">Shares<span class="text-red-500">*</span></label>
                <input name="share_no" id="share_no"
                    value="0"
                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Last Share No" @if($isView) disabled @endif>

                @error('share_no')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="share_nominal" class="md:text-lg font-medium block mb-4">Face Value</label>
                <input type="text" name="share_nominal" id="share_nominal"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="100.0" value="{{ old('share_nominal', '100.0') }}" readonly @if($isView) disabled @endif>
                @error('share_nominal')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="total_consideration" class="md:text-lg font-medium block mb-4">Total Consideration</label>
                <div class="w-full">
                    <input name="total_consideration" id="total_consideration"
                        value="{{ old('total_consideration', $shareholding->total_share_value ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Share Value" @if($isView) disabled @endif>
                    @error('total_consideration')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="w-full col-span-2">
                <div class="bg-primary border-l-4 border-blue-500 text-white p-4 rounded-md mb-6 w-full">
                    <div class="font-semibold text-lg mb-2"> <i class="fa fa-info-circle mr-2"></i>INFO !!</div>
                    <h6>
                        Open saving account of splitting promoter to deposit the share transfer amount automatically and manage your accounting.
                    </h6>
                    <ul class="list-disc list-inside text-sm leading-relaxed space-y-2">
                        <li>
                            You are transferring share from one of the promoter.
                        </li>
                        <li>The amount which you collect from member for the share transferred, should go to the promoter who's share is transferred to the member.</li>
                        <li>
                            We have made this functionality automatic and from here itself you can deposit that share amount to the promoter saving account.
                            So that the amount get accounted correctly.
                        </li>
                        <li>If you don't want the same you can ignore this.</li>
                    </ul>
                </div>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                {{-- Show Submit button only if not view page --}}

                <button class="btn-primary" type="submit">
                    Transfer Share
                </button>
                <a href="{{ route('shares-transfer.index') }}" class="btn-outline inline-flex items-center justify-center">
                    Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>

<script>
    $(document).ready(function() {
        const selectedId = $('#selectedId').val();
        const dropdown = $('#promoterDropdown');
        const businessTypeDropdown = $('#business_type');

        const sharesInput = $('#share_no');
        const faceValueInput = $('#share_nominal');
        const totalConsiderationInput = $('#total_consideration');

        const infoBox = $('#memberSharesInfo');

        let businessTypeSelected = false;
        let currentShares = 0; // 

        function calculateTotal() {
            if (!businessTypeSelected) {
                totalConsiderationInput.val("0.00");
                return;
            }
            let shares = parseFloat(sharesInput.val()) || 0;
            let faceValue = parseFloat(faceValueInput.val()) || 0;
            let total = shares * faceValue;
            totalConsiderationInput.val(total.toFixed(2));
        }




        dropdown.on('change', function() {
            let memberId = $(this).val();

            if (!memberId) {
                infoBox.text('');
                currentShares = 0;
                sharesInput.val(0);
                calculateTotal();
                return;
            }

            $.ajax({
                url: `/get-promoter-shares/${memberId}`,
                type: "GET",
                success: function(data) {
                    currentShares = parseInt(data.shares) || 0;
                    infoBox.html(`This member currently has <b>${currentShares}</b> shares.`);
                    sharesInput.val(0);
                    calculateTotal();
                },
                error: function() {
                    infoBox.text('Unable to fetch share info.');
                    currentShares = 0;
                    sharesInput.val(0);
                    calculateTotal();
                }
            });
        });

        // On business type change
        businessTypeDropdown.on('change', function() {
            businessTypeSelected = !!$(this).val();

            if (this.value === 'Saving') {
                sharesInput.val(1);
            } else if (this.value === 'FD') {
                sharesInput.val(10);
            } else if (this.value === 'RD') {
                sharesInput.val(1);
            } else if (this.value === 'Loan') {
                sharesInput.val(1);
            } else if (this.value === 'Shares') {
                let remaining = 100 - currentShares; // ✅ use global
                sharesInput.val(remaining > 0 ? remaining : 0);
            } else {
                sharesInput.val(0);
            }

            calculateTotal();
        });

        sharesInput.on('input', calculateTotal);
        faceValueInput.on('input', calculateTotal);

        totalConsiderationInput.val("0.00");
    });
</script>