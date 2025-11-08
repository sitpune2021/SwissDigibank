<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;
use App\Models\Rank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdvisorController extends Controller
{

    // Rank Structure 

        public function index()
        {
            $ranks = Rank::all();
            return view('associates-advisor.rank-structure.index', compact('ranks'));
        }

        public function add_new_rank()
        {
            return view('associates-advisor.rank-structure.add-new-rank');
        }

        public function store_new_rank(Request $request)
        {
            try {

                // VALIDATION
                $data = $request->validate([
                    'name' => 'required|string|max:191|unique:ranks,name',
                    'display_position' => 'nullable|integer|min:1',
                    'working_position' => 'nullable|integer|min:1',
                    'collection_commission' => 'required|in:1,0',
                ], [
                    'name.required' => 'Rank Name is required.',
                    'name.unique' => 'This rank name already exists.',
                    'collection_commission.required' => 'Please choose collection commission option.',
                ]);

                // NORMALIZE DATA
                $data['display_position'] = $data['display_position'] ?? null;
                $data['working_position'] = $data['working_position'] ?? null;
                $data['collection_commission'] = (int) $data['collection_commission'];
                $data['created_by'] = Auth::id() ?? null;

                // CREATE RANK
                $rank = Rank::create($data);

                // SUCCESS LOG
                Log::info('Rank created successfully.', [
                    'rank_id' => $rank->id,
                    'created_by' => Auth::id(),
                    'payload' => $data
                ]);

                return redirect()->route('associates-advisor.rank-structure.index')
                    ->with('success', 'Rank created successfully.');

            } catch (\Throwable $e) {

                // ERROR LOG (stores full error trace)
                Log::error('Error while creating rank.', [
                    'error_message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'payload' => $request->all(),
                    'user_id' => Auth::id(),
                ]);

                return redirect()->back()
                    ->with('error', 'Something went wrong while creating the rank.')
                    ->withInput();
            }
        }

        public function view_rank($id)
        {
            $rank = Rank::findOrFail($id);

            return view('associates-advisor.rank-structure.view', compact('rank'));
        }

        public function edit_rank($id)
        {
            $rank = Rank::findOrFail($id);
            return view('associates-advisor.rank-structure.add-new-rank', compact('rank'));
        }

        public function update_rank(Request $request, $id)
        {
            try {
                $request->validate([
                    'name' => 'required',
                    'display_position' => 'required',
                    'working_position' => 'required',
                    'collection_commission' => 'required'
                ]);

                $rank = Rank::findOrFail($id);
                $rank->update($request->all());

                return redirect()
                    ->route('associates-advisor.rank-structure.index')
                    ->with('success', 'Rank Updated Successfully');

            } catch (\Exception $e) {

                // Log error
                Log::error('Rank Update Error: '.$e->getMessage(), [
                    'rank_id' => $id,
                    'input_data' => $request->all(),
                    'user_id' => Auth::id(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                return back()
                    ->with('error', 'Something went wrong while updating rank. Please try again.');
            }
        }

    
    // Associates/ Advisors
        public function add_adc_asc()
        {
            return view('associates-advisor.associates-advisors.add');
        }
        public function adv_index()
        {
            return view('associates-advisor.associates-advisors.index');
        }
        public function adv_view()
        {
            return view('associates-advisor.associates-advisors.view');
        }
        public function change_photo()
        {
            return view('associates-advisor.associates-advisors.change-photo');
        }
        public function link_saving_account()
        {
            return view('associates-advisor.associates-advisors.link-saving-account');
        }
        public function reset_password()
        {
            return view('associates-advisor.associates-advisors.reset-password');
        }


    // Commission Payouts 
        public function commission_index()
        {
            return view('associates-advisor.commission-payout.index');
        }

        public function new_com_pay()
        {
            return view('associates-advisor.commission-payout.new-com-pay');
        }

        public function com_view()
        {
            return view('associates-advisor.commission-payout.view');
        }

        public function multiple_payout()
        {
            return view('associates-advisor.commission-payout.multiple-payout');
        }

        public function regenerate_com()
        {
            return view('associates-advisor.commission-payout.regenerate-com');
        }

        public function remove_payout_com()
        {
            return view('associates-advisor.commission-payout.remove-payout-com');
        }


    // Commission Chart 
        public function commission_charts_index()
        {
            return view('associates-advisor.commission-charts.index');
        }
        public function add_chart()
        {
            return view('associates-advisor.commission-charts.add-chart');
        }
        public function comission_view()
        {
            return view('associates-advisor.commission-charts.view');
        }
  


}
