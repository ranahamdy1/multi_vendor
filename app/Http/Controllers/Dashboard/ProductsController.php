<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $products = Product::paginate();
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
        $user = Auth::user();
        if($user->store_id){
            $products =Product::where('store_id','=',$user->store_id)->findOrFail($id);
        }else{
            $products = Product::findOrFail($id);
        }
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
