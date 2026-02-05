@if ($type === 'textarea')
<textarea id="{{ $id }}" name="{{ $name }}" rows="4"
    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
    placeholder="Enter {{ strtolower($label) }}" {{ !empty($readonly) ? 'readonly' : '' }}>{{ $value }}</textarea>
@elseif ($type === 'date')
@if (!empty($show))
{{-- SHOW PAGE: Readonly, black text, no disabled grey --}}
<input type="text" id="{{ $id }}" name="{{ $name }}" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                   rounded-10 px-3 md:px-6 py-2 md:py-3 pointer-events-none opacity-100 text-black"
    value="{{ \Carbon\Carbon::parse($value)->format('d-m-Y') }}" disabled />
@else
{{-- EDIT PAGE --}}
<input type="date" id="{{ $id }}" name="{{ $name }}" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                   rounded-10 px-3 md:px-6 py-2 md:py-3" value="{{ $value }}" />
@endif

@elseif ($type === 'number')
<input type="number" id="{{ $id }}" name="{{ $name }}"
    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
    placeholder="Enter {{ strtolower($label) }}" value="{{ $value }}" {{ !empty($readonly) ? 'readonly' : '' }} />
@elseif ($type === 'select')
<select name="{{ $name }}" id="{{ $id }}"
    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
    {{ empty($readonly) ? '' : 'disabled' }}>

    <option value="">-- Select {{ $label }} --</option>
    @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
    @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
    <option value="{{ $optionValue }}" {{ $value==$optionValue ? 'selected' : '' }}>
        <!-- {{ $optionValue }}{{ $value }} -->
        {{ $optionLabel }}
    </option>
    @endforeach
    @elseif(!empty($field['options']))
    @foreach ($field['options'] as $optionValue => $optionLabel)
    <option value="{{ $optionValue }}" {{ $value==$optionValue ? 'selected' : '' }}>
        {{ $optionLabel }}
    </option>
    @endforeach
    @endif
</select>
@elseif ($type === 'radio')
<div class="flex gap-4">
    @foreach ($field['options'] as $optionValue => $optionLabel)
    @php
    $radioId = $id . '_' . $optionValue;
    $isReadOnly = !empty($readonly); // show page = true
    @endphp

    <div class="flex items-center relative gap-2">
        <input id="{{ $radioId }}" type="radio" name="{{ $name }}" value="{{ $optionValue }}" class="h-6 w-6 accent-green-600 
                           {{ $isReadOnly ? 'pointer-events-none opacity-100' : '' }}" {{ $value==$optionValue
            ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}>

        <label for="{{ $radioId }}" class="select-none text-sm md:text-base flex gap-2 items-center ml-2
                           {{ $isReadOnly ? 'cursor-default text-black' : '' }}">
            {{ $optionLabel }}
        </label>
    </div>
    @endforeach
</div>


@elseif ($type === 'checkbox')
<label class="switch">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="1" {{ $value ? 'checked' : '' }}{{ isset($readonly)
        ? 'disabled' : '' }}>
    <div class="slider round">
        <span class="switch-on">ON</span>
        <span class="switch-off">OFF</span>
    </div>
</label>
@elseif ($type === 'file')
@if (!empty($value))

@endif

<input type="file" id="{{ $id }}" name="{{ $name }}"
    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
    {{ !empty($readonly) ? 'readonly disabled' : '' }} />
    <a href="{{ asset('storage/' . $value) }}" target="_blank" class="text-primary hover:underline mb-2 mt-3 inline-block">
    View File
</a>
@else
@if ($name === 'incorporation_date')
@php
try {
$formattedDate = \Carbon\Carbon::parse($value)->format('d-m-Y');
} catch (\Exception $e) {
$formattedDate = $value;
}
@endphp

<input type="text" id="{{ $id }}" name="{{ $name }}"
    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
    placeholder="Enter {{ strtolower($label) }}" value="{{ $formattedDate }}" {{ !empty($readonly) ? 'readonly' : ''
    }} />

@else
<input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
    placeholder="Enter {{ strtolower($label) }}" value="{{ $value }}" @if (!empty($field['maxlength']))
    maxlength="{{ $field['maxlength'] }}" @endif @if (!empty($field['pattern'])) pattern="{{ $field['pattern'] }}"
    @endif {{ !empty($readonly) ? 'readonly' : '' }} />
@endif

@endif