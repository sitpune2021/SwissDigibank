<!-- Words Display -->
<div id="{{ $for }}Words"
    class="mt-2 p-2 text-error min-h-[40px]">
</div>

<script>
function numberToWordsIndian(num) {
    if (num === 0) return "zero";

    const ones = ["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten",
        "Eleven","Twelve","Thirteen","Fourteen","Fifteen","Sixteen","Seventeen","Eighteen","Nineteen"];
    const tens = ["","","Twenty","Thirty","Forty","Fifty","Sixty","Seventy","Eighty","Ninety"];

    function twoDigits(n) {
        if (n < 20) return ones[n];
        return tens[Math.floor(n/10)] + (n % 10 ? " " + ones[n%10] : "");
    }

    function convertChunk(n) {
        let str = "";
        if (n >= 100) {
            str += ones[Math.floor(n/100)] + " Hundred ";
            n %= 100;
        }
        if (n > 0) str += twoDigits(n);
        return str.trim();
    }

    let output = "";

    // 🔹 Split into Crores, Lakhs, Thousands, Hundreds
    const crore = Math.floor(num / 10000000); // 1 crore = 1,00,00,000
    if (crore > 0) {
        output += numberToWordsIndian(crore) + " Crore ";
        num %= 10000000;
    }

    const lakh = Math.floor(num / 100000);
    if (lakh > 0) {
        output += convertChunk(lakh) + " Lakh ";
        num %= 100000;
    }

    const thousand = Math.floor(num / 1000);
    if (thousand > 0) {
        output += convertChunk(thousand) + " Thousand ";
        num %= 1000;
    }

    const hundred = Math.floor(num / 100);
    if (hundred > 0) {
        output += ones[hundred] + " Hundred ";
        num %= 100;
    }

    if (num > 0) {
        if (output !== "") output += "And ";
        output += twoDigits(num);
    }

    return output.trim();
}

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("{{ $for }}");
    const words = document.getElementById("{{ $for }}Words");

    function updateWords() {
        const val = parseInt(input.value, 10);
        if (!isNaN(val) && val > 0) {
            words.textContent = numberToWordsIndian(val);
        } else {
            words.textContent = "";
        }
    }

    if (input) {
        input.addEventListener("input", updateWords);
        updateWords(); // for old values
    }
});
</script>
