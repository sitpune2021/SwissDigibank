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
                $q->where('member_no', 'like', "%$search%")
                    ->orWhere('first_name', 'like', "%$search%")
                    ->orWhere('gender', 'like', "%$search%")
                    ->orWhere('enrollment_date', 'like', "%$search%");
            });
        }
        $share_holdings = $query->with('promoters')->orderBy('created_at', 'desc')->paginate(10);
        return view('company.share-holdings.manage-shareholding', compact('share_holdings'));
    }

    public function create()
    {
        $shareholding = null;
        $route = route('shareholding.store');
        $formFields = config('share_form');
        $method = 'POST';
        $isAdd = true;
        $nominal_value=10.00;
        $dynamicOptions = [
            'promotor' => Promotor::pluck('title', 'id')
        ];
        return view('company.share-holdings.add-shares', compact('shareholding', 'route', 'method', 'isAdd','nominal_value','formFields','dynamicOptions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'promoter'             => 'required|exists:promotors,id',
            'allotment_date'       => 'required|date',
            'first_share'          => 'required|numeric',
            'share_no'           => 'required|numeric|gt:first_share',
            'share_nominal'        => 'nullable|numeric',
            'total_share_held'     => 'required|numeric',
            'total_share_value'    => 'required|numeric',
            'certificate_no'       => 'nullable|string|max:50',
            'transaction_date'     => 'required|date',
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
        $shareholding = new Shareholding();
        $shareholding->promoter        = $validated['promoter'];
        $shareholding->allotment_date      = date('Y-m-d', strtotime($request->allotment_date));
        $shareholding->first_share      = $validated['first_share'];
        $shareholding->share_no       = $validated['share_no'];
        $shareholding->nominal_value = $validated['share_nominal'];
        $shareholding->total_share_held    = $validated['total_share_held'];
        $shareholding->total_share_value   = $validated['total_share_value'];
        $shareholding->transaction_date    = date('Y-m-d', strtotime($request->transaction_date));
        $shareholding->amount              = $validated['amount'];
        $shareholding->pay_mode            = $validated['pay_mode'];
        $shareholding->remarks             = $validated['remarks'] ?? null;
        $shareholding->certificate_no      = '2000230233';

        $shareholding->save();

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
            'promotor' => Promotor::pluck('title', 'id')
        ];
        return view('company.share-holdings.add-shares', compact('shareholding', 'show','formFields','route', 'method', 'dynamicOptions'));
    }
    public function edit($id)
    {
        $decryptedId = base64_decode($id);
        $shareholding = Shareholding::findOrFail($decryptedId);
        $route = route('shareholding.update', $decryptedId);
        $formFields = config('share_form');
        $method = 'PUT';
        return view('company.share-holdings.add-shares', compact('shareholding', 'route', 'method','formFields'));
        // return view('branch.add-branch', compact('branch', 'states'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'promoter'             => 'required|exists:promotors,id',
            'allotment_date'       => 'required|date',
            'first_share'          => 'required|numeric',
            'share_no'           => 'required|numeric|gt:first_share',
            'share_nominal'        => 'nullable|numeric',
            'total_share_held'     => 'required|numeric',
            'total_share_value'    => 'required|numeric',
            'certificate_no'       => 'nullable|string|max:50',
            //  'transaction_date'     => 'required|date',
            // 'amount'               => 'required|numeric',
            //  'remarks'              => 'nullable|string|max:255',
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
        $shareholding->promoter        = $validated['promoter'];
        $shareholding->allotment_date      = date('Y-m-d', strtotime($request->allotment_date));
        $shareholding->first_share      = $validated['first_share'];
        $shareholding->share_no       = $validated['share_no'];
        $shareholding->nominal_value = $validated['share_nominal'];
        $shareholding->total_share_held    = $validated['total_share_held'];
        $shareholding->total_share_value   = $validated['total_share_value'];
        //  $shareholding->transaction_date    = date('Y-m-d', strtotime($request->transaction_date));
        // $shareholding->amount              = $validated['amount'];
        //$shareholding->pay_mode            = $validated['pay_mode'];
        //$shareholding->remarks             = $validated['remarks'] ?? null;
        $shareholding->certificate_no      = '2000230233';

        $shareholding->save();

        return redirect()->route('shareholding.index')->with('success', 'Shareholding allocated successfully.');
    }
}
