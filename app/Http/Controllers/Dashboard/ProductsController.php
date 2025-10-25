<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
//        $user = Auth::user();
//        if($user->store_id){
//            $products =Product::where('store_id','=',$user->store_id)->paginate();
//        }else{
//            $products = Product::paginate();
//        }
        $products = Product::with(['category','store'])->paginate();
        return view('dashboard.products.index',compact('products'));
    }

    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit',compact('product','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('tags'));
        $tags = explode(',', $request->post('tags'));
        $tag_ids = [];
        foreach($tags as $t_name) {
            $slug = Str::slug($t_name);
            // نبحث عن التاج في الـ DB
            $tag = Tag::where('slug', $slug)->first();
            if (!$tag) {
                // إضافة تاج جديد لو مش موجود
                $tag = Tag::create([
                    'name' => trim($t_name),
                    'slug' => $slug
                ]);
            }
            $tag_ids[] = $tag->id;
        }
        // ✅ تحديث العلاقة Many-To-Many
        $product->tags()->sync($tag_ids);
        return redirect()->route('dashboard.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
