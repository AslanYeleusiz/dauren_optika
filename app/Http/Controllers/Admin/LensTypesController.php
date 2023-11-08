<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LensTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\Admin\LensTypesSaveRequest;

class LensTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = LensTypes::latest('id')
            ->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/lensTypes/Index', [
            'lensTypes' => $types,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/lensTypes/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LensTypesSaveRequest $request)
    {
        LensTypes::create([
            'name' => $request->name
        ]);
        return redirect()->route('admin.lensTypes.index')->withSuccess('Успешно добавлено');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LensTypes  $lensTypes
     * @return \Illuminate\Http\Response
     */
    public function show(LensTypes $lensTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LensTypes  $lensTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(LensTypes $lensType)
    {
        return Inertia::render('Admin/lensTypes/Edit', [
            'lensType' => $lensType,
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LensTypes  $lensTypes
     * @return \Illuminate\Http\Response
     */
    public function update(LensTypesSaveRequest $request, LensTypes $lensTypes)
    {
        $lensTypes->update([
            'name' => $request->name
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LensTypes  $lensTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LensTypes::
        findOrFail($id)
        ->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
        
    }
}
