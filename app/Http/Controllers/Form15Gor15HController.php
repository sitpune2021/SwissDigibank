<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Form15G15H;
use App\Models\Promotor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Form15Gor15HController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            $query = Form15G15H::with(['member', 'promotor'])->latest();

            if ($request->has('search')) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('financial_year', 'like', "%$search%")
                        ->orWhereHas('member', function ($memberQuery) use ($search) {
                            $memberQuery->where('member_no', 'like', "%$search%")
                                ->orWhere('member_info_first_name', 'like', "%$search%");
                        })
                        ->orWhereHas('promotor', function ($promotorQuery) use ($search) {
                            $promotorQuery->where('first_name', 'like', "%$search%");
                        });
                });
            }

            $form15g15hs = $query->paginate($perPage)->appends($request->all());

            return view('members.form15g15h.index', compact('form15g15hs'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            Log::error('Form15G15H index error', ['error' => $e->getMessage()]);
            abort(500, 'Unexpected error while fetching Form 15G/15H records');
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
            Log::info('Form15G15H Update Request Received', [
                'form_id' => $id,
                'payload' => $request->all()
            ]);

            $form15g15h = Form15G15H::findOrFail($id);

            $validated = $request->validate([
                'financial_year' => 'required|string|max:20',
                'member_id'      => 'nullable|exists:members,id',
                'promotor_id'    => 'nullable|exists:promotors,id',
                'form_15_upload' => 'nullable|file|mimes:pdf,jpg,png|max:2048',



            ]);

            // ✅ Safe check for missing keys
            $memberId = $validated['member_id']   ?? $form15g15h->member_id;
            $promotorId = $validated['promotor_id'] ?? $form15g15h->promotor_id;

            if (!$memberId && !$promotorId) {
                Log::warning('Form15G15H Update Validation Failed - Missing Relation', [
                    'form_id' => $id,
                    'validated_data' => $validated
                ]);
                return back()->withErrors(['relation' => 'Either member or promoter must be selected.'])->withInput();
            }

            // ✅ Handle file upload
            if ($request->hasFile('form_15_upload')) {
                Log::info('Form15G15H File Upload Detected', [
                    'form_id' => $id,
                    'old_file' => $form15g15h->form_15_upload
                ]);

                if ($form15g15h->form_15_upload) {
                    Storage::disk('public')->delete($form15g15h->form_15_upload);
                    Log::info('Old file deleted successfully', ['file' => $form15g15h->form_15_upload]);
                }

                $path = $request->file('form_15_upload')->store('uploads', 'public');
                $validated['form_15_upload'] = $path;

                Log::info('New file uploaded successfully', [
                    'form_id' => $id,
                    'file_path' => $path
                ]);
            }

            $form15g15h->update($validated);

            Log::info('Form15G15H Updated Successfully', [
                'form_id' => $form15g15h->id,
                'updated_data' => $validated
            ]);

            return redirect()->route('form15g15h.index')->with('success', 'Form updated successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Form15G15H Update Failed - Not Found', [
                'form_id' => $id,
                'error_message' => $e->getMessage()
            ]);
            abort(404);
        } catch (\Exception $e) {
            Log::error('Form15G15H Update Failed - Exception', [
                'form_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to update form: ' . $e->getMessage());
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
    public function download($member_id)
    {
        $form = Form15G15H::where('member_id', $member_id)->latest()->first();

        if (!$form || !$form->form_15_upload) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = $form->form_15_upload;

        if (Storage::disk('public')->exists($filePath)) {
            $fullPath = Storage::disk('public')->path($filePath);
            return response()->download($fullPath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }
    public function downloadByPromoter($promoter_id)
    {
        $form = Form15G15H::where('promotor_id', $promoter_id)->latest()->first();

        if (!$form || !$form->form_15_upload) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = $form->form_15_upload;

        if (Storage::disk('public')->exists($filePath)) {
            $fullPath = Storage::disk('public')->path($filePath);
            return response()->download($fullPath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }
}
