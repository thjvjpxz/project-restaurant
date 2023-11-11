<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Table;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.orders.index', ['orders' => Order::latest()->paginate(10)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        $orderDetails = OrderDetail::where('order_id', $order->id)->get();
        $count_orderDetails = count($orderDetails);
        return view('admin.orders.show', compact('orderDetails', 'count_orderDetails', 'order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        $table_id = $order->table_id;
        $table = Table::findOrfail($table_id);
        $table->status = 'available';
        $table->save();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}