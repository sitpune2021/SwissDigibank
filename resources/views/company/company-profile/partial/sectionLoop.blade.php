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
        if ($type === 'date' && !empty($certificateValue ?? $fieldValue)) {
            $rawDate = $certificateValue ?? $fieldValue;

            try {
                $value = \Carbon\Carbon::parse($rawDate)->format('Y-m-d');
            } catch (\Exception $e) {
                $value = $rawDate;
            }
        } else {
            $value = old($name, $certificateValue ?? ($fieldValue ?? ($field['default'] ?? '')));
        }

        // Use old input if available, otherwise use the certificate or model value
        // $value = old($name, $certificateValue ?? ($fieldValue ?? ($field['default'] ?? '')));

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
                                `${field.id.replace(/_/g, ' ')} must be exactly ${field.maxLength} digits.`
                                );
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

        // PAN (already handled previously)
        applyPatternValidation('pan_no', /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/, 10, 'ABCDE1234F');

        // CIN: 21 alphanumeric chars
        applyPatternValidation('cin_no', /^[A-Z0-9]{21}$/, 21, 'L12345MH2000PLC123456');

        // TAN: 10 chars - 4 letters + 5 digits + 1 letter
        applyPatternValidation('tan_no', /^[A-Z]{4}[0-9]{5}[A-Z]{1}$/, 10, 'MUMT12345G');

        // GST: 15 chars - 2 digits + PAN + suffix
        applyPatternValidation('gst_no', /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/, 15,
            '27AAECS1234F1Z5');

        // PF Number (optional validation – alphanumeric)
        applyPatternValidation('pf_number', /^[A-Z0-9\/]{6,22}$/, 22); // You can relax this if needed

        // ESIC: numeric, 17 digits
        applyPatternValidation('esic_number', /^[0-9]{17}$/, 17, '12345678901234567');
    });
</script>
