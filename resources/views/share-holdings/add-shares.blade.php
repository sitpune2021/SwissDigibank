@extends('layout.main')

@section('content')

<div class="main-inner">
    <div class="mb-6 lg:mb-8">
        <h3 class="h2">{!! (isset($show) && $show)
            ? $shareholding->promoters->first_name . ' <small class="text-sm text-gray-500">Share Holding</small>'
            : (isset($shareholding) ? 'Edit Allocated Shares' : 'Allocate New Shares to Promoter') !!}
        </h3>
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
        <form action="{{  isset($shareholding) ? ($show ?? false ? '#' : route('shareholding.update', $shareholding->id)) : route('add.shareholding') }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6 w-full">
            @csrf
            @if(isset($shareholding) && empty($show))
            @method('PUT')
            @endif

            @php $isView = !empty($show); @endphp
            <div class="col-span-2 md:col-span-1">
                <label for="branch" class="md:text-lg font-medium block mb-4">Promoter<span class="text-red-500">*</span></label>
                <input type="hidden" id="selectedId" value="{{ isset($shareholding) ? $shareholding->promoter : '' }}">
                @if(isset($isView) && $isView)
                {{-- View Mode: Just display the member name --}}
                <input type="text" value="{{ $shareholding->promoters->first_name ?? 'N/A' }}" @if($isView) disabled @endif
                    class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                @else
                <select name="promoter" id="promoterDropdown"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select Promoter</option>
                </select>
                @error('promoter')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                @endif
            </div>

            <div class="col-span-2 md:col-span-1 relative">
                <label for="allotment_date" class="md:text-lg font-medium block mb-4">
                    Allotment Date <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="allotment_date"
                    id="allotment_date"
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
                <label for="first_share" class="md:text-lg font-medium block mb-4">First Distinctive No.<span class="text-red-500">*</span></label>
                <input name="first_share" id="first_share"
                    value="{{ old('first_share', $shareholding->first_share ?? '') }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter First Share No" @if($isView) disabled @endif>

                @error('first_share')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="share_no" class="md:text-lg font-medium block mb-4">Last Distinctive No.<span class="text-red-500">*</span></label>
                <input name="share_no" id="share_no"
                    value="{{ old('share_no', $shareholding->share_no ?? '') }}"
                    class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Last Share No" @if($isView) disabled @endif>

                @error('share_no')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="share_nominal" class="md:text-lg font-medium block mb-4">Share Nominal Value</label>
                <input type="text" name="share_nominal" id="share_nominal"
                    value="{{ old('share_nominal', $shareholding->share_nominal ?? '') }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="10.0" value="{{ old('share_nominal', '10.0') }}" readonly @if($isView) disabled @endif>
                @error('share_nominal')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="total_share_held" class="md:text-lg font-medium block mb-4">Total Share Held</label>
                <input type="text" name="total_share_held" id="total_share_held"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Total No. of Shares" value="{{ old('total_share_held', $shareholding->total_share_held ?? '') }}" @if($isView) disabled @endif>
                @error('total_share_held')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="total_share_value" class="md:text-lg font-medium block mb-4">Total Share Value<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="total_share_value" id="share_nominal"
                        value="{{ old('total_share_value', $shareholding->total_share_value ?? '') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Share Value" @if($isView) disabled @endif>
                    @error('total_share_value')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="certificate_no" class="md:text-lg font-medium block mb-4">Certificate No</label>
                <input type="text" name="certificate_no" id="certificate_no"
                    value="{{ old('designation', $shareholding->designation ?? '') }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="2000230233" value="2000230233">
                @error('lastname')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            @if(isset($isAdd) && $isAdd)
            <div class="col-span-2 mt-8 flex flex-col items-center gap-6 w-full">
                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="transaction_date" class="col-span-2 md:col-span-1">Transaction Date<span class="text-red-500">*</span></label>
                    <div class="relative w-80 bg-secondary/5 py-2 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10">
                        <input name="transaction_date" id="date"
                            value="{{ old('transaction_date', $shareholding->transaction_date ?? '') }}"
                            class="w-full text-sm bg-transparent border-none px-3 pr-10 py-2"
                            placeholder="Select Date" autocomplete="off" @if($isView) disabled @endif />
                        <i class="las la-calendar absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                    </div>
                    @error('transaction_date')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="amount" class="col-span-2 md:col-span-1">Amount<span class="text-red-500">*</span></label>
                    <input type="text" name="amount" id="amount"
                        value="{{ old('amount', $shareholding->amount ?? '') }}"
                        class="w-80 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2"
                        placeholder="Enter Amount" @if($isView) disabled @endif>
                    @error('amount')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="remarks" class="col-span-2 md:col-span-1">Remarks (if any)</label>
                    <input type="text" name="remarks" id="remarks"
                        value="{{ old('remarks', $shareholding->remarks ?? '') }}"
                        class="w-80 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2"
                        placeholder="Enter Remark (if any)" @if($isView) disabled @endif>
                    @error('remarks')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="pay_mode" class="col-span-2 md:col-span-1">Pay Mode<span class="text-red-500">*</span></label>
                    @php
                    $selectedPayMode = old('pay_mode') ?? ($shareholding->pay_mode ?? '');
                    $isView = isset($show) && $show;
                    @endphp
                    <div class="flex flex-wrap gap-4">
                        <label><input type="radio" name="pay_mode" value="cash" {{ $selectedPayMode == 'cash' ? 'checked' : '' }} @if($isView) disabled @endif> Cash</label>
                        <label><input type="radio" name="pay_mode" value="online_tr" {{ $selectedPayMode == 'online_tr' ? 'checked' : '' }} @if($isView) disabled @endif> Online Tr.</label>
                        <label><input type="radio" name="pay_mode" value="cheque" {{ $selectedPayMode == 'cheque' ? 'checked' : '' }} @if($isView) disabled @endif> Cheque</label>
                        <label><input type="radio" name="pay_mode" value="saving_ac" {{ $selectedPayMode == 'saving_ac' ? 'checked' : '' }} @if($isView) disabled @endif> Saving Ac.</label>
                    </div>
                    @error('pay_mode')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @endif
            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                @if(empty($isView))
                <button class="btn-primary" type="submit">
                    {{ isset($shareholding) ? 'Update Share' : 'Allocate Share' }}

                </button>
                <button class="btn-outline" type="reset">
                    Reset
                </button>
                @endif
                @if((isset($isAdd) && $isAdd) || (isset($show) && $isView))
                <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('manage.shareholding') }}'">
                    Back
                </button>
                @endif
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
        const selectedId = $('#selectedId').val(); // Corrected
        $.ajax({
            url: "{{ url('/get-promoters') }}",
            type: "GET",
            success: function(response) {
                let dropdown = $('#promoterDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Promoter</option>');
                $.each(response, function(index, member) {
                    let selected = (selectedId == member.id) ? 'selected' : '';
                    dropdown.append(
                        `<option value="${member.id}" ${selected}>${member.member_no} - ${member.first_name}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to fetch promoters.');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const firstShareInput = document.getElementById('first_share');
        const lastShareInput = document.getElementById('share_no');
        const totalShareHeldInput = document.getElementById('total_share_held');
        const totalValueInput = document.getElementById('total_share_value');
        const shareNominalInput = document.getElementById('share_nominal'); // ✅ Nominal value field

        function calculateSharesAndValue() {
            const first = parseInt(firstShareInput.value) || 0;
            const last = parseInt(lastShareInput.value) || 0;
            const nominal = parseFloat(shareNominalInput.value) || 0;

            if (last >= first) {
                const totalShares = last - first + 1;
                const totalValue = totalShares * nominal;

                totalShareHeldInput.value = totalShares;
                totalValueInput.value = totalValue.toFixed(2);
            } else {
                totalShareHeldInput.value = '';
                totalValueInput.value = '';
            }
        }

        firstShareInput.addEventListener('input', calculateSharesAndValue);
        lastShareInput.addEventListener('input', calculateSharesAndValue);
    });
</script>