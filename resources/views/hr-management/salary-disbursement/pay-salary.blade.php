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

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-xl uppercase font-semibold">
                  Salary Disbursements
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between  gap-5">
            <div class=" w-full  overflow-hidden ">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">
                        <div class="col-span-2 md:col-span-1 mt-3 mb-3">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Employee
                                <span class="text-red-500">*</span>
                            </label>

                            <select id="employeeSelect"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Select Employee</option>
                                <option value="emp1">Romita Mukherjee</option>

                            </select>

                        </div>
                       
                       <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                               Advance Pay  <span class="text-error">*</span>
                            </label>

                            <input type="checkbox" id="showPayMode">

                        </div>

                        

                        <div class="col-span-2 md:col-span-1 mb-2">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Transaction Date 
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="date"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="DD/MM/YYYY">
                           
                        </div>
                      <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Amount 
                                <span class="text-error">*</span>

                            </label>

                            <input type="text" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Salary Amount">

                        </div>
                        <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                                Remarks(if any)

                            </label>

                            <textarea id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Remarks (if any)"></textarea>

                        </div>
                        
                       
                        <div class="col-span-2 md:col-span-1 mb-2 mt-3  ">
                            <div id="payModeSection"
                                class=" w-full max-w-2xl bg-white  rounded-lg ">
                                <label for="" class="md:text-lg font-medium block uppercase">
                                 PAY MODE
                                  <span class="text-error">*</span>
                                </label>
                             
                                 
                                <!-- Radio Buttons -->
                                <div class="mt-3 flex gap-3">
                                    <!-- Pay Mode -->
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="cash" checked {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'cash' ? 'checked' : '' }} --}}
                                        > 
                                        <p class="uppercase">Cash</p>
                                    </label>
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="cheque" {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'cheque' ? 'checked' : '' }} --}}
                                        > <p class="uppercase">Cheque</p>
                                    </label>
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="online" {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }} --}}
                                        > <p class="uppercase">Online Tr.</p>
                                    </label>
                                    <label class="mr-4 flex items-center gap-2">
                                        <input type="radio" name="fee_mode" value="saving" {{-- {{ old('fee_mode',
                                            $application->fee_mode ?? '') == 'online' ? 'checked' : '' }} --}}
                                        > <p class="uppercase"> Saving Ac.</p>
                                    </label>
                                </div>

                                <!-- Bank + Cheque Fields -->
                                <div id="bankDropdownWrapper" class="mt-3 hidden ">
                                    <label for="bank_id" class="uppercase block mb-2 text-sm font-medium">Select Bank</label>
                                    <select id="bank_id" name="bank_id"
                                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                        <option value="">-- Select Bank --</option>
                                        {{-- @foreach($banks as $id => $name)
                                        <option value="{{ $id }}" {{ old('bank_id', $application->bank_id ?? '') == $id ?
                                            'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach --}}
                                    </select>

                                    <!-- Cheque No -->
                                    <div class="mt-3">
                                        <label class="uppercase block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="cheque_no"
                                            class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No" value="
                                                {{-- {{ old('cheque_no', $application->cheque_no ?? '') }} --}}
                                                 ">
                                    </div>

                                    <!-- Cheque Date -->
                                    <div class="mt-3">
                                        <label class="uppercase block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="date" id="cheque_date" name="cheque_date" value="
                                            {{-- {{ old('cheque_date', $application->cheque_date ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>
                                </div>

                                <!-- Online Transaction Fields -->
                           <div id="onlineFields" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm uppercase font-medium text-gray-700">
                                            Transfer Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="transfer_date" name="transfer_date" value="
                                            {{-- {{ old('transfer_date', $application->transfer_date ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>

                                    <div>
                                        <label class="block text-sm uppercase font-medium text-gray-700">
                                            UTR / Transaction No. <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                            value="
                                            {{-- {{ old('utr_no', $application->utr_no ?? '') }} --}}
                                             " class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div>

                                    <div>
                                        <label class="uppercase block text-sm font-medium text-gray-700">
                                            Transfer Mode <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="imps" {{-- {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'imps' ?
                                                'checked' : '' }} --}}
                                                >
                                                <span>IMPS</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="vpa" {{-- {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'vpa' ?
                                                'checked' : '' }} --}}
                                                >

                                                <span>VPA</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="transfer_mode" value="neft_rtgs" {{-- {{
                                                    old('transfer_mode', $application->transfer_mode ?? '') == 'neft_rtgs' ?
                                                'checked' : '' }} --}}
                                                >
                                                <span>NEFT/RTGS</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="uppercase block text-sm font-medium text-gray-700">
                                            Credited in Company Account <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="1" {{-- {{ old('credited')==1
                                                    ? 'checked' : '' }} --}} checked>
                                                <span>Yes</span>
                                            </label>

                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="0" {{-- {{ old('credited')==0
                                                    ? 'checked' : '' }} --}}>
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                {{--  Saving Ac. --}}
                           <div id="savingAc" class="space-y-4 hidden">
                                    <div class="mt-3">
                                        <label class="block text-sm uppercase mb-3 font-medium text-gray-700">
                                           Select Saving Account  <span class="text-red-500">*</span>
                                        </label>
                                        <select  id="" name="]" value="" class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                             <option value="">Select Saving Account</option>
                                             </select>

                                    </div>
                           </div> 
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="">
                               Pay Salary
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-hidden">
                <div id="employeeInfo" class="hidden grid md:grid-cols-2 gap-4 max-w-4xl mx-auto">

                    <!-- Employee Info Box -->
                    <div class="bg-white border border-blue-300 p-2 rounded-lg shadow-md">
                        <div class="bg-secondary/5  px-4 py-2 rounded-t-lg">
                            <h3 class="text-lg uppercase font-semibold">EMPLOYEE INFO</h3>
                        </div>
                        <div class="p-4">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Branch</td>
                                        <td>KHANNA</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Name</td>
                                        <td>ROMITA MUKHERJEE</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Code</td>
                                        <td>MINL0014</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Joining Date</td>
                                        <td>1 July 2025</td>
                                    </tr>
                                     <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">
                                            Available Balance
                                        </td>
                                        <td>(4,600.00)</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="font-semibold uppercase p-2">Leaving Date</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <script>
            const select = document.getElementById("employeeSelect");
            const infoBox = document.getElementById("employeeInfo");

            select.addEventListener("change", () => {
                if (select.value) {
                    infoBox.classList.remove("hidden");
                    infoBox.classList.add("grid");
                } else {
                    infoBox.classList.add("hidden");
                }
            });
        </script>
        <script>
            const employeeSelect = document.getElementById("employeeSelect");
            const employeeBox = document.getElementById("employeeBox");

            employeeSelect.addEventListener("change", () => {
                if (employeeSelect.value) {
                    employeeBox.classList.remove("hidden"); // show div
                } else {
                    employeeBox.classList.add("hidden"); // hide div
                }
            });
        </script>

        <!-- Pay Salary Checkbox -->
        <script>
            const checkbox = document.getElementById("showPayMode");
            const payModeSection = document.getElementById("payModeSection");
            const feeModeRadios = document.querySelectorAll("input[name='fee_mode']");
            const bankFields = document.getElementById("bankDropdownWrapper");
            const onlineFields = document.getElementById("onlineFields");
             const savingAc = document.getElementById("savingAc");

            // ✅ Show/hide entire section when checkbox is toggled
            checkbox.addEventListener("change", () => {
                payModeSection.classList.toggle("hidden", !checkbox.checked);
            });

            // ✅ Show/hide bank or online fields based on selected pay mode
            feeModeRadios.forEach((radio) => {
                radio.addEventListener("change", () => {
                    if (radio.value === "cheque") {
                        bankFields.classList.remove("hidden");
                        onlineFields.classList.add("hidden");
                    } else if (radio.value === "online") {
                        onlineFields.classList.remove("hidden");
                        bankFields.classList.add("hidden");
                    }
                    else if (radio.value === "saving") {
                        savingAc.classList.remove("hidden");
                        bankFields.classList.add("hidden");
                    } else {
                        bankFields.classList.add("hidden");
                        onlineFields.classList.add("hidden");
                    }
                });
            });
        </script>
        <!-- pay mode -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const radios = document.querySelectorAll('input[name="fee_mode"]');
                const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
                const onlineFields = document.getElementById("onlineFields");

                radios.forEach(radio => {
                    radio.addEventListener("change", () => {
                        bankDropdownWrapper.classList.add("hidden");
                        onlineFields.classList.add("hidden");

                        if (radio.value === "cheque" && radio.checked) {
                            bankDropdownWrapper.classList.remove("hidden");
                        }
                        if (radio.value === "online" && radio.checked) {
                            onlineFields.classList.remove("hidden");
                        }
                    });
                });

                // Default dates
                let today = new Date().toISOString().split('T')[0];
                document.getElementById("cheque_date").value = today;
                document.getElementById("transfer_date").value = today;
            });
        </script>
@endsection