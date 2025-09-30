<div>
    <label class="block font-medium block mb-4">{{ $label ?? 'Amount' }} <span class="text-red-500">*</span></label>
    <input type="number" name="{{ $name ?? 'amount' }}" id="{{ $id ?? 'amount' }}"
        value="{{ old($name, $value ?? '') }}"
        placeholder="{{ $placeholder ?? 'Enter amount' }}"
        class="w-full bg-secondary/5 border border-n30 rounded-10 px-3 py-2.5">

    <p id="{{ $id ?? 'amount' }}_words" class="mt-2 text-[4px] text-error text-gray-600 "></p>
</div>

<script>
    document.addEventListener("input", function(e) {
        if (e.target && e.target.type === "number") {
            const wordsEl = document.getElementById(e.target.id + "_words");
            if (wordsEl) {
                let number = parseInt(e.target.value);
                wordsEl.textContent = !isNaN(number) ? numberToWords(number) : "";
            }
        }
    });

    function numberToWords(num) {
        const ones = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine",
            "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen",
            "Sixteen", "Seventeen", "Eighteen", "Nineteen"
        ];
        const tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

        if (num === 0) return "Zero";

        function convert(n) {
            if (n < 20) return ones[n];
            if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? " " + ones[n % 10] : "");
            if (n < 1000) return ones[Math.floor(n / 100)] + " Hundred" + (n % 100 !== 0 ? " " + convert(n % 100) : "");
            if (n < 100000) return convert(Math.floor(n / 1000)) + " Thousand" + (n % 1000 !== 0 ? " " + convert(n % 1000) : "");
            if (n < 10000000) return convert(Math.floor(n / 100000)) + " Lakh" + (n % 100000 !== 0 ? " " + convert(n % 100000) : "");
            return convert(Math.floor(n / 10000000)) + " Crore" + (n % 10000000 !== 0 ? " " + convert(n % 10000000) : "");
        }

        return convert(num);
    }
</script>