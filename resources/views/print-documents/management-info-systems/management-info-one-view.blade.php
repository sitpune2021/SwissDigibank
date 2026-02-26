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

        th,
        td {
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

        .small-table td,
        .small-table th {
            padding: 5px;
        }
    </style>

    <div class="main-inner">
        <h1 class="text-lg font-semibold uppercase" style="font-family: sans-serif !important; ">
            Management Information System
        </h1>
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

                <button formaction="{{ route('MisOneFormPrint') }}" {{-- href=" {{ route('MisOneFormPrint') }}" --}}
                    class="px-4 py-2 btn-primary uppercase" style="font-family: sans-serif !important; " target="_blank">
                    <i class="las la-print"></i> Print
                </button>
                <button {{-- href=" {{ route('MisOneForm') }}" --}} formaction="{{ route('MisOneForm') }}"
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

        <div class="box mt-4 overflow-x-auto">

            <!-- Header -->
            <div class="header ">
                   {{ $company->company_name }}  &nbsp; र. नं.  {{ $company->cin_no }}   यांची माहिती व्यवस्थापन प्रणाली
            </div>
            <div class="header">
                अहवाल माहे <span id="monthPreview" style="font-size:14px;">____________</span> <span id="yearPreview" style="font-size:14px;">____</span> अखेर
            </div>

            <!-- Society Info Table -->
            <table style="margin-top: 20px;">
                <tr>
                    <th style="width: 20% ; text-align: center;">अ. क्र.</th>
                    <th style="width: 20% ; text-align: center;">संस्थेचे नाव</th>
                    <th style="width: 20% ; text-align: center;">एकुण सभासद</th>
                    <th style="width: 20% ; text-align: center;">वसुल भागभांडवल</th>
                    <th style="width: 20% ; text-align: center;">ठेवी</th>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center;">१</td>
                    <td style="width: 20% ; text-align: center;">२</td>
                    <td style="width: 20% ; text-align: center;">३</td>
                    <td style="width: 20% ; text-align: center;">४</td>
                    <td style="width: 20% ; text-align: center;">५</td>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 10px !important;" class="text-left"></td>
                    <td style="width: 20% ; text-align: center; padding: 10px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 10px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 10px !important;"></td>
                </tr>
            </table>

            <!-- Loan Details -->
            <table>
                <tr>
                    <th style="width: 20% ; text-align: center;">दिलेले कर्ज</th>
                    <th style="width: 20% ; text-align: center;">ले. प. वर्ग</th>
                    <th style="width: 20% ; text-align: center;">खेळते भागभांडवल</th>
                    <th style="width: 20% ; text-align: center;">बाहेरील कर्ज</th>
                    <th style="width: 20% ; text-align: center;">स्वनिधी</th>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center;">६</td>
                    <td style="width: 20% ; text-align: center;">७</td>
                    <td style="width: 20% ; text-align: center;">८</td>
                    <td style="width: 20% ; text-align: center;">९</td>
                    <td style="width: 20% ; text-align: center;">१० </td>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;" class="text-left"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                </tr>
            </table>


            <!-- Profit / Loss -->
            <table>
                <tr>
                    <th style="width: 20% ; text-align: center;">राखिव निधी</th>
                    <th style="width: 20% ; text-align: center;">थकित रक्कम</th>
                    <th style="width: 20% ; text-align: center;">नफा</th>
                    <th style="width: 20% ; text-align: center;">तोटा</th>
                    <th style="width: 20% ; text-align: center;">सि.डी.रेषो</th>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center;"> ११ </td>
                    <td style="width: 20% ; text-align: center;">१२</td>
                    <td style="width: 20% ; text-align: center;"> १३</td>
                    <td style="width: 20% ; text-align: center;">१४ </td>
                    <td style="width: 20% ; text-align: center;">१५</td>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"> </td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                </tr>
            </table>


            <!-- Points Table -->
            <table>
                <tr>
                    <th style="width: 20% ; text-align: center;">थकित प्रमाण</th>
                    <th style="width: 20% ; text-align: center;">सि.डी.रेषो गुण</th>
                    <th style="width: 20% ; text-align: center;">थकित गुण</th>
                    <th style="width: 20% ; text-align: center;">नफा तोटा गुण</th>
                    <th style="width: 20% ; text-align: center;">एकुण गुण</th>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center;">१६</td>
                    <td style="width: 20% ; text-align: center;">१७</td>
                    <td style="width: 20% ; text-align: center;"> १८</td>
                    <td style="width: 20% ; text-align: center;">१९ </td>
                    <td style="width: 20% ; text-align: center;">२०</td>
                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center;padding: 40px !important;"></td>
                </tr>
            </table>


            <!-- Classification -->
            <table style="width: 40%">
                <tr>
                    <th style="width: 20% ; text-align: center;">वर्गवारी</th>
                    <th style="width: 20% ; text-align: center;">शेरा</th>

                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center;"> २१</td>
                    <td style="width: 20% ; text-align: center;">२२ </td>

                </tr>
                <tr>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;"></td>
                    <td style="width: 20% ; text-align: center; padding: 40px !important;" class="text-left"></td>

                </tr>
            </table>



            <!-- Signature -->

            <div class=" " style="text-align: right; padding:5px 30px;">
                <h5>     {{ $company->company_name }}   </h5>
            </div>

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