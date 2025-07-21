<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\State;
use App\Models\Promotor;

class SchemesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        // $branches = Branch::with('stateData')->orderBy('created_at', 'desc')->paginate(10);
        $query = Branch::with('stateData')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('branch_name', 'like', "%$search%")
                    ->orWhere('branch_code', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%")
                    ->orWhere('open_date', 'like', "%$search%") 
                    ->orWhereHas('stateData', function ($stateQuery) use ($search) {
                        $stateQuery->where('name', 'like', "%$search%");
                });
            });
        }

        $branches = $query->paginate(10);
        return view('schemes.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
  public function create()
    {
        $dynamicOptions = [
            'states' =>State::pluck('name', 'id'),
            'branches'=>Branch::pluck('branch_name','id')
        ];
        $sections = config('schemes_form');
        $schemes = null;
        $route = route('schemes.store');
        $method = 'POST';
        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method', 'dynamicOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
    {
        $dynamicOptions = [
            'states' =>State::pluck('name', 'id'),
             'branches'=>Branch::pluck('branch_name','id')

        ];
        $sections = config('schemes_form');
        $show = true;
        $schemes = Promotor::findOrFail($id);
      
        return view('schemes.add-edit', compact('sections', 'schemes', 'show','dynamicOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $dynamicOptions = [
            'states' =>State::pluck('name', 'id'),
           'branches'=>Branch::pluck('branch_name','id')

        ];
        $sections = config('schemes_form');
        $schemes = Promotor::findOrFail($id);
        $route = route('schemes.update',$id);
        $method = 'PUT';
        return view('schemes.add-edit', compact('sections', 'schemes', 'route', 'method', 'dynamicOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
