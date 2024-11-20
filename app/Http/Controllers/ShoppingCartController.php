<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function checkLocalAvailablity(int $localCartSize):bool{
        return $localCartSize != 0;
    }
    private function checkServerAvailablity(int $userId):JsonResponse{
        try{
            $result = DB::table('shopping_carts_tbl')->where('user_id', $userId)->where('status', 'processing')->first();
            if ($result) return response()->json(['success' => true, 'data'=> $result]);
            return response()->json(['success' => false]);
        }catch (Exception $exception){
            return response()->json(['success'=> false,'exception'=>$exception->getMessage()]);
        }
    }
    private function fetchDBCart(int $userId):JsonResponse{
        $result = $this->checkServerAvailablity($userId);
        if ($result->getData()->success){
            $user = User::where('id', $userId)
                ->whereHas('shoppingCarts', function ($query) {
                    $query->where('status', 'processing');
                })
                ->with(['shoppingCarts.products'])
                ->first();

            $products = $user->shoppingCarts->flatMap(function ($shoppingCart) {
                return $shoppingCart->products;
            });
            return response()->json(['success'=>true,'data'=>$products]);
        }
        return response()->json(['success'=>'false']);
    }
    private function serverSideProductAdding(int $userId, int $productId):JsonResponse{
        $serverAvailability = $this->checkServerAvailablity($userId)->getData()->success;
        if ($serverAvailability){
            try{
                $shoppingCart = ShoppingCart::where('user_id', $userId)->where('status', 'processing')->first();
                $productAddition = $shoppingCart->products()->attach($productId);
                return response()->json(['success'=>true,'message'=>'محصول با موفقیت به سبد خرید اضافه شد']);
            }catch (Exception $exception){
                return response()->json(['success'=>false,'message'=>'محصول به سبد خرید اضافه نشد','exception'=>$exception->getMessage()]);
            }
        }
        else return $this->checkServerAvailablity($userId);
    }
    private function serverCartCreating($userId):JsonResponse{
        try{
            $shopping_cart = DB::table('shopping_carts_tbl')->insert(['user_id'=>$userId,'status'=>'processing']);
            if($shopping_cart) return response()->json(['success'=>true,'message'=>'سبد خرید با موفقیت ساخته شد','data'=>$shopping_cart]);
            return response()->json(['success'=>false,'message'=>'سبد خرید ایجاد نشد']);
        }catch (Exception $exception){
            return response()->json(['success'=>false,'message'=>'سبد خرید ایجاد نشد','exception'=>$exception]);
        }
    }

    public function addProductToShoppingCart(int $localCartSize,int $userId, int $productId):JsonResponse{
        $localCartAvailable = $this->checkLocalAvailablity($localCartSize);
        $serverCartAvailable = $this->checkServerAvailablity($userId)->getData()->success;
        $result = $this->serverSideProductAdding($userId,$productId);
        $dbCart = $this->fetchDBCart($userId);
        if (!$localCartAvailable) {
            if($serverCartAvailable){
                if($result->getData()->success) return response()->json(['success'=>true,'message'=>$result->getData()->message,'products'=>$dbCart->getData()->data]);
                else return response()->json($result->getData());
            }else{
                $serverCartCreation = $this->serverCartCreating($userId)->getData()->success;
                if ($serverCartCreation){
                    $result = $this->serverSideProductAdding($userId,$productId);
                    $dbCart = $this->fetchDBCart($userId);
                    return response()->json(['success'=>true,'message'=>'محصول موفقیت به سبد خرید اضافه شد', 'products'=>$dbCart->getData()->data]);
                }
            }
        }else{
            $this->serverSideProductAdding($userId,$productId);
            $this->fetchDBCart($userId);
            return response()->json(['success'=>true,'message'=>'محصول موفقیت به سبد خرید اضافه شد', 'products'=>$dbCart->getData()->data]);
        }
    }
    public function showShoppingCart(int $localCartSize,int $userId):JsonResponse{
        $localCartAvailable = $this->checkLocalAvailablity($localCartSize);
        $serverCartAvailable = $this->checkServerAvailablity($userId)->getData()->success;
        if($localCartAvailable){
            $dbCart = $this->fetchDBCart($userId);
            if (!$dbCart->getData()->success) return response()->json(['success'=>true,'message'=>'سبد خرید شما خالی است']);
            return response()->json(['success'=>true,'data'=>$dbCart->getData()]);
        }else{
            if ($serverCartAvailable){
                $dbCart = $this->fetchDBCart($userId);
                return response()->json(['success'=>true,'data'=>$dbCart->getData()]);
            }else return response()->json(['success'=>true,'message'=>'سبد خرید شما خالی است']);
        }
    }
    public function index()
    {
        $localCartSize = false;
        $user = Session::get('user-id');
        $userId = User::where('id',$user)->first()->id;
        $productId = 262;

        $addProduct = $this->addProductToShoppingCart($localCartSize,$userId,$productId);
        $showShoppingCart = $this->showShoppingCart($localCartSize,$userId);

//        return $addProduct;
        return $showShoppingCart;


    }

    /**
     * Show the form for creating a new resource.
     */
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
