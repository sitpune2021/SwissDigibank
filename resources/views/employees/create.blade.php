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
        <div class="mb-6 flex flex-wrap items-start  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <h3 class="text-xl uppercase font-semibold">
                    New Employee
                </h3>


            </div>

        </div>

        <div class="col-span-12 box lg:col-span-12">

            <form>
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Link Member Profile
                            <span class="text-red-500">*</span>
                        </label>

                        <select id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Scheme Name " value="">
                            <option value="">select member or name</option>

                        </select>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        {{-- Do not Remove Div --}}
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Branch
                            <span class="text-red-500">*</span>
                        </label>

                        <select id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Enter Scheme Name " value="">
                            <option value="">Select Branch</option>

                        </select>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for=" " class="md:text-lg font-medium block mb-4 uppercase">
                            Joining Date
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">

                            <input type="text" id="date" name=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3 md:py-3"
                                placeholder="DD/MM/YYYY">
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="pincode" class="md:text-lg font-medium block mb-4 uppercase">
                            Designation
                        </label>
                        <div class="flex items-center gap-1 ">

                            <input type="text" name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3 md:py-3"
                                placeholder="Enter Designation like 'Executive'">
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1  pt-3 ">
                        <p class="text-blue-500">
                        </p>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="pincode" class="md:text-lg font-medium block mb-4 uppercase">
                            Name
                            <span class="text-error">*</span>
                        </label>
                        <div class="flex items-center gap-1 ">

                            <input type="text" name="" id=""
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3 md:py-3"
                                placeholder="Enter Name">
                        </div>

                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Gender
                            <span class="text-error">*</span>
                        </label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="">
                                <span class="uppercase">Male</span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="">
                                <span class="uppercase">Female</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="gender" value="">
                                <span class="uppercase">Other</span>
                            </label>
                        </div>

                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Date of Birth
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="date2" name="" placeholder="DD/MM/YYYY"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 py-3 md:py-3">
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                           Email
                        
                        </label>
                       
                        <input type="text" id="" name="" placeholder="Enter Email"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 py-3 md:py-3">
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Mobile No
                            <span class="text-red-500">*</span>
                        </label>
                          <div class="flex gap-3 flex-row ">
                            <input type="text" name="" id="" class="w-20 text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3" value="+91" disabled>

                            <input type="number" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3"
                            placeholder="Enter Mobile No">
                          </div>
                        
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                          Address
                        </label>

                        <textarea name="" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 py-3 md:py-3" placeholder="Enter Address"></textarea>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Father Name
                           
                        </label>
                        
                            <input type="number" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3 "
                            placeholder="Enter Father Name">

                    </div>
                      <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            PAN No.
                            
                        </label>
                        
                            <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3" style="text-transform: uppercase;"
                            placeholder="Enter Pan No">

                    </div>


                    <div class="col-span-2 md:col-span-1">
                       <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                          Aadhaar No.
                        </label>
                        
                            <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3" style="text-transform: uppercase;"
                            placeholder="Enter Aadhaar No.">
                    </div>

                    <!--  Nominee  -->
                    <div class="mt-4 col-span-2 md:col-span-1 ">
                        <p class="font-medium">
                            Nominee
                            <span class="text-red-500">*</span>
                        </p>
                        <div class="flex items-center  gap-2">
                            <label class=" mt-2 flex items-center  gap-2">
                                <input type="radio" name="second" value="yes" onclick="toggleAddMore(true)"> Yes
                            </label>
                            <label class=" mt-2 flex items-center  gap-2">
                                <input type="radio" name="second" value="no" onclick="toggleAddMore(false)"> No
                            </label>
                        </div>


                        <!-- Add More Button -->

                        <div id="addMoreText" class="hidden mt-3">
                            <p class="text-blue-600 underline cursor-pointer uppercase" onclick="addNomineeInputs()">+ ADD
                                MORE NOMINEE</p>
                        </div>

                    </div>
                </div>

                <div id="extraInputs" class="mt-3 w-full space-y-3"></div>

                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Final Amount

                        </label>

                        <input type="text" id="" name=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6    py-3 md:py-3"
                            placeholder="0" value="" disabled>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            T. Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="date2" name="" placeholder="DD/MM/YYYY" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 
                                            py-3 md:py-3">

                    </div>



                    <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">

                        <!-- Section Title -->
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Pay Mode 1</h4>

                        <!-- Amount Field -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                            <label for="" class="text-sm font-medium text-gray-700">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="" name="" placeholder="Enter Amount"
                                    class="w-full border rounded-10 px-3 py-3 text-sm bg-white/5 ">

                            </div>
                        </div>

                        <!-- Pay Mode -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start">
                            <label class="text-sm font-medium text-gray-700">
                                Pay Mode <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2 flex flex-wrap gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode" value="cash"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Cash</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode" value="cheque"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Cheque</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode" value="online"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Online Tr.</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode" value="saving"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Saving Ac.</span>
                                </label>
                            </div>
                        </div>
                        <!-- Cheque Fields -->
                        <div id="chequeFields" class="space-y-4 hidden">
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700">Bank Name <span
                                        class="text-red-500">*</span></label>
                                <select class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3">
                                    <option value="">Select Bank</option>
                                    <option>SBI</option>
                                    <option>HDFC</option>
                                    <option>ICICI</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text" class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                    placeholder="Enter Cheque No.">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="date4"
                                    class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                    placeholder="DD/MM/YYYY">
                            </div>
                        </div>

                        <!-- Online Transaction Fields -->
                        <div id="onlineFields" class="space-y-4 hidden">
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="date3"
                                    class="w-full border rounded-10 px-3 py-3 dark:bg-bg3 text-sm bg-white"
                                    placeholder="DD/MM/YYYY">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text" class="w-full border rounded-10 px-3 py-3 text-sm dark:bg-bg3 bg-white"
                                    placeholder="Enter Transaction No.">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transfer Mode <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transferMode" value="neft"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>IMPS</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transferMode" value="rtgs"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>VPA</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transferMode" value="upi"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>NEFT/RTGS</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Credited in Company Account <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="yes"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="no"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Saving Account Fields -->
                        <div id="savingFields" class="space-y-4 hidden mt-3">
                            <label class="block text-sm font-medium text-gray-700">Select Saving Account <span
                                    class="text-red-500">*</span></label>
                            <select class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                                <option value="">Select Account</option>
                                <option>Account 1</option>

                            </select>
                        </div>
                    </div>



                    <!-- pay mode 2-->
                    <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">
                        <!-- Section Title -->
                        <h4 class="text-lg font-semibold dark:text-white  text-gray-800 mb-2">Pay Mode 2</h4>

                        <!-- Amount Field -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                            <label for="pay2_amount" class="text-sm font-medium text-gray-700">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="" name="pay2_amount" placeholder="Enter Amount"
                                    class="w-full border rounded-10 px-3 py-3 text-sm bg-gray-50 ">
                            </div>
                        </div>

                        <!-- Pay Mode -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start">
                            <label class="text-sm font-medium text-gray-700">
                                Pay Mode <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2 flex flex-wrap gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode2" value="cash"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Cash</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode2" value="cheque"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Cheque</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode2" value="online"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Online Tr.</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="payMode2" value="saving"
                                        class="text-green-600 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Saving Ac.</span>
                                </label>
                            </div>
                        </div>



                        <!-- Cheque Fields -->
                        <div id="chequeFields2" class="space-y-4 hidden">
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700">Bank Name <span
                                        class="text-red-500">*</span></label>
                                <select class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                                    <option value="">Select Bank</option>
                                    <option>SBI</option>
                                    <option>HDFC</option>
                                    <option>ICICI</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text" class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white"
                                    placeholder="Enter Cheque No.">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="date5" placeholder="DD/MM/YYYY"
                                    class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                            </div>
                        </div>

                        <!-- Online Transaction Fields -->
                        <div id="onlineFields2" class="space-y-4 hidden">
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="date6" placeholder="DD/MM/YYYY"
                                    class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text" class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white"
                                    placeholder="Enter Transaction No.">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transfer Mode <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transferMode2" value="imps"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>IMPS</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transferMode2" value="vpa"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>VPA</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transferMode2" value="neft"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>NEFT/RTGS</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Credited in Company Account <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited2" value="yes"
                                            class="text-green-600 focus:ring-green-500">
                                        <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited2" value="no"
                                            class="text-green-600 focus:ring-green-500">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Saving Account Fields -->
                        <div id="savingFields2" class="space-y-4 hidden mt-3">
                            <label class="block text-sm font-medium text-gray-700">Select Saving Account <span
                                    class="text-red-500">*</span></label>
                            <select class="w-full border rounded-10 px-3 py-3 text-sm  dark:bg-bg3 bg-white">
                                <option value="">Select Account</option>
                                <option>Account 1</option>
                                <option>Account 2</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="flex flex-col sm:flex-row justify-center  gap-3 mt-5 w-full">
                    <button type="submit" class=" sm:w-auto  justify-center btn-primary  uppercase ">
                        open MIS
                    </button>
                    <button type="reset" class="sm:w-auto  justify-center uppercase btn-outline">
                        Reset
                    </button>
                    <button type="button" class=" sm:w-auto  justify-center uppercase btn-outline">
                        back
                    </button>


                </div>

            </form>
        </div>


    </div>

    </div>


    <!--nomine -->

    <script>
        //nomine
        function toggleSelect(show) {
            document.getElementById("accountSelect").classList.toggle("hidden", !show);
        }

        function toggleAddMore(show) {
            document.getElementById("addMoreText").classList.toggle("hidden", !show);
            if (!show) {
                document.getElementById("extraInputs").innerHTML = "";
            }
        }

        function addNomineeInputs() {
            const container = document.getElementById("extraInputs");
            const nomineeBlock = document.createElement("div");

            //  Added nominee-item class here
            nomineeBlock.className = "nominee-item grid grid-cols-4 gap-2 items-center bg-gray-50 p-2 rounded-md shadow";

            nomineeBlock.innerHTML = `
                        <div class="nominee-row flex  flex-wrap items-start gap-6">
                            <div class="flex-center  flex-1 min-w-[200px] max-w-full">
                                <label class="font-medium mb-2">Relation <span class="text-red-500">*</span></label>
                                <select class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500
                                               rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    <option value="">Select Relation</option>
                                    <option>Father</option>
                                    <option>Mother</option>
                                    <option>Spouse</option>
                                    <option>Son</option>
                                    <option>Daughter</option>
                                    <option>Brother</option>
                                    <option>Sister</option>
                                    <option>Grandfather</option>
                                    <option>Grandmother</option>
                                    <option>Uncle</option>
                                    <option>Aunt</option>
                                    <option>Cousin</option>
                                    <option>Nephew</option>
                                    <option>Niece</option>
                                    <option>Father-in-law</option>
                                    <option>Mother-in-law</option>
                                    <option>Brother-in-law</option>
                                    <option>Sister-in-law</option>
                                    <option>Son-in-law</option>
                                    <option>Daughter-in-law</option>
                                    <option>Guardian</option>
                                    <option>Friend</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="flex-1 min-w-[200px]  max-w-full">
                                <label class="font-medium mb-2">Name <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Enter Nominee Name"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500
                                    rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            <div class="flex-1 min-w-[200px]  max-w-full">
                                <label class="font-medium mb-2">Address <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Enter Nominee Address"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500
                                    rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>

                            <div class="flex-1 min-w-[60px]  max-w-full flex justify-end items-center">
                                <button type="button" onclick="removeNominee(this)"
                                    class="text-error font-bold  text-lg hover:text-red-700">✕</button>
                            </div>
                        </div> `;

            container.appendChild(nomineeBlock);
        }

        function removeNominee(button) {
            const item = button.closest(".nominee-item");
            if (item) item.remove();

            const container = document.getElementById("extraInputs");

            // ✅ Keep container visible, just clear content if empty
            if (container.children.length === 0) {
                container.innerHTML = "";
            }
        }

    </script>



    <!--payment mode1-->
    <script>
        //payment mode1
        const payModeRadios = document.querySelectorAll('input[name="payMode"]');
        const onlineFields = document.getElementById('onlineFields');
        const chequeFields = document.getElementById('chequeFields');
        const savingFields = document.getElementById('savingFields');

        payModeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                // hide all first
                onlineFields.classList.add('hidden');
                chequeFields.classList.add('hidden');
                savingFields.classList.add('hidden');

                // show based on selected
                if (radio.value === 'online') onlineFields.classList.remove('hidden');
                if (radio.value === 'cheque') chequeFields.classList.remove('hidden');
                if (radio.value === 'saving') savingFields.classList.remove('hidden');
            });
        });
    </script>


    <script>
        //pay mode 2
        (function () {
            const payModeRadios2 = document.querySelectorAll('input[name="payMode2"]');
            const onlineFields2 = document.getElementById('onlineFields2');
            const chequeFields2 = document.getElementById('chequeFields2');
            const savingFields2 = document.getElementById('savingFields2');

            payModeRadios2.forEach(radio => {
                radio.addEventListener('change', () => {
                    onlineFields2.classList.add('hidden');
                    chequeFields2.classList.add('hidden');
                    savingFields2.classList.add('hidden');

                    if (radio.value === 'online') onlineFields2.classList.remove('hidden');
                    if (radio.value === 'cheque') chequeFields2.classList.remove('hidden');
                    if (radio.value === 'saving') savingFields2.classList.remove('hidden');
                });
            });
        })();
    </script>
@endsection