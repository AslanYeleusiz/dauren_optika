<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lenses;
use App\Models\LensTypes;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Requests\Admin\LensSaveRequest;
use Inertia\Inertia;

class LensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $type_id = $request->type_id;
        $lenses = Lenses::with(['lens_type'])->latest('id')
            ->when($name, fn($q)=>$q->where('name', 'like', "%$name%"))
            ->when($type_id, fn($q)=>$q->where('type_id', $type_id))
        ->paginate($request->input('per_page', 20))
        ->appends($request->except('page'));
        $types = LensTypes::get();
        return Inertia::render('Admin/lenses/Index', [
            'lenses' => $lenses,
            'types' => $types,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = LensTypes::orderBy('name')->get();
        return Inertia::render('Admin/lenses/Create', [
            'types' => $types,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LensSaveRequest $request)
    {
        $file_path = FileService::saveFile($request->img, Lenses::IMAGE_PATH);
        Lenses::create([
            'name' => $request->name,
            'type_id' => $request->type_id,
            'img' => $file_path,
            'value' => $request->value,
            'description' => $request->description,
            'dpt' => $request->dpt,
            'price' => $request->price,
        ]);
        return redirect()->route('admin.lenses.index')->withSuccess('Успешно добавлено');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lenses  $lenses
     * @return \Illuminate\Http\Response
     */
    public function show(Lenses $lenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lenses  $lenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Lenses $lens)
    {
        $types = LensTypes::orderBy('name')->get();
        return Inertia::render('Admin/lenses/Edit', [
            'lens' => $lens,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lenses  $lenses
     * @return \Illuminate\Http\Response
     */
    public function update(LensSaveRequest $request, $id)
    {
        $file_path = $request->img;
        if($request->newImg){
            FileService::deleteFile($file_path, Lenses::IMAGE_PATH);
            $file_path = FileService::saveFile($request->newImg, Lenses::IMAGE_PATH);
        }
        Lenses::findOrFail($id)->update([
            'name' => $request->name,
            'type_id' => $request->type_id,
            'img' => $file_path,
            'value' => $request->value,
            'description' => $request->description,
            'dpt' => $request->dpt,
            'price' => $request->price,
        ]);
        return redirect()->back()->withSuccess('Успешно сохранено');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lenses  $lenses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lens = Lenses::findOrFail($id);
        FileService::deleteFile($lens->img, Lenses::IMAGE_PATH);
        $lens->delete();
        return redirect()->back()->withSuccess('Успешно удалено');
    }
}
