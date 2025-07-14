@extends('layout.main')

@section('content')
<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 30px;
        text-align: center;
        line-height: 30px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4CAF50;
    }

    input:checked+.slider:before {
        transform: translateX(30px);
    }

    .slider .switch-on,
    .slider .switch-off {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider .switch-on {
        left: 0;
    }

    .slider .switch-off {
        right: 0;
    }
</style>
<div class="main-inner">
    <div class="mb-6 lg:mb-8">
        <h3 class="h2">Allocate New Shares to Promoter</h3>
        <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
            <li><a href="{{ url('/manage.shareholding') }}" class="text-blue-600 hover:underline">Promoter Share Holdings</a></li>
            <li><a class="text-blue-600">New</a></li>
            <!-- <li class="text-gray-500">Manage Promoters</li> -->
        </ol>
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
        <form action="{{route('add.shareholding')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6 w-full">
            @csrf

            <div class="flex items-start gap-4">
                <label for="branch" class="w-48 text-sm font-medium">Promoter<span class="text-red-500">*</span></label>
                <select name="promoter" id="promoterDropdown"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select Promoter</option>
                </select>
                @error('promoter')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="allotment_date" class="w-48 text-sm font-medium">Allotment Date<span class="text-red-500">*</span></label>
                <input name="allotment_date" id="date2" placeholder="Select Date" class="w-full text-sm border px-3 py-2" autocomplete="off" />
                <i
                    class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                @error('allotment_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="share_no" class="w-48 text-sm font-medium">First Distinctive No.<span class="text-red-500">*</span></label>
                <input name="first_share" id="first_share"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter First Share No">

                @error('share_no')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="last_share" class="w-48 text-sm font-medium">Last Distinctive No.<span class="text-red-500">*</span></label>
                <input name="share_no" id="share_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Last Share No">

                @error('last_share')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="share_nominal" class="w-48 text-sm font-medium">Share Nominal Value</label>
                <input type="text" name="share_nominal" id="share_nominal" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="10.0" value="{{ old('share_nominal', '10.0') }}" readonly>
                @error('share_nominal')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="total_share_held" class="w-48 text-sm font-medium">Total Share Held</label>
                <input type="text" name="total_share_held" id="total_share_held" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Total No. of Shares" value="">
                @error('total_share_held')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="total_share_value" class="w-48 text-sm font-medium mt-2">Total Share Value<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="total_share_value" id="total_share_value" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Share Value">
                    @error('total_share_value')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="certificate_no" class="w-48 text-sm font-medium">Certificate No</label>
                <input type="text" name="certificate_no" id="certificate_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="2000230233" value="2000230233" readonly>
                @error('lastname')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 mt-8 flex flex-col items-center gap-6 w-full">

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="transaction_date" class="w-48 text-sm font-medium text-right">Transaction Date<span class="text-red-500">*</span></label>
                    <div class="relative w-80 bg-secondary/5 py-2 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10">
                        <input name="transaction_date" id="date"
                            class="w-full text-sm bg-transparent border-none px-3 pr-10 py-2"
                            placeholder="Select Date" autocomplete="off" />
                        <i class="las la-calendar absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                    </div>
                    @error('transaction_date')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="amount" class="w-48 text-sm font-medium text-right">Amount<span class="text-red-500">*</span></label>
                    <input type="text" name="amount" id="amount"
                        class="w-80 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2"
                        placeholder="Enter Amount">
                    @error('amount')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="remarks" class="w-48 text-sm font-medium text-right">Remarks (if any)</label>
                    <input type="text" name="remarks" id="remarks"
                        class="w-80 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-4 py-2"
                        placeholder="Enter Remark (if any)">
                    @error('remarks')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="pay_mode" class="w-48 text-sm font-medium text-right">Pay Mode<span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-4">
                        <label><input type="radio" name="pay_mode" value="cash" {{ old('pay_mode') == 'cash' ? 'checked' : '' }}> Cash</label>
                        <label><input type="radio" name="pay_mode" value="online_tr" {{ old('pay_mode') == 'online_tr' ? 'checked' : '' }}> Online Tr.</label>
                        <label><input type="radio" name="pay_mode" value="cheque" {{ old('pay_mode') == 'cheque' ? 'checked' : '' }}> Cheque</label>
                        <label><input type="radio" name="pay_mode" value="saving_ac" {{ old('pay_mode') == 'saving_ac' ? 'checked' : '' }}> Saving Ac.</label>
                    </div>
                    @error('pay_mode')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Allocate Share
                </button>
                <!-- <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('manage.shareholding') }}'">
                    Back
                </button> -->
                <button class="btn-outline" type="reset">
                    Reset
                </button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/get-promoters') }}",
            type: "GET",
            success: function(response) {
                $.each(response, function(key, promoter) {
                    $('#promoterDropdown').append(`<option value="${promoter.id}">${promoter.member_no}-${promoter.first_name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch promoters.');
            }
        });
    });
</script>