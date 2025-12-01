<label class="font-medium block mb-2 uppercase">
    Nominee <span class="text-red-500">*</span>
</label>

{{-- @php
    // Ensure $promoter exists
    $nomineeSource = $promoter ?? null;
    $hasNominee = $nomineeSource ? $nomineeSource->nominees()->exists() : false;
@endphp --}}
@php

    $hasNominee = $promoter->nominees()->exists();
@endphp

<div class="flex items-center gap-4">
    <label class="flex items-center gap-2">
        <input class="ms-2" type="radio" name="nominee" value="yes" onclick="toggleAddMore(true)"
            {{ $hasNominee ? 'checked' : '' }}>
        Yes
    </label>

    <label class="flex items-center gap-2">
        <input class="ms-2" type="radio" name="nominee" value="no" onclick="toggleAddMore(false)"
            {{ !$hasNominee ? 'checked' : '' }}>
        No
    </label>

    @error('nominee')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<!-- Add More Button -->
<div id="addMoreContainer" class="mt-2" style="display: none;">
    <button type="button" onclick="addNominee()" class="text-blue-600 font-medium">
        + ADD MORE NOMINEE
    </button>
</div>

<!-- Nominee Form Container -->
<div id="nomineeContainer"
    class="mt-2 flex flex-col md:flex-row flex-wrap gap-4 items-end p-3 rounded-10 bg-gray-50 dark:bg-bg3"
    style="display: none;">

    {{-- Prefilled Nominees (for update) --}}
    @if ($hasNominee)
        @foreach ($promoter->nominees as $index => $nominee)
            <div class="w-full nominee-item columns-4 border-t gap-4 items-end bg-white p-4 rounded dark:bg-bg3">
                <div class="nominee-row flex flex-wrap justify-start gap-6">

                    <input type="hidden" name="nominees[{{ $index }}][id]" value="{{ $nominee->id }}">

                    <!-- Relation -->
                    <div class="flex-1 min-w-[300px]">
                        <label class="font-medium block mb-2 uppercase">Relation <span
                                class="text-red-500">*</span></label>
                        <select name="nominees[{{ $index }}][relation]"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-2">
                            <option value="">Select Relation</option>
                            @foreach (['Father', 'Mother', 'Spouse', 'Son', 'Daughter', 'Brother', 'Sister', 'Grandfather', 'Grandmother', 'Uncle', 'Aunt', 'Cousin', 'Nephew', 'Niece', 'Father-in-law', 'Mother-in-law', 'Brother-in-law', 'Sister-in-law', 'Son-in-law', 'Daughter-in-law', 'Guardian', 'Friend', 'Other'] as $relation)
                                <option value="{{ $relation }}"
                                    {{ $nominee->relation == $relation ? 'selected' : '' }}>
                                    {{ $relation }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="flex-1 min-w-[300px]">
                        <label class="font-medium block mb-2 uppercase">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="nominees[{{ $index }}][name]" value="{{ $nominee->name }}"
                            placeholder="Enter Nominee Name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-2">
                    </div>

                    <!-- Address -->
                    <div class="flex-1 min-w-[300px]">
                        <label class="font-medium block mb-2 uppercase">Address <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nominees[{{ $index }}][address]"
                            value="{{ $nominee->address }}" placeholder="Enter Nominee Address"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-2">
                    </div>

                    <!-- Share Holding -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="font-medium block mb-2 uppercase">Share Holding (%)<span
                                class="text-red-500">*</span></label>
                        <input type="number" step="0.01" min="0"
                            name="nominees[{{ $index }}][share_holding]"
                            value="{{ number_format($nominee->share_holding, 1) }}"
                            placeholder="Enter Share Holding (%)"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-2">
                    </div>

                    <!-- Remove -->
                    <div class="flex-1 min-w-[60px] flex justify-end items-center">
                        <button type="button" onclick="removeNominee(this)"
                            class="text-red-500 mt-8 font-bold text-lg hover:text-red-700">✕</button>
                    </div>

                </div>
            </div>
        @endforeach
    @endif

</div>

<div class="flex justify-end gap-3 mt-6">
    @if ($isUpdate ?? false)
        <button type="submit" class="sm:w-auto btn-primary uppercase justify-center">Update</button>
        <a href="{{ url()->previous() }}" class="sm:w-auto btn-outline uppercase justify-center">Back</a>
    @endif
</div>

{{-- JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const yesBtn = document.querySelector("input[name='nominee'][value='yes']");
        const hasNominee = @json($hasNominee);

        // Initially hide all
        document.getElementById('addMoreContainer').style.display = "none";
        document.getElementById('nomineeContainer').style.display = "none";

        // If in update mode and nominees exist, show them
        if (hasNominee || (yesBtn && yesBtn.checked)) {
            if (hasNominee) {
                toggleAddMore(true);
            } else {
                toggleAddMore(false);
            }
        }
    });

    function toggleAddMore(show) {
        document.getElementById('addMoreContainer').style.display = show ? 'block' : 'none';
        document.getElementById('nomineeContainer').style.display = show ? 'flex' : 'none';
    }

    function addNominee() {
        const container = document.getElementById("nomineeContainer");
        container.style.display = "flex";
        const index = container.children.length;

        const newNominee = document.createElement("div");
        newNominee.className =
            "w-full nominee-item columns-4 border-t gap-4 items-end bg-white p-4 rounded dark:bg-bg3";
        newNominee.innerHTML = `
            <div class="nominee-row flex flex-wrap justify-start gap-6">
                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                    <label class="font-medium block mb-2">Relation <span class="text-red-500">*</span></label>
                    <select name="nominees[${index}][relation]"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Relation</option>
                        <option>Father</option><option>Mother</option><option>Spouse</option><option>Son</option><option>Daughter</option>
                        <option>Brother</option><option>Sister</option><option>Grandfather</option><option>Grandmother</option>
                        <option>Uncle</option><option>Aunt</option><option>Cousin</option><option>Nephew</option><option>Niece</option>
                        <option>Father-in-law</option><option>Mother-in-law</option><option>Brother-in-law</option><option>Sister-in-law</option>
                        <option>Son-in-law</option><option>Daughter-in-law</option><option>Guardian</option><option>Friend</option><option>Other</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[300px] max-w-full">
                    <label class="font-medium block mb-2">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="nominees[${index}][name]" placeholder="Enter Nominee Name"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>

                <div class="flex-1 min-w-[300px] max-w-full">
                    <label class="font-medium block mb-2">Address <span class="text-red-500">*</span></label>
                    <input type="text" name="nominees[${index}][address]" placeholder="Enter Nominee Address"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
            <div class="flex-1 min-w-[200px] max-w-full">
                <label class="font-medium block mb-2 uppercase">Share Holding (%) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0"
                    name="nominees[${index}][share_holding]"
                    placeholder="Enter Share Holding (%)"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
            </div>

                <div class="flex-1 min-w-[60px] max-w-full flex justify-end items-center">
                    <button type="button" onclick="removeNominee(this)"
                        class="text-red-500 mt-8 font-bold text-lg hover:text-red-700">✕</button>
                </div>
            </div>`;
        container.appendChild(newNominee);
    }

    function removeNominee(button) {
        const item = button.closest(".nominee-item");
        item.remove();

        const container = document.getElementById("nomineeContainer");
        if (container.children.length === 0) {
            container.style.display = "none";
            document.getElementById('addMoreContainer').style.display = "none";
            document.querySelector("input[name='nominee'][value='no']").checked = true;
        }
    }
</script>
