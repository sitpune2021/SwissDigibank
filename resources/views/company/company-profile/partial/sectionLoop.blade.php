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

        @if ($field['type'] === 'textarea')
            <textarea id="{{ $field['id'] }}" name="{{ $fieldName }}" rows="4"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 resize-none"
                placeholder="Enter {{ strtolower($field['label']) }}" {{ $readonly }}>{{ $fieldValue }}</textarea>
        @elseif ($field['type'] === 'date')
            <input type="date" id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                value="{{ $fieldValue }}" {{ $readonly }} />
        @elseif ($field['type'] === 'number')
            <input type="number" id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                placeholder="Enter {{ strtolower($field['label']) }}" value="{{ $fieldValue }}" {{ $readonly }} />
        @else
            <input type="{{ $field['type'] }}" id="{{ $field['id'] }}" name="{{ $fieldName }}"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                placeholder="Enter {{ strtolower($field['label']) }}" value="{{ $fieldValue }}" {{ $readonly }} />
        @endif
    </div>
@endforeach
