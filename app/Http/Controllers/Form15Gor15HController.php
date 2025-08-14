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
        try {
            $form15g15hs = Form15G15H::latest()->get();
            return view('members.form15g15h.index', compact('form15g15hs'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function create(Request $request)
    {
        try {
            $memberId = $request->member_id ?? session('member_id');
            $type = $request->type ?? session('type');

            $dynamicOptions = [
                'member' => Member::pluck('member_info_first_name', 'id'),
                'promoter' => Promotor::pluck('first_name', 'id'),
                'financial_year' => $this->generateFinancialYears()
            ];

        $sections = config('form15G15H_form');
        $route = route('form15g15h.store');
        $method = 'POST';
           
           
           


            return view('members.form15g15h.create', compact(
                'sections',
                'route',
                'method',
                'dynamicOptions',
                'memberId',
                'type'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function store(Request $request)
    {
        try {
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

            // Fixing data fields
            $validated['member_id'] = $type === 'member' ? $request->member_id : null;
            $validated['promotor_id'] = $type === 'promoter' ? $request->promotor_id : null;

            // File upload
            if ($request->hasFile('form_15_upload')) {
                $path = $request->file('form_15_upload')->store('uploads', 'public');
                $validated['form_15_upload'] = $path;
            }

            Form15G15H::create($validated);

            // Conditional redirect
            if ($type === 'member') {
                return redirect()->route('member.show', $validated['member_id'])
                    ->with('success', 'Form 15G/15H submitted successfully.');
            } else {
                return redirect()->route('promotor.show', base64_encode($validated['promotor_id']))
                    ->with('success', 'Form 15G/15H submitted successfully.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function show(string $id)
    {
        try {
            $form15g15h = Form15G15H::findOrFail($id);
            return view('members.form15g15h.show', compact('form15g15h'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function edit(string $id)
    {
        try {
            $form15g15h = Form15G15H::findOrFail($id);

            $dynamicOptions = [
                'member' => Member::pluck('member_info_first_name', 'id'),
                'promoter' => Promotor::pluck('first_name', 'id'),
                'financial_year' => $this->generateFinancialYears()
            ];

        
       
       
        
            $sections = config('form15G15H_form');
            $route = route('form15g15h.update', $id);
            $method = 'PUT';
            $type = $form15g15h->member_id ? 'member' : 'promoter';

            return view('members.form15g15h.create', compact(
                'form15g15h',
                'sections',
                'route',
                'method',
                'type',
                'dynamicOptions'
            ));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function update(Request $request, string $id)
    {
        try {
            $form15g15h = Form15G15H::findOrFail($id);

            $validated = $request->validate([
                'financial_year' => 'required|string|max:20',
                'member_id' => 'nullable|exists:members,id',
                'promotor_id' => 'nullable|exists:promotors,id',
                'form_15_upload' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            ]);

            // At least one of member_id or promotor_id is required
            if (!$validated['member_id'] && !$validated['promotor_id']) {
                return back()->withErrors(['relation' => 'Either member or promoter must be selected.'])->withInput();
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

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
        try {
            $options = [];
            $currentYear = now()->year;

            for ($i = 0; $i < $years; $i++) {
                $start = $currentYear - $i;
                $end = $start + 1;
                $label = "FY {$start} - {$end}";
                $value = "FY {$start}-{$end}";
                $options[$value] = $label;
            }

            return $options;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }
}
