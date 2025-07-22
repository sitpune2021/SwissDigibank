@php
$companyprofile = config('companyprofile_form');
@endphp

@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-center gap-2">
            <h1 class="text-xl font-semibold">Edit Company Profile</h1>
        </div>
    </div>

    @if (session('success'))
    <div id="success-alert"
        style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="document.getElementById('success-alert').style.display='none';"
            style="position: absolute; top: 5px; right: 10px; cursor: pointer;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert"
        style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="document.getElementById('error-alert').style.display='none';"
            style="position: absolute; top: 5px; right: 10px; cursor: pointer;">&times;</span>
    </div>
    @endif

    <form action="{{ route('company.update') }}" method="POST">
        @csrf
        <div class="grid grid-cols-12 gap-4 xxxxxl:gap-6">
            @foreach ($companyprofile as $section)
            <div class="col-span-12 lg:col-span-6">
                <div class="box xxl:p-8 xxxl:p-10 mb-6">
                    <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">{{ $section['heading'] }}</h4>
                    <form class="grid grid-cols-2 gap-4 xxxxxl:gap-6">
                        @foreach ($section['fields'] as $field)
                        <div class="col-span-2 md:col-span-1">
                            <label for="{{ $field['id'] }}" class="md:text-lg font-medium block mb-4">
                                {{ $field['label'] }}
                                @if (!empty($field['required']))
                                <span class="text-red-500">*</span>
                                @endif
                            </label>

                            @if ($field['type'] === 'textarea')
                            <textarea id="{{ $field['id'] }}" name="{{ $field['name'] }}" rows="4"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
                                placeholder="Enter {{ strtolower($field['label']) }}" readonly>{{ old($field['name'], $company->{$field['name']} ?? '') }}</textarea>
                            @elseif ($field['type'] === 'date')
                            <input type="date" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                                readonly />
                            @elseif ($field['type'] === 'number')
                            <input type="number" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter {{ strtolower($field['label']) }}"
                                value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                                readonly />
                            @elseif ($field['type'] === 'select')
                            <select name="{{ $field['name'] }}" id="{{ $field['id'] }}"
                                class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                {{ $field['required'] ? 'required' : '' }}>
                                <option value="">-- Select {{ $field['name'] }} --</option>

                                @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
                                @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" {{  $company->{$field['name']} == $optionValue ? 'selected' : '' }}>
                                    {{ $optionLabel }}
                                </option>
                                @endforeach
                                @elseif(!empty($field['options']))
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}"
                                    {{ $value == $optionValue ? 'selected' : '' }}>
                                    {{ $optionLabel }}
                                </option>
                                @endforeach
                                @endif
                            </select>

                            @else
                            <input type="{{ $field['type'] }}" id="{{ $field['id'] }}"
                                name="{{ $field['name'] }}"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter {{ strtolower($field['label']) }}"
                                value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                                readonly />
                            @endif
                            @error($field['name'])
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
            <button class="btn-primary" type="submit">Update</button>
            <a href="{{ route('company.view') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection

