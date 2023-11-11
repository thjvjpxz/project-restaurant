@extends('admin.layouts.app')

@section('title_page', 'Dishes Management')
@section('content')
    <div class="col-md mx-auto">
        <h1 class="text-center">List of Dishes</h1>
        <div class="mb-2 d-flex justify-content-end"><a href="{{ route('dishes.create') }}" class="btn btn-primary">Add dish</a></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Dish name</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dishes as $dish)
                    <tr>
                        <th class="text-center">{{ $dish->id }}</th>
                        <td class=" col-md-2">{{ $dish->name }}</td>
                        <td class=" col-md-2">{{ $dish->category->name }}</td>
                        <td class=" col-md-3">{{ $dish->description }}</td>
                        <td class="text-center col-md-2">${{ $dish->price }}</td>
                        <td class="text-center"><img src="{{ $dish->getImageURL() }}" alt="img" width="100" height="100"></td>
                        <td class="text-center"><a href="{{ route('dishes.edit', compact('dish')) }}"><i class="bi bi-pencil"></i></a></td>
                        <td class="text-center">
                            <a href="" data-bs-toggle="modal" data-bs-target="#i{{ $dish->id }}"><i class="bi bi-trash"></i></a>

                            <!-- Modal -->
                            <div class="modal fade" id="i{{ $dish->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Do you want delete: <span class="text-danger fw-bold">{{ $dish->name }}</span> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                                            <form action="{{ route('dishes.destroy', compact('dish')) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">OK</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <nav class="d-flex justify-content-end">
            {{ $dishes->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endsection
