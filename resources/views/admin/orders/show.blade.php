@extends('admin.layouts.app')

@section('title_page', 'Order details')
@section('content')
  <div class="row">
    <h1 class="text-center">List of Order details</h1>
    <div class="col-md-10 mx-auto">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Order id</th>
            <th>Table number</th>
            <th>Dish</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Created at</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @php
              $order_id = -1;
              $table_id = -1;
              foreach ($orderDetails as $orderDetail) {
                  $order_id = $orderDetail->order_id;
                  $table_id = $orderDetail->order->table_id;
                  break;
              }
            @endphp
            <td rowspan="{{ $count_orderDetails }}" class="text-center" style="vertical-align: middle">
              {{ $order_id }}</td>
            <td rowspan="{{ $count_orderDetails }}" class="text-center" style="vertical-align: middle">
              {{ $table_id }}</td>
            @foreach ($orderDetails as $orderDetail)
              <td>{{ $orderDetail->dish->name }}</td>
              <td>{{ $orderDetail->quantity }}</td>
              <td>{{ $orderDetail->status }}</td>
              <td>{{ $orderDetail->created_at->diffForHumans() }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-end gap-3">
        @if ($order->order_status === 'unpaid')
          <a href="" class="btn btn-danger " data-bs-toggle="modal"
            data-bs-target="#i{{ $order->id }}">Delete</a>

          <!-- Modal -->
          <div class="modal fade" id="i{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Do you want delete order ?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                  <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">OK</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endif
        <a href="{{ route('orders.index') }}" class="btn btn-secondary ">Back</a>
      </div>
    </div>
  </div>
@endsection
