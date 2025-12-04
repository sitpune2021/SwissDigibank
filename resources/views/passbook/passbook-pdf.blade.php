<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Load html2canvas and jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="font-sans bg-gray-100 p-5">
  <div id="pdfContent"
    class="bg-white border border-black p-5 max-w-3xl mx-auto shadow-md rounded-md print:border-0 print:shadow-none print:bg-white">

    <!-- Title -->
    <div class="text-center text-xl font-bold uppercase mb-5 border-b-2 border-black pb-2">
      SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LIMITED
    </div>

    <!-- Account Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
      <div class="flex gap-2"><span class="font-bold w-28">Br. Name:</span> <span>GORAKSHAN ROAD AKOLA</span></div>
      <div class="flex gap-2"><span class="font-bold w-28">Minor a/c:</span> <span>No</span></div>

      <div class="flex gap-2"><span class="font-bold w-28">Br. Address:</span>
        <span>SBC GLOBAL TOWER, SHOP NO 13, SECOND FLOOR, MUKTA PLAZA, OLD INCOME TAX CHOWK, GORAKSHAN ROAD AKOLA,
          Maharashtra - 444002</span>
      </div>
      <div class="flex gap-2"><span class="font-bold w-28">Name:</span> <span>SANJAY RAMBHAU KATHALE</span></div>

      <div class="flex gap-2"><span class="font-bold w-28">Br. Tel:</span> <span>1800 202 6261</span></div>
      <div class="flex gap-2"><span class="font-bold w-28">Address:</span> <span>BHAURAD, AKOLA AKOLA, Maharashtra -
          444001, India</span></div>

      <div class="flex gap-2"><span class="font-bold w-28">Br. Email:</span>
        <span>nishatahakar1615@gmail.com</span>
      </div>
      <div class="flex gap-2"><span class="font-bold w-28">Nominee:</span> <span>SAURABH SANJAY KATHALE</span></div>

      <div class="flex gap-2"><span class="font-bold w-28">Member No:</span> <span>M06395</span></div>
      <div class="flex gap-2"><span class="font-bold w-28">Open Date:</span> <span>12/07/2025</span></div>

      <div class="flex gap-2"><span class="font-bold w-28">Account Type:</span> <span>Saving</span></div>
      <div class="flex gap-2"><span class="font-bold w-28">IFSC:</span> <span>YESBOCMSNOC (5th letter is zero)</span>
      </div>

      <div class="flex gap-2"><span class="font-bold w-28">Account No:</span> <span>SBC111000005751</span></div>
      <div class="flex gap-2"><span class="font-bold w-28">Internal a/c No:</span> <span>S05751</span></div>
    </div>

    <!-- Footer -->
    <div
      class="text-xs mt-6 text-center text-gray-600 leading-relaxed border-t border-gray-300 pt-3 print:border-0 print:pt-0">
      This passbook is system generated and does not require any initials.<br>
      For NEFT/IMPS or any other payment to saving a/c use YES BANK LTD as bank name.<br>
      Payment is related to collection through Virtual A/c only, using of bank name does not denote any tie-up of bank.
    </div>
  </div>

  <!-- Download Button -->
  <button onclick="downloadPDF()"
    class="block mx-auto mt-5 px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md text-sm font-medium shadow">
    Download as PDF
  </button>

  <!-- JS for PDF Download -->
  <script>
    async function downloadPDF() {
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF('p', 'pt', 'a4');
      const content = document.getElementById('pdfContent');

      // Use html2canvas manually to render content
      const canvas = await html2canvas(content, { scale: 2 });
      const imgData = canvas.toDataURL('image/png');

      const pageWidth = pdf.internal.pageSize.getWidth();
      const pageHeight = pdf.internal.pageSize.getHeight();
      const imgWidth = pageWidth - 40; // padding
      const imgHeight = (canvas.height * imgWidth) / canvas.width;

      pdf.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
      pdf.save('Account-Details.pdf');
    }
  </script>
</body>

</html>
