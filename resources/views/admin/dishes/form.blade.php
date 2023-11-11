@extends('admin.layouts.app')

@section('title_page', isset($dish) ? 'Edit dish' : 'Add dish')
@section('content')
    <div class="col-md-7 mx-auto">
        <h1 class="text-center">{{ isset($dish) ? 'Edit dish' : 'Add dish' }}</h1>
        <form action="{{ isset($dish) ? route('dishes.update', compact('dish')) : route('dishes.store') }}" class="form" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($dish)
                @method('PUT')
            @endisset
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $dish->name ?? old('name') }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="category_id" class="form-label">Category name:</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(isset($dish) && $category->id == $dish->category_id) selected @endif>{{ $category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="text-danger">{{ $message }}<span>
                @enderror
            </div>
            <div>
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"
                >{{ $dish->description ?? old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $dish->price ?? old('price') }}">
                @error('price')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            @if(isset($dish))
                <label for="image_url" class="form-label">Image</label>
                <table class="w-100">
                    <tr>
                        <td class="col-md-2"><img src="{{ $dish->getImageURL() }}" alt="img" width="100" height="100"></td>
                        <td>
                            <input type="file" class="form-control" name="image_url" id="image_url" accept="image/png, image/jpeg, image/jpg">
                        </td>
                    </tr>
                </table>
            @else
                <div>
                    <label for="image_url" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image_url" id="image_url" accept="image/png, image/jpeg, image/jpeg">
                </div>
            @endif
            @error('image')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
            <div class="mt-2 d-flex justify-content-center gap-1">
                <a href="{{ route('dishes.index') }}" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-success">{{ isset($dish) ? 'Edit' : 'Add' }}</button>
            </div>
        </form>
    </div>
@endsection
