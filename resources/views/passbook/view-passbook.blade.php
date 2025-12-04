@extends('layout.main')

@section('content')
<div class="main-inner">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6 lg:mb-8">
        <h2 class="text-xl font-semibold">
            {{ $passbook->passbook_no }}
            <span class="text-gray-500 font-normal">Passbook</span>
        </h2>
    </div>

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('passbook.index') }}" class="text-gray-600 hover:underline">Passbooks</a>
        <span class="mx-1">></span>
        <span class="text-gray-700">{{ $passbook->passbook_no }}</span>
    </div>

    <!-- Passbook Details Card -->
    <div class="bg-white shadow-md rounded-lg p-6 w-1/2 mx-auto">
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 mb-4">
            <!-- Edit Button -->
            <a href="{{ route('passbook.edit', $passbook->id) }}"
                class="flex items-center gap-2 px-2 py-2 btn-outline text-black rounded-lg shadow-md transition">
                <i class="las la-edit"></i>
            </a>
            <!-- Delete Button -->
            @if(session('success'))
            <div id="toast-success" class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-md z-50">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) toast.remove();
                }, 3000);
            </script>
            @endif

            <form action="{{ route('passbook.destroy', $passbook->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this passbook?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-error text-white rounded-lg shadow-md transition">
                    <i class="las la-trash-alt"></i>
                </button>
            </form>
        </div>

        <!-- Passbook Information -->
        <div class="divide-y divide-gray-200">
            <table class="w-full text-sm text-gray-700 rounded-md">
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="font-semibold px-3 py-2 w-1/3">Account</td>
                        <td class="px-3 py-2">{{ $passbook->account_no }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="font-semibold px-3 py-2">Passbook No.</td>
                        <td class="px-3 py-2">{{ $passbook->passbook_no }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="font-semibold px-3 py-2">Issue Date</td>
                        <td class="px-3 py-2">{{ \Carbon\Carbon::parse($passbook->issue_date)->format('d/m/Y') }}</td>
                    </tr>

                </tbody>
            </table>

        </div>


    </div>
    @endsection