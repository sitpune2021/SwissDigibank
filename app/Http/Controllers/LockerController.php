<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Member;
use App\Models\LockerList;
use App\Models\Account;
use App\Models\Transaction;


class LockerController extends Controller
{
    public function locker_list_index()
    {
        // $lockers = LockerList::all();
        $lockers = LockerList::orderByDesc('id')->get();
        
        return view('lockers.locker-list.index', compact('lockers'));
    }

    public function locker_list_add()
    {
        $branch = Branch::all();
        $locker = null; // Important for dynamic form
        return view('lockers.locker-list.add', compact('branch','locker'));
    }

    public function locker_list_store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'       => 'required|exists:branches,id',
            'locker_no'       => 'required|string|max:255',
            'locker_name'     => 'required|string|max:255',
            'monthly_charges' => 'required|numeric',
        ]);

        LockerList::create($validated);

        return redirect()->route('lockers.locker-list.index')
            ->with('success', 'Locker added successfully!');
    }

    public function locker_list_view($id)
    {
        $locker = LockerList::findOrFail($id);

        $memberIds = $locker->member_id ? explode(',', $locker->member_id) : [];

        $members = [];

        foreach ($memberIds as $mid) {
            $m = Member::find($mid);
            if ($m) {

                // Correct: blade me account_no show ho raha hai, to yahin set karo
                $m->account_no = Account::where('member_id', $mid)->value('account_no');

                $members[] = $m;
            }
        }

        return view('lockers.locker-list.view', compact('locker', 'members'));
    }

    public function locker_list_edit($id)
    {
        $locker = LockerList::findOrFail($id);
        $branch = Branch::all();

        return view('lockers.locker-list.add', compact('branch', 'locker'));
    }

    public function locker_list_update(Request $request, $id)
    {
        $request->validate([
            'branch_id' => 'required',
            'locker_no' => 'required',
            'locker_name' => 'required',
            'monthly_charges' => 'required|numeric',
        ]);

        $locker = LockerList::findOrFail($id);

        $locker->update([
            'branch_id' => $request->branch_id,
            'locker_no' => $request->locker_no,
            'locker_name' => $request->locker_name,
            'monthly_charges' => $request->monthly_charges,
        ]);

        return redirect()->route('lockers.locker-list.index')
                        ->with('success', 'Locker Updated Successfully!');
    } 
   
    public function assign_locker($id)
    {
        $locker = LockerList::findOrFail($id);
        $members = Member::all();

        return view('lockers.locker-list.assign-locker', compact('locker','members'));
    }

    public function getMemberAccounts($member_id)
    {
        $accounts = Account::with('members')
            ->where('member_id', $member_id)
            ->get();

        // Add latest balance for each account
        foreach ($accounts as $acc) {
            $lastTxn = Transaction::where('account_id', $acc->id)
                ->orderBy('id', 'DESC')
                ->first();

            $acc->latest_balance = $lastTxn ? $lastTxn->amount : 0;
        }

        return response()->json($accounts);
    }

    public function assign_locker_store(Request $request, $id)
    {
        $request->validate([
            'member_id'   => 'required|exists:members,id',
            'assign_date' => 'required|date',
            'account_id'  => 'required|exists:accounts,id',
        ], [
            'account_id.required' => 'Please create your account first!',
        ]);

        // Check if selected member has ANY account
        $accountExists = Account::where('member_id', $request->member_id)->exists();

        if (!$accountExists) {
            return redirect()
            ->route('lockers.locker-list.assign-locker', $id)
            ->withInput()
            ->with('error', 'This member does not have an account. Please create an account first.');
        }

        $locker = LockerList::findOrFail($id);

        // -------------------------------------------------------
        // STEP 1: Fetch Existing Member History
        // -------------------------------------------------------
        $oldMembers      = $locker->member_id ? explode(',', $locker->member_id) : [];
        $oldAssignDates  = $locker->assign_date ? explode(',', $locker->assign_date) : [];
        $oldReleaseDates = $locker->release_date ? explode(',', $locker->release_date) : [];

        // -------------------------------------------------------
        // STEP 2: History Length Check (Avoid Corruption)
        // -------------------------------------------------------
        if (
            count($oldMembers) !== count($oldAssignDates) ||
            count($oldMembers) !== count($oldReleaseDates)
        ) {
            return back()->with('error', 'Locker history mismatch for dates. Fix release_date entries.');
        }

        // -------------------------------------------------------
        // STEP 3: Check Member Already Has Active Locker Anywhere
        // -------------------------------------------------------
        $activeLocker = LockerList::where('member_id', 'LIKE', "%{$request->member_id}%")
            ->get()
            ->filter(function($l) use ($request) {
                $mIds  = explode(',', $l->member_id);
                $rDates = $l->release_date ? explode(',', $l->release_date) : [];

                foreach ($mIds as $index => $mId) {
                    if ($mId == $request->member_id) {
                        // ACTIVE IF release_date empty at same index
                        if (empty($rDates[$index])) {
                            return true;
                        }
                    }
                }
                return false;
            })
            ->first();

        if ($activeLocker) {
            return redirect()
            ->route('lockers.locker-list.assign-locker', $id)
            ->withInput()
            ->with('error', 'This member already has an active locker.');
            //return back()->with('error', 'This member already has an active locker.');
        }

        // -------------------------------------------------------
        // STEP 4: Append new member id + assign date
        // -------------------------------------------------------
        $oldMembers[] = $request->member_id;

        $formattedAssignDate = \Carbon\Carbon::parse($request->assign_date)->format('Y-m-d');
        $oldAssignDates[] = $formattedAssignDate;

        // NEW ENTRY → release_date will be blank
        $oldReleaseDates[] = '';

        $locker->member_id     = implode(',', $oldMembers);
        $locker->assign_date   = implode(',', $oldAssignDates);
        $locker->release_date  = implode(',', $oldReleaseDates);
        $locker->assigned      = 1;
        $locker->save();

        // -------------------------------------------------------
        // STEP 5: Transaction Logic
        // -------------------------------------------------------
        $lockerCharge = $locker->monthly_charges;

        $lastTransaction = Transaction::where('account_id', $request->account_id)
                                    ->orderBy('id', 'DESC')
                                    ->first();

        // $currentBalance = $lastTransaction ? $lastTransaction->amount : 0;

        // $newBalance = $currentBalance - $lockerCharge;

        // Transaction::create([
        //     'account_id'       => $request->account_id,
        //     'amount'           => $newBalance,
        //     'transaction_type' => 'Debit',
        //     'payment_mode'     => 'cash',
        //     'transaction_date' => now(),
        //     'comment'          => 'Monthly Locker Charge Deducted',
        // ]);

        Transaction::create([
            'account_id'       => $request->account_id,
            'amount'           => $lockerCharge,
            'transaction_type' => 'Debit',
            'payment_mode'     => 'cash',
            'transaction_date' => now(),
            'comment'          => 'Monthly Locker Charge Deducted',
        ]);


        return redirect()->route('lockers.locker-list.view', $locker->id)
            ->with('success', 'Locker assigned successfully with history & transaction added.');
    }

    // public function release_locker($id)
    // {
    //     $locker = LockerList::findOrFail($id);
    //     $members = Member::all();
    //     return view('lockers.locker-list.release-locker', compact('locker','members'));
    // }

    public function release_locker($id)
    {
        $locker = LockerList::findOrFail($id);

        // Convert columns to arrays
        $memberIds = explode(',', $locker->member_id);
        $assignDates = explode(',', $locker->assign_date);
        $releaseDates = $locker->release_date ? explode(',', $locker->release_date) : [];

        $notReleasedName = null;
        $notReleasedAssignDate = null;
        $notReleasedReleaseDate = null;

        foreach ($memberIds as $index => $mId) {

            $released = isset($releaseDates[$index]) && !empty($releaseDates[$index]);

            // If NOT released → take its details
            if (!$released) {
                $member = Member::find($mId);

                if ($member) {
                    $notReleasedName = $member->member_info_first_name;
                    $notReleasedAssignDate = $assignDates[$index] ?? null;
                    $notReleasedReleaseDate = "Not Released";  // you can change text as needed
                }

                break; // only first unreleased member show
            }
        }

        return view(
            'lockers.locker-list.release-locker',
            compact(
                'locker',
                'notReleasedName',
                'notReleasedAssignDate',
                'notReleasedReleaseDate'
            )
        );
    }

    public function release_locker_store(Request $request, $id)
    {
        $request->validate([
            'end_date' => 'required|date',
        ]);

        $locker = LockerList::findOrFail($id);

        // Locker ko release karte waqt assigned = 0 set karo
        $locker->assigned = 0;

        
        // Convert DD-MM-YYYY to YYYY-MM-DD before saving
        $locker->release_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date)
                                            ->format('Y-m-d');


        $locker->save();

        return redirect()
            ->route('lockers.locker-list.index')
            ->with('success', 'Locker released successfully.');
    }

    public function member_locker_index()
    {
        $lockers = LockerList::all();
        $finalData = [];

        foreach ($lockers as $locker) {

            $memberIds    = $locker->member_id ? explode(',', $locker->member_id) : [];
            $assignDates  = $locker->assign_date ? explode(',', $locker->assign_date) : [];
            $releaseDates = $locker->release_date ? explode(',', $locker->release_date) : [];

            $total = count($memberIds);

            for ($i = 0; $i < $total; $i++) {

                $mid = $memberIds[$i] ?? null;

                $item = new \stdClass;

                // Locker details
                $item->id = $locker->id;
                $item->locker_no = $locker->locker_no;
                $item->locker_name = $locker->locker_name;

                if ($mid) {
                    $member = Member::find($mid);
                    if ($member) {
                        $item->member_name = $member->member_info_first_name;
                        $item->member_no = $member->member_no;
                        $item->account_no = Account::where('member_id', $mid)->value('account_no') ?? '—';
                    } else {
                        $item->member_name = 'Unknown';
                        $item->member_no = '—';
                        $item->account_no = '—';
                    }
                }

                $item->assign_on = $assignDates[$i] ?? null;
                $item->release_on = $releaseDates[$i] ?? null;

                $item->is_assigned = empty($item->release_on) ? 'Yes' : 'No';

                $finalData[] = $item;
            }
        }

        return view('lockers.member-locker.index', ['lockers' => $finalData]);
    }

    public function member_locker_view()
    {
        return view('lockers.member-locker.view');
    }

    
}
