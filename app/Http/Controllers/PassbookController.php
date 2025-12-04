<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Passbook;
use App\Models\FdAccount;
use App\Models\RdAccount;
use App\Models\Account;
use App\Models\DdsAccount;
use App\Models\Misaccount;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PassbookController extends Controller
{
    public function index()
    {
        $passbooks = Passbook::orderBy('issue_date', 'desc')->get();
        return view('passbook.index', compact('passbooks'));
    }

    public function create()
    {
        $savingAccounts = Account::select('id', 'account_no')->get();
        $currentAccount = Account::select('id', 'account_no')->get();
        $rdAccounts = RdAccount::select('id')->get();
        $fdAccounts = FdAccount::select('id')->get();
        $ddsAccounts = DdsAccount::select('id')->get();
        $misAccounts = Misaccount::select('id')->get();

        return view('passbook.create-passbook', [
            'savingAccounts' => $savingAccounts,
            'rdAccounts' => $rdAccounts,
            'fdAccounts' => $fdAccounts,
            'currentAccounts' => $currentAccount,
            'ddsAccounts' => $ddsAccounts,
            'misAccounts' => $misAccounts,
            'currentDate' => Carbon::now()->format('Y-m-d'), // For input value
            'currentDateDisplay' => Carbon::now()->format('d/m/Y') // For formatted display
        ]);
    }


    public function store(Request $request)
    {
        try {
            // Step 1: Define validation rules
            $rules = [
                'account_type' => ['required', 'string', 'in:Saving,Current,RD Accounts,DD Accounts,FD Accounts,MIS Accounts,DDS Accounts'],
                'account_no'   => 'required|string|max:255',
                'passbook_no'  => 'required|string|max:255|unique:passbook,passbook_no',
                'issue_date'   => 'required|date_format:d-m-Y',
                'pages'        => 'nullable|integer|min:1',
            ];

            // Step 2: Validate request
            $validated = $request->validate($rules);

            // Step 3: Format issue_date to Y-m-d
            $dateParts = explode('-', $validated['issue_date']); // dd-mm-yyyy
            $validated['issue_date'] = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

            // Step 4: Save Passbook
            Passbook::create([
                'account_type' => $validated['account_type'],
                'account_no'   => $validated['account_no'],
                'passbook_no'  => $validated['passbook_no'],
                'issue_date'   => $validated['issue_date'],
                'pages'        => $validated['pages'] ?? null,
            ]);


            return redirect()->route('passbook.index')->with('success', 'Passbook issued successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log full error for debugging
            Log::error('Passbook Store Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),

            ]);

            return back()->with('error', 'Something went wrong! Check logs for details.')->withInput();
        }
    }

    public function show(Passbook $passbook)
    {
        return view('passbook.view-passbook', compact('passbook'));
    }

    public function edit($id)
    {
        $passbook = Passbook::findOrFail($id);
        return view('passbook.edit-passbook', compact('passbook'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Step 1: Find the passbook record
            $passbook = Passbook::findOrFail($id);

            // Step 2: Validate input
            $validated = $request->validate([
                'account_type' => 'required|string|in:Saving,Current,RD Accounts,DD Accounts,FD Accounts,MIS Accounts,DDS Accounts',
                'account_no'   => 'required|string|max:255',
                'passbook_no'  => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('passbook', 'passbook_no')->ignore($passbook->id),
                ],
                'issue_date'   => 'required|date_format:d-m-Y',
                'pages'        => 'nullable|integer|min:1',
            ]);

            // Step 3: Format issue date for DB (Y-m-d)
            $dateParts = explode('-', $validated['issue_date']); // dd-mm-yyyy
            $validated['issue_date'] = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";

            // Step 4: Update record
            $passbook->update($validated);

            // Step 5: Redirect back with success message
            return redirect()->route('passbook.index')->with('success', 'Passbook updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Passbook Update Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->withErrors('Something went wrong while updating!')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $passbook = Passbook::findOrFail($id);
            $passbook->delete();

            // Set success message in session
            return redirect()->route('passbook.index')->with('success', 'Passbook deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Passbook Delete Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->withErrors('Something went wrong while deleting the passbook.');
        }
    }


    public function passbookPdf()
    {
        // return view('passbook.passbook-pdf');
    }
}
