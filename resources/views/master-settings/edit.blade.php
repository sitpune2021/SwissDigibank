@extends('layout.main')
@section('content')
<style>
    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
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

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }
</style>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg uppercase font-semibold">
                Edit Master Settings
            </h1>
        </div>
    </div>
    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <form action="{{ route('master-settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b font-semibold uppercase text-black">
                            Play Store Url For Application
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Member App Play Store Url
                            </label>
                            <input type="text" name="member_playstore_url"
                                value="{{ old('member_playstore_url', $setting->member_playstore_url ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Member App Play Store Url">
                            @error('member_playstore_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Member App IOs Store Url
                            </label>
                            <input type="text" name="member_ios_url"
                                value="{{ old('member_ios_url', $setting->member_ios_url ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Member App IOs Store Url">
                            @error('member_ios_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b font-semibold uppercase text-black">
                            TDS Deduction Limit on RD/ DD / FD/ MIS
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Tax Deduction Limit
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" name="tax_deduction_limit"
                                value="{{ old('tax_deduction_limit', $setting->tax_deduction_limit ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.00">
                            @error('tax_deduction_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Tax Deduction Limit Senior Citizen
                                <span class="text-error">*</span>
                            </label>
                            <input type="number" name="tax_deduction_limit_senior"
                                value="{{ old('tax_deduction_limit_senior', $setting->tax_deduction_limit_senior ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.00">
                            @error('tax_deduction_limit_senior')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b font-semibold uppercase text-black">
                            Membership Fee Setting
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Enable Membership Fee
                            </label>
                            <div class="flex gap-3 items-center">
                                <input type="checkbox" name="membership_fee_enabled" class="w-32" {{
                                    old('membership_fee_enabled', $setting->membership_fee_enabled ?? false) ? 'checked'
                                : '' }}>
                                <p class="w-full text-sm font-semibold uppercase">
                                    (tick check box if you want to collect fee while adding new member)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Membership Fee
                            </label>
                            <input type="number" name="membership_fee"
                                value="{{ old('membership_fee', $setting->membership_fee ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b font-semibold uppercase text-black">
                            Associate Registration Fee Settings
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Enable Registration Fee
                            </label>
                            <div class="flex gap-3 items-center">
                                <input type="checkbox" name="associate_fee_enabled" class="w-32" {{
                                    old('associate_fee_enabled', $setting->associate_fee_enabled ?? false) ? 'checked' :
                                '' }}>
                                <p class="w-full text-sm font-semibold uppercase">
                                    (tick check box if you want to collect fee while adding new Associate)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Registration Fee
                            </label>
                            <input type="number" name="associate_fee"
                                value="{{ old('associate_fee', $setting->associate_fee ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Associate Registration Fee">
                        </div>
                    </div>

                    <div class="px-2 py-3">
                        <h3 class="text-lg border-b font-semibold uppercase text-black">
                            Share Transfer / Allocation Setting
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Shares Transfer / Allocation
                            </label>
                            <div class="flex gap-3 items-center">
                                <input type="radio" name="share_transfer_mode" value="split" class="w-32" {{
                                    old('share_transfer_mode', $setting->share_transfer_mode ?? '') == 'split' ?
                                'checked' : ''
                                }}>
                                <p>Split Promoter Shares</p>

                                <input type="radio" name="share_transfer_mode" value="allocate" class="w-32" {{
                                    old('share_transfer_mode', $setting->share_transfer_mode ??
                                '') == 'allocate' ? 'checked' : '' }}>
                                <p>Allocate New Shares</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Disable Share Selection
                            </label>
                            <div class="flex gap-3 items-center">
                                <input type="checkbox" name="disable_share_selection" class="w-32" {{
                                    old('disable_share_selection', $setting->disable_share_selection ?? false) ?
                                'checked' : '' }}>
                                <p class="w-full text-sm font-semibold uppercase">
                                    (tick check box if you want to disable manual share selection)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="mb-4">
                            <label class="block font-medium mb-2">
                                Default Shares To Allocate
                            </label>
                            <input type="number" name="default_shares"
                                value="{{ old('default_shares', $setting->default_shares ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Shares To Allocate/Transfer to every member">
                                 
                        </div>
                    </div>

                    <div class="flex gap-5 justify-center mt-5">
                        <button type="submit" class="btn-primary uppercase">Update</button>
                        <a href="{{ route('master-settings.index') }}" class="btn-outline uppercase">Back</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right: Settings -->
        <div class=" w-full overflow-hidden "> </div>

    </div>


    @endsection