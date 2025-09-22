<!-- Words Display for input -->
<div id="{{ $for }}Words"
     class="mt-2 p-2 text-error capitalize min-h-[40px]">
</div>
 
<script>
document.addEventListener("DOMContentLoaded", function () {
    function numberToWordsIndian(num) {
        if (num === 0) return "zero";
 
        const ones = ["","one","two","three","four","five","six","seven","eight","nine","ten",
            "eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eighteen","nineteen"];
        const tens = ["","","twenty","thirty","forty","fifty","sixty","seventy","eighty","ninety"];
 
        function twoDigits(n) {
            if (n < 20) return ones[n];
            return tens[Math.floor(n/10)] + (n % 10 ? " " + ones[n%10] : "");
        }
 
        function convertChunk(n) {
            let str = "";
            if (n >= 100) {
                str += ones[Math.floor(n/100)] + " hundred ";
                n %= 100;
            }
            if (n > 0) str += twoDigits(n);
            return str.trim();
        }
 
        let output = "";
        const crore = Math.floor(num / 10000000);
        if (crore > 0) {
            output += numberToWordsIndian(crore) + " crore ";
            num %= 10000000;
        }
 
        const lakh = Math.floor(num / 100000);
        if (lakh > 0) {
            output += convertChunk(lakh) + " lakh ";
            num %= 100000;
        }
 
        const thousand = Math.floor(num / 1000);
        if (thousand > 0) {
            output += convertChunk(thousand) + " thousand ";
            num %= 1000;
        }
 
        const hundred = Math.floor(num / 100);
        if (hundred > 0) {
            output += ones[hundred] + " hundred ";
            num %= 100;
        }
 
        if (num > 0) {
            if (output !== "") output += "and ";
            output += twoDigits(num);
        }
 
        return output.trim();
    }
 
    function updateWords(value) {
        const val = parseInt(value, 10);
        const text = (!isNaN(val) && val > 0) ? numberToWordsIndian(val) : "";
 
        // Update all inputs with same value
        document.querySelectorAll("input").forEach(input => {
            if (input.value == value) {
                const wordsBox = document.getElementById(input.id + "Words");
                if (wordsBox) wordsBox.textContent = text;
            }
        });
    }
 
    // Bind listener to inputs that have matching number-to-word component
    document.querySelectorAll("[id$='Words']").forEach(div => {
        const inputId = div.id.replace("Words", "");
        const input = document.getElementById(inputId);
 
        if (input) {
            input.addEventListener("input", function () {
                updateWords(this.value);
            });
 
            if (input.value) updateWords(input.value);
        }
    });
});
</script>