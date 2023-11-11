<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\Table;

class CashierController extends Controller
{
    public function index()
    {
        //
        return view('cashier.table', ['tables' => Table::latest()->paginate(5)]);
    }

    public function orderTable(Request $request)
    {
        //            return $request->input('name');
        $table_id = $request->input('name');
        $table = Table::where('id', $table_id)->first();
        $html = $this->getOrderDetailsByTable($table_id);
        return view('cashier.index', ['table' => $table, 'categories' => Category::all(), 'html' => $html]);
        //            dd($orderDetails);
    }

    public function getCategoryById(Request $request)
    {
        $category_id = $request->category_id;
        $dishes = Dish::where('category_id', $category_id)->get();
        $html = '';
        foreach ($dishes as $dish) {
            $html .=
                '<div class="col-md-3 text-center">
                        <a class="btn btn-outline-secondary btn-menu" style="width: 100%" data-id="' . $dish->id . '">
                        <img src="' . $dish->getImageURL() . '" style="height: 5rem" alt="" class="img-fluid">
                        <br>
                        ' . $dish->name . '
                        <br>$
                        ' . number_format($dish->price) . '
                        </a>
                    </div>';
        }
        return $html;
    }

    public function getTables()
    {
        $tables = Table::all();
        $html = '';
        foreach ($tables as $table) {
            $html .= '<div class="col-md-2 mb-4">';
            $html .=
                '<button type="submit" class="btn btn-primary btn-table" data-id="' . $table->id . '" data-name="' . $table->name . '">
                    <img src="' . asset('storage/images/default_table.png') . '" class="img-fluid" alt="">
                    <br>';
            if ($table->status == "available") {
                $html .= '<span class="badge text-bg-success fs-5">' . $table->name . '</span>';
            } else {
                $html .= '<span class="badge text-bg-danger fs-5">' . $table->name . '</span>';
            }

            $html .= '</button>';
            $html .= '</div>';
        }
        return $html;
    }

    public function order(Request $request)
    {
        $dish = Dish::find($request->dish_id);
        $table_id = $request->table_id;
        $order = Order::where('table_id', $table_id)->where('order_status', 'unpaid')->first();
        // return $order;
        // if there is no order for the selected table, create a new order record
        if (!$order) {
            $order = new Order();
            $order->table_id = $table_id;
            $order->save();
            $order_id = $order->id;

            // Update table status
            $table = Table::find($table_id);
            $table->status = 'unavailable';
            $table->save();
        } else {
            $order_id = $order->id;
        }
        $orderDetail = OrderDetail::where('order_id', $order_id)->where('dish_id', $dish->id)->where('status', 'noConfirm')->first();
        if (!$orderDetail) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order_id;
            $orderDetail->dish_id = $dish->id;
            $orderDetail->quantity = $request->quantity;
            $orderDetail->save();
        } else {
            $orderDetail->quantity = ++$orderDetail->quantity;
            $orderDetail->save();
        }
        $orderDetails = OrderDetail::where('order_id', $order_id)->get();
        $total = 0;
        foreach ($orderDetails as $orderDetail) {
            $total += $orderDetail->quantity * $orderDetail->dish->price;
        }
        // // update total price in the orders table
        $order->total_price = $total;
        $order->save();


