@extends('layout.main')
@section('content')
    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
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

        .tableWidth {
            width: 90%;
            margin: auto;

        }

        .bg-yellow {
            background-color: #e17100;
        }
    </style>


    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="text-lg font-semibold uppercase">
                Add New Collection Center
            </h3>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form method="POST" action="{{ isset($center)
        ? route('collection-centers.update',  base64_encode($center->id))
        : route('collection-centers.store') }}" enctype="multipart/form-data">

                @csrf
                @isset($center)
                    @method('PUT')
                @endisset

                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6 mb-4">
                    {{-- Branch --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Branch <span class="text-red-500">*</span>
                        </label>
                        <select name="branch_id"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $center->branch_id ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    </div>
                    <div class="col-span-2 md:col-span-1"></div>
                    {{-- Center No --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Center No <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="center_no" value="{{ old('center_no', $center->center_no ?? '') }}"
                            placeholder="Enter Center No"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('center_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Center Name --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Center Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="center_name" value="{{ old('center_name', $center->center_name ?? '') }}"
                            placeholder="Enter Center Name "
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('center_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Center Head --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Center Head
                        </label>
                        <select name="center_head"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                            <option value="">Select Center Head</option>
                            <optgroup label="Members">
                                @foreach($members as $member)
                             <option value="member_{{ $member->id }}"
                                 {{ old('center_head') == 'member_' . $member->id || (isset($center) && $center->center_head_member_id == $member->id) ? 'selected' : '' }}>

                             {{ $member->member_info_first_name }}

                            </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Employees">
                                @foreach($employees as $employee)
                                    <option value="employee_{{ $employee->id }}"
                                 {{ old('center_head') == 'employee_' . $employee->id || (isset($center) && $center->center_head_employee_id == $employee->id) ? 'selected' : '' }}>
                                 {{ $employee->name }}
                                </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('center_head')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Center Cashier --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Center Cashier
                        </label>
                        <select name="center_cashier"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                            <option value="">Select Center Cashier</option>
                            <optgroup label="Members">
                                @foreach($members as $member)
                                    <option value="member_{{ $member->id }}"
                                {{ old('center_cashier') == 'member_' . $member->id || (isset($center) && $center->center_cashier_member_id == $member->id) ? 'selected' : '' }}>
                                        {{ $member->member_info_first_name }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Employees">
                                @foreach($employees as $employee)
                                    <option value="employee_{{ $employee->id }}"
                                        {{ old('center_cashier') == 'employee_' . $employee->id || (isset($center) && $center->center_cashier_employee_id == $employee->id) ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('center_cashier')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Collection Day --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Collection Day
                        </label>
                        <input type="text" name="collection_day" value="{{ old('collection_day', $center->collection_day ?? '') }}" placeholder="Enter Collection Day"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('collection_day')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Collection Time --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Collection Time
                        </label>
                        <input type="text" name="collection_time" value="{{ old('collection_time', $center->collection_time ?? '') }}" placeholder="Enter Collection Time"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('collection_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Center Active --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Center Active <span class="text-error">*</span>
                        </label>
                        <div class="flex gap-6">
                            <label class="flex gap-2">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', $center->is_active ?? 1) == 1 ? 'checked' : '' }} checked>
                                <p>Yes</p>
                            </label>

                            <label class="flex gap-2">
                                <input type="radio" name="is_active" value="0" {{ old('is_active', $center->is_active ?? 1) == 0 ? 'checked' : '' }}>
                                <p>No</p>
                            </label>
                        </div>
                        @error('is_active')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Center Address --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Center Address
                        </label>
                        <textarea name="address"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Center Address">{{ old('address', $center->address ?? '') }}</textarea>
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr>

                {{-- GPS Location --}}
                <div class="mt-5 ">
                    <h4 class="text-center">
                        Center's Address GPS Location -
                        <a href="" class="uppercase btn-warning rounded-10 py-2 text-sm">Get current Location</a>
                    </h4>
                    <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6 mb-4">
                        {{-- Latitude --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-4 uppercase">
                                Location Latitude
                            </label>
                            <input type="text" name="latitude" value="{{ old('latitude', $center->latitude ?? '') }}" placeholder="Enter Latitude"
                                class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            @error('latitude')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Longitude --}}
                        <div class="col-span-2 md:col-span-1">
                            <label class="md:text-lg font-medium block mb-4 uppercase">
                                Location Longitude
                            </label>
                            <input type="text" name="longitude" value="{{ old('longitude', $center->longitude ?? '') }}" placeholder="Enter Longitude"
                                class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            @error('longitude')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                @if(isset($center))
    <p class="text-sm text-error mt-5 px-6 ">
        <strong>Note:</strong>
        <strong>
            If you change the collection center's branch, the system will automatically update
        the branch in all groups associated with this collection center
        </strong>
        (<strong>{{ $center->center_name }}</strong>).
    </p>
@endif

                {{-- Buttons --}}
                <div class="flex justify-center gap-3 mt-6 col-span-2">
                    <button type="submit" class="btn-primary uppercase">
                        {{ isset($center) ? 'Update Center' : 'Add Center' }}
                    </button>
                    <a href="{{ route('collection-centers.index') }}" class="btn-outline uppercase">
                        BACK
                    </a>
                </div>

            </form>

        </div>
    </div>
@endsection