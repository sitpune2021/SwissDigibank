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
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-center flex-col  gap-2">
            <h1 class="text-xl font-semibold">Open New RD Account</h1>
            <p class="text-gray-500">
                <a href="{{route('mds-rd-accounts.rd-account-index')}}" class="text-gray-500">Recuuring Deposits</a> >
                <a href="#" class="text-gray-500"> New</a>
            </p>

        </div>

    </div>

    <div class="col-span-12 box lg:col-span-12">

        <form>
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Memeber Name
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="frequency" name="frequency"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Search Member no or name</option>
                    </select>

                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Member Name<span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="" name=""
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="">
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="city" class="md:text-lg font-medium block mb-4">
                        Member Address

                    </label>

                    <input type="text" id="" name=""
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="frequency" class="md:text-lg font-medium block mb-4">
                        Member Mobile No
                    </label>
                    <div class="flex gap-2">

                        <input type="text" name="" id="" class=" text-sm bg-primary/5 w-20 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3" value="+91" disabled>
                        <input type="text" id="" name="" class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3" placeholder="Enter Mobile No " disabled>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Minor (if any) </label>
                    <select id="" name="branch"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">ALL</option>
                        <option value="head_office"> Minor 1</option>

                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Branch </label>
                    <select id="" name="branch"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">ALL</option>
                        <option value="head_office">Head Office</option>
                        <option value="city_branch_1">City Branch 1</option>
                        <option value="city_branch_2">City Branch 2</option>
                        <option value="rural_branch_1">Rural Branch 1</option>
                        <option value="rural_branch_2">Rural Branch 2</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Advisor/ Staff </label>
                    <select id="" name="branch"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">ALL</option>
                        <option value="head_office">Head Office</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Collection Advisor/ Staff </label>
                    <select id="" name="branch"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Collection Advisor Staff</option>
                        <option value="head_office">Head Office</option>
                    </select>
                </div>


                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Scheme <span class="text-red-500">*</span>
                        :</label>
                    <select id="" name="scheme"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">ALL</option>
                        <option value="head_office">Head Office</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">RD Amount <span class="text-red-500">*</span>
                        :</label>
                    <input type="number" id="" name="rd_amount"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Open Datet <span class="text-red-500">*</span>
                        :</label>
                    <input type="date" id="date5" name="rd_amount"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="">
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <!-- TDS -->
                <div class="col-span-2 md:col-span-1 mt-4">
                    <label class="font-medium block mb-2">TDS Deduction<span class="text-red-500">*</span></label>
                    <div class="flex items-center  gap-2">
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds" value="yes"> Yes</label>
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds" value="no"> No</label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1 mt-4">
                    <label class="font-medium block mb-2">Account Type <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="accountType" value="single" onclick="toggleAccountType('single')" class="accent-primary">
                            <span>Single</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="accountType" value="joint" onclick="toggleAccountType('joint')" class="accent-primary">
                            <span>Joint A/C</span>
                        </label>
                    </div>
                    <!-- single (no fields) -->
                    <div id="single" class="hidden"></div>
                </div>

                <div class="col-span-2 md:col-span-1 mt-4">
                    <div id="joint" class="hidden mt-4">
                        <label class="font-medium block mb-1">Select Saving Account<span class="text-red-500">*</span></label>
                        <select class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                       rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Search member no or name</option>
                            <option value="1001">Account 1001 - Akask Doshi</option>
                            <option value="1002">Account 1002 - vijay Smith</option>
                            <option value="1003">Account 1003 - Alex Kumar</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Nominee -->
            <div class="col-span-2 md:col-span-1 mt-4">
                <label class="font-medium block mb-2">Nominee <span class="text-red-500">*</span></label>
                <div class="flex items-center  gap-2">
                    <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee" value="yes" onclick="toggleAddMore(true)">Yes</label>
                    <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee" value="no" onclick="toggleAddMore(false)"> No</label>
                </div>

                <!-- Add More Button -->
                <div id="addMoreContainer" class="mt-2 hidden">
                    <button type="button" onclick="addNominee()" class="text-blue-600 font-medium">
                        + ADD MORE NOMINEE
                    </button>
                </div>

                <!-- Nominee Forms Container -->
                <div id="nomineeContainer" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 items-end p-3 rounded-10 bg-gray-50 dark:bg-bg3">
                    <!-- Forms will be added here -->
                </div>
            </div>

            <div class="col-span-2 md:col-span-1"></div>
            <!-- Payment Mode -->
            <div class="grid grid-cols-1 gap-4 mt-6 xl:mt-8 2xl:gap-6">

                <div class="col-span-1 mt-4">
                    <label class="block font-medium mb-2">
                        Payment Mode <span class="text-red-500">*</span>
                    </label>

                    <!-- Payment Mode Radios -->
                    <div class="flex flex-wrap gap-4 mt-4">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="payment_mode" value="cash" onclick="togglePaymentMode('cash')">
                            <span>Cash</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_mode" value="onlineTr" onclick="togglePaymentMode('onlineTr')">
                            <span>Online Tr.</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_mode" value="cheque" onclick="togglePaymentMode('cheque')">
                            <span>Cheque</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_mode" value="savingAcc" onclick="togglePaymentMode('savingAcc')">
                            <span>Saving Ac.</span>
                        </label>
                    </div>


                    <!-- Cash (no fields) -->
                    <div id="cash" class="hidden"></div>


                    <!-- Online Transfer Fields -->
                    <div id="onlineTr" class="hidden grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6 mt-4">

                        <!-- Transfer Date -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">Transfer Date <span class="text-red-500">*</span></label>
                            <input type="text" id="date2" placeholder="dd/mm/yyyy"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        </div>

                        <!-- UTR / Transaction No -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">UTR / Transaction No <span class="text-red-500">*</span></label>
                            <input type="text" placeholder="Enter UTR / Transaction No"
                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        </div>

                        <!-- Transfer Mode -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">Transfer Mode <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="IMPS" class="accent-primary">
                                    <span>IMPS</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="VPA" class="accent-primary">
                                    <span>VPA</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="NEFT/RTGS" class="accent-primary">
                                    <span>NEFT/RTGS</span>
                                </label>
                            </div>
                        </div>

                        <!-- Credited in Company Account -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">Credited in Company Account? <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="yes"> <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="no"> <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>


                    <!-- Cheque Fields -->
                    <div id="cheque" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 mt-4">
                        <div class="cheque-row flex flex-wrap justify-start gap-4">
                            <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                <label class="font-medium block mb-1">Bank Name<span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Enter Bank Name" class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                            <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                <label class="font-medium block mb-1">Cheque No<span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Enter Cheque No" class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                            <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                <label class="font-medium block mb-1">Cheque Date<span class="text-red-500">*</span></label>
                                <input type="date" id="date3" class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                        </div>
                    </div>

                    <!-- Saving Account Fields -->
                    <div id="savingAcc" class="hidden mt-4">
                        <label class="font-medium block mb-1">Select Saving Account<span class="text-red-500">*</span></label>
                        <select class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Choose Account</option>
                            <option>Account 1</option>
                            <option>Account 2</option>
                            <option>Account 3</option>
                        </select>
                    </div>

                </div>

            </div>


            <!-- Date & Amount -->
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">
                        T.Date <span class="text-red-500">*</span>
                        <input type="date" name="t_date" id="date4"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            </label>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">
                        Amount <span class="text-red-500">*</span>
                        <input type="number" name="amount"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            </label>
                </div>
            </div>

        </form>

        <!-- Buttons -->
        <div class="flex justify-center col-span-2 gap-4 mt-2 md:gap-6">
            <button class="btn-primary" type="submit">Save Scheme</button>
            <button class="btn-outline" type="button">Back</button>
            <button class="btn-outline" type="reset">Reset</button>
        </div>
    </div>