{{-- @extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="h2">Edit Profile</h3>
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
<form action="{{ route('company.update') }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
    @csrf
    <div class="col-span-12 lg:col-span-6">
        <div class="box xxl:p-8 xxxl:p-10">
            <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">
                Profile
                <p>Company Website: <a href="{{ $company->company_website }}" target="_blank"
                        style="text-decoration: underline; color: blue;">
                        {{ $company->company_website }}
                    </a>

                <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 xxxxxl:gap-6">

                    <div class="col-span-2 md:col-span-1">
                        <label for="company_name" class="md:text-lg font-medium block mb-4">
                            Company Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Company Name" id="company_name" name="company_name"
                            value="{{ $company->company_name }}" />
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="short_name" class="md:text-lg font-medium block mb-4">
                            Short Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Short Name" value="{{ $company->short_name }}" id="short_name"
                            name="short_name" />
                    </div>

                    <div class="col-span-2 md:col-span-2">
                        <label for="about_company" class="md:text-lg font-medium block mb-4">
                            About Company <span class="text-red-500">*</span>
                        </label>
                        <textarea id="about_company" name="about_company" rows="4"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
                            placeholder="Enter details about the company">{{ $company->about_company ?? 'SWISS Payments Digital Bank demo3' }}</textarea>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="cin_no" class="md:text-lg font-medium block mb-4">
                            CIN No. <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="cin_no" name="cin_no"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter CIN Number" value="{{ $company->cin_no ?? 'xcvb' }}" />
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="pan_no" class="md:text-lg font-medium block mb-4">
                            PAN No.
                        </label>
                        <input type="text" id="pan_no" name="pan_no"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter PAN Number" value="{{ $company->pan_no ?? 'gfjgfg545hg' }}" />
                    </div>


                    <div class="col-span-2 md:col-span-1">
                        <label for="tan_no" class="md:text-lg font-medium block mb-4">
                            TAN No.
                        </label>
                        <input type="text" id="tan_no" name="tan_no"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter TAN Number" value="{{ $company->tan_no ?? '33dd' }}" />
                    </div>

                    <!-- GST No. -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="gst_no" class="md:text-lg font-medium block mb-4">
                            GST No.
                        </label>
                        <input type="text" id="gst_no" name="gst_no"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter GST Number" value="{{ $company->gst_no ?? '12345sdc' }}" />
                    </div>


                    <!-- Company Category: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="company_category" class="md:text-lg font-medium block mb-4">
                            Company Category <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Company Category" value="{{ $company->company_category }}"
                            id="company_category" name="company_category" />
                    </div>

                    <!-- Company Class: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="company_class" class="md:text-lg font-medium block mb-4">
                            Company Class <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Company Class" value="{{ $company->company_class }}"
                            id="company_class" name="company_class" />
                    </div>

                    <!-- Incorporation Date: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="incorporation_date" class="md:text-lg font-medium block mb-4">
                            Incorporation Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            value="{{ $company->incorporation_date }}" id="incorporation_date"
                            name="incorporation_date" />
                    </div>

                    <!-- Incorporation State: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="incorporation_state" class="md:text-lg font-medium block mb-4">
                            Incorporation State <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Incorporation State" value="{{ $company->incorporation_state }}"
                            id="incorporation_state" name="incorporation_state" />
                    </div>

                    <!-- Incorporation Country: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="incorporation_country" class="md:text-lg font-medium block mb-4">
                            Incorporation Country <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Incorporation Country"
                            value="{{ $company->incorporation_country }}" id="incorporation_country"
                            name="incorporation_country" />
                    </div>

                    <!-- Authorized Capital: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="authorized_capital" class="md:text-lg font-medium block mb-4">
                            Authorized Capital <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Authorized Capital" value="{{ $company->authorized_capital }}"
                            id="authorized_capital" name="authorized_capital" />
                    </div>

                    <!-- Paid Up Capital: * -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="paid_up_capital" class="md:text-lg font-medium block mb-4">
                            Paid Up Capital <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Paid Up Capital" value="{{ $company->paid_up_capital }}"
                            id="paid_up_capital" name="paid_up_capital" />
                    </div>


                    <div class="col-span-2">
                        <label for="email" class="md:text-lg font-medium block mb-4">
                            Email
                        </label>
                        <input type="email"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Email" value="example@mail.com" id="email" />
                    </div>
                    <div class="col-span-2">
                        <label for="phone" class="md:text-lg font-medium block mb-4">
                            Mobile No <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Phone" value="91021421144" id="phone" />
                    </div>
                    <div class="col-span-2">
                        <label for="phone" class="md:text-lg font-medium block mb-4">
                            Landline No <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter landline no" value="91021421144" id="phone" />
                    </div>

                </form>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-6">
        <div class="box xxl:p-8 xxxl:p-10 mb-6">

            <!-- Address Section -->
            <div class="col-span-2">
                <h4 class="h4 bb-dashed mt-10 mb-4 pb-4 md:mb-6 md:pb-6">Reg. Office Address:</h4>
            </div>

            <!-- Address Line 1 -->
            <div class="col-span-2 md:col-span-1">
                <label for="address_line1" class="md:text-lg font-medium block mb-4">
                    Address Line 1
                </label>
                <input type="text"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Address Line 1" value="{{ $company->address_line1 }}" id="address_line1"
                    name="address_line1" />
            </div>

            <!-- Address Line 2 -->
            <div class="col-span-2 md:col-span-1">
                <label for="address_line2" class="md:text-lg font-medium block mb-4">
                    Address Line 2
                </label>
                <input type="text"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Address Line 2" value="{{ $company->address_line2 }}" id="address_line2"
                    name="address_line2" />
            </div>

            <!-- Country -->
            <div class="col-span-2 md:col-span-1">
                <label for="country" class="md:text-lg font-medium block mb-4">
                    Country <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Country" value="{{ $company->country }}" id="country"
                    name="country" />
            </div>

            <!-- State -->
            <div class="col-span-2 md:col-span-1">
                <label for="state" class="md:text-lg font-medium block mb-4">
                    State <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter State" value="{{ $company->state }}" id="state" name="state" />
            </div>

            <!-- City -->
            <div class="col-span-2 md:col-span-1">
                <label for="city" class="md:text-lg font-medium block mb-4">
                    City <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter City" value="{{ $company->city }}" id="city" name="city" />
            </div>
            <!-- Pincode -->
            <div class="col-span-2 md:col-span-1">
                <label for="pincode" class="md:text-lg font-medium block mb-4">
                    Pincode <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Pincode" value="{{ $company->pincode }}" id="pincode"
                    name="pincode" />
            </div>
            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Update
                </button>
                <button class="btn-outline" onclick="window.location.href='{{ route(`company.view`) }}'"
                    type="button">
                    Back
                </button>
            </div>
        </div>


</form>
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
        let selectedStateId = $('#selectedStateId').val();

        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#stateDropdown');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    let isSelected = (state.id == selectedStateId) ? 'selected' : '';
                    select.append('<option value="' + state.id + '" ' + isSelected + '>' +
                        state.name + '</option>');
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
        let selectedStateId = $('#selectedIncorporationStateId').val();

        $.ajax({
            url: '/api/states',
            type: 'GET',
            dataType: 'json',
            success: function(states) {
                let select = $('#incorporation_state');
                select.empty();
                select.append('<option value="">Select State</option>');

                $.each(states, function(index, state) {
                    let isSelected = (state.id == selectedStateId) ? 'selected' : '';
                    select.append('<option value="' + state.id + '" ' + isSelected + '>' +
                        state.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    });
</script> --}}