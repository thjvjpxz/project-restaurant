@extends('admin.layouts.app')
@section('title')
  @if (isset($category))
    Edit
  @else
    Add
  @endif
@endsection
@section('content')
  <h1 class="mb-2 text-center">{{ isset($category) ? 'Edit category' : 'Add new category' }}</h1>
  <form action="{{ isset($category) ? route('categories.update', ['category' => $category]) : route('categories.store') }}"
    method="POST">
    @csrf
    @isset($category)
      @method('PUT')
    @endisset
    <div>
      <label class="form-label" for="name">Category Name:</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $category->name ?? old('name') }}">
      @error('name')
        <span class="text-danger">{{ $message }}<span>
          @enderror
    </div>

    <div class="d-flex justify-content-center gap-3 mt-2">
      <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
      <button type="submit" class="btn btn-success">{{ isset($category) ? 'Save' : 'Add' }}</button>
    </div>
  </form>
@endsection
