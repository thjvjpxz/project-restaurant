@extends('cashier.layouts.app')

@section('title_page', 'Index')

@section('content')
    <div class="row mt-3 px-5">
        <div>
            <a href="{{ route('cashier.index') }}" class="btn btn-secondary">Quay lại chọn bàn</a>
        </div>
        <div class="col-md-5">
            <h1 class="text-center">Đơn hàng</h1>
            <hr>
            <div id="selected-table" data-id="{{ $table->id }}">Số bàn: {{ $table->name }}</div>
            <div id="order-detail" class="mt-2">
                {!! $html !!}
            </div>
        </div>
        <div class="col-md-7">
            <h1 class="text-center">Gọi món</h1>
            <hr>
            <div class="row">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row gap-4 mt-3 justify-content-end" id="list-menu"></div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            var category_id = $('#category').val();
            $.ajax({
                type: "POST",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "category_id": category_id
                },
                url: "/cashier/ordertable/category",
                success: function(data) {
                    $("#list-menu").html(data);
                }
            });
            $("#category").change(function() {
                var category_id = $(this).val();
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "category_id": category_id
                    },
                    url: "/cashier/ordertable/category",
                    success: function(data) {

                        $("#list-menu").html(data);
                    }
                });
            });

            // When clicking on the dish
            $("#list-menu").on("click", ".btn-menu", function() {
                var dish_id = $(this).data('id');
                var table_id = $("#selected-table").data('id');
                // alert(table_id);
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "dish_id": dish_id,
                        "table_id": table_id,
                        "quantity": 1
                    },
                    url: "/cashier/order",
                    success: function(data) {
                        $("#order-detail").html(data);
                        // location.reload();
                        // console.log(data);
                    }
                });
            });

            // delete order detail
            $("#order-detail").on('click', ".btn-delete-orderdetail", function() {
                var orderDetailId = $(this).data('id');
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "orderDetail_id": orderDetailId
                    },
                    url: "/cashier/deleteOrderDetail",
                    success: function(data) {
                        $("#order-detail").html(data);
                    }
                });
            });

            $("#order-detail").on('click', ".btn-confirm-order", function() {
                var orderId = $(this).data("id");
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "order_id": orderId
                    },
                    url: "/cashier/confirmOrderStatus",
                    success: function(data) {
                        $("#order-detail").html(data);
                    }
                });
            });

            $("#order-detail").on('click', '.btn-payment', function() {
                var order_id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "order_id": order_id
                    },
                    url: "/cashier/payment",
                    success: function(data) {
                        $("#order-detail").html(data);
                    }
                });
            });

            $(".quantity_edit").on('input', function() {
                var orderDetail_id = $(this).data('id');
                var quantity = $(this).val();
                $.ajax({
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "orderDetail_id": orderDetail_id,
                        "quantity": quantity
                    },
                    url: "/cashier/ordertable/editQuantity",
                    success: function(data) {
                        for (let i = 0; i < data.length; i++) {
                            $('.edit_price').eq(i).html(data[i]['price']);
                        }
                        $(".edit_price_amount").html('Total Amount: $' + data[0]['total']);
                    }
                });
            });
        });
    </script>
@endsection
