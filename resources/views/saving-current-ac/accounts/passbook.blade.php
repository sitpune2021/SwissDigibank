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
        <form action="" method="" target="" class="space-y-6">

          <!-- Scheme -->
          <div class="mb-4">
            <label for="" class="block font-medium mb-2">Account No <span class="text-red-500">*</span></label>
            <select id="" name="" required
              class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5 dark:bg-bg3 ">
              <option value="">Account No</option>
              
            </select>
          </div>      
<!-- HTML -->
<div class="w-full mt-4">
  <label class="block font-medium mb-2">Date From <span class="text-red-500">*</span></label>
  <input type="text" id="from_date" placeholder="DD/MM/YYYY" autocomplete="off"
    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
</div>

<div class="w-full mt-4">
  <label class="block font-medium mb-2">Date To <span class="text-red-500">*</span></label>
  <input type="text" id="to_date" placeholder="DD/MM/YYYY" autocomplete="off"
    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
</div>

<div class="w-full mt-4 flex flex-wrap gap-2">
  <button type="button" data-range="6m" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 6 Months</button>
  <button type="button" data-range="3m" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 3 Months</button>
  <button type="button" data-range="1w" class="px-3 py-2 border rounded-10 btn-primary hover:bg-gray-200">Last 1 Week</button>
  <button type="button" data-range="1d" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Last 1 Day</button>
  <button type="button" data-range="custom" class="px-3 py-2 border  rounded-10 btn-primary hover:bg-gray-200">Custom</button>
</div>

    <!--  Date -->
          {{-- <div class="w-full mt-4 ">
            <label class="block font-medium mb-2" for="tenure_type">
             Date From <span class="text-red-500">*</span>
            </label>
            

            <div class="flex flex-wrap gap-4">

              <input type="text" name="" id="date" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5
                      dark:bg-bg3 " placeholder="DD/MM/YYYY">

            </div>
          </div>
            <div class="w-full mt-4 ">
            <label class="block font-medium mb-2" for="tenure_type">
             Date To <span class="text-red-500">*</span>
            </label>
            

            <div class="flex flex-wrap gap-4">

             <input type="text" name="" id="date2" class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5
                      dark:bg-bg3 " placeholder="DD/MM/YYYY">

            </div>
          </div> --}}
        <!-- Input -->

           <!-- PrintType *-->
          <div class="w-full mt-4 ">
            <label class="block font-medium mb-2" for="tenure_type">
             Print  <span class="text-red-500">*</span>
            </label>

            <div class="flex flex-wrap gap-4">

              <label class="flex items-center space-x-2 gap-2">
                <input type="radio" name="print" value="" required class="text-blue-600 focus:ring-blue-500">
                <span> FRONT PAGE</span>
              </label>

              <label class="flex items-center space-x-2 gap-2">
                <input type="radio" name="print" value="" required class="text-blue-600 focus:ring-blue-500">
                <span>STATEMENT</span>
              </label>
              <label class="flex items-center space-x-2 gap-2">
                <input type="radio" name="print" value="" required checked
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
    <a href="#" class="btn-primary p-3">
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
    <div class="print-preview border   shadow-sm">
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
const fromPicker = new Datepicker(fromElem, { autohide:true, format:"dd-mm-yyyy" });
const toPicker = new Datepicker(toElem, { autohide:true, format:"dd-mm-yyyy" });

// Reset pickers
function resetPickers() {
  fromPicker.setDate(null);
  toPicker.setDate(null);
  fromPicker.setOptions({ minDate:null, maxDate:null });
  toPicker.setOptions({ minDate:null, maxDate:null, beforeShowDay: null });
  fromSelected = null;
}

// Calculate To max date (6 months after From, capped by today)
function calculateMaxTo(fromDate) {
  const maxTo = new Date(fromDate);
  maxTo.setMonth(maxTo.getMonth() + 6);
  const today = new Date();
  return maxTo > today ? today : maxTo;
}

// Highlight only the 6-month range in To calendar
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
  if(!isCustomMode) return;
  fromSelected = e.date;
  if(!fromSelected) return;

  // Reset To Date
  toPicker.setDate(null);

  // Set To Date min/max
  toPicker.setOptions({ minDate: fromSelected, maxDate: calculateMaxTo(fromSelected) });

  // Highlight the range
  highlightToRange(fromSelected);
});

// To Date focus → show only 6 months after From, capped by today
toElem.addEventListener("focus", () => {
  if(!isCustomMode || !fromSelected) return;
  toPicker.setOptions({ minDate: fromSelected, maxDate: calculateMaxTo(fromSelected) });
  highlightToRange(fromSelected);
});

// To Date change → cannot be smaller than From
toElem.addEventListener("changeDate", e => {
  if(!isCustomMode) return;
  const toSelected = e.date;
  if(!toSelected || !fromSelected) return;
  if(toSelected < fromSelected) toPicker.setDate(null);
});

// Quick-select buttons
document.querySelectorAll("button[data-range]").forEach(btn => {
  btn.addEventListener("click", () => {
    const range = btn.getAttribute("data-range");
    isCustomMode = (range === "custom");
   console.log("hiii");
   
    if(isCustomMode){
      resetPickers();
      fromPicker.setOptions({ minDate: null, maxDate: null });
      toPicker.setOptions({ minDate: null, maxDate: null, beforeShowDay: null });
      return;
    }

    const today = new Date();
    let startDate = new Date();
    if(range==="6m") startDate.setMonth(startDate.getMonth()-6);
    if(range==="3m") startDate.setMonth(startDate.getMonth()-3);
    if(range==="1w") startDate.setDate(startDate.getDate()-7);
    if(range==="1d") startDate.setDate(startDate.getDate()-1);

    isCustomMode = false;
    fromPicker.setOptions({ minDate: startDate, maxDate: today });
    fromPicker.setDate(startDate);
    toPicker.setOptions({ minDate: startDate, maxDate: today });
    toPicker.setDate(today);
  });
});
</script>
@endsection