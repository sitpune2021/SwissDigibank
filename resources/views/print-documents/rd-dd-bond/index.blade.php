@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
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

                    <select id="account_type" name="account_type" class="w-full border bg-secondary/5 rounded-10 px-3 py-3 text-sm">
                        <option value="">Select</option>

                        <option value="RD" {{ old('account_type', $type ?? '' )==='RD' ? 'selected' : '' }}>
                            RD
                        </option>
                        <option value="DD" {{ old('account_type', $type ?? '' )==='DD' ? 'selected' : '' }}>
                            DD
                        </option>
                    </select>

                    @error('account_type')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

             
                <div class="mt-4">
                    <label class="block font-medium mb-2">
                        Account No <span class="text-error">*</span>
                    </label>

                    <select id="account_no"
        name="account_no"
        class="w-full bg-secondary/5 border rounded-10 px-3 py-3 text-sm"
        {{ empty($type) ? 'disabled' : '' }}>

    <option value="">Select Account No</option>

    @if(($type ?? old('account_type')) === 'RD')
        @foreach($accounts as $acc)
            <option value="{{ $acc->id }}"
                {{ old('account_no', $account->id ?? '') == $acc->id ? 'selected' : '' }}>
                {{ $acc->rd_no }}
            </option>
        @endforeach

    @elseif(($type ?? old('account_type')) === 'DD')
        @foreach($accounts as $acc)
            <option value="{{ $acc->id }}"
                {{ old('account_no', $account->id ?? '') == $acc->id ? 'selected' : '' }}>
                {{ $acc->dd_no }}
            </option>
        @endforeach
    @endif
</select>

                    {{-- <select id="account_no" name="account_no" class="w-full border rounded-10 px-3 py-3 text-sm" >

                        <option value="">Select Account No</option>

                      
                    </select> --}}

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


          
          

            {{-- Download Buttons --}}
            @if(!empty($account))
            <div class="mt-6 text-center">
                @if($type === 'RD')
                <a href="{{ route('rd.bond.download', $account->id) }}" class="btn-primary" target="_blank">
                    Download RD Bond
                </a>
                @elseif($type === 'DD')
                <a href="{{ route('dd.bond.download', $account->id) }}" class="btn-primary" target="_blank">
                    Download DD Bond
                </a>
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

                fetch(`/get-rd-dd-account-numbers/${type}`)
                    .then(res => res.json())
                    .then(data => {
                        accountSelect.innerHTML = '<option value="">Select Account No</option>';

                        data.forEach(account => {
                            const option = document.createElement('option');

                            // use ID as value
                            option.value = account.id;

                            // show account number
                            if (type === 'RD') {
                                option.textContent = account.rd_no;
                            } else if (type === 'DD') {
                                option.textContent = account.dd_no;
                            }

                            accountSelect.appendChild(option);
                        });

                        accountSelect.disabled = false;
                    })
                    .catch(() => {
                        accountSelect.innerHTML = '<option value="">Error loading accounts</option>';
                    });
            });
            
    </script>
     <script>
   
</script>







    @endsection