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

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

@section('content')

@php
    $distributor = $distributor ?? new \App\Models\VehicleDistributor;
@endphp


    <div class="main-inner">
        
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <h1 class="text-xl font-semibold uppercase">New Vehicle Distributor</h1>
            </div>
        </div>

        <div class="box">

                <form action="{{ isset($distributor) && $distributor?->id 
                    ? route('vehical.distributors.update', $distributor->id) 
                    : route('vehicle-distributor.store') }}" 
                    method="POST">

                    @csrf
                    @if(isset($distributor) && $distributor?->id)
                        @method('PUT')
                    @endif

                    <div class="col-span-12  lg:col-span-12">
                        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6" action="" method="">

                        <div class="col-span-2 md:col-span-1">
                            <label for="distributor_name" class="md:text-lg font-medium block mb-4">
                                Distributor Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="" name="distributor_name"
                                value="{{ old('distributor_name', $distributor->distributor_name ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Distributor Name">
                                @error('distributor_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="distributor_code" class="md:text-lg uppercase font-medium block mb-4">
                                Distributor Code
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="distributor_code"
                                value="{{ old('distributor_code', $distributor->distributor_code ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase"
                                placeholder="Enter Distributor Code">
                                @error('distributor_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Distributor Type
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="distributor_type" name="distributor_type"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                                <option value="">Select Distributor Type</option>
                                <option value="authorized_dealer" 
                                    {{ old('distributor_type', $distributor->distributor_type ?? '') == 'authorized_dealer' ? 'selected' : '' }}>
                                    Authorized Dealer
                                </option>
                                <option value="third_party_dealer" 
                                    {{ old('distributor_type', $distributor->distributor_type ?? '') == 'third_party_dealer' ? 'selected' : '' }}>
                                    Third Party Dealer
                                </option>
                                <option value="manufacturer_direct" 
                                    {{ old('distributor_type', $distributor->distributor_type ?? '') == 'manufacturer_direct' ? 'selected' : '' }}>
                                    Manufacturer Direct
                                </option>
                            </select>
                            @error('distributor_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1"></div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Contact No
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="contact_no" name="contact_no"
                            value="{{ old('contact_no', $distributor->contact_no ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Contact No ">
                            @error('contact_no')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="email" name="email"
                            value="{{ old('email', $distributor->email ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Email">
                                @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="address" class="md:text-lg uppercase font-medium block mb-4">
                                Address
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Address">{{ old('address', $distributor->address ?? '') }}</textarea>
                            
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="city" class="md:text-lg uppercase  font-medium block mb-4">
                                City / District
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <input type="text" id="city" name="city"
                                    value="{{ old('city', $distributor->city ?? '') }}"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                        placeholder="Enter City">
                                        @error('city')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="state" class="md:text-lg uppercase font-medium block mb-4">
                                State
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="state" name="state"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3">
                                <option value="">Select State</option>
                                <option value="Andhra_Pradesh" {{ $distributor->state == 'Andhra_Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                <option value="Andaman_and_Nicobar_Islands" {{ $distributor->state == 'Andaman_and_Nicobar_Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                <option value="Arunachal_Pradesh" {{ $distributor->state == 'Arunachal_Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                <option value="Assam" {{ $distributor->state == 'Assam' ? 'selected' : '' }}>Assam</option>
                                <option value="Bihar" {{ $distributor->state == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                <option value="Chandigarh" {{ $distributor->state == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                <option value="Chhattisgarh" {{ $distributor->state == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                <option value="Dadar_and_Nagar_Haveli" {{ $distributor->state == 'Dadar_and_Nagar_Haveli' ? 'selected' : '' }}>Dadar and Nagar Haveli</option>
                                <option value="Daman_and_Diu" {{ $distributor->state == 'Daman_and_Diu' ? 'selected' : '' }}>Daman and Diu</option>
                                <option value="Delhi" {{ $distributor->state == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                <option value="Goa" {{ $distributor->state == 'Goa' ? 'selected' : '' }}>Goa</option>
                                <option value="Gujarat" {{ $distributor->state == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                <option value="Haryana" {{ $distributor->state == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                <option value="Himachal_Pradesh" {{ $distributor->state == 'Himachal_Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                <option value="Jammu_and_Kashmir" {{ $distributor->state == 'Jammu_and_Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                                <option value="Jharkhand" {{ $distributor->state == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                <option value="Karnataka" {{ $distributor->state == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                <option value="Kerala" {{ $distributor->state == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                <option value="Lakshadweep" {{ $distributor->state == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                <option value="Madhya_Pradesh" {{ $distributor->state == 'Madhya_Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                <option value="Maharashtra" {{ $distributor->state == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                <option value="Manipur" {{ $distributor->state == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                <option value="Meghalaya" {{ $distributor->state == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                <option value="Mizoram" {{ $distributor->state == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                <option value="Nagaland" {{ $distributor->state == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                <option value="Odisha" {{ $distributor->state == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                <option value="Pondicherry" {{ $distributor->state == 'Pondicherry' ? 'selected' : '' }}>Pondicherry</option>
                                <option value="Punjab" {{ $distributor->state == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option value="Rajasthan" {{ $distributor->state == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                <option value="Sikkim" {{ $distributor->state == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                <option value="Tamil_Nadu" {{ $distributor->state == 'Tamil_Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                <option value="Telangana" {{ $distributor->state == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                <option value="Tripura" {{ $distributor->state == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                <option value="Uttar_Pradesh" {{ $distributor->state == 'Uttar_Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                <option value="Uttarakhand" {{ $distributor->state == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                <option value="West_Bengal" {{ $distributor->state == 'West_Bengal' ? 'selected' : '' }}>West Bengal</option>
                                <option value="OUTSIDE_INDIA" {{ $distributor->state == 'OUTSIDE_INDIA' ? 'selected' : '' }}>OUTSIDE INDIA</option>
                            </select>
                            @error('contact_no')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="country" class="md:text-lg uppercase font-medium block mb-4">
                                Country
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <input type="text" id="country" name="country" value="India"
                                    value="{{ old('country', $distributor->country ?? '') }}"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                        placeholder="Enter Country" readonly>
                                        @error('country')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="pincode" class="md:text-lg uppercase font-medium block mb-4">
                                Pincode <span class="text-error">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" id="pincode" name="pincode"
                                value="{{ old('pincode', $distributor->pincode ?? '') }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                    placeholder="Enter Pincode ">
                            </div>
                            @error('pincode')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 md:col-span-1"> </div>

                        <div class="col-span-2 md:col-span-1">
                            <div class="col-sm-7">
                                <label for="gst_no" class="md:text-lg uppercase font-medium block mb-4">
                                    GST No
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" id="gst_no" name="gst_no"
                                    value="{{ old('gst_no', $distributor->gst_no ?? '') }}"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                        placeholder="Enter GST No">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="license_no" class="md:text-lg uppercase font-medium block mb-4">
                                License No
                            </label>
                            <input type="text" id="license_no" name="license_no"
                            value="{{ old('license_no', $distributor->license_no ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter License No">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label for="active" class="md:text-lg uppercase font-medium block mb-4">
                                Active <span class="text-error">*</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <label for="" class="flex gap-2">
                                <input type="radio" name="active" value="1"
                                    {{ old('active', $distributor->is_active ?? 0) == 1 ? 'checked' : '' }}> Yes
                            </label>
                            <label for="active" class="flex  gap-2">
                                <input type="radio" name="active" value="0"
                                {{ old('active', $distributor->is_active ?? 0) == 0 ? 'checked' : '' }}> No
                            </label>
                            </div>
                            @error('active')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>  

                    <!-- Buttons -->
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-6">
                        <button class="btn-primary uppercase justify-center" type="submit">
                            {{ isset($distributor) && $distributor?->id ? 'Update Distributor' : 'Save Distributor' }}
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="{{ route('vehical.distributors.index') }}">Back</a>
                        </button>
                    </div>

                </div>

            </form>
            
        </div>
        
    </div>
 

@endsection