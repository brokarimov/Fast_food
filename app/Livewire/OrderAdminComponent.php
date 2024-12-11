<?php

namespace App\Livewire;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;

class OrderAdminComponent extends Component
{
    public $orders1;
    public $orders2;
    public $orders3;
    public function mount()
    {
        $this->orders1 = Order::where('status', 1)->get();
        $this->orders2 = Order::where('status', 2)->get();
        $this->orders3 = Order::where('status', 3)->get();
    }
    public function render()
    {
        return view('livewire.order-admin-component')->layout('components.layouts.admin');
    }

    public function statusChange(int $orderId, int $foodId)
    {
        // dd(vars: $orderId);
        $order = Order::findOrFail($orderId);
        $orderItem = OrderItem::where('order_id', $orderId)->where('food_id', $foodId)->first();
        $countOfstatus2 = OrderItem::where('order_id', $order->id)->where('status', 2)->count();

        if ($orderItem->status == 1) {
            $orderItem->status = 2;
        } elseif($orderItem->status == 2) {
            $orderItem->status = 3;
            if($countOfstatus2 - 1 == 0){
                $order->status = 3;
                $order->save();
            }
        }else{
            $orderItem->status = 2;
        }
        $orderItem->save();
        $this->mount();
    }
    
    public function statusChange2(int $orderId, int $foodId)
    {
        $orderItem = OrderItem::where('order_id', $orderId)->where('food_id', $foodId)->first();
        if ($orderItem->status == 1) {
            $orderItem->status = 2;
        } elseif($orderItem->status == 2) {
            $orderItem->status = 3;
        }
        $orderItem->save();
    }

    public function orderStatusChange(Order $order)
    {
        $order->status = 2;
        $order->save();

        foreach($order->foods as $food)
        {
            $this->statusChange2($order->id,$food->id);
        }
        $this->mount();
    }
    public function orderStatusChange3(Order $order)
    {
        $order->status = 3;
        $order->save();

        foreach($order->foods as $food)
        {
            $this->statusChange2($order->id,$food->id);
        }
        $this->mount();
    }
}