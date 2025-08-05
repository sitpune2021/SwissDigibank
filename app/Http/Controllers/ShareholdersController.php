<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shareholders;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Shareholding;
use App\Models\Promotor;


class ShareholdersController extends Controller
{
    public function index()
    {
        $sharesholdings = Shareholders::with('shareholding','branch', 'member')->get();
        return view('members.shares-holdings.index', compact('sharesholdings'));
    }

    public function create(Request $request)
    {

        $transfoer = Promotor::where('is_transfer', true)->first();
        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id'),
             'branches' => Branch::pluck('branch_name', 'id'),
        ];
        $sections = config('shareholders_form');
        $sharesholdings = null;
        $route = route('shares-holdings.store');
        $method = 'POST';
        $nominal_value=10.00;
         
    // ✅ Add this to calculate existing shares
    $memberId = $request->input('member_id') ?? old('member_id');
    $memberShareCount = 0;

    if ($memberId) {
        $memberShareCount = Shareholders::where('member_id', $memberId)->sum('shares');
    }
    $Promotor = Promotor::where('is_transfer', true)->select('id', 'first_name')->first();

        return view('members.shares-holdings.create', compact('sections','nominal_value', 'sharesholdings', 'route', 'memberShareCount','transfoer','method', 'dynamicOptions', 'Promotor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transferor' => 'required|string|max:255',
            'member_id' => 'required|exists:members,id',
            'business_type' => 'nullable|in:fd/mis,rd/dd,saving,loan',
            'transfer_date' => 'required|date',
            'shares' => 'required|integer|min:1',
            'face_value' => 'nullable|numeric|min:0',
            'total_consideration' => 'nullable|numeric|min:0',
        ]);

        $data['transfer_date'] = date('Y-m-d', strtotime($data['transfer_date']));
          // ✅ Auto-calculate total_consideration if not provided
            if (empty($data['total_consideration'])) {
                $data['total_consideration'] = $data['shares'] * $data['face_value'];
    }

       $shareholder = new Shareholders($data);
        $shareholder->save();
        // dd($shareholder);

        return redirect()->route('shares-holdings.index')->with('success', 'Shares holding recorded successfully.');
    }

    public function show(string $id)
    {
        $decryptedId = base64_decode($id);

        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id'),
            'branches' => Branch::pluck('branch_name', 'id')
        ];
        $sections = config('shareholders_form');
        $sharesholdings = Shareholders::findOrFail($decryptedId);
        $show = true;
        $method = 'PUT';
        // $route = null;
        return view('shares-holdings.create', compact('sections', 'sharesholdings', 'show', 'route', 'method', 'dynamicOptions'));
    }

    public function edit(string $id)
    {
        $decryptedId = base64_decode($id);

        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id'),
             'branches' => Branch::pluck('branch_name', 'id')
        ];

        $sharesholdings = Shareholders::findOrFail($decryptedId);
        $sections = config('shareholders_form');
        $route = route('shares-holdings.update', $id);
        $method = 'PUT';

        return view('shares-holdings.create', compact('sections', 'sharesholdings', 'route', 'method', 'dynamicOptions'));
    }

    public function update(Request $request, string $id)
    {
        $decryptedId = base64_decode($id);

        $data = $request->validate([
            'transferor' => 'required|string|max:255',
            'member_id' => 'required|exists:members,id',
            'business_type' => 'nullable|in:fd/mis,rd/dd,saving,loan',
            'transfer_date' => 'required|date',
            'shares' => 'required|integer|min:1',
            'face_value' => 'nullable|numeric|min:0',
            'total_consideration' => 'nullable|numeric|min:0',
        ]);

        $data['transfer_date'] = date('Y-m-d', strtotime($data['transfer_date']));
         // ✅ Auto-calculate total_consideration if not provided
            if (empty($data['total_consideration'])) {
                $data['total_consideration'] = $data['shares'] * $data['face_value'];
    }

        $sharesholdings = Shareholders::findOrFail($decryptedId);
        $sharesholdings->update($data);

        return redirect()->route('shares-holdings.index')->with('success', 'Shareholding updated successfully.');
    }

    public function destroy(string $id)
    {
        $decryptedId = base64_decode($id);

        $sharesholding = Shareholders::findOrFail($decryptedId);
        $sharesholding->delete();

        return redirect()->route('shares-holdings.index')->with('success', 'Shareholding deleted successfully.');
    }
    
}
