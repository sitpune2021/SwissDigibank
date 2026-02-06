<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class NoticeBoardController extends Controller
{

    public function index()
    {
        $notices = Notice::with('branch')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notice-boards.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('notice-boards.create', compact('branches'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'branch_id' => 'required|exists:branches,id',
    //         'notice_title' => 'required|string|max:255',
    //         'notice_body' => 'required|string',
    //         'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date',
    //         'app_type' => 'required|in:Admin App,Agent App,Both App',
    //     ]);
    //     $data = $request->all();

    //      // Handle image upload
    //     if ($request->hasFile('images')) {
    //         $data['images'] = $request->file('images')->store('notices', 'public');

    //     }
    //     // Convert dates to Y-m-d format for database
    //     $data['start_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
    //     $data['end_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

    //     // Insert into database
    //     Notice::create($data);
    //     return redirect()->route('notice-boards.index')->with('success', 'Notice added successfully!');
    // }

    /**
     * Display the specified resource.
     */

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'notice_title' => 'required|string|max:255',
            'notice_body' => 'required|string',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'app_type' => 'required|in:Admin App,Agent App,Both App',
        ]);

        try {
            $data = $request->all();

            // ✅ STORE LOGGED-IN USER ID
            $data['created_by'] = auth()->id();

            // Handle image upload
            // if ($request->hasFile('images')) {
            //     $data['images'] = $request->file('images')->store('notices', 'public');
            // }
            if ($request->hasFile('images')) {
                $image = $request->file('images');

                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('assets/images/notices'), $imageName);

                // Save path in DB
                $data['images'] = 'assets/images/notices/' . $imageName;
            }


            // Convert dates to Y-m-d format for database
            $data['start_date'] = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $data['end_date'] = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

            // Insert into database
            $notice = Notice::create($data);

            // Log success
            Log::info('Notice created successfully', ['notice_id' => $notice->id, 'user_id' => auth()->id() ?? null]);

            // Redirect with success message
            return redirect()->route('notice-boards.index')->with('success', 'Notice added successfully!');

        } catch (\Exception $e) {
            // Log the error
            Log::error('Notice creation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id() ?? null,
                'request_data' => $request->all()
            ]);

            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Notice submission failed! Please try again.');
        }
    }
    public function show($notice_board)
    {

        //  $id = base64_decode($notice_board);
        // $notice_board->load(['branch', 'user']);

        $id = base64_decode($notice_board);

        if (!is_numeric($id)) {
            abort(404);
        }

        $notice_board = Notice::with(['branch', 'user'])->findOrFail($id);

        return view('notice-boards.show', compact('notice_board'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = base64_decode($id);
        $notice = Notice::findOrFail($id);
        $branches = Branch::all(); // For dropdown

        return view('notice-boards.create', compact('notice', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'notice_title' => 'required|string|max:255',
            'notice_body' => 'required|string',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'app_type' => 'required|in:Admin App,Agent App,Both App',
        ]);

        try {
            $notice = Notice::findOrFail($id);
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/images/notices'), $imageName);
                $data['images'] = 'assets/images/notices/' . $imageName;
            } else {
                // Keep old image if not changed
                $data['images'] = $notice->images;
            }

            // Convert dates
            $data['start_date'] = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $data['end_date'] = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

            $notice->update($data);

            // Log successful update
            Log::info('Notice updated successfully', [
                'notice_id' => $notice->id,
                'user_id' => auth()->id() ?? null,
                'updated_data' => $data
            ]);

            return redirect()->route('notice-boards.index')->with('success', 'Notice updated successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Notice update failed', [
                'notice_id' => $id,
                'user_id' => auth()->id() ?? null,
                'error_message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
