<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCartRequest;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;
    // 利用 Laravel 的自动解析功能注入 CartService 类
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(AddCartRequest $request)
    {
        $this->cartService->add($request->input('sku_id'), $request->input('amount'));

        return [];
    }

    public function index(Request $request)
    {
        //拿到当前登录对象的模型
        $cartItems = $this->cartService->get();
        //拿到登录对象的地址
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        return view('cart.index', ['cartItems' => $cartItems,'addresses' => $addresses]);
    }

    public function remove(ProductSku $sku, Request $request)
    {
        $this->cartService->remove($sku->id);
        return [];
    }
}
