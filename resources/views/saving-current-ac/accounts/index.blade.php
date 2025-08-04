@extends('layout.main')
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <div class="flex items-center gap-2"> -->
        <h2 class="h2">Saving / Current Accounts</h2>
        <a class="btn-primary" href="{{ route('accounts.create') }}">
            <i class="text-base md:text-lg"></i>
            Add
        </a>
        <!-- </div> -->
    </div>

    <!-- Latest Transactions -->
    <div class="box col-span-12 lg:col-span-6">
        <x-searchbox />
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead class="custom-thead">
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        @php
                        $headers = [

                        "Associate",
                        "Type",
                        "Scheme",
                        "A/c No.",
                        "Joint A/C",
                        "Member Name",
                        "Balance",
                        "Action"
                        ];
                        @endphp
                        @foreach ($headers as $index => $header)
                        <th class="{{ $header === 'Action' ? 'text-center' : 'text-start' }} py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                {{ $header }}
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                @php
                $lastAdvisorId = null;
                @endphp

                <tbody>
                    @foreach($Accounts as $index => $Account)
                    <tr class="even:bg-secondary/5 dark:even:bg-bg3">

                        {{-- Associate --}}
                        <td class="text-start py-5 px-6">
                            @if ($lastAdvisorId !== $Account->advisor_id)
                            {{ $Account->users ? $Account->users->fname . ' ' . $Account->users->lname : '-' }}
                            @php $lastAdvisorId = $Account->advisor_id; @endphp
                            @else
                            {{-- Empty cell for repeated advisor --}}
                            @endif
                        </td>

                        {{-- Type --}}
                        <td class="text-start py-5 px-6">{{ $Account->account_type ?? '-' }}</td>

                        {{-- Scheme Name --}}
                        <td class="text-start py-5 px-6">
                            {{ $Account->scheme->scheme_name ?? '-' }}
                        </td>

                        {{-- A/C NO. --}}
                        <td class="text-start py-5 px-6">
                            <a href="{{ route('accounts.show', base64_encode($Account->id)) }}" class="text-primary underline hover:text-primary/80">
                                {{ $Account->account_no ?? '-' }}
                            </a>
                        </td>

                        {{-- joint_account --}}
                        <td class="text-start py-5 px-6">

                            {!! $Account->account_holder_type == 'joint'
                            ? '<span class="block text-xs w-28 xxl:w-36 text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-error/10 dark:bg-bg3 text-error">Joint</span>'
                            : '<span class="block text-xs w-28 xxl:w-36 text-center rounded-[30px] dark:border-n500 border border-n30 py-2 bg-primary/10 dark:bg-bg3 text-primary">single</span>'
                            !!}

                        </td>


                        {{-- Member Name --}}
                        <td class="text-start py-5 px-6">
                            @if ($Account->members)
                            <a href="{{ route('member.show', $Account->members->id) }}" class="text-primary hover:underline">
                                {{ "Member ".$Account->members->id ." - ". $Account->members->member_info_first_name . ' ' . $Account->members->member_info_last_name }}
                            </a>
                            @else
                            -
                            @endif
                        </td>

                        {{-- show Balance --}}
                        <td class="text-start py-5 px-6">{{ $Account->amount_deposit ?? '-' }}</td>

                        {{-- Action --}}
                        <td class="text-center py-5 px-6">
                            <div class="flex justify-center">
                                @include('partials._vertical-options', [
                                'id' => base64_encode($Account->id),
                                'viewRoute' => 'accounts.show'
                                ])
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <x-pagination :paginator="$Accounts" />
</div>
@endsection