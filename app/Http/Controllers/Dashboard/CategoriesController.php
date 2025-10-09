<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $request->input('name');
//        $request->post('name');
//        $request->query('name');
//        $request->get('name');
//        $request->name;
//        $request['name'];

        //request merge
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('uploads',['disk' => 'public']);
            $data['image'] = $path;
        }

        //mass assignment
        $category = Category::create($data);
        //PRG
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category= Category::findOrFail($id);
        $parents = Category::where('id' , '<>', $id)
            ->where(function ($query) use ($id){
                $query->orwhere('parent_id' , '<>', $id);
            })->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category= Category::find($id);

        $old_image = $category->image;
        $data = $request->except('image');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('uploads',['disk' => 'public']);
            $data['image'] = $path;
        }

        $category->update($data);

        if ($old_image && isset($data['image'])){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        $category = Category::findOrFail($id);
//        $category->delete();

        //==
        //Category::where('id', '=', $id)->delete();
        //==
        Category::destroy($id);

        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted!');
    }
}
