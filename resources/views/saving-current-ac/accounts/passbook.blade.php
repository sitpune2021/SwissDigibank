@extends('layout.main')
@section('content')

<style>
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

<div class="main-inner">
  <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
    <div class="flex items-start flex-col  gap-2">
      <div class="flex items-center gap-3">
        <h1 class="text-xl font-semibold uppercase">
          Print Saving Passbook
        </h1>
      </div>
    </div>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 ">
    <div class="col-span-2 md:col-span-1 box dark:bg-bg3 rounded-2xl p-6">
      <form action="" id="passbookForm">
        @csrf
        <div class="mb-4">
          <label for="" class="block font-medium mb-2 uppercase">Account No <span class="text-red-500">*</span></label>
          <select id="account_id" name="account_id"
            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
            <!-- <option value="">Select Account</option> -->
            @foreach($accounts as $account)
            <option value="{{ $account->id }}">{{ $account->account_no }}</option>
            @endforeach
          </select>
        </div>
        <!-- HTML -->
        <div class="w-full mt-4">
          <label class="block font-medium mb-2 uppercase">Date From <span class="text-red-500">*</span></label>
          <input type="text" id="from_date" name="from_date" placeholder="DD/MM/YYYY" autocomplete="off"
            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
        </div>

        <div class="w-full mt-4">
          <label class="block font-medium mb-2 uppercase">Date To <span class="text-red-500">*</span></label>
          <input type="text" id="to_date" name="to_date" placeholder="DD/MM/YYYY" autocomplete="off"
            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
        </div>

        <div class="w-full mt-4 flex flex-wrap gap-2">
          <button type="button" data-range="6m" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 6 Months</button>
          <button type="button" data-range="3m" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 3 Months</button>
          <button type="button" data-range="1w" class="px-3 py-2 border rounded-10 btn-primary hover:bg-gray-200">Last 1 Week</button>
          <button type="button" data-range="1d" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 1 Day</button>
          <button type="button" data-range="custom" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Custom</button>
        </div>

        <!-- PrintType *-->
        <div class="w-full mt-4 ">
          <label class="block font-medium mb-2 uppercase" for="tenure_type">
            Print <span class="text-red-500">*</span>
          </label>

          <div class="flex flex-wrap gap-4" id="resultContainer">
            <label class="flex items-center space-x-2 gap-2">
              <input type="radio" name="print" value="front" class="text-blue-600 focus:ring-blue-500">
              <span> FRONT PAGE</span>
            </label>

            <label class="flex items-center space-x-2 gap-2">
              <input type="radio" name="print" value="statement" class="text-blue-600 focus:ring-blue-500">
              <span>STATEMENT</span>
            </label>
            <label class="flex items-center space-x-2 gap-2">
              <input type="radio" name="print" value="full" checked
                class="text-blue-600 focus:ring-blue-500">
              <span> FULL STATEMENT</span>
            </label>
          </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center gap-4 mt-6 pt-6">
          <button type="submit" class="btn-primary rounded-10 uppercase">
            Search
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="box p-4">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 min-h-[46px]">
      <!-- Print Button -->
      <a href="#" class="btn-primary p-3" onclick="printPassbook()">
        <i class="las la-print mr-2"></i>
      </a>

      <!-- Printing Type -->
      {{-- <div class="flex flex-col sm:flex-row sm:items-center gap-2">
      <label for="design_type" class="text-sm font-medium text-gray-700">
        Printing Type:
      </label>
      <select name="design_type" id="design_type" required
              class="w-full sm:w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
        <option value="1">Format 1</option>
        <option value="20.0">20.0 cm</option>
      </select>
    </div> --}}
    </div>

    <!-- Printable Area -->
    <div id="printableArea">
      <div class="print-preview border shadow-sm">
        <div class="overflow-x-auto w-full justify-center ">
          <!-- <table class="w-full border border-gray-300 text-sm mt-8">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-2 py-2 border w-1/6 text-left">Date</th>
                <th class="px-2 py-2 border w-1/6 text-left">Particulars</th>
                <th class="px-2 py-2 border w-1/6 text-left">Cheque No</th>
                <th class="px-2 py-2 border w-1/6 text-right">DR Amount</th>
                <th class="px-2 py-2 border w-1/6 text-right">CR Amount</th>
                <th class="px-2 py-2 border w-1/6 text-right">Balance</th>
              </tr>
            </thead>
          </table> -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- JS -->

