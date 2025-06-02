<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SparePart;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spareParts = SparePart::latest()->paginate(10);
        return view('admin.spareparts.index', compact('spareParts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.spareparts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer',
            'status' => 'required|in:available,unavailable',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('spareparts', 'public');
        }
        SparePart::create($validated);
        return redirect()->route('admin.spareparts.index')->with('success', 'تمت إضافة القطعة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SparePart $sparepart)
    {
        return view('admin.spareparts.edit', compact('sparepart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SparePart $sparepart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer',
            'status' => 'required|in:available,unavailable',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('spareparts', 'public');
        }
        $sparepart->update($validated);
        return redirect()->route('admin.spareparts.index')->with('success', 'تم تحديث القطعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SparePart $sparepart)
    {
        $sparepart->delete();
        return redirect()->route('admin.spareparts.index')->with('success', 'تم حذف القطعة بنجاح');
    }
}
