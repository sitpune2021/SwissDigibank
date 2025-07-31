<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Form15G15H;
use Illuminate\Support\Facades\Storage;

class Form15Gor15HController extends Controller
{
    // Show all records
    public function index()
    {
        $form15g15hs = Form15G15H::with('member')->orderBy('created_at', 'desc')->get();
        return view("members.form15g15h.index", compact('form15g15hs'));
    }

    // Show form to create new entry
    public function create()
    {
        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id')
        ];
        $sections = config('form15g15h_form');
        $route = route('form15g15h.store');
        $method = 'POST';

        return view('members.form15g15h.create', compact('sections', 'route', 'method', 'dynamicOptions'));
    }

    // Store the uploaded form and data
   public function store(Request $request)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id',
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


    // Show the details of a record
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

    // Edit record
    public function edit(string $id)
    {
        $form15g15h = Form15G15H::findOrFail($id);

        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id')
        ];
        $sections = config('form15g15h_form');
        $route = route('form15g15h.update', $id);
        $method = 'PUT';

        // return view('form15g15h.create', compact('form15g15h', 'sections', 'route', 'method', 'dynamicOptions'));
        return view('members.form15g15h.create', compact('form15g15h', 'sections', 'route', 'method', 'dynamicOptions'));

    }

    // Update the record
    public function update(Request $request, string $id)
    {
        $form15g15h = Form15G15H::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'financial_year' => 'required|string|max:20',
            'form_15_upload' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($request->hasFile('form_15_upload')) {
            // Delete old file if exists
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
}
