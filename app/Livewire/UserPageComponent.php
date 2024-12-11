<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Livewire\Component;

class UserPageComponent extends Component
{

    public $models;
    public $categories;
    public $categoriesSort;
    public $selectedCategoryId = null;
    public $activeCart = false;
    public function mount()
    {
        $this->models = Food::all();
        $this->categories = Category::orderBy('sort', 'asc')->get();
        $this->categoriesSort = Category::orderBy('sort', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.user-page-component')->layout('components.layouts.user');
    }

    public function categoryFilter($categoryId)
    {
        if ($categoryId != '') {
            $this->models = Food::where('category_id', $categoryId)->get();
            $this->categories = Category::where('id', $categoryId)->get();
            $this->selectedCategoryId = $categoryId;
        } else {
            $this->categories = Category::orderBy('sort', 'asc')->get();
            $this->models = Food::all();
            $this->selectedCategoryId = null;
        }
        $this->activeCart = false;
    }

    public function addCart(Food $food)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$food->id])) {
            $cart[$food->id]['quantity']++;
        } else {
            $cart[$food->id] = [
                'food_id' => $food->id,
                'name' => $food->name,
                'image' => $food->image,
                'price' => $food->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        // dd(session('cart'));
        // session()->forget('cart');
    }

    public function plus(Food $food)
    {
        $cart = session('cart');

        if (isset($cart[$food->id])) {
            $cart[$food->id]['quantity']++;
            $cart[$food->id]['price'] += $food->price;

        }
        session()->put('cart', $cart);
    }
    public function minus(Food $food)
    {
        $cart = session('cart');

        if (isset($cart[$food->id])) {
            if ($cart[$food->id]['quantity'] > 0) {
                $cart[$food->id]['quantity']--;
                $cart[$food->id]['price'] -= $food->price;

            }
            if ($cart[$food->id]['quantity'] == 0) {
                unset($cart[$food->id]);
                session(['cart' => $cart]);
            }
        }
        session()->put('cart', $cart);
    }
    public function removeItem(Food $food)
    {

        if (session()->has('cart')) {
            $cart = session('cart');


            if (array_key_exists($food->id, $cart)) {

                unset($cart[$food->id]);
                session(['cart' => $cart]);
            }
        }
    }

    public function toggleCart()
    {
        $this->activeCart = !$this->activeCart;
    }
    public function isInCart($foodId)
    {
        return session()->has('cart') && in_array($foodId, session('cart'));
    }

    public function order()
    {
        $cart = session('cart');

        $queue = Order::where('date', Carbon::today()->format('Y-m-d'))->count() + 1;
        $summ = collect(session('cart'))->sum('price');
        $order = Order::create(
            [
                'date' => Carbon::today()->format('Y-m-d'),
                'queue' => $queue,
                'summ' => $summ,
            ]
        );
        foreach ($cart as $id => $item) {
            OrderItem::create(
                [
                    'order_id' => $order->id,
                    'food_id' => $item['food_id'],
                    'count' => $item['quantity'],
                    'total_price' => $item['price'],
                ]
            );
        }
        session()->forget('cart');
    }
}