</div>
</div>


<script>
    // Nominee functions
    function toggleAddMore(show) {
        document.getElementById('addMoreContainer').style.display = show ? 'block' : 'none';
        if (!show) document.getElementById('nomineeContainer').style.display = 'hidden';
    }

    function addNominee() {
        const container = document.getElementById("nomineeContainer");
        container.style.display = "flex"; // make visible

        const newNominee = document.createElement("div");
        newNominee.className = "w-full nominee-item columns-4 gap-4 items-end bg-white p-4 rounded dark:bg-bg3";

        newNominee.innerHTML = `
        
<div class="nominee-row flex flex-wrap justify-start gap-6">
    <div class="flex-center flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Relation <span class="text-red-500">*</span></label>
        <select class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                           rounded-10 px-3 md:px-6 py-2 md:py-3">
            <option value="">Select Relation</option>

            <!-- Immediate Family -->
            <option>Father</option>
            <option>Mother</option>
            <option>Spouse</option>
            <option>Son</option>
            <option>Daughter</option>

            <!-- Siblings -->
            <option>Brother</option>
            <option>Sister</option>

            <!-- Extended Family -->
            <option>Grandfather</option>
            <option>Grandmother</option>
            <option>Uncle</option>
            <option>Aunt</option>
            <option>Cousin</option>
            <option>Nephew</option>
            <option>Niece</option>

            <!-- In-Laws -->
            <option>Father-in-law</option>
            <option>Mother-in-law</option>
            <option>Brother-in-law</option>
            <option>Sister-in-law</option>
            <option>Son-in-law</option>
            <option>Daughter-in-law</option>

            <!-- Others -->
            <option>Guardian</option>
            <option>Friend</option>
            <option>Other</option>
        </select>


    </div>

    <div class="flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Name <span class="text-red-500">*</span></label>
        <input type="text" placeholder="Enter Nominee Name"
            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                        rounded-10 px-3 md:px-6 py-2 md:py-3">
    </div>

    <div class="flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Address <span class="text-red-500">*</span></label>
        <input type="text" placeholder="Enter Nominee Address"
            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                         rounded-10 px-3 md:px-6 py-2 md:py-3">
    </div>

    <div class="flex-1 min-w-[60px] max-w-full flex justify-end items-center">
        <button type="button" onclick="removeNominee(this)"
            class="text-red-500 mt-8 font-bold text-lg hover:text-red-700">✕</button>
    </div>
</div>
          
        `;

        container.appendChild(newNominee);
    }

    function removeNominee(button) {
        const item = button.closest(".nominee-item");
        item.remove();

        // Hide container if no nominee left
        const container = document.getElementById("nomineeContainer");
        if (container.children.length === 0) {
            container.style.display = "none";
        }
    }


    function togglePaymentMode(type) {
        // Hide all sections first
        ['cash', 'onlineTr', 'cheque', 'savingAcc'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        // Show the selected section
        if (type === 'onlineTr') document.getElementById('onlineTr').classList.remove('hidden');
        if (type === 'cheque') document.getElementById('cheque').classList.remove('hidden');
        if (type === 'savingAcc') document.getElementById('savingAcc').classList.remove('hidden');
    }

    function toggleAccountType(type) {

        ['single', 'joint'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        // Show the selected section
        if (type === 'joint') {
            document.getElementById('joint').classList.remove('hidden');
        } else {
            document.getElementById('single').classList.remove('hidden');
        }
    }
</script>
@endsection