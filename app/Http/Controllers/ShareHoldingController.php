<?php

namespace App\Http\Controllers;

use App\Models\Shareholding;
use Illuminate\Http\Request;

class ShareHoldingController extends Controller
{
    public function index()
    {
        $share_holdings = Shareholding::with('promoters')->orderBy('created_at', 'desc')->paginate(10);
        return view('share-holdings.manage-shareholding', compact('share_holdings'));
    }
    public function create()
    {
        $shareholding = null;
        $route = route('add.shareholding');
        $method = 'POST';
        return view('share-holdings.add-shares', compact('shareholding', 'route', 'method'));
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
        $shareholding = Shareholding::findOrFail($id);
        $show = true;
        return view('share-holdings.add-shares', compact('shareholding', 'show'));
    }
    public function edit($id)
    {
        $shareholding = Shareholding::findOrFail($id);
        $route = route('shareholding.update', $id);
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
