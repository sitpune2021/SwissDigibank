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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Digit-only fields
        const digitOnlyFields = [{
                id: 'mobile_no',
                maxLength: 10
            },
            {
                id: 'landline_no',
                maxLength: 11
            },
            {
                id: 'pincode',
                maxLength: 6,
                exact: true
            }
        ];

        digitOnlyFields.forEach(field => {
            const input = document.getElementById(field.id);
            if (input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                    if (this.value.length > field.maxLength) {
                        this.value = this.value.slice(0, field.maxLength);
                    }
                });

                // Validate exact length on blur
                if (field.exact) {
                    input.addEventListener('blur', function() {
                        if (this.value.length !== field.maxLength) {
                            alert(
                                `${field.id.replace(/_/g, ' ')} must be exactly ${field.maxLength} digits.`);
                            this.focus();
                        }
                    });
                }
            }
        });

        // PAN number validation (Format: AAAAA9999A)
        const panInput = document.getElementById('pan_no');
        if (panInput) {
            panInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
        }
    });
</script>
