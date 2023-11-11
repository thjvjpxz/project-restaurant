@extends('admin.layouts.app')

@section('title_page', 'Order Management')
@section('content')
  <div>
    <h1 class="text-center">List of Orders</h1>
    <table class="table table-bordered mt-5">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th>Table name</th>
          <th>Status</th>
          <th>Created at</th>
          <th class="text-center">Detail</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
          <tr>
            <th class="text-center">{{ $order->id }}</th>
            <td>{{ $order->table->name }}</td>
            <td>{{ $order->order_status }}</td>
            <td>{{ $order->created_at->diffForHumans() }}</td>
            <td class="text-center"><a href="{{ route('orders.show', compact('order')) }}"><i class="bi bi-eye"></i></a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <nav>
    {{$orders->links('pagination::bootstrap-4')}}
  </nav>
@endsection
