<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Mockery\Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::all();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $validated = $request->validate([
            'persian_title' => 'required|string|max:255',
            'english_title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products_tbl,slug',
            'product_size' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'product_introduction_text' => 'required|string',
            'consumption_guide_text' => 'required|string',
            'inventory' => 'required|integer|min:0',
            'special_offer' => 'required|boolean',
            'brand_id' => 'required|exists:brands_tbl,id',
        ]);
        try{
            Product::create($validated);
            return response()->json(['success'=>true,'message'=>'محصول با موفقیت ثبت شد'],201);
        }catch (Exception $exception){
            return response()->json(['success'=>false,'message'=>'مشکلی پیش آمد','exception'=>$exception],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
          [
              'first_name' => 'required|string|max:255',
              'last_name' => 'required|string|max:255',
              'phone_number' => 'required|string|max:15',
              'email' => 'required|email|unique:users_tbl,email',
              'national_code' => 'required|numeric|unique:users_tbl,national_code',
              'gender' => 'nullable|in:1,0',
              'birthday_date' => 'required|date|date_format:Y-m-d',
              'password'=> ['required', 'string', 'min:10', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/']
          ]

        );
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
        //
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
