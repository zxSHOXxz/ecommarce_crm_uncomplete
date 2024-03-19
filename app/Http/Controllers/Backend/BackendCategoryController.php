<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class BackendCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cover' => 'nullable'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        if ($request->hasFile('cover')) {
            $cover = $category->addMedia($request->cover)->toMediaCollection('cover');
            $category->update(['cover' => $cover->id . '/' . $cover->file_name]);
        }

        toastr()->success('Done Added Category', 'Succesfully');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'cover' => 'nullable'
        ]);

        $category->update([
            'name' => $category->name
        ]);

        if ($request->hasFile('cover')) {
            $cover = $category->addMedia($request->cover)->toMediaCollection('cover');
            $category->update(['cover' => $cover->id . '/' . $cover->file_name]);
        }

        toastr()->success('Done Added Category', 'Succesfully');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // if (!auth()->user()->can('category-delete')) abort(403);
        $category->delete();
        toastr()->success('Category deleted successfully', 'The operation is successful');
        return redirect()->route('admin.categories.index');
    }
}
