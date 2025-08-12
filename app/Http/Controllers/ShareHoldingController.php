<?php

namespace App\Http\Controllers;

use App\Models\Shareholding;
use App\Models\Promotor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class ShareHoldingController extends Controller
{
    public function index(Request $request)
    {
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
            return [$item->id => 'DEMO-' .$item->folio_no . " - ". $item->first_name];
        }),
];

        $share_holdings = $query->with('promotor')->orderBy('created_at', 'desc')->paginate(10);

         $promoters = Promotor::all();
        return view('company.share-holdings.manage-shareholding', compact('share_holdings','promoters'));

    }

    public function create()
    {
        $shareholding = null;
        $route = route('shareholding.store');
        $formFields = config('share_form');
        $method = 'POST';
        $isAdd = true;
        $nominal_value = 10.00;
        $dynamicOptions = [
            'promoter' => Promotor::pluck('first_name', 'id')
        ];
        return view('company.share-holdings.add-shares', compact('shareholding', 'route', 'method', 'isAdd', 'nominal_value', 'formFields', 'dynamicOptions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'promotor_id'             => 'required|exists:promotors,id',
            'allotment_date'       => 'required',
            'first_share'          => 'required|numeric',
            'share_no'           => 'required|numeric|gt:first_share',
            'nominal_value'        => 'nullable|numeric',
            'total_share_held'     => 'required|numeric',
            'total_share_value'    => 'required|numeric',
            'certificate_no'       => 'nullable|string|max:50',
            'transaction_date'     => 'required',
            'amount'               => 'required|numeric',
            'remarks'              => 'nullable|string|max:255',
            'pay_mode'             => 'required|in:cash,online_tr,cheque,saving_ac',
        ]);

        $overlap = Shareholding::where(function ($query) use ($validated) {
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
        $data = $request->all();
        $data['certificate_no'] = '2000230233';
        Shareholding::create($data);
        return redirect()->route('shareholding.index')->with('success', 'Shareholding allocated successfully.');
    }

    public function show($id)
    {
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
    }
    public function edit($id)
    {
        $decryptedId = base64_decode($id);
        $shareholding = Shareholding::findOrFail($decryptedId);
        $route = route('shareholding.update', $decryptedId);
        $formFields = config('share_form');
        $method = 'PUT';
        $dynamicOptions = [
            'promoter' => Promotor::pluck('first_name', 'id')
        ];
        return view('company.share-holdings.add-shares', compact('shareholding', 'route', 'method', 'formFields', 'dynamicOptions'));
        // return view('branch.add-branch', compact('branch', 'states'));
    }
    public function update(Request $request, $id)
    {
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
    }

   public function IsTransforror(Request $request)
    {
        $decryptedId = $request->input('is_transfer'); // assuming field name is 'is_transfer'

        \DB::transaction(function () use ($decryptedId) {
            Promotor::query()->update(['is_transfer' => false]);

            $shareholding = Promotor::findOrFail($decryptedId);
            $shareholding->update(['is_transfer' => true]);
        });

        return redirect()->route('shareholding.index')
            ->with('success', 'Shareholding updated. Only one marked as transferred.');
    }


}
