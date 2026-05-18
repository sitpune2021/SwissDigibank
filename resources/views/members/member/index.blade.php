@extends('layout.main')
@extends('layout.tablestyle')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 w-full">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- PREMIUM ICON -->
        <div
            class="relative overflow-hidden
            w-11 h-11 sm:w-12 sm:h-12
            rounded-2xl flex items-center justify-center shrink-0"

            style="
                background: linear-gradient(135deg,#06b6d4,#2563eb);
                box-shadow:
                    0 10px 25px rgba(37,99,235,.30),
                    inset 0 1px 0 rgba(255,255,255,.35);
            "
        >

            <!-- SHINE -->
            <div
                class="absolute inset-0"
                style="
                    background:
                    linear-gradient(
                        135deg,
                        rgba(255,255,255,.28),
                        transparent 45%
                    );
                "
            ></div>

            <i class="las la-user-tie text-white text-xl sm:text-2xl relative z-10"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 dark:text-white leading-tight break-words">

                CUSTOMER Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 dark:text-gray-400 font-medium mt-1">

                Efficiently manage customer profiles, member activities.

            </p>

        </div>

    </div>

    <!-- RIGHT SIDE BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm shrink-0">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
@if($isSuperAdmin || in_array('member.create', $permissions))
<a href="{{ route('member.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5 rounded-xl
    text-xs sm:text-sm font-bold uppercase tracking-wide
    shadow-lg hover:scale-105 transition-all duration-300"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">

    <span>Add CUSTOMER</span>

</a>
@endif
@endsection

@section('content')

    <div class="box col-span-12 lg:col-span-6 bank-page-animate">

        <x-searchbox />

        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>


        <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">
            
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                
                <thead
                    class="bg-gradient-to-r from-slate-100 via-blue-50 to-cyan-50
                    dark:from-bg3 dark:via-bg4 dark:to-bg3
                    border-y border-slate-200 dark:border-white/10"
                >
                    <tr>

                        <!-- SR NO -->
                        <th class="text-start !py-4 px-4 sm:px-6 min-w-[120px]">
                            <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                <!-- ICON BOX -->
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-indigo-100 dark:bg-indigo-500/10">

                                    <i class="las la-hashtag text-indigo-600 dark:text-indigo-400 text-lg"></i>

                                </div>

                                <!-- TEXT -->
                                <div>

                                    <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        SR No
                                    </h6>

                                </div>

                            </div>
                        </th>

                        <!-- BRANCH -->
                        <th class="text-center !py-4 px-4 sm:px-6 min-w-[140px]">
                            <div class="flex items-center justify-center gap-2 text-slate-700 dark:text-white">

                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-cyan-100 dark:bg-cyan-500/10">
                                    <i class="las la-code-branch text-cyan-600 dark:text-cyan-400 text-lg"></i>
                                </div>

                                <div class="text-left">
                                    <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        Branch Info
                                    </h6>
                                </div>

                            </div>
                        </th>

                        <!-- CUSTOMER -->
                        <th class="text-start !py-4 px-4 sm:px-6 min-w-[200px]">
                            <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-violet-100 dark:bg-violet-500/10">
                                    <i class="las la-user-tie text-violet-600 dark:text-violet-400 text-lg"></i>
                                </div>

                                <div>
                                   <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        Customer Name
                                    </h6>
                                </div>

                            </div>
                        </th>

                        <!-- MOBILE -->
                        <th class="text-start !py-4 px-4 sm:px-6 min-w-[150px]">
                            <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-indigo-100 dark:bg-indigo-500/10">
                                    <i class="las la-mobile text-indigo-600 dark:text-indigo-400 text-lg"></i>
                                </div>

                                <div>
                                    <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        Mobile No
                                    </h6>
                                </div>

                            </div>
                        </th>

                        <!-- ENROLL DATE -->
                        <th class="text-start !py-4 px-4 sm:px-6 min-w-[160px]">
                            <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-emerald-100 dark:bg-emerald-500/10">
                                    <i class="las la-calendar-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
                                </div>

                                <div>
                                    <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        Enroll Date
                                    </h6>
                                </div>

                            </div>
                        </th>

                        <!-- KYC -->
                        <th class="text-start !py-4 px-4 sm:px-6 min-w-[140px]">
                            <div class="flex items-center gap-2 text-slate-700 dark:text-white">

                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-green-100 dark:bg-green-500/10">
                                    <i class="las la-shield-alt text-green-600 dark:text-green-400 text-lg"></i>
                                </div>

                                <div>
                                    <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        KYC Status
                                    </h6>
                                </div>

                            </div>
                        </th>                       

                        <!-- ACTION -->
                        <th class="text-center !py-4 px-4 min-w-[120px]">
                            <div class="flex items-center justify-center gap-2 text-slate-700 dark:text-white">

                                <div class="w-8 h-8 rounded-xl flex items-center justify-center
                                    bg-red-100 dark:bg-red-500/10">
                                    <i class="las la-cog text-red-600 dark:text-red-400 text-lg"></i>
                                </div>

                                <div class="text-left">
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
                                        Controls
                                    </p>

                                    <h6 class="text-xs sm:text-sm font-extrabold uppercase">
                                        Action
                                    </h6>
                                </div>

                            </div>
                        </th>

                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($members as $index => $item)
                        <tr class="table-row border-b border-gray-100"
                            style="animation-delay:{{ $loop->index * 0.05 }}s">
                            
                            <!-- SR NO -->
                            <td class="px-6 py-5 text-center font-semibold text-gray-700">

                                {{ $loop->iteration }}
                            </td>                                                
                            
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-2">

                                    <!-- Branch Name -->
                                    <span class="text-gray-700 font-medium">
                                        {{ $item->branch->branch_name ?? '-' }}
                                    </span>

                                </div>
                            </td>

                            <td class="px-3 py-3">
                                <div class="flex items-center gap-2">

                                    <!-- Name + Number -->
                                    <div>
                                         <a href="{{ route('member.show',$item->id) }}">
                                            <p class="text-primary hover:underline font-semibold text-green-700 leading-tight">
                                                {{ $item->member_info_first_name }} {{ $item->member_info_last_name }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                Customer No : {{ $item->member_no }}
                                            </p>
                                        </a>
                                    </div>

                                </div>
                            </td> 

                            <td class="py-3 px-6">
                                {{ $item->member_info_mobile_no }}
                            </td>                        

                            <td class="py-3 px-6">
                              <div class="px-2">
                                  {{ \Carbon\Carbon::parse($item->general_enrollment_date)->format('d-m-Y') }}
                              </div>
                            </td>

                            <td class="py-3 px-6">
                                <div class="px-2">
                                    @php
                                        $aadhaar = $item->kyc?->member_kyc_aadhaar_no;
                                        $pan = $item->kyc?->member_kyc_pan_no;
                                        $otpVerified = $item->kyc?->otp_verified; 
                                        $selfie = $item->kyc?->selfie_uploaded;

                                        if (!$aadhaar && $pan) {
                                            $status = 'MINI KYC';
                                            $class = 'text-warning';
                                        } elseif ($aadhaar && $pan && $otpVerified && $selfie) {
                                            $status = 'FULL KYC';
                                            $class = 'text-success';
                                        } else {
                                            $status = 'PENDING';
                                            $class = 'text-error';
                                        }
                                    @endphp

                                    <span class="text-sm {{ $class }}">
                                        {{ $status }}
                                    </span>
                                </div>
                            </td>

                            <!-- ACTION -->
                            <td class="text-center px-4 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    <!-- VIEW -->
                                    @if($isSuperAdmin || in_array('member.show', $permissions))
                                    <a href="{{ route('member.show', $item->id) }}"
                                        class="action-btn action-view">

                                        <i class="las la-eye"></i>
                                        <span>VIEW</span>

                                    </a>
                                    @endif

                                    <!-- EDIT -->
                                    @if($isSuperAdmin || in_array('member.edit', $permissions))
                                    <a href="{{ route('member.edit', $item->id) }}"
                                        class="action-btn action-edit">

                                        <i class="las la-edit"></i>
                                        <span>EDIT</span>

                                    </a>
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
