<?php

namespace App\Http\Controllers;

use App\Models\Shareholding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        return view('share-holdings.manage-shareholding', compact('share_holdings'));
    }
    
    public function create()
    {
        $shareholding = null;
        $route = route('add.shareholding');
        $method = 'POST';
        $isAdd = true;
        $nominal_value=10.00;
        return view('share-holdings.add-shares', compact('shareholding', 'route', 'method', 'isAdd','nominal_value'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'promoter'             => 'required|exists:promotors,id',
            'allotment_date'       => 'required|date',
            'first_share'          => 'required|numeric',
            'share_no'           => 'required|numeric|gte:first_share',
            'share_nominal'        => 'nullable|numeric',
            'total_share_held'     => 'required|numeric',
            'total_share_value'    => 'required|numeric',
            'certificate_no'       => 'nullable|string|max:50',
            'transaction_date'     => 'required|date',
            'amount'               => 'required|numeric',
            'remarks'              => 'nullable|string|max:255',
            'pay_mode'             => 'required|in:cash,online_tr,cheque,saving_ac',
        ]);
        $shareholding = new Shareholding();
        $shareholding->promoter        = $validated['promoter'];
        $shareholding->allotment_date      = date('Y-m-d', strtotime($request->allotment_date));
        $shareholding->first_share      = $validated['first_share'];
        $shareholding->share_no       = $validated['share_no'];
        $shareholding->nominal_value = 10;
        $shareholding->total_share_held    = $validated['total_share_held'];
        $shareholding->total_share_value   = $validated['total_share_value'];
        $shareholding->transaction_date    = date('Y-m-d', strtotime($request->transaction_date));
        $shareholding->amount              = $validated['amount'];
        $shareholding->pay_mode            = $validated['pay_mode'];
        $shareholding->remarks             = $validated['remarks'] ?? null;
        $shareholding->certificate_no      = '2000230233';

        $shareholding->save();

        return redirect()->route('manage.shareholding')->with('success', 'Shareholding allocated successfully.');
    }

    public function show($id)
    {
        $decryptedId = base64_decode($id);
        $shareholding = Shareholding::findOrFail($decryptedId);
        $show = true;
        return view('share-holdings.add-shares', compact('shareholding', 'show'));
    }
    public function edit($id)
    {
        $decryptedId = base64_decode($id);
        $shareholding = Shareholding::findOrFail($decryptedId);
        $route = route('shareholding.update', $decryptedId);
        $method = 'PUT';
        return view('share-holdings.add-shares', compact('shareholding', 'route', 'method'));
        // return view('branch.add-branch', compact('branch', 'states'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'promoter'           => 'required|exists:promotors,id',
            'allotment_date'     => 'required|date',
            'first_share'        => 'required|numeric',
            'last_share'           => 'required|numeric|gte:first_share',
            'share_nominal'      => 'nullable|numeric',
            'total_share_held'   => 'required|numeric',
            'total_share_value'  => 'required|numeric',
            'transaction_date'   => 'required|date',
            'amount'             => 'required|numeric',
            'pay_mode'           => 'required|in:cash,online_tr,cheque,saving_ac',
            'remarks'            => 'nullable|string',
        ]);

        $shareholding = new Shareholding();
        $shareholding->promoter        = $validated['promoter'];
        $shareholding->allotment_date      = date('Y-m-d', strtotime($request->allotment_date));
        $shareholding->first_share      = $validated['first_share'];
        $shareholding->share_no       = $validated['last_share'];
        $shareholding->nominal_value = 10;
        $shareholding->total_share_held    = $validated['total_share_held'];
        $shareholding->total_share_value   = $validated['total_share_value'];
        $shareholding->transaction_date    = date('Y-m-d', strtotime($request->transaction_date));
        $shareholding->amount              = $validated['amount'];
        $shareholding->pay_mode            = $validated['pay_mode'];
        $shareholding->remarks             = $validated['remarks'] ?? null;
        $shareholding->certificate_no      = '2000230233';

        $shareholding->save();

        return redirect()->route('manage.shareholding')->with('success', 'Shareholding allocated successfully.');
    }
}
