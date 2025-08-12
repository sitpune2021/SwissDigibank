<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Form15G15H;
use App\Models\Promotor;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\Storage;

class Form15Gor15HController extends Controller
{
    public function index()
    {
        $form15g15hs = Form15G15H::latest()->get();
        return view("members.form15g15h.index", compact('form15g15hs'));
    }

    public function create(Request $request)
    {
        $memberId = $request->member_id ?? session('member_id');
        $type = $request->type ?? session('type');

        if (!$memberId || !Member::find($memberId)) {
            return redirect()->back()->with('error', 'Invalid Member ID');
        }

        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id'),
            'promoter' => Promotor::pluck('first_name', 'id'),
            'financial_year' => $this->generateFinancialYears()
        ];

        $sections = config('form15g15h_form');
        $route = route('form15g15h.store');
        $method = 'POST';

        return view('members.form15g15h.create', compact('sections', 'route', 'method', 'dynamicOptions', 'memberId', 'type'));
    }

    public function store(Request $request)
    {
        $type = $request->type;

        $validator = Validator::make($request->all(), [
            'financial_year' => 'required|string|max:20',
            'form_15_upload' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'member_id' => $type === 'member' ? 'required|exists:members,id' : 'nullable',
            'promotor_id' => $type === 'promoter' ? 'required|exists:promotors,id' : 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Fix key name to match DB column exactly:
        $validated['member_id'] = $type === 'member' ? $request->member_id : null;
        $validated['promotor_id'] = $type === 'promoter' ? $request->promotor_id : null;

        if ($request->hasFile('form_15_upload')) {
            $path = $request->file('form_15_upload')->store('uploads', 'public');
            $validated['form_15_upload'] = $path;
        }

        Form15G15H::create($validated);


        // Conditional redirect after form submission
        if ($type === 'member') {
            $memberId = $validated['member_id'];
            return redirect()->route('member.show', $memberId)
                ->with('success', 'Form 15G/15H submitted successfully.');
        } else {
            $promoterId = $validated['promotor_id'];
            return redirect()->route('promotor.show', base64_encode($promoterId))
                ->with('success', 'Form 15G/15H submitted successfully.');
        }
    }




    public function show(string $id)
    {
        $form15g15h = Form15G15H::findOrFail($id);

        return view('members.form15g15h.show', compact('form15g15h'));
    }

    public function edit(string $id)
    {
        $form15g15h = Form15G15H::findOrFail($id);

        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id'),
            'promotor' => Promotor::pluck('first_name', 'id'),
            'financial_year' => $this->generateFinancialYears()
        ];

        $sections = config('form15g15h_form');
        $route = route('form15g15h.update', $id);
        $method = 'PUT';

        return view('members.form15g15h.create', compact('form15g15h', 'sections', 'route', 'method', 'dynamicOptions'));
    }

    public function update(Request $request, string $id)
    {
        $form15g15h = Form15G15H::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'financial_year' => 'required|string|max:20',
            'promotor_id' => 'required|exists:promotors,id',

            'form_15_upload' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
        if (!$validated['member_id'] && !$validated['promoter_id']) {
            return back()->withErrors(['relation' => 'Either member_id or promotor_id is required.']);
        }

        if ($request->hasFile('form_15_upload')) {
            if ($form15g15h->form_15_upload) {
                Storage::disk('public')->delete($form15g15h->form_15_upload);
            }

            $path = $request->file('form_15_upload')->store('uploads', 'public');
            $validated['form_15_upload'] = $path;
        }
        $form15g15h->update($validated);

        return redirect()->route('form15g15h.index')->with('success', 'Form updated successfully!');
    }

    // Delete record
    public function destroy(string $id)
    {
        $form = Form15G15H::findOrFail($id);

        if ($form->form_15_upload) {
            Storage::disk('public')->delete($form->form_15_upload);
        }
        $form->delete();

        return redirect()->route('form15g15h.index')->with('success', 'Form deleted successfully!');
    }
    private function generateFinancialYears($years = 9)
    {
        $options = [];
        $currentYear = now()->year;

        for ($i = 0; $i < $years; $i++) {
            $start = $currentYear - $i;
            $end = $start + 1;
            $label = "FY {$start} - {$end}";
            $value = "FY {$start}-{$end}";
            $options[$label] = $value;
        }
        return $options;
    }
}
