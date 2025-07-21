@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">Add Schemes</h3>
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
        <form id="companyForm" action="{{route('schemes.create')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Branch Name <span
                class="text-red-500">*</span></label>
                <input type="text" name="branch_name" id="branch_name" value="{{ old('branch_name') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch name" value="">

                    @error('branch_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Branch Code <span
                class="text-red-500">*</span></label>
                <input type="text" name="branch_code" id="branch_code" value="{{ old('branch_code') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch code like 'BRH001'" value="">
                    @error('branch_code')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Open Date <span
                class="text-red-500">*</span></label>
                <input name="open_date" id="date2" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Select Date"
                            value="{{ old('open_date') }}"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer" style="top: 73%;"></i>
                            @error('open_date')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">IFSC Code <span
                class="text-red-500">*</span></label>
                <input type="text" name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter IFSC code" value="">
                    @error('ifsc_code')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Address Line 1 <span
                class="text-red-500">*</span></label>
                <input name="address_line1" id="address_line1" value="{{ old('address_line1') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter address line 1">
                    @error('address_line1')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>
            
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Address Line 2 <span
                class="text-red-500">*</span></label>
                <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter address line 2" value="">
                    @error('address_line2')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">City <span class="text-red-500">*</span></label>
                <input type="text" name="city" id="city" value="{{ old('city') }}" placeholder="Enter city"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="">
                    @error('city')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">State <span class="text-red-500">*</span></label>
                <input type="text" name="city" id="city" value="{{ old('city') }}" placeholder="Enter city"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="">
                    @error('city')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Pincode <span class="text-red-500">*</span></label>
                <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter pincode" value="">
                    @error('pincode')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>
            

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Country <span class="text-red-500">*</span></label>
                <input type="text" name="country" value="{{ old('country') }}" id="country"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter country" value="">
                    @error('country')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Contact Email <span class="text-red-500">*</span></label>
                <input type="email" name="contact_email" value="{{ old('contact_email') }}" id="contact_email"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch contact email" value="">
                    @error('contact_email')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>


            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Contact No. <span class="text-red-500">*</span></label>
                <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch contact no" value="">
                    @error('mobile_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>
            
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Landline No.<span class="text-red-500">*</span></label>
                <input type="text" name="landline_no" id="landline_no" value="{{ old('landline_no') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch landline no" value="">
                    @error('landline_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">GST No.<span class="text-red-500">*</span></label>
                <input type="text" name="gst_no" id="gst_no" value="{{ old('gst_no') }}" placeholder="Enter GST No"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="">
                    @error('gst_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Disable Recharge / Bill Payment<span class="text-red-500">*</span></label>
                <label>
                        <input type="radio" name="disable_recharge" value="yes"
                            {{ old('disable_recharge') == 'yes' ? 'checked' : '' }}>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="disable_recharge" value="no"
                            {{ old('disable_recharge') == 'no' ? 'checked' : '' }}>
                        No
                    </label>
                    @error('disable_recharge')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>


            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Disable Recharge / Bill Payment<span class="text-red-500">*</span></label>
                <label>
                        <input type="radio" name="disable_neft" value="yes" value="yes"
                            {{ old('disable_neft') == 'yes' ? 'checked' : '' }}>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="disable_neft" value="no"
                            {{ old('disable_neft') == 'no' ? 'checked' : '' }}>
                        No
                    </label>
                    @error('disable_neft')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
            </div>


            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Save Branch
                </button>
                <!-- <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('manage.branch') }}'">
                    Back
                </button> -->
                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
