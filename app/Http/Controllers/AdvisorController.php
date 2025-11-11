<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;
use App\Models\Rank;
use App\Models\CommissionChart;
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
            $rank = null;
            return view('associates-advisor.rank-structure.add-new-rank', compact('rank'));
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
            $charts = CommissionChart::orderBy('id', 'DESC')->get();
            return view('associates-advisor.commission-charts.index', compact('charts'));
        }

        public function add_chart()
        {
            // prepare rank list (as you had in UI). Change titles as needed.
            $rankData = [
                1  => "Field Head Officer",
                2  => "Field Officer",
                3  => "Relationship Manager",
                4  => "Relationship Manager",
                5  => "Area Relationship Manager",
                6  => "Regional Relationship Manager",
                7  => "Field Manager",
                8  => "Field Associate",
                9  => "Field Executive",
                10 => "Sales Officer",
                11 => "Field Organizer",
                12 => "Field Associate",
                13 => "Field Officer",
                14 => "Adviser",
                15 => "Sales Manager",
                16 => "DEL Officer",
                17 => "Asst Dev Officer",
                18 => "Sales Officer",
                19 => "Asst Sales Officer",
                20 => "C Director",
                // add more if required
            ];

            // pass to view
            return view('associates-advisor.commission-charts.add-chart', compact('rankData'));
        }     
       
        // public function chartstore(Request $request)
        // {
        //     // Rank master list (same as in add_chart)
        //     $rankData = [
        //         1  => "Field Head Officer",
        //         2  => "Field Officer",
        //         3  => "Relationship Manager",
        //         4  => "Relationship Manager",
        //         5  => "Area Relationship Manager",
        //         6  => "Regional Relationship Manager",
        //         7  => "Field Manager",
        //         8  => "Field Associate",
        //         9  => "Field Executive",
        //         10 => "Sales Officer",
        //         11 => "Field Organizer",
        //         12 => "Field Associate",
        //         13 => "Field Officer",
        //         14 => "Adviser",
        //         15 => "Sales Manager",
        //         16 => "DEL Officer",
        //         17 => "Asst Dev Officer",
        //         18 => "Sales Officer",
        //         19 => "Asst Sales Officer",
        //         20 => "C Director",
        //     ];

        //     $cleanData = [];

        //     if (!empty($request->rank)) 
        //     {

        //         foreach ($request->rank as $rankNo => $months) 
        //         {

        //             if (!is_numeric($rankNo) || $rankNo <= 0) continue;

        //             // Get rank name instead of number
        //             $rankName = $rankData[$rankNo] ?? null;
        //             if (!$rankName) continue;

        //             // Check if row has any value
        //             $rowHasValue = false;
        //             foreach ($months as $v) {
        //                 if ($v !== null && $v !== "") {
        //                     $rowHasValue = true;
        //                     break;
        //                 }
        //             }

        //             if (!$rowHasValue) continue;

        //             // Clean values
        //             $cleanMonths = [];
        //             foreach ($months as $m => $v) {
        //                 $cleanMonths[$m] = ($v !== "" && $v !== null) ? $v : null;
        //             }

        //             // Store using rank name
        //             $cleanData[$rankName] = $cleanMonths;
        //         }
        //     }

        //     CommissionChart::create([
        //         'chart_name'        => $request->chart_name,
        //         'payout_type'       => $request->payout_type,
        //         'commission_type'   => $request->commission_type,
        //         'chart_type'        => $request->chart_type,
        //         'tenure_months'     => $request->tenure_months,
        //         'rank_month_values' => $cleanData, // No json_encode
        //     ]);

        //     return redirect()
        //         ->route('associates-advisor.commission-charts.index')
        //         ->with('success', 'Commission Chart Saved Successfully!');
        // }

        
        public function chartstore(Request $request)
        {
            $rankData = [
                1  => "Field Head Officer",
                2  => "Field Officer",
                3  => "Relationship Manager",
                4  => "Relationship Manager",
                5  => "Area Relationship Manager",
                6  => "Regional Relationship Manager",
                7  => "Field Manager",
                8  => "Field Associate",
                9  => "Field Executive",
                10 => "Sales Officer",
                11 => "Field Organizer",
                12 => "Field Associate",
                13 => "Field Officer",
                14 => "Adviser",
                15 => "Sales Manager",
                16 => "DEL Officer",
                17 => "Asst Dev Officer",
                18 => "Sales Officer",
                19 => "Asst Sales Officer",
                20 => "C Director",
            ];

            $cleanData = [];

            if (!empty($request->rank)) 
            {
                // foreach ($request->rank as $rankNo => $months) 
                // {
                //     // ✅ Allow "total" row and numeric rows
                //     if ($rankNo !== "total" && (!is_numeric($rankNo) || $rankNo <= 0)) {
                //         continue;
                //     }

                //     // ✅ Assign name
                //     if ($rankNo === "total") {
                //         $rankName = "TOTAL";
                //     } else {
                //         $rankName = $rankData[$rankNo] ?? null;
                //     }

                //     if (!$rankName) continue;

                //     // ✅ Check if at least one value is present
                //     $rowHasValue = false;
                //     foreach ($months as $v) {
                //         if ($v !== null && $v !== "") {
                //             $rowHasValue = true;
                //             break;
                //         }
                //     }

                //     if (!$rowHasValue) continue;

                //     // ✅ Clean values
                //     $cleanMonths = [];
                //     foreach ($months as $m => $v) {
                //         $cleanMonths[$m] = ($v !== "" && $v !== null) ? $v : null;
                //     }

                //     $cleanData[$rankName] = $cleanMonths;
                // }

                foreach ($request->rank as $rankNo => $months) 
                {
                    if ($rankNo !== "total" && (!is_numeric($rankNo) || $rankNo <= 0)) {
                        continue;
                    }

                    if ($rankNo === "total") {
                        continue; // bottom total row ignore
                    }

                    // Rank name
                    $rankName = $rankData[$rankNo] ?? null;
                    if (!$rankName) continue;

                    // Check if row has values
                    $rowHasValue = false;
                    foreach ($months as $v) {
                        if ($v !== null && $v !== "") {
                            $rowHasValue = true;
                            break;
                        }
                    }
                    if (!$rowHasValue) continue;

                    // Clean months
                    $cleanMonths = [];
                    $sum = 0;

                    foreach ($months as $m => $v) {
                        $cleanMonths[$m] = ($v !== "" && $v !== null) ? $v : null;

                        if ($v !== null && $v !== "" && is_numeric($v)) {
                            $sum += floatval($v);
                        }
                    }

                    // FINAL STRUCTURE
                    $cleanData[$rankName] = [
                        $cleanMonths,        // monthly values
                        ["total" => $sum]    // total
                    ];
                }

            }

            CommissionChart::create([
                'chart_name'        => $request->chart_name,
                'payout_type'       => $request->payout_type,
                'commission_type'   => $request->commission_type,
                'chart_type'        => $request->chart_type,
                'tenure_months'     => $request->tenure_months,
                'rank_month_values' => $cleanData,
            ]);

            return redirect()
                ->route('associates-advisor.commission-charts.index')
                ->with('success', 'Commission Chart Saved Successfully!');
        }

        public function comission_view()
        {
            return view('associates-advisor.commission-charts.view');
        }
  


}