<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
<script>
  const fromElem = document.getElementById("from_date");
  const toElem = document.getElementById("to_date");

  let isCustomMode = false;
  let fromSelected = null;

  // Initialize pickers
  const fromPicker = new Datepicker(fromElem, {
    autohide: true,
    format: "dd-mm-yyyy"
  });
  const toPicker = new Datepicker(toElem, {
    autohide: true,
    format: "dd-mm-yyyy"
  });

  // Reset pickers
  function resetPickers() {
    fromPicker.setDate(null);
    toPicker.setDate(null);
    fromPicker.setOptions({
      minDate: null,
      maxDate: null
    });
    toPicker.setOptions({
      minDate: null,
      maxDate: null,
      beforeShowDay: null
    });
    fromSelected = null;
  }

  function calculateMaxTo(fromDate) {
    const maxTo = new Date(fromDate);
    maxTo.setMonth(maxTo.getMonth() + 6);
    const today = new Date();
    return maxTo > today ? today : maxTo;
  }

  function highlightToRange(fromDate) {
    const maxTo = calculateMaxTo(fromDate);
    toPicker.setOptions({
      beforeShowDay: function(date) {
        return (date >= fromDate && date <= maxTo) ? true : false;
      }
    });
  }

  // From Date change
  fromElem.addEventListener("changeDate", e => {
    if (!isCustomMode) return;
    fromSelected = e.date;
    if (!fromSelected) return;

    // Reset To Date
    toPicker.setDate(null);

    // Set To Date min/max
    toPicker.setOptions({
      minDate: fromSelected,
      maxDate: calculateMaxTo(fromSelected)
    });

    // Highlight the range
    highlightToRange(fromSelected);
  });

  // To Date focus → show only 6 months after From, capped by today
  toElem.addEventListener("focus", () => {
    if (!isCustomMode || !fromSelected) return;
    toPicker.setOptions({
      minDate: fromSelected,
      maxDate: calculateMaxTo(fromSelected)
    });
    highlightToRange(fromSelected);
  });

  // To Date change → cannot be smaller than From
  toElem.addEventListener("changeDate", e => {
    if (!isCustomMode) return;
    const toSelected = e.date;
    if (!toSelected || !fromSelected) return;
    if (toSelected < fromSelected) toPicker.setDate(null);
  });

  // Quick-select buttons
  document.querySelectorAll("button[data-range]").forEach(btn => {
    btn.addEventListener("click", () => {
      const range = btn.getAttribute("data-range");
      isCustomMode = (range === "custom");

      if (isCustomMode) {
        resetPickers();
        fromPicker.setOptions({
          minDate: null,
          maxDate: null
        });
        toPicker.setOptions({
          minDate: null,
          maxDate: null,
          beforeShowDay: null
        });
        return;
      }

      const today = new Date();
      let startDate = new Date();
      if (range === "6m") startDate.setMonth(startDate.getMonth() - 6);
      if (range === "3m") startDate.setMonth(startDate.getMonth() - 3);
      if (range === "1w") startDate.setDate(startDate.getDate() - 7);
      if (range === "1d") startDate.setDate(startDate.getDate() - 1);

      isCustomMode = false;
      fromPicker.setOptions({
        minDate: startDate,
        maxDate: today
      });
      fromPicker.setDate(startDate);
      toPicker.setOptions({
        minDate: startDate,
        maxDate: today
      });
      toPicker.setDate(today);
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let currentTransactions = [];
  let accountData = {};

  $('#passbookForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
      url: "{{ route('accounts.passbook.search') }}",
      type: "POST",
      data: $(this).serialize(),
      success: function(res) {
        console.log(res.transactions);

        accountData = res.account ?? {};
        currentTransactions = res.transactions ?? [];

        if (res.printType === "front") {
          $("#printableArea").html(renderFrontPage(res.account));
        } else if (res.printType === "statement") {
          $("#printableArea").html(renderStatement(res.transactions));
        } else {
          $("#printableArea").html(renderFullStatement(res.account, res.transactions));
        }
      },
      error: function(xhr) {
        alert("Error fetching transactions");
      }
    });
  });

  // 🔹 Print Button Function
  function printPassbook() {
    const printType = $("input[name='print']:checked").val();
    let html = "";
    if (printType === "front") {

      html = renderFrontPage(accountData);
    } else if (printType === "statement") {
      html = renderStatement(currentTransactions);
    } else if (printType === "full") {
      html = renderFullStatement(accountData, currentTransactions);
    } else {
      alert("Please select a print option!");
      return;
    }

    showPrintWindow(html);
  }

  function renderFullStatement(accountData, transactions) {
    if (!transactions || transactions.length === 0) {
      alert("No transactions to print!");
      return;
    }

    let html = `
    

<body style="font-family: Arial, sans-serif; font-size: 12px; margin: 0; display: flex; flex-direction:column; justify-content: center; align-items: flex-start; padding-top: 20px;">

  <div style=" padding: 18px 20px; box-sizing: border-box; display: flex; flex-direction: column; gap: 20px;">

    <!-- Main Content -->
    <div style="display: flex; justify-content: space-between; gap: 20px;">

      <!-- Left Section -->
      <div style="flex: 1;">
        <div>
          <img src="{{ asset('assets/images/LM_logo.png') }}" alt="Logo" style="height: 100px; width: auto;">
        </div>
        <div style="border: 1px solid black; padding: 12px; font-size: 13px; line-height: 1.4;">
          <div style="font-weight: bold; margin-bottom: 6px;">

            ${accountData.members?.member_info_first_name ?? '-'} ${accountData.members?.member_info_last_name ?? ''}
          </div>
          <div>
            ${[
            accountData.address?.member_address_line_1,
            accountData.address?.member_address_line_2,
            accountData.address?.member_address_area,
            accountData.address?.member_address_landmark,
            accountData.address?.member_address_city_district,
            accountData.address?.name,
            accountData.address?.member_address_pincode
            ].filter(Boolean).join(', ') || '-' }
          </div>
          <div style="margin-top: 10px; font-weight: bold;">
            JOINT HOLDER : ${accountData.account_holder_type === 'joint' ? 'YES' : 'NO'}
          </div>
        </div>
      </div>

      <!-- Right Section -->
      <div style="flex: 1; font-size: 13px;">
        <table style="width: 100%; border-collapse: collapse;">
          <tr>
            <td style="width: 40%; font-weight: bold; padding: 3px 4px; vertical-align: top;">CUSTOMER ID</td>
            <td style="width: 2%; text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="width: 58%; padding: 3px 4px; vertical-align: top;">${accountData.members?.member_no ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">BRANCH NAME</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.branch?.branch_name ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">ACCOUNT TYPE</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.account_type ?? '-'} </td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">BRANCH CODE</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.branch?.branch_code ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">ACCOUNT NUMBER</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.account_no ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">IFSC CODE</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.branch?.ifsc_code ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">BRANCH ADDRESS</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.branch?.address_line1 ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">JOINT A/C HOLDER NAME</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.joint_member1 ?? '–'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">PHONE</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.members?.member_info_mobile_no ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">MODE OF OPERATION</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.operation_mode ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">DATE OF ISSUE</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.issue_date ?? '-'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">NOMINEE NAME</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">${accountData.nominee?.nominee_name ?? 'Not Reg.'}</td>
          </tr>
          <tr>
            <td style="font-weight: bold; padding: 3px 4px; vertical-align: top;">PHONE</td>
            <td style="text-align: center; padding: 3px 4px; vertical-align: top;">:</td>
            <td style="padding: 3px 4px; vertical-align: top;">0000000000</td>
          </tr>
        </table>
      </div>
    </div>

  </div>
</body>
 

  <table class="transactions" style="width:100%; text-align:left; border:1px solid black; border-collapse:collapse; margin-top:15px;" border="1">
    <thead>
      <tr>
        <th style="border:1px solid black; border-collapse:collapse;">Date</th>
        <th style="border:1px solid black; border-collapse:collapse;">Description</th>
        <th style="border:1px solid black; border-collapse:collapse;">Cheque No</th>
        <th style="border:1px solid black; border-collapse:collapse;">Debit</th>
        <th style="border:1px solid black; border-collapse:collapse;">Credit</th>
        <th style="border:1px solid black; border-collapse:collapse;">Balance</th>
      </tr>
    </thead>
    <tbody>
    `;

    transactions.forEach(txn => {
      html += `
          <tr style="border:1px solid black; border-collapse:collapse;">
            <td style="border:1px solid black; border-collapse:collapse;">${txn.date ?? '-'}</td>
            <td style="text-align:left border:1px solid black; border-collapse:collapse;">${txn.description ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.cheque_no ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.debit_amount ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.credit_amount ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.balance ?? '-'}</td>
          </tr>
        `;
    });
    html += `
        </tbody>
      </table>
        </div>
    `;


    return html;
  }

  function renderFrontPage(accountData) {
    return ` 
<body style="font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px;">
  <style>
    @media print {
      body {
        -webkit-print-color-adjust: exact;
      }
      .passbook {
        width: 100%;
        height: auto !important;   /* remove fixed height */
        padding: 0;
        box-sizing: border-box;
        font-size: 11px;          /* slightly smaller font */
        border-bottom:1px solid black;
      }
      table {
        page-break-inside: auto;
      }
      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
    }
  </style>

  <div class="passbook" style="width: 100%; padding: 15px 20px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between;">
    <table style="width: 100%; border-collapse: collapse; flex-grow: 1; margin-top: 37px;">
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">CUSTOMER ID</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.members?.member_no ?? '-'}</td>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">BRANCH NAME</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.branch?.branch_name ?? '-'}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">ACCOUNT TYPE</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.account_holder_type ?? '-'}</td>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">BRANCH CODE</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.branch?.branch_code ?? '-'}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">ACCOUNT NUMBER</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.account_no ?? '-'}</td>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">IFSC CODE</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.branch?.ifsc_code ?? '-'}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">ACCOUNT HOLDER NAME</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.members?.member_info_first_name ?? '-'}</td>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">BRANCH ADDRESS</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">  
        ${accountData.address?.member_address_line_1 ?? ''}

        </td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">JOINT A/c HOLDER NAME</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.members?.member_info_first_name ?? ''}
        </td>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">PHONE</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.branch?.mobile_no ?? '-'}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">MODE OF OPERATION</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.operation_mode ?? '-'}</td>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">DATE OF ISSUE</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">ADDRESS</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">
                      ${[
            accountData.address?.member_address_line_1,
            accountData.address?.member_address_line_2,
            accountData.address?.member_address_area,
            accountData.address?.member_address_landmark,
            accountData.address?.member_address_city_district,
            accountData.address?.name,
            accountData.address?.member_address_pincode
            ].filter(Boolean).join(', ') || '-' }
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">NOMINEE NAME</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.nominee?.nominee_name ?? 'Not Reg.'}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">PHONE</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.members?.member_info_mobile_no ?? '-'}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; width: 19%; padding: 2px 5px; vertical-align: top; font-size: 12px;">EMAIL</td>
        <td style="font-weight: bold; width: 2%; padding: 2px 5px; vertical-align: top; font-size: 12px;">:</td>
        <td style="width: 29%; padding: 2px 5px; vertical-align: top; font-size: 12px;">${accountData.members?.member_info_email?? '-'}</td>
      </tr>
    </table>
    <div style="margin-top: 6px; text-align: right; font-weight: bold; font-size: 12px;">AUTHORIZED  SIGNATORY</div>
  </div>
</body>
  `;
  }

  // ✅ Render Statement
  function renderStatement(transactions) {
    if (!currentTransactions.length) {
      return `<p style="color:red; text-align:center;">No transactions found!</p>`;
    }
    let html = `
    <div class="statement" style="width:794px; padding:18px 20px; box-sizing:border-box; font-family:Arial, sans-serif; font-size:12px;">
      <table class="transactions" style="width:100%; text-align:left; border:1px solid black; border-collapse:collapse; margin-top:15px;" border="1">
        <thead >
          <tr>
            <th style="border:1px solid black; border-collapse:collapse;">Date</th>
            <th style="border:1px solid black; border-collapse:collapse;">Description</th>
            <th style="border:1px solid black; border-collapse:collapse;">Cheque No</th>
            <th style="border:1px solid black; border-collapse:collapse;">Debit</th>
            <th style="border:1px solid black; border-collapse:collapse;">Credit</th>
            <th style="border:1px solid black; border-collapse:collapse;">Balance</th>
          </tr>
        </thead>
        <tbody>
    `;

    transactions.forEach(txn => {
      html += `
          <tr style="border:1px solid black; border-collapse:collapse;">
            <td style="border:1px solid black; border-collapse:collapse;">${txn.date ?? '-'}</td>
            <td style="text-align:left border:1px solid black; border-collapse:collapse;">${txn.description ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.cheque_no ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.debit_amount ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.credit_amount ?? '-'}</td>
            <td style="border:1px solid black; border-collapse:collapse;">${txn.balance ?? '-'}</td>
          </tr>
        `;
    });
    html += `
        </tbody>
      </table>
        </div>
    `;
    return html;

  }

  function showPrintWindow(content) {
    let printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Passbook</title></head><body>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  }
</script>

@endsection