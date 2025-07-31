@extends('layout.main')
@section('page-title',
    isset($shareholding)
    ? (!empty($show)
    ? 'View ' .
    $shareholding->promotor->first_name .
    '
    Allocated Shares'
    : 'Edit ' . $shareholding->promotor->first_name . ' Allocated Shares')
    : 'Allocate New Shares to
    Promoter')

@section('content')
    @include('fields.errormessage')
    <div class="box mb-4 xxxl:mb-6">

        <form id="companyForm" action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @endif

            @foreach ($formFields as $field)
                @php
                    $name = $field['name'];
                    $type = $field['type'] ?? 'text';
                    $label = $field['label'];
                    $id = $field['id'] ?? $field['name'];
                    $required = $field['required'] ?? false;
                    $value = old($name, $shareholding[$name] ?? ($field['default'] ?? ''));
                    if ($name == 'allotment_date' || $name == 'transaction_date' ) {
                        $value = old(
                            $name,
                            $shareholding?->$name instanceof \Carbon\Carbon
                                ? $shareholding?->$name->format('D M d Y')
                                : $shareholding?->$name ?? ($field['default'] ?? ''),
                        );
                    }
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
            <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                @if (empty($show))
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Allocate Share
                    </button>
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Reset
                    </button>
                @endif
                <button class="btn-outline" type="reset"
                    onclick="window.location.href='{{ route('shareholding.index') }}'">Back</button>
            </div>
        </form>

    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            var errorAlert = document.getElementById('error-alert');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 5000);
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstShareInput = document.getElementById('first_share');
            const lastShareInput = document.getElementById('share_no');
            const totalShareHeldInput = document.getElementById('total_share_held');
            const totalValueInput = document.getElementById('total_share_value');
            const shareNominalInput = document.getElementById('share_nominal'); // ✅ Nominal value field
            const amountInput = document.getElementById('amount');

            function calculateSharesAndValue() {
                const first = parseInt(firstShareInput.value) || 0;
                const last = parseInt(lastShareInput.value) || 0;
                const nominal = parseFloat(shareNominalInput.value) || 0;

                if (last >= first) {
                    const totalShares = last - first + 1;
                    const totalValue = totalShares * nominal;
                    amountInput.value = totalValue.toFixed(2);

                    totalShareHeldInput.value = totalShares;
                    totalValueInput.value = totalValue.toFixed(2);

                    console.log(totalValue);

                } else {
                    totalShareHeldInput.value = 0;
                    totalValueInput.value = '';
                    amountInput.value = '';
                }
            }

            firstShareInput.addEventListener('input', calculateSharesAndValue);
            lastShareInput.addEventListener('input', calculateSharesAndValue);
        });
    </script>
@endpush
