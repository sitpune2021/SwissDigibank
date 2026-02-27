@extends('layout.main')
@section('content')
 <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            /* margin: 20px; */
        }

        .header {
            text-align: center;
            font-weight: bold;
            line-height: 1.5;
        }

        .sub-header {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .no-border {
            border: none !important;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
        }

        .signature td {
            border: none;
            text-align: right;
            padding-top: 30px;
        }

        .small-table td, .small-table th {
            padding: 5px;
        }

    </style>

<div class="main-inner">
     <h1 class="text-lg font-semibold uppercase" style="font-family: sans-serif !important; ">
       Management Information System
    </h1>
{{-- <div class="text-center flex justify-center gap-5 mt-4" >
    <a href=" {{ route('MisTwoPrint') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-print"></i> Print
</a>
     <a href=" {{ route('MisTwo') }}"
   class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; "
   target="_blank">
   <i class="las la-download"></i> Download
</a>
 <a href="
 {{ route('mis_index') }}
  "
   class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; "
   target="_self">
   BACK
</a>
</div> --}}

  <div class="text-center flex justify-center gap-3 mt-4 box ">
            <form method="GET" target="_blank">
                <select name="month" id="monthSelect"
                    class="w-64 border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3 ">
                    {{-- <option value="">Select Month</option> --}}
                    {{-- <option value="जानेवारी">जानेवारी</option>
                    <option value="फेब्रुवारी">फेब्रुवारी</option>
                    <option value="मार्च">मार्च</option>
                    <option value="एप्रिल">एप्रिल</option>
                    <option value="मे">मे</option>
                    <option value="जून">जून</option>
                    <option value="जुलै">जुलै</option>
                    <option value="ऑगस्ट">ऑगस्ट</option>
                    <option value="सप्टेंबर">सप्टेंबर</option>
                    <option value="ऑक्टोबर">ऑक्टोबर</option>
                    <option value="नोव्हेंबर">नोव्हेंबर</option>
                    <option value="डिसेंबर">डिसेंबर</option> --}}
                </select>

                <select name="year" id="yearSelect" class="w-64 border rounded-10 px-3 py-3 text-sm bg-secondary/5">
                </select>
                <br>
                <br>

                <button formaction="{{ route('MisTwoPrint') }}" {{-- href=" {{ route('MisTwoPrint') }}" --}}
                    class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; " target="_blank">
                    <i class="las la-print"></i> Print
                </button>
                <button {{-- href=" {{ route('MisTwo') }}" --}} formaction="{{ route('MisTwo') }}"
                    class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; " target="_blank">
                    <i class="las la-download"></i> Download
                </button>
                <a href="
         {{ route('mis_index') }}
          " class="px-4 py-2 btn-outline uppercase" style="font-family: sans-serif !important; " target="_self">
                    BACK
                </a>

            </form>
        </div>

   <div class="box mt-5">

    <div class="header" style="font-size: 14px;">
        {{ $company->company_name }}  &nbsp; र. नं.  {{ $company->cin_no }} 
    </div>
    <div class="header" style="margin-top: 20px; font-size: 14px;">
        प्रगती (एम आय एस) अहवाल माहे <span id="monthPreview" style=" font-size: 14px;">____________</span> <span id="yearPreview" style="font-size:14px;">____</span> अखेर
    </div>

    <!-- MAIN FINANCIAL TABLE -->
    <table style="margin-top: 50px;">
        <tr>
            <th>अ.क्र.</th>
            <th>संस्थेचे नाव</th>
            <th>एकूण सभासद</th>
            <th>वसूल भाग भांडवल</th>
            <th>ठेवी</th>
            <th>दिलेले कर्ज</th>
            <th>लेखा परीक्षण वर्ग</th>
            <th>खेळते भाग भांडवल</th>
            <th>बाहेरील कर्ज</th>
            <th>स्वनिधी</th>
            <th>राखीव निधी</th>
        </tr>

        <tr>
            
             <td >१</td>
            <td >२</td>
            <td >३</td>
            <td >४</td>
            <td >५</td>
             <td>६</td>
            <td>७</td>
            <td>८</td>
            <td>९</td>
            <td>१० </td>
              <td> ११ </td>
        </tr>
  
        <tr>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;" class="text-left" >
               
            </td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
        </tr>
    </table>
  
    <div class="" style="margin-top: 30px ; ">
        पुढे चालू
    </div>
    <!-- PERFORMANCE TABLE -->
    <table style="margin-top: 20px;">
        <tr>
            <th>थकीत रक्कम</th>
            <th>नफा</th>
            <th>तोटा</th>
            <th>सी डी रेषो</th>
            <th>ओव्हर ड्यूज प्रमाण</th>
            <th>सी डी रेषो गुण</th>
            <th>ओव्हर ड्यूज गुण</th>
            <th>नफा/तोटा गुण</th>
            <th>एकूण गुण</th>
            <th>वर्गवारी</th>
            <th>शेरा</th>
        </tr>

        <tr>
            <td style="padding: 20px;" >१२</td>
            <td style="padding: 20px;" >१३ </td>
            <td style="padding: 20px;" >१४</td>
            <td style="padding: 20px;" >१५</td>
            <td style="padding: 20px;">१६</td>
            <td style="padding: 20px;">१७</td>
            <td style="padding: 20px;">१८</td>
            <td style="padding: 20px;">१९</td>
            <td style="padding: 20px;">२०</td>
            <td style="padding: 20px;">२१</td>
            <td style="padding: 20px;">२२</td> 
        </tr>
        <tr>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
        </tr>
        <tr>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
            <td style="padding: 20px;"></td>
        </tr>
    </table>

    <!-- SIGNATURE -->
    
<div class=" " style="text-align: right; padding:80px 30px;">
        <h5>{{ $company->company_name }}</h5>
    </div>
</div>

</div>
<script>
document.getElementById("monthSelect").addEventListener("change", function () {
    document.getElementById("monthPreview").textContent =
        this.value || "____________";
});

document.getElementById("yearSelect").addEventListener("change", function () {
    document.getElementById("yearPreview").textContent =
        this.value || "____________";
});
/* set default preview values on load */
yearSelect.value = currentYear;
document.getElementById("yearPreview").textContent = currentYear;

// month remains blank by default
document.getElementById("monthPreview").textContent = "____________";
</script>
<script>
const monthSelect = document.getElementById("monthSelect");
const yearSelect  = document.getElementById("yearSelect");

const months = [
    "जानेवारी","फेब्रुवारी","मार्च","एप्रिल","मे","जून",
    "जुलै","ऑगस्ट","सप्टेंबर","ऑक्टोबर","नोव्हेंबर","डिसेंबर"
];

const currentDate  = new Date();
const currentYear  = currentDate.getFullYear();
const currentMonth = currentDate.getMonth();

// ---- Year dropdown (current + previous 3)
for (let i = 0; i < 4; i++) {
    const year = currentYear - i;
    yearSelect.add(new Option(year, year));
}

// ---- Month population
function populateMonths(selectedYear) {
    monthSelect.innerHTML = '<option value="">Select Month</option>';

    let limit = selectedYear == currentYear ? currentMonth : 11;

    for (let i = 0; i <= limit; i++) {
        monthSelect.add(new Option(months[i], months[i]));
    }
}

// initial load
yearSelect.value = currentYear;
populateMonths(currentYear);

// ---- Preview defaults
document.getElementById("yearPreview").textContent = currentYear;
document.getElementById("monthPreview").textContent = "____________";

// ---- Live preview updates
monthSelect.addEventListener("change", function () {
    document.getElementById("monthPreview").textContent =
        this.value || "____________";
});

yearSelect.addEventListener("change", function () {
    document.getElementById("yearPreview").textContent = this.value;
    populateMonths(this.value);
});
</script>
{{-- <script>
document.getElementById("monthSelect").addEventListener("change", function () {
    document.getElementById("monthPreview").textContent =
        this.value || "____________";
});

document.getElementById("yearSelect").addEventListener("change", function () {
    document.getElementById("yearPreview").textContent =
        this.value || "____________";
});
</script>
    <script>
        const monthSelect = document.getElementById("monthSelect");
        const yearSelect = document.getElementById("yearSelect");

        const months = [
            "जानेवारी", "फेब्रुवारी", "मार्च", "एप्रिल", "मे", "जून",
            "जुलै", "ऑगस्ट", "सप्टेंबर", "ऑक्टोबर", "नोव्हेंबर", "डिसेंबर"
        ];

        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth(); // 0 index

        // ---------- YEAR DROPDOWN ----------
        for (let i = 0; i < 4; i++) {
            let year = currentYear - i;
            let option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }

        // ---------- MONTH FILTER FUNCTION ----------
        function populateMonths(selectedYear) {

            monthSelect.innerHTML = '<option value="">Select Month</option>';

            let limit = 11; // default = December

            if (selectedYear == currentYear) {
                limit = currentMonth; // only till current month
            }

            for (let i = 0; i <= limit; i++) {
                let opt = document.createElement("option");
                opt.value = months[i];
                opt.textContent = months[i];
                monthSelect.appendChild(opt);
            }
        }

        // initial load
        populateMonths(currentYear);

        // when year changes
        yearSelect.addEventListener("change", function () {
            populateMonths(this.value);
        });
    </script> --}}
    @endsection