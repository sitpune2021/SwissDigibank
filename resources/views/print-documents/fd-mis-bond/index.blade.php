@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
            <h2 class="text-lg uppercase">Print FD/ MIS Bond </h2>

        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen md-4">
            <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

                <form action="{{ route('fd.mis.bond.search') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block font-medium mb-2">
                            Account Type <span class="text-error">*</span>
                        </label>
                        <select id="account_type" name="account_type" class="w-full bg-secondary/5 border rounded-10 px-3 py-3 text-sm">
                            <option value="">Select</option>
                            <option value="FD" {{ old('account_type', $type ?? '') === 'FD' ? 'selected' : '' }}>
                                FD
                            </option>
                            <option value="MIS" {{ old('account_type', $type ?? '') === 'MIS' ? 'selected' : '' }}>
                                MIS
                            </option>
                        </select>
                        
                        @error('account_type')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium mb-2">Account No
                            <span class="text-error">*</span>
                        </label>
                        <select id="account_no" name="account_no" class="w-full border bg-secondary/5 rounded-10 px-3 py-3 text-sm" {{
        isset($type) ? '' : 'disabled' }}>
                            <option value="">Select Account No</option>

                            @if(($type ?? old('account_type')) === 'FD')
                                @foreach(\App\Models\FdAccount::select('account_no')->get() as $acc)
                                                <option value="{{ $acc->account_no }}" {{ old('account_no', $account->account_no ?? '') ==
                                    $acc->account_no ? 'selected' : '' }}>
                                                    {{ $acc->account_no }}
                                                </option>
                                @endforeach

                            @elseif(($type ?? old('account_type')) === 'MIS')
                                @foreach(\App\Models\Misaccount::select('mis_account_no')->get() as $acc)
                                                <option value="{{ $acc->mis_account_no }}" {{ old('account_no', $account->mis_account_no ?? '')
                                    == $acc->mis_account_no ? 'selected' : '' }}>
                                                    {{ $acc->mis_account_no }}
                                                </option>
                                @endforeach
                            @endif
                        </select>
                        @error('account_no')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror

                        
                    </div>

                    <div class="flex justify-center pt-4">
                        <button type="submit" class="btn-primary uppercase">
                            Search
                        </button>
                    </div>
                </form>

                @if(!empty($account))
                    <div class="mt-6 text-center">
                        @if($type === 'FD')
                            <a href="{{ route('fd.bond.view', $account->id) }}" class="btn-primary" target="_blank">
                                Show FD Bond
                            </a>
                        @elseif($type === 'MIS')
                            <a href="{{ route('misaccount.printbond.view', $account->id) }}" class="btn-primary" target="_blank">
                                Show MIS Bond
                            </a>
                        @else
                            <p class="text-error font-medium">
                                no mis bond found
                            </p>
                        @endif
                    </div>
                @endif

            </div>

        </div>
        <script>
            document.getElementById('account_type').addEventListener('change', function () {
                const type = this.value;
                const accountSelect = document.getElementById('account_no');

                accountSelect.innerHTML = '<option value="">Loading...</option>';
                accountSelect.disabled = true;

                if (!type) return;

                fetch(`/get-account-numbers/${type}`)
                    .then(response => response.json())
                    .then(data => {
                        accountSelect.innerHTML = '<option value="">Select Account No</option>';

                        data.forEach(account => {
                            const option = document.createElement('option');

                            if (type === 'FD') {
                                option.value = account.account_no;
                                option.textContent = account.account_no;
                            } else if (type === 'MIS') {
                                option.value = account.mis_account_no;
                                option.textContent = account.mis_account_no;
                            }

                            accountSelect.appendChild(option);
                        });

                        accountSelect.disabled = false;
                    });
            });
        </script>




@endsection