@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Assign Locker
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">
                <form action="{{ route('lockers.locker-list.assign-locker.store', $locker->id) }}" method="POST">
                    @csrf

                    {{-- Member --}}
                    <div class="mb-4">
                        <label class="block mb-1 uppercase">CUSTOMER <span class="text-red-500">*</span></label>
                        <select name="member_id" id="memberSelect" class="w-full rounded px-3 py-2 border">
                            <option value="">Select Customer</option>
                                @foreach($members as $m)
                                    <option value="{{ $m->id }}"
                                        {{ old('member_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->member_info_first_name }} ({{ $m->member_no }})
                                    </option>
                                @endforeach
                        </select>
                        @error('member_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4" id="saving_account_box" style="display:none;">
                        <label class="block mb-1 uppercase">Member Saving Account <span class="text-red-500">*</span></label>
                        <select name="account_id" id="account_id" class="w-full rounded px-3 py-2 border">
                            <option value="">Select Saving Account</option>
                        </select>
                        @error('account_id') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    @php
                        $assignDate = null;

                        if (!empty($locker->assigned_date)) {
                            try {
                                $assignDate = \Carbon\Carbon::parse($locker->assigned_date)->format('d-m-Y');
                            } catch (\Exception $e) {
                                $assignDate = null;
                            }
                        }
                    @endphp

                    {{-- Enrollment / Assign Date --}}
                    <div class="mb-4 hidden" id="assignDateWrapper">
                        <label class="block mb-1 uppercase">
                            Enrollment Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="assign_date"
                            value="{{ old('assign_date', $assignDate ?? now()->format('d-m-Y')) }}"
                            class="w-full rounded px-3 py-2 border"
                            placeholder="dd-mm-yyyy"
                        />

                        @error('assign_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary">Assign</button>
                        <a href="{{ route('lockers.locker-list.index') }}" class="btn-outline">Back</a>
                    </div>
            
                </form>
            </div>

            <div class=" col-span-2 box md:col-span-1 ">
                
                <div class="bg-secondary/5 rounded-10  px-5 py-3">
                    <h3 class="text-lg font-semibold uppercase tracking-wide">
                        Locker Info
                    </h3>
                </div>

                <div class="bg-white dark:bg-gray-900">
                    <div class="overflow-x-auto whitespace-nowrap">
                        
                        <table class="w-full  text-sm md:text-base">
                            <tbody class="divide-y divide-gray-200">
                                <tr class="bg-gray-50 border-b ">
                                    <td class="font-semibold uppercase p-3 w-1/2">Locker No</td>
                                    <td class="p-3">{{ $locker->locker_no }}</td>
                                </tr>
                                <tr class="bg-gray-50 uppercase border-b ">
                                    <td class="font-semibold p-3">Locker Name</td>
                                    <td class="p-3">{{ $locker->locker_name }} </td>
                                </tr>
                                <tr class="bg-gray-50 uppercase border-b ">
                                    <td class="font-semibold p-3">Locker Charge(Monthly)	</td>
                                    <td class="p-3">{{ number_format($locker->monthly_charges, 2) }}
                                </td>
                                </tr>
                                <tr class="bg-gray-50 border-b ">
                                    <td class="font-semibold uppercase p-3">Assigned	</td>
                                <td class="text-start !py-5 px-6">
                                    @if($locker->assigned == 1)
                                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                            Yes
                                        </span>
                                    @else
                                        <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                            No
                                        </span>
                                    @endif
                                </td>      
                                </tr>
                                
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
            
        </div>


<!-- Fetch saving account info regarding member -->
<script>
    document.getElementById('memberSelect').addEventListener('change', function () {
    let memberId = this.value;

    let box = document.getElementById('saving_account_box');
    let accountSelect = document.getElementById('account_id');

    if (!memberId) {
        box.style.display = "none";
        accountSelect.innerHTML = '<option value="">Select Saving Account</option>';
        return;
    }

    fetch("{{ url('/locker/get-member-accounts') }}/" + memberId)
        .then(res => res.json())
        .then(data => {

            if (data.length > 0) {

                box.style.display = "block";
                accountSelect.innerHTML = '<option value="">Select Saving Account</option>';

                data.forEach(acc => {
                    accountSelect.innerHTML += `
                       <option value="${acc.id}">
                            ${acc.members.member_info_first_name} (Bal - ${acc.latest_balance})
                        </option>`;
                });

            } else {
                box.style.display = "none";
                accountSelect.innerHTML = '<option value="">Select Saving Account</option>';
            }
        });
});
</script>

<!-- Enrollment Date hide & show -->
<script>
    document.getElementById('memberSelect').addEventListener('change', function () {
    const assignDateBox = document.getElementById('assignDateWrapper');

    if (this.value) {
        assignDateBox.classList.remove('hidden');  // ✅ SHOW
    } else {
        assignDateBox.classList.add('hidden');     // ❌ HIDE
    }
});

</script>


@endsection