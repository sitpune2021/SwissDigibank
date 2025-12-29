@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="text-lg uppercase">Print RD/ DD Bond </h2>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen md-4">
        <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

            <form action="{{ route('rd.dd.bond.search') }}" method="POST" id="bondForm" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-medium mb-2">
                        Account Type <span class="text-error">*</span>
                    </label>

                    <select id="account_type" name="account_type" class="w-full border rounded-10 px-3 py-3 text-sm">
                        <option value="">Select</option>
                        <option value="RD" {{ old('account_type', $type ?? '' )==='RD' ? 'selected' : '' }}>RD</option>
                        <option value="DD" {{ old('account_type', $type ?? '' )==='DD' ? 'selected' : '' }}>DD</option>
                    </select>
                    <p id="account_type_error" class="text-error text-sm mt-1"></p>
                </div>

                <div class="mt-4">
                    <label class="block font-medium mb-2">
                        Account No <span class="text-error">*</span>
                    </label>

                    <select id="account_no" name="account_no" class="w-full border rounded-10 px-3 py-3 text-sm" {{ isset($type) ? '' : 'disabled' }}>
                        <option value="">Select Account No</option>
                    </select>
                    <p id="account_no_error" class="text-error text-sm mt-1"></p>
                </div>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="btn-primary uppercase">
                        Search
                    </button>
                </div>
            </form>

            {{-- Download Buttons --}}
            <div id="downloadButtons" class="mt-6 text-center">
                @if(!empty($account))
                    @if($type === 'RD')
                        <a href="{{ route('rd.bond.download', $account->id) }}" class="btn-primary" target="_blank">
                            Download RD Bond
                        </a>
                    @elseif($type === 'DD')
                        <a href="{{ route('dd.bond.download', $account->id) }}" class="btn-primary" target="_blank">
                            Download DD Bond
                        </a>
                    @endif
                @endif
            </div>

        </div>
    </div>

    <script>
        // Account type change logic
        document.getElementById('account_type').addEventListener('change', function () {
            const type = this.value;
            const accountSelect = document.getElementById('account_no');

            accountSelect.innerHTML = '<option value="">Loading...</option>';
            accountSelect.disabled = true;

            if (!type) return;

            fetch(`/get-rd-dd-account-numbers/${type}`)
                .then(res => res.json())
                .then(data => {
                    accountSelect.innerHTML = '<option value="">Select Account No</option>';

                    data.forEach(account => {
                        const option = document.createElement('option');
                        option.value = account.id;
                        option.textContent = type === 'RD' ? account.rd_no : account.dd_no;
                        accountSelect.appendChild(option);
                    });

                    accountSelect.disabled = false;
                })
                .catch(() => {
                    accountSelect.innerHTML = '<option value="">Error loading accounts</option>';
                });
        });

        // AJAX form submit
        const bondForm = document.getElementById('bondForm');

        bondForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(bondForm);

            fetch("{{ route('rd.dd.bond.search') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'  // important for Laravel to return JSON on validation errors
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // Clear previous errors
                document.getElementById('account_type_error').textContent = '';
                document.getElementById('account_no_error').textContent = '';

                if (data.errors) {
                    // Show validation errors
                    if (data.errors.account_type) {
                        document.getElementById('account_type_error').textContent = data.errors.account_type[0];
                    }
                    if (data.errors.account_no) {
                        document.getElementById('account_no_error').textContent = data.errors.account_no[0];
                    }
                    return;
                }

                // Display download buttons dynamically
                const downloadDiv = document.getElementById('downloadButtons');
                let html = '';

                if (data.type === 'RD' && data.account_id) {
                    html = `<a href="/rd-bond-download/${data.account_id}" class="btn-primary" target="_blank">Download RD Bond</a>`;
                } else if (data.type === 'DD' && data.account_id) {
                    html = `<a href="/dd-bond-download/${data.account_id}" class="btn-primary" target="_blank">Download DD Bond</a>`;
                }

                downloadDiv.innerHTML = html;
            })
            .catch(err => console.error('Error:', err));
        });
    </script>
@endsection
