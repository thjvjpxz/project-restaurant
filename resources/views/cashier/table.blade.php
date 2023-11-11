@extends('cashier.layouts.app')

@section('title_page', 'Index')

@section('content')
  <div class="row justify-content-center">
    @foreach ($tables as $table)
      <div class="col-md-2 mt-3">
        <form action="{{ route('cashier.ordertable') }}" method="POST">
          @csrf
          <label>
            <input type="text" hidden="hidden" value="{{ $table->id }}" name="name">
          </label>
          <button type="submit" class="btn btn-primary">
            <img src="{{ asset('/table.png') }}" class="img-fluid" alt="">
            @if ($table->status == 'available')
              <span class="badge text-bg-success fs-5">{{ $table->name }}</span>
            @else
              <span class="badge text-bg-danger fs-5">{{ $table->name }}</span>
            @endif
          </button>
        </form>
      </div>
    @endforeach
    <div class="text-center mt-3">
      <h3>Vui lòng chọn 1 bàn</h3>
    </div>
    <nav class="mt-3 d-flex justify-content-center">
      {{ $tables->links('pagination::bootstrap-4') }}
    </nav>
  </div>
@endsection
