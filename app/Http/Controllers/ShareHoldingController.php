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

            $share_holdings = $query->with('promotor')->orderBy('created_at', 'desc')->paginate(25);
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
            $nominal_value = 10.00; $formFieldsConfig = config('share_form');
            // $banks = Bank::select('id', 'name')->get();
$banks = Bank::pluck('name', 'id');

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
        Log::info('Shareholding@store called', ['request' => $request->all()]);

        try {
            // 1️⃣ Validation
            $validated = $request->validate([
                'promotor_id'       => 'required|exists:promotors,id',
                'allotment_date'    => 'required',
                'first_share' => 'required|numeric|min:1|max:50000',
                'share_no'    => 'required|numeric|gt:first_share|min:1|max:50000',
                'nominal_value'     => 'nullable|numeric',
                'total_share_held'  => 'required|numeric',
                'total_share_value' => 'required|numeric',
                'certificate_no'    => 'nullable|string|max:50',
                'transaction_date'  => 'required',
                'amount'            => 'required|numeric',
                'remarks'           => 'nullable|string|max:255',
                'pay_mode'          => 'required|in:cash,online_tr,cheque,saving_ac',

                // Online Transfer
                'transfer_date'     => 'required_if:pay_mode,online_tr|nullable|date',
                'utr_no'            => 'required_if:pay_mode,online_tr|nullable|string|max:255',
                'transfer_mode'     => 'required_if:pay_mode,online_tr|nullable|in:IMPS,VPA,NEFT/RTGS',

                // Cheque
                // 'bank_name'           => 'required_if:pay_mode,cheque|nullable|exists:banks,id',
                 'bank_id'           => 'required_if:pay_mode,cheque|nullable|exists:banks,id',
                'cheque_no'         => 'required_if:pay_mode,cheque|nullable|string|max:255',
                'cheque_date'       => 'required_if:pay_mode,cheque|date',

                // Saving Account
                'saving_account_id' => 'required_if:pay_mode,saving_ac|nullable|exists:accounts,id',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            // 2️⃣ Check overlapping shares
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

            $bank = null;

if ($request->pay_mode === 'cheque' && $request->bank_id) {
    $bank = Bank::find($request->bank_id);
}
            // 3️⃣ Prepare data for insert
            $data = [
                'promotor_id'       => $request->promotor_id,
                'allotment_date'    => $request->allotment_date ? \Carbon\Carbon::parse($request->allotment_date)->format('Y-m-d') : null,
                'first_share'       => $request->first_share,
                'share_no'          => $request->share_no,
                'nominal_value'     => $request->nominal_value,
                'total_share_held'  => $request->total_share_held,
                'total_share_value' => $request->total_share_value,
                'certificate_no'    => $request->certificate_no ?? '2000230233',
                'transaction_date'  => $request->transaction_date ? \Carbon\Carbon::parse($request->transaction_date)->format('Y-m-d') : null,
                'amount'            => $request->amount,
                'remarks'           => $request->remarks,
                'pay_mode'          => $request->pay_mode,
                'transfer_date'     => $request->pay_mode === 'online_tr' && $request->transfer_date ? \Carbon\Carbon::parse($request->transfer_date)->format('Y-m-d') : null,
                'utr_no'            => $request->pay_mode === 'online_tr' ? $request->utr_no : null,
                'transfer_mode'     => $request->pay_mode === 'online_tr' ? $request->transfer_mode : null,
                // 'bank_name'           => $request->pay_mode === 'cheque' ? $request->bank_name : null,
                'bank_id'           => $bank?->id,
    'bank_name'         => $bank?->name,
                'cheque_no'         => $request->pay_mode === 'cheque' ? $request->cheque_no : null,
                'cheque_date'       => $request->pay_mode === 'cheque' && $request->cheque_date ? \Carbon\Carbon::parse($request->cheque_date)->format('Y-m-d') : null,
                'saving_account_id' => $request->pay_mode === 'saving_ac' ? $request->saving_account_id : null,
            ];

            Log::info('Final data before insert', $data);

            // 4️⃣ Insert record
            $shareholding = Shareholding::create($data);

            Log::info('Shareholding created successfully', [
                'id' => $shareholding->id,
                'data' => $shareholding->toArray()
            ]);

            return redirect()->route('shareholding.index')->with('success', 'Shareholding allocated successfully.');
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
            // $formFields = config('share_form');
            $formFields = array_filter(config('share_form'), function ($item) {
                return is_array($item) && isset($item['name']);
            });
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
$formFields = array_filter(config('share_form'), function ($item) {
                return is_array($item) && isset($item['name']);
            });            $method = 'PUT';
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
