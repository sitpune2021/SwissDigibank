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
          <label for="" class="block font-medium mb-2">Account No <span class="text-red-500">*</span></label>
          <select id="account_id" name="account_id" required
            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
            <option value="">Select Account</option>
            @foreach($accounts as $account)
            <option value="{{ $account->id }}">{{ $account->account_no }}</option>
            @endforeach
          </select>
        </div>
        <!-- HTML -->
        <div class="w-full mt-4">
          <label class="block font-medium mb-2">Date From <span class="text-red-500">*</span></label>
          <input type="text" id="from_date" name="from_date" placeholder="DD/MM/YYYY" autocomplete="off"
            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
        </div>

        <div class="w-full mt-4">
          <label class="block font-medium mb-2">Date To <span class="text-red-500">*</span></label>
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
          <label class="block font-medium mb-2" for="tenure_type">
            Print <span class="text-red-500">*</span>
          </label>

          <div class="flex flex-wrap gap-4">
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
        <div class="overflow-x-auto ">
          <table class="w-full border border-gray-300 text-sm mt-8">
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
          </table>
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
  $('#passbookForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
      url: "{{ route('accounts.passbook.search') }}",
      type: "POST",
      data: $(this).serialize(),
      success: function(res) {
        if (res.transactions && res.transactions.length > 0) {
          currentTransactions = res.transactions; // save data in variable
        } else {
          currentTransactions = [];
          alert("No transactions found!");
        }
      },
      error: function(xhr) {
        alert("Error fetching transactions");
      }
    });
  });

  function printPassbook() {
    if (!currentTransactions || currentTransactions.length === 0) {
      alert("No transactions to print!");
      return;
    }
    
    let printHtml = `
    <style>
        .letterhead {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #000;
      padding-bottom: 8px;
      margin-bottom: 15px;
    }

    .logo {
      width: 120px;
      text-align: center;
    }

    .logo img {
      width: 100%;
      height: 100%;
    }

    .bank-details {
      flex: none;
      text-align: center;
      padding: 0 15px;
    }

    .bank-details h1 {
      font-size: 18px;
      margin: 0;
      font-weight: bold;
      white-space: nowrap;
    }

    .bank-details p {
      margin: 3px 0;
      font-size: 13px;
    }
    </style>
       <div class="letterhead">
        <!-- Logo -->
        <div class="logo">
          <img src="{{ asset('assets/images/Loan_Management_logo.png') }}" alt="Logo">
        </div>
        <!-- Bank Details -->
        <div class="bank-details">
          <h1>SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA <br> LIMITED</h1>
          <br>
          <p>SHEGAON SHEGAON Maharashtra - 110012</p>
          <p>E: sbcglobalbank@gmail.com | L: 0724-2991230 | M: 9922870805</p>
          <p>CIN: 969/03-04</p>
        </div>
        <div class="logo"></div>
      </div>


      <div  style="  text-align: right;
    padding-bottom: 20px;">Date - {{ now()->format('d/m/Y') }}</div>
 
 
<div style="font-weight: bold; margin-top: 15px; text-align: center;"><h3 >Saving Account Statement</h3></div>
 
<table border="1" style=" width: 100%; border-collapse: collapse; margin-bottom: 20px;">
  <tr>
    <td style="width: 25%;">Member's Name</td>
    <td style="width: 25%;">{{ $account->members->member_info_first_name }} {{ $account->members->member_info_last_name }}</td>
    <td style="width: 25%;">Internal A/c No</td>
    <td style="width: 25%;">{{ $account->account_no }}</td>
  </tr>
  <tr>
    <td>Virtual A/c No</td>
    <td></td>
    <td>IFSC code</td>
    <td>NA</td>
  </tr>
  <tr>
    <td style="padding: 20px 0;">Address</td>
<td>
    @php
        $address = trim(
            ($account->members->address->member_address_line_1 ?? '') . ' ' .
            ($account->members->address->member_address_line_2 ?? '') . ' ' .
            ($account->members->address->member_address_area ?? '') . ' ' .
            ($account->members->address->member_address_landmark ?? '') . ' ' .
            ($account->members->address->member_address_city_district ?? '') . ' ' .
            ($account->members->address->member_address_state ?? '') . ' ' .
            ($account->members->address->member_address_pincode ?? '')
        );
    @endphp

    {{ $address !== '' ? $address : 'NA' }}
</td>
    <td >Scheme</td>
    <td >{{ $account->scheme->name ?? 'NA' }}</td>
  </tr>
  <tr>
    <td>Opening date</td>
    <td>{{ \Carbon\Carbon::parse($account->open_date)->format('d/m/Y') }}</td>
    <td>Interest Rate</td>
    <td>{{ $account->scheme->interest_rate ?? 0 }}%</td>
  </tr>
</table>
<div style="margin-bottom: 15px; text-align: center;""><p>Statement Period: 29/02/2024  10:26 - 29/09/2024 12:23</p></div>

    <table border="1" cellspacing="0" cellpadding="5" style="width:100%;border-collapse:collapse;">
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Cheque No</th>
          <th>Debit</th>
          <th>Credit</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>
  `;

    currentTransactions.forEach(txn => {
      printHtml += `
      <tr>
        <td>${txn.date ?? '-'}</td>
        <td>${txn.description ?? '-'}</td>
        <td>${txn.cheque_no ?? '-'}</td>
        <td style="text-align:right">${txn.debit_amount ?? '-'}</td>
        <td style="text-align:right">${txn.credit_amount ?? '-'}</td>
        <td style="text-align:right">${txn.balance ?? '-'}</td>
      </tr>`;
    });

    printHtml += `</tbody></table>`;

    let printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Passbook</title></head><body>');
    printWindow.document.write(printHtml);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  }
</script>

@endsection