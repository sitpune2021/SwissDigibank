@extends('layout.main')
@section('page-title', 'CUSTOMERS')

@section('action-button')

    <a class="btn-primary uppercase" href="{{ route('member.create') }}">
        ADD
    </a>

@endsection

@section('content')

        <div class="box col-span-12 lg:col-span-6">
            <x-searchbox />
                <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>


        <div class="overflow-x-auto pb-4 lg:pb-6">
            
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                GROUP
                            </div>
                        </th>
                        <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 text-center">
                                CUSTOMER NO
                            </div>
                        </th>
                        <th class="text-start text-center !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 text-center">
                                BRANCH
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                NAME
                            </div>
                        </th>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                F/H NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                SENIOR CTZ
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ENROLL DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                AADHAR NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                PAN NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                KYC STATUS
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                MOBILE NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                STATUS
                            </div>
                        </th>
                        <th class="text-center !py-5" data-sortable="false">ACTION</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($members as $index => $item)
                        <tr class="border-b dark:border-bg3">
                            
                            <td class="py-3 px-6">{{ $item->general_group }}</td>

                            <td class="py-3 px-6 text-center">

                                @if($item->user && $item->user->otp_verified == 1)

                                    <a href="{{ route('member.show',$item->id) }}"
                                    class="text-primary hover:underline">
                                    {{ $item->member_no ?? 'N/A' }}
                                    </a>

                                    @else

                                    <span class="text-gray-400 cursor-not-allowed"
                                    title="Please verify OTP first">
                                    {{ $item->member_no ?? 'N/A' }}
                                    </span>

                                @endif

                            </td>
                            
                            <td class="py-3 px-6">{{ $item->branch->branch_name ?? '' }}</td>

                            <td class="py-3 px-6">
                                {{ $item->member_info_first_name }}
                                {{ $item->member_info_last_name }}
                            </td>

                            <td class="py-3 px-6">
                              <div class="px-2">
                                  {{ $item->member_info_father_name ?? ($item->member_info_spouse_name ?? 'N/A') }}
                              </div>
                            </td>

                            <td class="py-3 px-6">
                                @php
                                    $age = \Carbon\Carbon::parse($item->member_info_dob)->age;
                                @endphp

                              <div class="px-2">
                                  @if ($age >= 60)
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                        Yes
                                    </span>
                                @else
                                    <span
                                        class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                        No
                                    </span>
                                @endif
                              </div>
                            </td>

                            <td class="py-3 px-6">
                              <div class="px-2">
                                  {{ \Carbon\Carbon::parse($item->general_enrollment_date)->format('d-m-Y') }}
                              </div>
                            </td>

                            <td class="py-3 px-6">
                                {{ $item->kyc?->member_kyc_aadhaar_no ?? 'N/A' }}
                            </td>

                            <td class="py-3 px-6">
                                {{ $item->kyc?->member_kyc_pan_no ?? 'N/A' }}
                            </td>

                            <td class="py-3 px-6">
                               <div class="px-2">
                                 @php
                                    $hasKYC = $item->kyc?->member_kyc_aadhaar_no || $item->kyc?->member_kyc_pan_no;
                                @endphp
                                <span class="text-sm {{ $hasKYC ? 'text-primary' : 'text-error' }}">
                                    {{ $hasKYC ? 'COMPLETED' : 'PENDING' }}
                                </span>
                               </div>
                            </td>

                            <td class="py-3 px-6">
                                {{ $item->member_info_mobile_no }}
                            </td>

                            <td class="py-3 px-6">
                                <span class=" px-2 py-1 rounded bg-green-100 text-green-700">
                                    Active
                                </span>
                            </td>

                            <td class="py-2 px-6">
                                <div class="flex justify-center">

                                    @if($item->user && $item->user->otp_verified != 1)

                                    <button 
                                    onclick="openOtpModal('{{ $item->user->id }}')" 
                                    class="px-3 py-1 text-xs rounded bg-warning text-white">
                                    VERIFY / RESEND OTP
                                    </button>

                                    @else

                                        @include('partials._vertical-options', [
                                        'id' => $item->id,
                                        'viewRoute' => 'member.show',
                                        'editRoute' => 'member.edit',
                                        ])

                                    @endif

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

        <div class="mt-4">
            <x-pagination :paginator="$members"/>
        </div>


        <div id="otpModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded shadow w-96">

                <h3 class="text-lg font-bold mb-4">Verify OTP</h3>

                <input type="hidden" id="otp_user_id">

                    <p class="text-sm text-gray-500 mb-2">
                    OTP expires in <span id="otpTimer">300</span> seconds
                    </p>

                <input type="text" id="otp_input"
                    placeholder="Enter OTP"
                    class="w-full border px-3 py-2 mb-3 rounded">

                <div class="flex justify-end gap-2">

                    <button onclick="closeOtpModal()" class="px-3 py-1 bg-primary text-white rounded">
                    Cancel
                    </button>

                    <button onclick="resendOtp()" class="px-3 py-1 bg-warning text-white rounded">
                    Resend OTP
                    </button>

                    <button onclick="submitOtp()" class="px-3 py-1 bg-primary text-white rounded">
                    Verify
                    </button>

                </div>

            </div>
        </div>
        

<script>

    let otpTimerInterval;

    function openOtpModal(userId)
    {
        document.getElementById('otp_user_id').value = userId;

        // 🔥 OTP send immediately
        resendOtp();

        // modal open
        document.getElementById('otpModal').classList.remove('hidden');

        startOtpTimer();
    }

    function closeOtpModal()
    {
        document.getElementById('otpModal').classList.add('hidden');
        clearInterval(otpTimerInterval);
    }

    function submitOtp()
    {
        let otp = document.getElementById('otp_input').value;
        let user_id = document.getElementById('otp_user_id').value;

        if(otp.length != 4)
        {
            alert("Please enter 4 digit OTP");
            return;
        }

        fetch("{{ route('member.verifyOtp') }}",{
        method:"POST",
        headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body:JSON.stringify({
        otp:otp,
        user_id:user_id
        })
        })
        .then(res=>res.json())
        .then(data=>{

        if(data.status)
        {
        alert(data.message);
        location.reload();
        }
        else
        {
        alert(data.message);
        }

        });
    }

    function resendOtp()
    {
        let user_id = document.getElementById('otp_user_id').value;

        fetch("{{ route('member.resendOtp') }}",{
        method:"POST",
        headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body:JSON.stringify({
        user_id:user_id
        })
        })
        .then(res=>res.json())
        .then(data=>{

        if(data.status)
        {
        alert(data.message);
        startOtpTimer();
        }
        else
        {
        alert(data.message);
        }

        });
    }

    function startOtpTimer()
    {
        let time = 300; // 5 minutes

        clearInterval(otpTimerInterval);

        otpTimerInterval = setInterval(function(){

        if(time <= 0)
        {
        clearInterval(otpTimerInterval);
        document.getElementById("otpTimer").innerText = "Expired";
        return;
        }

        time--;
        document.getElementById("otpTimer").innerText = time;

        },1000);
    }

</script>

@endsection
