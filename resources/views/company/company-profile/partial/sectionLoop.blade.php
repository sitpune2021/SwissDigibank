@foreach ($section['fields'] as $field)
    @php
        $fieldName = $field['name'];
        $fieldId = $field['id'] ?? $fieldName;
        $fieldLabel = $field['label'] ?? ucfirst(str_replace('_', ' ', $fieldName));
        $fieldType = $field['type'] ?? 'text';
        $fieldValue = old($fieldName, $model->{$fieldName} ?? '');
        $isRequired = !empty($field['required']);
        $isReadonly = isset($show) && $show;

        // Determine classes
        $inputClasses = 'w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3';
    @endphp

    <div class="col-span-2 md:col-span-1">
        <label for="{{ $fieldId }}" class="md:text-lg font-medium block mb-4 mt-4">
            {{ $fieldLabel }}
            @if ($isRequired)
                <span class="text-red-500">*</span>
            @endif
        </label>

        {{-- Textarea --}}
        @if ($fieldType === 'textarea')
            <textarea id="{{ $fieldId }}" name="{{ $fieldName }}" rows="4"
                class="{{ $inputClasses }} resize-none"
                placeholder="Enter {{ strtolower($fieldLabel) }}" 
                @if ($isReadonly) readonly @endif>{{ $fieldValue }}</textarea>

        {{-- Date --}}
        @elseif ($fieldType === 'date')
            <input type="date" id="{{ $fieldId }}" name="{{ $fieldName }}"
                class="{{ $inputClasses }}"
                value="{{ $fieldValue }}" 
                @if ($isReadonly) readonly @endif />

        {{-- Number --}}
        @elseif ($fieldType === 'number')
            <input type="number" id="{{ $fieldId }}" name="{{ $fieldName }}"
                class="{{ $inputClasses }}"
                placeholder="Enter {{ strtolower($fieldLabel) }}"
                value="{{ $fieldValue }}" 
                @if ($isReadonly) readonly @endif />

        {{-- Select --}}
        @elseif ($fieldType === 'select')
            @php
                $options = [];

                // Load dynamic options if set
                if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']])) {
                    $options = $dynamicOptions[$field['options_key']];
                }

                // Static override
                if (!empty($field['options']) && is_array($field['options'])) {
                    $options = $field['options'];
                }
            @endphp

            <select id="{{ $fieldId }}" name="{{ $fieldName }}"
                class="{{ $inputClasses }}"
                @if ($isReadonly) disabled @endif>
                <option value="">-- Select {{ $fieldLabel }} --</option>
                @foreach ($options as $value => $label)
                    <option value="{{ $value }}" {{ $fieldValue == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            {{-- If select is disabled, add a hidden field to submit value --}}
            @if ($isReadonly)
                <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue }}">
            @endif

        {{-- Default input (text, email, etc.) --}}
        @else
            <input type="{{ $fieldType }}" id="{{ $fieldId }}" name="{{ $fieldName }}"
                class="{{ $inputClasses }}"
                placeholder="Enter {{ strtolower($fieldLabel) }}"
                value="{{ $fieldValue }}" 
                @if ($isReadonly) readonly @endif />
        @endif

        {{-- Validation error --}}
        @error($fieldName)
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
@endforeach
