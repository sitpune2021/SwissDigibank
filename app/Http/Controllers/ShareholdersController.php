<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shareholders;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Shareholding;
class ShareholdersController extends Controller
{
    public function index()
    {
              $sharesholdings = Shareholders::with('shareholding')->get();
        return view('members.shares-holdings.index', compact('sharesholdings'));
        // return view('members.shares-holdings.index');
    }

     public function create()
    {
        $dynamicOptions = [
            'member' => Member::pluck('member_id', 'id'),
             'branches' => Branch::pluck('branch_name', 'id'),
             'shareholding'=>Shareholders::pluck('shareholding_id','id')

        ];
        $sections = config('shareholders_form');
        $sharesholdings = null;
        $route = route('shares-holdings.store');
        $method = 'POST';

        return view('members.shares-holdings.create', compact('sections', 'sharesholdings', 'route', 'method', 'dynamicOptions'));
    }

    public function store(Request $request)
     {
        // $decryptedId = base64_decode($id);

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

        $sharesholdings = Shareholders::findOrFail($decryptedId);
        $sharesholdings->update($data);

        return redirect()->route('shares-holdings.index')->with('success', 'Shareholding updated successfully.');
    }

    public function show(string $id)
     {
        $decryptedId = base64_decode($id);

        $dynamicOptions = [
            'member' => Member::pluck('member_id', 'id'),
            'branches' => Branch::pluck('branch_name', 'id'),
          'shareholding'=>Shareholders::pluck('shareholding_id','id')

        ];
        $sections = config('shareholders_form');
        $sharesholdings = Shareholders::findOrFail($decryptedId);
        $show = true;
        $method = 'PUT';
        $route = null;

        return view('shares-holdings.create', compact('sections', 'sharesholdings', 'show', 'route', 'method', 'dynamicOptions'));
    }

   
    public function edit(string $id)
    {
        
    }

   
    public function update(Request $request, string $id)
    {
        
    }
   
    public function destroy(string $id)
    {
    
    }
}
