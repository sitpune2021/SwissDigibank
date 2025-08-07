<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Form15G15H;
use App\Models\Promotor;

use Illuminate\Support\Facades\Storage;

class Form15Gor15HController extends Controller
{
    public function index()
    {
        $form15g15hs = Form15G15H::latest()->get(); 
        return view("members.form15g15h.index", compact('form15g15hs'));
    }

   public function create()
{
    $dynamicOptions = [
        'member' => Member::pluck('member_info_first_name', 'id'),
        'promoter' => Promotor::pluck('first_name', 'id'),
        'financial_year' => $this->generateFinancialYears()
    ];

    $sections = config('form15g15h_form');
    $route = route('form15g15h.store');
    $method = 'POST';

    return view('members.form15g15h.create', compact('sections', 'route', 'method', 'dynamicOptions'));
}
   public function store(Request $request)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
         'promotor_id' => 'required|exists:promotors,id',
        'financial_year' => 'required|string|max:20',
        'form_15_upload' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ]);

    if ($request->hasFile('form_15_upload')) {
        $path = $request->file('form_15_upload')->store('uploads', 'public');
        $validated['form_15_upload'] = $path;
    }

    Form15G15H::create($validated);

    return redirect()->route('form15g15h.index')->with('success', 'Form submitted successfully!');
}


    public function show(string $id)
    {
        $form15g15h = Form15G15H::findOrFail($id);

        // $dynamicOptions = [
        //     'member' => Member::pluck('member_info_first_name', 'id')
        // ];
        // $sections = config('form15g15h_form');
        // $show = true;
        // $method = 'PUT';
        // return view('members.form15g15h.create', compact('form15g15h', 'sections', 'dynamicOptions', 'method', 'show'));

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
