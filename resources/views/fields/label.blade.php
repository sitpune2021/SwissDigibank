<label for="{{ $id }}" class="md:text-lg font-medium block mb-4 mt-4">
    {{ $label }} @if ($required)
        <span class="text-red-500">*</span>
    @endif
</label>
