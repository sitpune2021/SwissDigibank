@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2">withdraw</h2>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Deposit Form: col-7 -->
        <div class="col-span-12 lg:col-span-7">
            <div class="mb-4 box" x-data="{ payMode: '' }">
                

                <form class="grid grid-cols-2 gap-6" method="POST" action="#" enctype="multipart/form-data">
                    @csrf

                    <div class="col-span-2 md:col-span-1">
                        <label for="pan_no" class="block mb-1 font-semibold text-gray-700">Member's PAN No</label>
                        <div class="px-2 py-1 mt-2 text-sm text-green-700 border border-green-500 rounded w-fit">Yes</div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-1 font-semibold text-gray-700">Member's Sign</label>
                        <div class="p-2 text-sm text-gray-500 border border-yellow-300 rounded bg-yellow-50">
                            No Signature Present<br>(Upload in Member Documents)
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-1 font-semibold text-gray-700">Member's Photo</label>
                        <div class="p-2 text-sm text-gray-500 border border-yellow-300 rounded bg-yellow-50">
                            No Photo Present<br>(Upload in Member Documents)
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="amount" class="block mb-1 font-semibold text-gray-700">Amount With Draw <span class="text-red-500">*</span></label>
                        <input type="number" id="amount" name="amount"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter Amount" required>
                    </div>

                    <div class="col-span-2">
                        <label for="remarks" class="block mb-1 font-semibold text-gray-700">Remarks (if any)</label>
                        <textarea id="remarks" name="remarks" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter Remarks"></textarea>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="transaction_date" class="block mb-1 font-semibold text-gray-700">Transaction Date <span class="text-red-500">*</span></label>
                        <input type="date" id="transaction_date" name="transaction_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                <label for="receipt" class="block mb-1 font-semibold text-gray-700">T. Receipt</label>
                   <input type="file" id="receipt" name="receipt" disabled
            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"  style="cursor: not-allowed;">
              </div>

                    <div class="col-span-2">
                        <label class="block mb-1 font-semibold text-gray-700">Pay Mode <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6 mt-1">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cash" x-model="payMode" class="text-blue-600 focus:ring-blue-500"> Cash
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="online" x-model="payMode" class="text-blue-600 focus:ring-blue-500"> Online Tr.
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cheque" x-model="payMode" class="text-blue-600 focus:ring-blue-500"> Cheque
                            </label>
                        </div>
                    </div>

                    <!-- Online Transfer Fields -->
                    <div class="grid grid-cols-2 col-span-2 gap-6 p-4 border rounded-lg bg-blue-50" x-show="payMode === 'online'">
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Transfer Date <span class="text-red-500">*</span></label>
                            <input type="date" name="transfer_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">UTR/ Transaction No <span class="text-red-500">*</span></label>
                            <input type="text" name="utr_no"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-1 font-semibold text-gray-700">Transfer Mode <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="imps" class="text-blue-600"> IMPS
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="vpa" class="text-blue-600"> VPA
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="neft" class="text-blue-600"> NEFT/RTGS
                                </label>
                            </div>
                        </div>

                    </div>
            <div class="grid grid-cols-2 col-span-2 gap-6 p-4 border rounded-lg bg-green-50" x-show="payMode === 'cheque'">
          <div>
        <label class="block mb-1 font-semibold text-gray-700">Bank Name <span class="text-red-500">*</span></label>
        <select name="bank_name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <option value="">Select Bank</option>
            <option value="SBI">State Bank of India (SBI)</option>
            <option value="HDFC">HDFC Bank</option>
            <option value="ICICI">ICICI Bank</option>
            <option value="BOB">Bank of Baroda</option>
            <option value="PNB">Punjab National Bank</option>
        </select>
    </div>
      <div>
        <label class="block mb-1 font-semibold text-gray-700">Cheque Number <span class="text-red-500">*</span></label>
        <input type="text" name="cheque_number"  placeholder="Enter Cheque No"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
         </div>

    <!-- Cheque Date -->
         <div>
        <label class="block mb-1 font-semibold text-gray-700">Cheque Date <span class="text-red-500">*</span></label>
        <input type="date" name="cheque_date"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div> 
        </div>
                    <!-- Buttons -->
    <div class="flex gap-4">
        <button type="submit" class="btn-primary">Withdraw</button>
        <button type="reset" class="btn-outline">Cancel</button>
    </div>
                </form>
            </div>
        </div>

  
<div class="col-span-12 lg:col-span-5" x-data="{ open: false }">

    <div class="overflow-hidden border border-green-600 rounded-lg">

        <!-- Full background header (click to toggle) -->
        <div style="background-color:#20b757; color:#fff;"
             class="flex items-center justify-between px-4 py-3 font-bold text-white cursor-pointer"
             @click="open = !open">
            <span>Saving Account Info</span>
            <span x-text="open ? '-' : '+'"
                  class="text-lg font-bold"></span>
        </div>

        <!-- Content -->
        <div x-show="open" x-transition class="p-4 text-sm bg-white">
            <ul class="space-y-2">
                <li class="flex justify-between"><strong>Member:</strong><span>DEMO-04395 - Sagar Chavan</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between"><strong>PAN No.:</strong><span>AAAAA4444A</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between"><strong>Account No.:</strong><span>01940</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between"><strong>Scheme:</strong><span>Future Saving</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between"><strong>Open Date:</strong><span>28/07/2025</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between"><strong>Status:</strong><span>Active</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between"><strong>Available Balance (C):</strong><span>1,000.00</span></li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between">
                    <strong>Joint Account:</strong>
                    <span class="px-2 py-1 text-xs border rounded"
                          style="background-color:#dc2626; color:#fff; border-color:#dc2626;">
                        No
                    </span>
                </li>
                <hr class="my-2 border-gray-300">
                <li class="flex justify-between">
                    <strong>Special Account:</strong>
                    <span class="px-2 py-1 text-xs border rounded"
                          style="background-color:#dc2626; color:#fff; border-color:#dc2626;">
                        No
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
