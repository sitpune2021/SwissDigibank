@foreach ($section['fields'] as $field)
    <div class="col-span-2 md:col-span-1">
        <label for="{{ $field['id'] }}" class="md:text-lg font-medium block mb-4 mt-4">
            {{ $field['label'] }}
            @if (!empty($field['required']))
                <span class="text-red-500">*</span>
            @endif
        </label>

        @php
            $fieldName = $field['name'];
            $fieldValue = old($fieldName, $model->{$fieldName} ?? '');
            $readonly = isset($show) && $show ? 'readonly' : '';
        @endphp

        {{-- Textarea --}}
        @if ($field['type'] === 'textarea')
            <textarea id="{{ $field['id'] }}" name="{{ $fieldName }}" rows="4"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
                placeholder="Enter {{ strtolower($field['label']) }}" {{ $readonly }}>{{ $fieldValue }}</textarea>

        {{-- Date --}}
        @elseif ($field['type'] === 'date')
            <input type="date" id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                value="{{ $fieldValue }}" {{ $readonly }} />

        {{-- Number --}}
        @elseif ($field['type'] === 'number')
            <input type="number" id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                placeholder="Enter {{ strtolower($field['label']) }}" value="{{ $fieldValue }}" {{ $readonly }} />

        {{-- Select --}}
        @elseif ($field['type'] === 'select')
            @php
                $options = [];

                if (!empty($field['dynamic']) && !empty($field['options_key']) && !empty($dynamicOptions[$field['options_key']])) {
                    $options = $dynamicOptions[$field['options_key']];
                }

                if (isset($field['options']) && is_array($field['options'])) {
                    $options = $field['options'];
                }
            @endphp

            <select id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                @if ($readonly) disabled @endif>
                <option value="">-- Select {{ $field['label'] }} --</option>
                @foreach ($options as $value => $label)
                    <option value="{{ $value }}" {{ $fieldValue == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

        {{-- Default input (text, email, etc.) --}}
        @else
            <input type="{{ $field['type'] }}" id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                placeholder="Enter {{ strtolower($field['label']) }}" value="{{ $fieldValue }}" {{ $readonly }} />
        @endif
    </div>
@endforeach