        return $this->getOrderDetails($order_id);

    }

    private function getOrderDetailsByTable($table_id)
    {
        $order = Order::where('table_id', $table_id)->where('order_status', 'unpaid')->first();
        $html = '';
        if ($order) {
            $order_id = $order->id;
            $html .= $this->getOrderDetails($order_id);
        } else {
            $html .= "Chưa có món ăn nào cho bàn này";
        }
        return $html;
    }

    private function getOrderDetails($order_id)
    {
        // List all order detail
        $html = '';
        $orderDetails = OrderDetail::where('order_id', $order_id)->get();
        $html .=
            '<div class="table-responsive-md" style="overflow-y: scroll; height: 200px; border: 1px solid #343A40">
                <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Món ăn</th>
                        <th scope="col">SL</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Tổng</th>
                        <th scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>';
        $showBtnPayment = true;
        foreach ($orderDetails as $orderDetail) {
            $html .= '
                    <tr>
                        <td>' . $orderDetail->dish->id . '</td>
                        <td>' . $orderDetail->dish->name . '</td>
                        <td>  
                            <input style="width:50px" min="1" class="rounded ps-2 quantity_edit" data-id="' . $orderDetail->id . '" type="number" value="' . $orderDetail->quantity . '"';
            if ($orderDetail->status == 'noConfirm') {
                $showBtnPayment = false;
            }
            else {
                $html .= 'readonly';
            }
            $html .= '>    
                        </td>
                        <td>' . $orderDetail->dish->price . '</td>
                        <td class="edit_price">' . $orderDetail->dish->price * $orderDetail->quantity . '</td>';
            if (!$showBtnPayment) {
                $html .= '<td><button data-id="' . $orderDetail->id . '" class="btn btn-danger btn-delete-orderdetail"><i class="bi bi-trash"></i></button></td>';
            } else { // status == 'confirm'
                $html .= '<td><i class="bi bi-check-circle"></i></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';

        $order = Order::find($order_id);
        $html .= '<hr>';
        $html .= '<h3 class="text-end edit_price_amount">Total Amount: $' . number_format($order->total_price) . '</h3>';

        if ($showBtnPayment) {
            $html .= '<button data-id="' . $order_id . '" class="btn btn-success btn-payment w-100">Payment</button>';
        } else {
            $html .= '<button data-id="' . $order_id . '" class="btn btn-warning btn-confirm-order w-100">Confirm Order</button>
            ';
        }

        return $html;
    }

    public function editQuantity(Request $request)
    {
        $orderDetail_id = $request->orderDetail_id;
        $quantity = $request->quantity;
        $orderDetail = OrderDetail::find($orderDetail_id);
        $orderDetail->quantity = $quantity;
        $orderDetail->save();
        $orderDetails = OrderDetail::where('order_id', $orderDetail->order_id)->get();
        $total = 0;
        foreach ($orderDetails as $orderDetail) {
            $total += $orderDetail->quantity * $orderDetail->dish->price;
        }
        // return $total;
        $order = Order::find($orderDetail->order_id);
        $order->total_price = $total;
        $order->save();
        // return $this->getOrderDetails($orderDetail->order_id);
        $arr_price = [];
        foreach ($orderDetails as $orderDetail) {
            $arr_price[] = [
                'price' => $orderDetail->quantity * $orderDetail->dish->price,
                'total' => $order->total_price
            ];
        }

        return $arr_price;
    }

    public function confirmOrderStatus(Request $request)
    {
        $order_id = $request->order_id;
        $orderDetails = OrderDetail::where('order_id', $order_id)->update(['status' => 'confirm']);
        return $this->getOrderDetails($order_id);
    }

    public function deleteOrderDetail(Request $request)
    {
        $orderDetail_id = $request->orderDetail_id;
        $orderDetail = OrderDetail::find($orderDetail_id);
        $order_id = $orderDetail->order->id;
        $dish_price = ($orderDetail->dish->price * $orderDetail->quantity);
        $orderDetail->delete();
        // update total price
        $order = Order::find($order_id);
        $order->total_price = $order->total_price - $dish_price;
        $order->save();
        // check if there any orderDetail having the order id
        $orderDetails = OrderDetail::where('order_id', $order_id)->first();
        if ($orderDetails) {
            $html = $this->getOrderDetails($order_id);
        } else {
            $html = "Chưa có món ăn nào cho bàn này";
            $table_id = $order->table_id;
            $table = Table::where('id', $table_id)->update(['status' => 'available']);
            $order->delete();
        }
        return $html;
    }

    public function payment(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);

        if (!$order) {
            return 'Order not found';
        }

        $order->order_status = 'paid';
        $order->save();

        $table_id = $order->table_id;
        $table = Table::find($table_id);

        if (!$table) {
            return 'Table not found';
        }

        $table->status = 'available';
        $table->save();

        return '<h1>Payment Successful</h1>';
    }

}