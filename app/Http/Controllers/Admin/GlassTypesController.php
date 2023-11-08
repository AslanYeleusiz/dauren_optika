<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlassTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GlassTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = GlassTypes::latest('id')
        ->paginate($request->input('per_page', 20))
        ->appends($request->except('page'));
        return Inertia::render('Admin/types/Index', [
            'types' => $types
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/types/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        GlassTypes::create([
            'name' => $request->name
        ]);
        return redirect()->route('admin.types.index')->withSuccess('Успешно добавлено');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GlassTypes  $glassTypes
     * @return \Illuminate\Http\Response
     */
    public function show(GlassTypes $glassTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GlassTypes  $glassTypes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $glassTypes = GlassTypes
        ::findOrFail($id);
        return Inertia::render('Admin/types/Edit', [
            'type' => $glassTypes
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GlassTypes  $glassTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        GlassTypes
        ::findOrFail($id)->update([
            'name' => $request->name
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GlassTypes  $glassTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GlassTypes
        ::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Успешно удалено');

    }
}
