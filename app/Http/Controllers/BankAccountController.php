<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\BankAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BankAccountController extends Controller
{


    public function index(Request $request)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        // SUPER ADMIN = FULL ACCESS
        if ($user->role_id != 1 && !in_array('bank-account.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $search = $request->search;

        $bankAcc = BankAccount::with('bank')

            ->when($search, function ($query) use ($search) {

                $query->where('account_no', 'like', "%{$search}%")

                    ->orWhere('account_open_date', 'like', "%{$search}%")

                    ->orWhereHas('bank', function ($q) use ($search) {

                        $q->where('name', 'like', "%{$search}%");

                    })

                    ->orWhere(function ($q) use ($search) {

                        if (strtolower($search) == 'active') {

                            $q->where('account_active', 1);

                        }

                        if (strtolower($search) == 'inactive') {

                            $q->where('account_active', 0);

                        }

                    });

            })

            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('company.bankAccount.index', compact('bankAcc'));
    }

    public function create()
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('bank-account.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $mode = 'create';
        $banks = Bank::all();
        $branches = Branch::all();
        return view('company.bankAccount.create', compact('mode', 'banks', 'branches'));
    }

    public function store(Request $request)
    {
        Log::info('BankAccount Store Request Started', [
            'request_data' => $request->all()
        ]);

        $validated = $request->validate([
            'bank_id'           => 'required|exists:banks,id',
            'branch_id'         => 'nullable|exists:branches,id',
            'account_open_date' => 'required',
            'account_no'        => 'required|string|max:100',
            'ifsc_code'         => 'required|string|max:20',
            'account_type'      => 'required|in:saving,current,overdraft',
            'address'           => 'nullable|string',
            'account_active'    => 'nullable|boolean',
            'use_for_printing'  => 'nullable|boolean',
            'accounting_bank'   => 'required|exists:banks,id',
        ]);

        // ✅ Convert date BEFORE save
        if (!empty($validated['account_open_date'])) {
            $validated['account_open_date'] = Carbon::createFromFormat(
                'd-m-Y',
                $validated['account_open_date']
            )->format('Y-m-d');
        }

        Log::info('BankAccount Validated Data', $validated);

        $bankAccount = BankAccount::create([
            'bank_id'           => $validated['bank_id'],
            'branch_id'         => $validated['branch_id'] ?? null,
            'account_open_date' => $validated['account_open_date'],
            'account_no'        => $validated['account_no'],
            'ifsc_code'         => $validated['ifsc_code'],
            'account_type'      => $validated['account_type'],
            'address'           => $validated['address'] ?? null,
            'account_active'    => $validated['account_active'] ?? 0,
            'use_for_printing'  => $validated['use_for_printing'] ?? 0,
            'accounting_bank'   => $validated['accounting_bank'],
        ]);

        Log::info('BankAccount Created Successfully', [
            'bank_account_id' => $bankAccount->id
        ]);

        return redirect()
            ->route('bank-account.index')
            ->with('success', 'Bank account created successfully.');
    }

    public function show(string $id)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('bank-account.show', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $mode = 'view';
        $bankAccount = BankAccount::findOrFail($id);
        $banks = Bank::all();
        $branches = Branch::all();

        return view('company.bankAccount.create', compact(
            'mode',
            'bankAccount',
            'banks',
            'branches'
        ));
    }

    public function edit(string $id)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('bank-account.edit', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $mode = 'edit';
        $bankAccount = BankAccount::findOrFail($id);
        $banks = Bank::all();
        $branches = Branch::all();

        return view('company.bankAccount.create', compact(
            'mode',
            'bankAccount',
            'banks',
            'branches'
        ));
    }

    public function update(Request $request, string $id)
    {
        Log::info('BankAccount Update Started', [
            'bank_account_id' => $id,
            'request_data'    => $request->all(),
        ]);

        $bankAccount = BankAccount::findOrFail($id);

        $validated = $request->validate([
            'bank_id'           => 'required|exists:banks,id',
            'branch_id'         => 'nullable|exists:branches,id',
            'account_open_date' => 'required',
            'account_no'        => 'required|string|max:100',
            'ifsc_code'         => 'required|string|max:20',
            'account_type'      => 'required|in:saving,current,overdraft',
            'address'           => 'nullable|string',
            'account_active'    => 'nullable|boolean',
            'use_for_printing'  => 'nullable|boolean',
            'accounting_bank'   => 'required|exists:banks,id',
        ]);

        // ✅ Convert date BEFORE update
        if (!empty($validated['account_open_date'])) {
            $validated['account_open_date'] = Carbon::createFromFormat(
                'd-m-Y',
                $validated['account_open_date']
            )->format('Y-m-d');
        }

        Log::info('BankAccount Update Validated Data', [
            'bank_account_id' => $bankAccount->id,
            'validated'       => $validated,
        ]);

        $bankAccount->update([
            'bank_id'           => $validated['bank_id'],
            'branch_id'         => $validated['branch_id'] ?? null,
            'account_open_date' => $validated['account_open_date'],
            'account_no'        => $validated['account_no'],
            'ifsc_code'         => $validated['ifsc_code'],
            'account_type'      => $validated['account_type'],
            'address'           => $validated['address'] ?? null,
            'account_active'    => $validated['account_active'] ?? 0,
            'use_for_printing'  => $validated['use_for_printing'] ?? 0,
            'accounting_bank'   => $validated['accounting_bank'],
        ]);

        Log::info('BankAccount Updated Successfully', [
            'bank_account_id' => $bankAccount->id,
            // 'updated_by'      => auth()->id(),
        ]);

        return redirect()
            ->route('bank-account.index')
            ->with('success', 'Bank account updated successfully.');
    }

    public function destroy(string $id) {}

  
}
