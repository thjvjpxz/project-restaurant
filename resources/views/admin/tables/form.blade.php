@extends('admin.layouts.app')

@section('title_page', isset($table) ? 'Edit table' : 'Add table')
@section('content')
    <div class="col-md-7 mx-auto">
        <h1 class="text-center">{{ isset($table) ? 'Edit table' : 'Add table' }}</h1>
        <form action="{{ isset($table) ? route('tables.update', compact('table')) : route('tables.store') }}" class="form" method="POST">
            @csrf
            @isset($table)
                @method('PUT')
            @endisset
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $table->name ?? old('name') }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-2 d-flex justify-content-center gap-1">
                <a href="{{ route('tables.index') }}" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-success">{{ isset($table) ? 'Edit' : 'Add' }}</button>
            </div>
        </form>
    </div>
@endsection
