@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <h3 class="h2">Add New Company</h3>
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
        <form action="{{route('add.profile')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="flex items-start gap-4">
                <label for="company_website" class="w-48 text-sm font-medium">Company Website</label>
                <div class="w-full">
                    <input type="text" name="company_website" id="company_website"
                        class="w-full text-sm border rounded px-3 py-2"
                        placeholder="Enter company name" value="{{ old('company_website') }}">

                    @error('company_website')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_name" class="w-48 text-sm font-medium">Company Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="company_name" id="company_name"
                        class="w-full text-sm border rounded px-3 py-2"
                        placeholder="Enter company name" value="{{ old('company_name') }}">

                    @error('company_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="short_name" class="w-48 text-sm font-medium">Short Name<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="short_name" id="short_name" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter short name" value="{{ old('short_name') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="short_name" id="short_name" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter short name" value="{{ old('short_name') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('short_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="about_company" class="w-48 text-sm font-medium mt-2">About Company<span class="text-red-500">*</span></label>
                <!-- <textarea name="about_company" id="about_company" rows="3" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter about company" class="flex-1 text-sm border rounded px-3 py-2">{{ old('about_company') }}</textarea> -->
                <div class="w-full">
                    <textarea name="about_company" id="about_company" rows="3" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter about company" class="flex-1 text-sm border rounded px-3 py-2">{{ old('about_company') }}</textarea>
                    @error('about_company')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="email" class="w-48 text-sm font-medium">User ID<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="email" name="user_id" id="email" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter email" value="">
                    @error('user_id')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="password" class="w-48 text-sm font-medium">Password<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="password" name="password" id="password" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter password">
                    @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <h4>Reg. Office Address:</h4><br>
            <div class="flex items-start gap-4">
                <label for="address_line1" class="w-48 text-sm font-medium">Address Line 1<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="address_line1" id="address_line1" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter Address Line 1" value="{{ old('address_line1') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="address_line1" id="address_line1" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter short name" value="{{ old('short_name') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('address_line1')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line2" class="w-48 text-sm font-medium">Address Line 2</label>
                <!-- <input type="text" name="address_line2" id="address_line2" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter Address Line 2" value="{{ old('address_line2') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="address_line2" id="address_line2" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter Address Line 2" value="{{ old('address_line2') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('address_line2')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="city" class="w-48 text-sm font-medium">City<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="city" id="city" placeholder="Enter city" class="w-full text-sm border rounded px-3 py-2" value="{{ old('city') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="city" id="city" placeholder="Enter city" class="w-full text-sm border rounded px-3 py-2" value="{{ old('city') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('city')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="state" class="w-48 text-sm font-medium">State<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="state" id="state" placeholder="Enter state" value="{{ old('state') }}" class="flex-1 text-sm border rounded px-3 py-2" required> -->
                <div class="w-full">
                    <select name="state" id="stateDropdown" class="w-full text-sm border rounded px-3 py-2">
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
                    <input type="text" name="pincode" id="pincode" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter pincode" value="{{ old('pincode') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('pincode')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="country" class="w-48 text-sm font-medium">Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="country" id="country" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter country" value="{{ old('country') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('country')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Mobile No.<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter mobile no" value="{{ old('mobile_no') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('mobile_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter landline no" value="{{ old('landline_no') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('landline_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="contact_email" class="w-48 text-sm font-medium">Email<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="email" name="contact_email" id="contact_email" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter contact email" value="{{ old('contact_email') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('contact_email')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="cin_no" class="w-48 text-sm font-medium">CIN No. <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="cin_no" id="cin_no" placeholder="Enter CIN No" class="w-full text-sm border rounded px-3 py-2" value="{{ old('cin_no') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('cin_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pan_no" class="w-48 text-sm font-medium">PAN No.</label>
                <div class="w-full">
                    <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN No" class="w-full text-sm border rounded px-3 py-2" value="{{ old('pan_no') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('pan_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="tan_no" class="w-48 text-sm font-medium">TAN No.</label>
                <div class="w-full">
                    <input type="text" name="tan_no" id="tan_no" placeholder="Enter TAN No" class="w-full text-sm border rounded px-3 py-2" value="{{ old('tan_no') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('tan_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gst_no" class="w-48 text-sm font-medium">GST No.</label>
                <div class="w-full">
                    <input type="text" name="gst_no" id="gst_no" placeholder="Enter GST No" class="w-full text-sm border rounded px-3 py-2" value="{{ old('gst_no') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('gst_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_category" class="w-48 text-sm font-medium">Company Category <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <!-- <input type="text" name="company_category" id="company_category" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter company category" value="{{ old('company_category') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                    <select name="company_category" id="company_category" class="w-full text-sm border rounded px-3 py-2">
                        <option value="limited_by_shares">Limited By Shares</option>
                        <option value="limited_by_guarantee">Limited By Guarantee</option>
                        <option value="unlimited_company">Unlimited Company</option>
                    </select>
                    @error('company_category')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_class" class="w-48 text-sm font-medium">Company Class<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <!-- <input type="text" name="company_class" id="company_class" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter company class" value="{{ old('company_class') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                    <select name="company_class" id="company_class" class="w-full text-sm border rounded px-3 py-2">
                        <option value="public_limited_company">Public Limited Company</option>
                        <option value="association_of_persons">Association of Persons</option>
                        <option value="private_limited_company">Private Limited Company</option>
                        <option value="partnership_firm">Partnership Firm</option>
                    </select>
                    @error('company_class')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_date" class="w-48 text-sm font-medium">Incorporation Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="incorporation_date" id="date2" class="border-none" placeholder="Select Date" class="w-full text-sm border rounded px-3 py-2" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    <!-- <input type="date" name="incorporation_date" id="incorporation_date" value="{{ old('incorporation_date') }}" class="flex-1 text-sm border rounded px-3 py-2" required> -->
                    @error('incorporation_date')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_state" class="w-48 text-sm font-medium">Incorporation State<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <!-- <input type="text" name="incorporation_state" id="incorporation_state" placeholder="Enter incorporation state" value="{{ old('incorporation_state') }}" class="flex-1 text-sm border rounded px-3 py-2" required> -->
                    <select name="incorporation_state" id="incorporation_state" class="w-full text-sm border rounded px-3 py-2">
                        <option value="">Select State</option>
                    </select>
                    @error('incorporation_state')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_country" class="w-48 text-sm font-medium">Incorporation Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="incorporation_country" id="incorporation_country" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter incorporation country" value="{{ old('incorporation_country') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('incorporation_country')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="authorized_capital" class="w-48 text-sm font-medium">Authorized Capital<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="number" name="authorized_capital" id="authorized_capital" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter authorized capital" value="{{ old('authorized_capital') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('authorized_capital')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="paid_up_capital" class="w-48 text-sm font-medium">Paid Up Capital<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="number" name="paid_up_capital" id="paid_up_capital" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter paid up capital" value="{{ old('paid_up_capital') }}" class="flex-1 text-sm border rounded px-3 py-2">
                    @error('paid_up_capital')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Create Account
                </button>
                <button class="btn-outline" type="reset">
                    Cancel
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