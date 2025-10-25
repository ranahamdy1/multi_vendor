<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
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
        $request = request();
        //$query = Category::query();
        $categories = Category::with('parent')
            /*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select(['categories.*', 'parents.name as parent_name'])*/
            //->select('categories.*')
            //->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id ) as products_count')
            ->withCount([
                'products'=>function($query){
                    $query->where('status','=','active');
                }
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();



        //$categories = Category::active()->paginate();
        //$categories = Category::status('active')->paginate();
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
        $request->validate(Category::rules(), [
            'required' => 'this field is required.',
            'unique' => 'this is the name already exists'
        ]);

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
        $data['image'] = $this->uploadImage($request);

        //mass assignment
        $category = Category::create($data);
        //PRG
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',[
            'category'=>$category
        ]);
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
    public function update(CategoryRequest $request, string $id)
    {

        $category= Category::find($id);

        $old_image = $category->image;
        $data = $request->except('image');
        $new_image = $this->uploadImage($request);
        if ($new_image){
            $data['image'] = $new_image;
        }
        $category->update($data);

        if ($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //$category = Category::findOrFail($id);
        $category->delete();

//        if ($category->image)
//        {
//            Storage::disk('public')->delete($category->image);
//        }

        //==
        //Category::where('id', '=', $id)->delete();
        //==
        //Category::destroy($id);

        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted!');
    }

    protected function uploadImage(Request $request)
    {
        if(!$request->hasFile('image')){
            return;
        }
            $file = $request->file('image');
            $path = $file->store('uploads',['disk' => 'public']);
            return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(10);

        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request,$id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category Restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image)
        {
            Storage::disk('public')->delete($category->image);
        }

        if($category->image){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category Deleted Forever!');
    }
}
