@extends('layout.main')
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
</style>
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h3 class="h2">Company Profile</h3> -->
        <div>
            <h1 class="text-xl font-semibold">Company Profile</h1>
            <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                <!-- <li><a href="{{ url('/branch') }}" class="text-blue-600 hover:underline">Branch</a></li> -->
                <li class="text-gray-500">Company Profile</li>
            </ol>
        </div>
        <a href="{{ route('company.edit') }}" class="btn-primary">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Edit Profile
        </a>
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
        <form action="" method="" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf

            <div class="flex items-start gap-4">
                <label for="company_website" class="w-48 text-sm font-medium">Company Website</label>
                <div class="w-full">
                    <input type="text" name="company_name" id="company_name"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        value="{{ $company->company_website }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_name" class="w-48 text-sm font-medium">Company Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="company_name" id="company_name"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                        value="{{ $company->company_name }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="short_name" class="w-48 text-sm font-medium">Short Name<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="short_name" id="short_name" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter short name" value="{{ old('short_name') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="short_name" id="short_name" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->short_name }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="about_company" class="w-48 text-sm font-medium mt-2">About Company<span class="text-red-500">*</span></label>
                <!-- <textarea name="about_company" id="about_company" rows="3" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter about company" class="flex-1 text-sm border rounded px-3 py-2">{{ old('about_company') }}</textarea> -->
                <div class="w-full">
                    <textarea name="about_company" id="about_company" rows="3" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>{{ $company->about_company }}</textarea>
                </div>
            </div>

            <h4>Reg. Office Address:</h4><br>
            <div class="flex items-start gap-4">
                <label for="address_line1" class="w-48 text-sm font-medium">Address Line 1<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="address_line1" id="address_line1" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter Address Line 1" value="{{ old('address_line1') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="address_line1" id="address_line1" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->address_line1 }}">
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address_line2" class="w-48 text-sm font-medium">Address Line 2</label>
                <!-- <input type="text" name="address_line2" id="address_line2" class="w-full text-sm border rounded px-3 py-2" placeholder="Enter Address Line 2" value="{{ old('address_line2') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="address_line2" id="address_line2" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->address_line2 }}">
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="city" class="w-48 text-sm font-medium">City<span class="text-red-500">*</span></label>
                <!-- <input type="text" name="city" id="city" placeholder="Enter city" class="w-full text-sm border rounded px-3 py-2" value="{{ old('city') }}" class="flex-1 text-sm border rounded px-3 py-2"> -->
                <div class="w-full">
                    <input type="text" name="city" id="city" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->city }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="state" class="w-48 text-sm font-medium">State<span class="text-red-500">*</span></label>

                <div class="w-full">
                    <!-- <select name="state" id="stateDropdown" class="w-full text-sm border rounded px-3 py-2">
                        <option value="">Select State</option>
                    </select> -->
                    <input type="text" name="state" id="state" value="{{ $company->stateData->name }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pincode" class="w-48 text-sm font-medium">Pincode<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="pincode" id="pincode" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->pincode }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="country" class="w-48 text-sm font-medium">Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="country" id="country" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->country }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Mobile No.<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->mobile_no }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->landline_no }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="contact_email" class="w-48 text-sm font-medium">Email<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="email" name="contact_email" id="contact_email" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->contact_email }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="cin_no" class="w-48 text-sm font-medium">CIN No. <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="cin_no" id="cin_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->cin_no }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pan_no" class="w-48 text-sm font-medium">PAN No.</label>
                <div class="w-full">
                    <input type="text" name="pan_no" id="pan_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->pan_no }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="tan_no" class="w-48 text-sm font-medium">TAN No.</label>
                <div class="w-full">
                    <input type="text" name="tan_no" id="tan_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->tan_no }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gst_no" class="w-48 text-sm font-medium">GST No.</label>
                <div class="w-full">
                    <input type="text" name="gst_no" id="gst_no" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->gst_no }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_category" class="w-48 text-sm font-medium">Company Category <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="company_category" id="company_category" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->company_category }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="company_class" class="w-48 text-sm font-medium">Company Class<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="company_class" id="company_class" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->company_class }}" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_date" class="w-48 text-sm font-medium">Incorporation Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="date" name="incorporation_date" id="incorporation_date" value="{{ $company->incorporation_date }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_state" class="w-48 text-sm font-medium">Incorporation State<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="incorporation_state" id="incorporation_state" value="{{ $company->incorporationState->name }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="incorporation_country" class="w-48 text-sm font-medium">Incorporation Country<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="incorporation_country" id="incorporation_country" value="{{ $company->incorporation_country }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="authorized_capital" class="w-48 text-sm font-medium">Authorized Capital<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="number" name="authorized_capital" id="authorized_capital" value="{{ $company->authorized_capital }}" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" disabled>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="paid_up_capital" class="w-48 text-sm font-medium">Paid Up Capital<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="number" name="paid_up_capital" id="paid_up_capital" class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $company->paid_up_capital }}" disabled>
                </div>
            </div>

            <!-- <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-outline" onclick="history.back()" type="button">
                    Back
                </button>
            </div> -->
        </form>
    </div>
</div>
@endsection