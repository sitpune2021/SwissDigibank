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
                <li><a href="{{ url('/manage.shareholding') }}" class="text-blue-600 hover:underline">Promoter Share
                        Holdings</a></li>
                <li><a class="text-blue-600">New</a></li>
                <!-- <li class="text-gray-500">Manage Promoters</li> -->
            </ol>
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
            {{-- <form  action="{{route('add.shareholding')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">


            <div class="flex items-start gap-4">
                <label for="branch" class="w-48 text-sm font-medium">Promoter<span class="text-red-500">*</span></label>
                <!-- <div class="w-full"> -->
                <select name="promoter" id="promoterDropdown"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select Promoter</option>
                </select>
                @error('promoter')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="allotment_date" class="w-48 text-sm font-medium">Allotment Date<span class="text-red-500">*</span></label>
                <!-- <div class="w-full"> -->
                <!-- <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl"> -->
                <input name="allotment_date" id="date2" placeholder="Select Date" class="w-full text-sm border px-3 py-2" autocomplete="off" />
                <i
                    class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                <!-- </div> -->
                @error('allotment_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <!-- </div> -->
            </div>

            <div class="flex items-start gap-4">
                <label for="share_no" class="w-48 text-sm font-medium">First Distinctive No.<span class="text-red-500">*</span></label>
                <!-- <div class="w-full"> -->
                <input name="first_share" id="first_share"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter First Share No">

                @error('share_no')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <!-- </div> -->
            </div>

            <div class="flex items-start gap-4">
                <label for="last_share" class="w-48 text-sm font-medium">Last Distinctive No.<span class="text-red-500">*</span></label>
                <!-- <div class="w-full"> -->
                <!-- <div class="flex gap-4"> -->
                <input name="share_no" id="share_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter Last Share No">

                <!-- </div> -->
                @error('last_share')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <!-- </div> -->
            </div>

            <div class="flex items-start gap-4">
                <label for="first_name" class="w-48 text-sm font-medium">Share Nominal Value<span class="text-red-500">*</span></label>
                <!-- <div class="w-full"> -->
                <input type="text" name="first_name" id="first_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="" value="">
                @error('first_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <!-- </div> -->
            </div>

            <div class="flex items-start gap-4">
                <label for="total_share_held" class="w-48 text-sm font-medium">Total Share Held<span class="text-red-500">*</span></label>
                <input type="text" name="total_share_held" id="total_share_held" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Total No. of Shares" value="">
                @error('total_share_held')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>


            <div class="flex items-start gap-4">
                <label for="total_share_value" class="w-48 text-sm font-medium mt-2">Total Share Value<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="total_share_value" id="total_share_value" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Share Value">
                    @error('total_share_value')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="certificate_no" class="w-48 text-sm font-medium">Certificate No</label>
                <input type="text" name="certificate_no" id="certificate_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Certificate No" value="">
                @error('lastname')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- <div class="flex items-start gap-4">
                <label for="transaction_date" class="w-48 text-sm font-medium">Transaction Date<span class="text-red-500">*</span></label>
                <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                    <input name="transaction_date" id="date" class="border-none" placeholder="Select Date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" />
                    <i
                        class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                </div>
                @error('transaction_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="amount" class="w-48 text-sm font-medium">Amount<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="amount" id="amount" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter Amount" value="">
                    @error('amount')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="remarks" class="w-48 text-sm font-medium">Remarks (if any)<span class="text-red-500">*</span></label>
                <input type="text" name="remarks" id="remarks" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter Remark (if any)" value="">
                @error('remarks')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-start gap-4">
                <label for="pay_mode" class="w-48 text-sm font-medium">Pay Mode<span class="text-red-500">*</span></label>
                <label>
                    <input type="radio" name="pay_mode" value="yes" {{ old('pay_mode') == 'cash' ? 'checked' : '' }}>
                    Cash
                </label>
                <label>
                    <input type="radio" name="pay_mode" value="online_tr" {{ old('pay_mode') == 'online_tr' ? 'checked' : '' }}>
                    Online Tr.
                </label>
                <label>
                    <input type="radio" name="pay_mode" value="cheque" {{ old('pay_mode') == 'cheque' ? 'checked' : '' }}>
                   Cheque
                </label>
                <label>
                    <input type="radio" name="pay_mode" value="saving_ac" {{ old('pay_mode') == 'saving_ac' ? 'checked' : '' }}>
                   Saving Ac.
                </label>
                @error('pay_mode')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div> -->

            <div class="col-span-2 mt-8 flex flex-col items-center gap-6 w-full">

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="transaction_date" class="w-48 text-sm font-medium text-right">Transaction Date<span class="text-red-500">*</span></label>
                    <div class="relative w-80 bg-secondary/5 py-2 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
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
                        class="w-80 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-4 py-2"
                        placeholder="Enter Amount">
                    @error('amount')
                    <span class="text-red-500 text-xs w-full">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-center gap-4 w-full max-w-2xl">
                    <label for="remarks" class="w-48 text-sm font-medium text-right">Remarks (if any)<span class="text-red-500">*</span></label>
                    <input type="text" name="remarks" id="remarks"
                        class="w-80 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-4 py-2"
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
                <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('manage.shareholding') }}'">
                    Back
                </button>
                <button class="btn-outline" type="reset"  onclick="document.getElementById('companyForm').reset();">
                    Reset
                </button>
            </div>
        </form> --}}
        <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
            {{-- <form action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4" id="dynamicForm"> --}}
                @csrf

                @foreach ($formFields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'] ?? ucfirst($name);
                        $id = $field['id'] ?? $name;
                        $required = $field['required'] ?? false;
                        $value = old($name, $data[$name] ?? '');
                        $hasHtml = isset($field['html']);
                        $options = $field['option'] ?? [];

                        // Handle dynamic options from controller
                        if (
                            !empty($field['dynamic']) &&
                            !empty($field['objectKey']) &&
                            isset($dynamicOptions[$field['objectKey']])
                        ) {
                            $options = $dynamicOptions[$field['objectKey']];
                        }
                    @endphp

                    <div class="col-span-2 md:col-span-1 relative">
                        <label for="{{ $id }}" class="block mb-2 font-medium">
                            {{ $label }} @if ($required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        {{-- SELECT FIELD --}}
                        @if ($type === 'select')
                            <select name="{{ $name }}" id="{{ $id }}"
                                class="w-full bg-white border border-gray-300 rounded px-3 py-2"
                                {{ $required ? 'required' : '' }}>
                                <option value="">-- Select {{ $label }} --</option>
                                @foreach ($options as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                                        {{ $optionLabel }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- RADIO FIELD --}}
                        @elseif ($type === 'radio')
                            <div class="flex gap-4 mt-1">
                                @foreach ($options as $optionValue => $optionLabel)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                            {{ $value == $optionValue ? 'checked' : '' }}
                                            {{ $required ? 'required' : '' }}>
                                        <span>{{ $optionLabel }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- TEXT FIELD --}}
                        @else
                            <div class="relative">
                                <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                                    value="{{ $value }}"
                                    class="w-full bg-white border border-gray-300 rounded px-3 py-2 pr-10"
                                    placeholder="Enter {{ strtolower($label) }}" {{ $required ? 'required' : '' }} />
                                {!! $hasHtml ? $field['html'] : '' !!}
                            </div>
                        @endif

                        {{-- Validation Error --}}
                        @error($name)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="col-span-2 flex gap-4 mt-6">
                    <button type="submit" class="btn-primary">Save</button>
                    <button type="reset" class="btn-outline">Reset</button>
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
            url: "{{ url('/get-branches') }}",
            type: "GET",
            success: function(response) {
                $.each(response, function(key, branch) {
                    $('#branchDropdown').append(
                        `<option value="${branch.id}">${branch.branch_name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch branches.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/get-marital-statuses') }}",
            type: 'GET',
            success: function(response) {
                $.each(response, function(index, status) {
                    $('#mariatal_status').append(
                        `<option value="${status.id}">${status.status}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/get-religion-statuses') }}",
            type: 'GET',
            success: function(response) {
                $.each(response, function(index, status) {
                    $('#member_religion').append(
                        `<option value="${status.id}">${status.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
