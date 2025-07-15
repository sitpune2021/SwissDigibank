@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">Add Branch</h3>
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
        <form id="companyForm" action="{{route('add.branch')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="flex items-start gap-4">
                <label for="company_website" class="w-48 text-sm font-medium">Branch Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="branch_name" id="branch_name" value="{{ old('branch_name') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch name" value="">

                    @error('branch_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_name" class="w-48 text-sm font-medium">Branch Code<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="branch_code" id="branch_code" value="{{ old('branch_code') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter branch code like 'BRH001'" value="">
                    @error('branch_code')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="open_date" class="w-48 text-sm font-medium">Open Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="open_date" id="date2" class="border-none" placeholder="Select Date" value="{{ old('open_date') }}"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" />
                        <i 
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    @error('open_date')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="short_name" class="w-48 text-sm font-medium">IFSC Code<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter IFSC code" value="">
                    @error('ifsc_code')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line1" class="w-48 text-sm font-medium mt-2">Address Line 1<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="address_line1" id="address_line1" value="{{ old('address_line1') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 1">
                    @error('address_line1')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line2" class="w-48 text-sm font-medium">Address Line 2</label>
                <div class="w-full">
                    <input type="text" name="address_line2" id="address_line2" value="{{ old('address_line2') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 2" value="">
                    @error('address_line2')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="city" class="w-48 text-sm font-medium">City<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                        placeholder="Enter city" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="">
                    @error('city')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="state" class="w-48 text-sm font-medium">State<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="hidden" id="oldState" value="{{ old('state') }}">
                    <select name="state" id="stateDropdown"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select State</option>
                    </select>
                    @error('state')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pincode" class="w-48 text-sm font-medium">Pincode<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter pincode" value="">
                    @error('pincode')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="country" class="w-48 text-sm font-medium">Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="country" value="{{ old('country') }}"
                        id="country" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter country" value="">
                    @error('country')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="contact_email" class="w-48 text-sm font-medium">Contact Email</label>
                <div class="w-full">
                    <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                        id="contact_email" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter branch contact email" value="">
                    @error('contact_email')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Contact No.</label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter branch contact no" value="">
                    @error('mobile_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" value="{{ old('landline_no') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter branch landline no" value="">
                    @error('landline_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gst_no" class="w-48 text-sm font-medium">GST No.</label>
                <div class="w-full">
                    <input type="text" name="gst_no" id="gst_no" value="{{ old('gst_no') }}"
                        placeholder="Enter GST No" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="">
                    @error('gst_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="disable_recharge" class="w-48 text-sm font-medium">Disable Recharge / Bill Payment Service<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <label>
                        <input type="radio" name="disable_recharge" value="yes" {{ old('disable_recharge') == 'yes' ? 'checked' : '' }}>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="disable_recharge" value="no" {{ old('disable_recharge') == 'no' ? 'checked' : '' }}>
                        No
                    </label>
                    @error('disable_recharge')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="disable_neft" class="w-48 text-sm font-medium">Disable NEFT/ IMPS / WITHIN Transfer Service<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <label>
                        <input type="radio" name="disable_neft" value="yes" value="yes" {{ old('disable_neft') == 'yes' ? 'checked' : '' }}>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="disable_neft" value="no" {{ old('disable_neft') == 'no' ? 'checked' : '' }}>
                        No
                    </label>
                    @error('disable_neft')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Save Branch
                </button>
                <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('manage.branch') }}'">
                    Back
                </button>
                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
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

<script>
    $(document).ready(function() {
        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#stateDropdown');
                select.empty();
                select.append('<option value="">Select State</option>');
                let oldState = $('#oldState').val();
                $.each(states, function(index, state) {
                    let selected = (state.id == oldState) ? 'selected' : '';
                    select.append('<option value="' + state.id + '" ' + selected + '>' + state.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#incorporation_state');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    select.append('<option value="' + state.id + '">' + state.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });
</script>