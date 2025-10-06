<?php

namespace App\Http\Controllers;

use App\Models\Shareholding;
use App\Models\Promotor;
use App\Models\Account;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ShareHoldingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Shareholding::query();
            if ($request->has('search')) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    // Search in shareholding table fields
                    $q->where('first_share', 'like', "%$search%")
                        ->orWhere('share_no', 'like', "%$search%")
                        ->orWhere('total_share_held', 'like', "%$search%")
                        ->orWhere('nominal_value', 'like', "%$search%")
                        ->orWhere('total_share_value', 'like', "%$search%");
                })
                    ->orWhereHas('promotor', function ($q) use ($search) {
                        // Search in related promoter table
                        $q->where('first_name', 'like', "%$search%");
                    });
            }
            $dynamicOptions = [
                'promoter' => Promotor::select('id', 'folio_no', 'first_name')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [$item->id => '' . $item->folio_no . " - " . $item->first_name];
                    }),
            ];

            $share_holdings = $query->with('promotor')->orderBy('created_at', 'desc')->paginate(10);
            $transfoer = Promotor::where('is_transfer', true)->first();
            return view('company.share-holdings.manage-shareholding', compact('share_holdings', 'dynamicOptions', 'transfoer'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function create()
    {
        try {
            $shareholding = null;
            $route = route('shareholding.store');
            $formFields = config('share_form');
            $method = 'POST';
            $isAdd = true;
            $nominal_value = 10.00;
            $formFieldsConfig = config('share_form');
            $banks = Bank::select('id', 'name')->get();

            $formFields = [];

            foreach ($formFieldsConfig as $key => $field) {
                if (isset($field['name'])) {
                    $formFields[] = $field; // normal field
                } elseif (is_array($field)) {
                    // nested fields (online_tr, cheque, saving_ac)
                    foreach ($field as $nestedField) {
                        $formFields[] = $nestedField;
                    }
                }
            }
            $dynamicOptions = [
                'promoter' => Promotor::pluck('first_name', 'id'),
                'savingAccounts' => Account::pluck('account_no', 'id'), // ✅ key=id, value=account_no


            ];
            return view('company.share-holdings.add-shares', compact('shareholding', 'route', 'method', 'isAdd', 'nominal_value', 'formFields', 'banks', 'dynamicOptions', 'formFields'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        Log::info('Shareholding@store called', ['request' => $request->all()]);

        try {
            $validated = $request->validate([
                'promotor_id'             => 'required|exists:promotors,id',
                'allotment_date'          => 'required',
                'first_share'             => 'required|numeric',
                'share_no'                => 'required|numeric|gt:first_share',
                'nominal_value'           => 'nullable|numeric',
                'total_share_held'        => 'required|numeric',
                'total_share_value'       => 'required|numeric',
                'certificate_no'          => 'nullable|string|max:50',
                'transaction_date'        => 'required',
                'amount'                  => 'required|numeric',
                'remarks'                 => 'nullable|string|max:255',
                'pay_mode'                => 'required|in:cash,online_tr,cheque,saving_ac',

                // Online Transfer
                'transfer_date'           => 'required_if:pay_mode,online_tr|nullable|date',
                'utr_no'                  => 'required_if:pay_mode,online_tr|nullable|string|max:255',
                'transfer_mode'           => 'required_if:pay_mode,online_tr|nullable|in:IMPS,VPA,NEFT/RTGS',

                // Cheque
                'bank_id' => 'required_if:pay_mode,cheque|nullable|exists:banks,id',
                'cheque_no'               => 'required_if:pay_mode,cheque|nullable|string|max:255',
                'cheque_date'             => 'required_if:pay_mode,cheque|date',

                // Saving Account
                'saving_account_id'       => 'required_if:pay_mode,saving_ac|nullable|exists:accounts,id',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // Check for overlapping shares
            $overlap = Shareholding::where(function ($query) use ($validated) {
                $query->whereBetween('first_share', [$validated['first_share'], $validated['share_no']])
                    ->orWhereBetween('share_no', [$validated['first_share'], $validated['share_no']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('first_share', '<', $validated['first_share'])
                            ->where('share_no', '>', $validated['share_no']);
                    });
            })->exists();

            if ($overlap) {
                Log::warning('Share overlap detected', [
                    'first_share' => $validated['first_share'],
                    'share_no' => $validated['share_no']
                ]);
                throw ValidationException::withMessages([
                    'first_share' => ['This share already allocated.'],
                    'share_no'    => ['This share already allocated.'],
                ]);
            }

            // Convert and prepare data
            $data = $request->all();

            // ✅ Fix date formats (DB expects Y-m-d)
            $data['allotment_date']   = \Carbon\Carbon::createFromFormat('d-m-Y', $request->allotment_date)->format('Y-m-d');
            $data['transaction_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $request->transaction_date)->format('Y-m-d');

            if ($request->pay_mode === 'online_tr' && !empty($request->transfer_date)) {
                $data['transfer_date'] = \Carbon\Carbon::parse($request->transfer_date)->format('Y-m-d');
            }

            if ($request->pay_mode === 'cheque' && !empty($request->cheque_date)) {
                $data['cheque_date'] = \Carbon\Carbon::parse($request->cheque_date)->format('Y-m-d');
            }

            // Optional: auto-generate certificate number
            $data['certificate_no'] = $data['certificate_no'] ?? '2000230233';

            Log::info('Final data before insert', $data);

            Shareholding::create($data);

            Log::info('Shareholding created successfully', ['shareholding_data' => $data]);

            return redirect()->route('shareholding.index')->with('success', 'Shareholding allocated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Model not found', ['error' => $e->getMessage()]);
            abort(404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error in Shareholding@store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong. Check logs for details.']);
        }
    }


    public function show($id)
    {
        try {
            $decryptedId = base64_decode($id);
            $shareholding = Shareholding::findOrFail($decryptedId);
            $show = true;
            $formFields = config('share_form');
            $route = '';
            $method = '';
            $dynamicOptions = [
                'promoter' => Promotor::pluck('first_name', 'id')
            ];
            return view('company.share-holdings.add-shares', compact('shareholding', 'show', 'formFields', 'route', 'method', 'dynamicOptions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function edit($id)
    {
        try {
            $decryptedId = base64_decode($id);
            $shareholding = Shareholding::findOrFail($decryptedId);
            $route = route('shareholding.update', $decryptedId);
            $formFields = config('share_form');
            $method = 'PUT';
            $dynamicOptions = [
                'promoter' => Promotor::pluck('first_name', 'id')
            ];
            return view('company.share-holdings.add-shares', compact('shareholding', 'route', 'method', 'formFields', 'dynamicOptions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
        // return view('branch.add-branch', compact('branch', 'states'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'promotor_id'             => 'required|exists:promotors,id',
                'allotment_date'       => 'required',
                'first_share'          => 'required|numeric',
                'share_no'           => 'required|numeric|gt:first_share',
                'share_nominal'        => 'nullable|numeric',
                'total_share_held'     => 'required|numeric',
                'total_share_value'    => 'required|numeric',
                'certificate_no'       => 'nullable|string|max:50',
            ]);

            $overlap = Shareholding::where('id', '!=', $id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('first_share', [$validated['first_share'], $validated['share_no']])
                        ->orWhereBetween('share_no', [$validated['first_share'], $validated['share_no']])
                        ->orWhere(function ($q) use ($validated) {
                            $q->where('first_share', '<', $validated['first_share'])
                                ->where('share_no', '>', $validated['share_no']);
                        });
                })->exists();

            if ($overlap) {
                throw ValidationException::withMessages([
                    'first_share' => ['This share already allocated.'],
                    'share_no' => ['This share already allocated.'],
                ]);
            }

            $shareholding = Shareholding::findOrFail($id);
            $shareholding->update($request->all());

            return redirect()->route('shareholding.index')->with('success', 'Shareholding allocated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function IsTransforror(Request $request)
    {
        try {
            $decryptedId = $request->input('is_transfer'); // assuming field name is 'is_transfer'

            DB::transaction(function () use ($decryptedId) {
                Promotor::query()->update(['is_transfer' => false]);

                $shareholding = Promotor::findOrFail($decryptedId);
                $shareholding->update(['is_transfer' => true]);
            });

            return redirect()->route('shareholding.index')
                ->with('success', 'Shareholding updated. Only one marked as transferred.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
}
