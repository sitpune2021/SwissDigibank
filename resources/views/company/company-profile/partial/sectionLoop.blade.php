@foreach ($section['fields'] as $field)
    @php
        $name = $field['name'];
        $type = $field['type'] ?? 'text';
        $label = $field['label'];
        $id = $field['id'] ?? $field['name'];
        $required = $field['required'] ?? false;
        // $value = old($name, $model[$name] ?? ($field['default'] ?? ''));
        $certificateValue = $model->certificate ? $model->certificate->$name : null;
        $fieldValue = $model->$name ?? null;

        // Use old input if available, otherwise use the certificate or model value
        $value = old($name, $certificateValue ?? ($fieldValue ?? ($field['default'] ?? '')));

        $inputClasses =
            'w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3';
    @endphp
    <div class="col-span-2 md:col-span-1">
        @include('fields.label', [
            'id' => $id,
            'label' => $label,
            'required' => $required,
        ])
        @include('fields.inputs', [
            'id' => $id,
            'label' => $label,
            'required' => $required,
            'type' => $type,
            'name' => $name,
            'value' => $value,
            'readonly' => empty($show) ? '' : 'readonly',
            'field' => $field,
        ])

        @error($name)
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
        @enderror
    </div>
@endforeach
