@extends('admin.layouts.app')
@section('title', 'Index')
@section('content')
  <h1 class="text-center">List of category</h1>
  <div class="mb-2 d-flex justify-content-end">
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add category</a>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th>Name</th>
        <th class="text-center">Edit</th>
        <th class="text-center">Delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
        <tr>
          <th class="text-center">{{ $category->id }}</th>
          <td>{{ $category->name }}</td>
          <td class="text-center"><a href="{{ route('categories.edit', compact('category')) }}"><i
                class="bi bi-pencil"></i></a></td>
          <td class="text-center">
            <a href="" data-bs-toggle="modal" data-bs-target="#i{{ $category->id }}"><i
                class="bi bi-trash"></i></a>

            <!-- Modal -->
            <div class="modal fade" id="i{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Do you want delete category: <span class="text-danger fw-bold">{{ $category->name }}</span> ?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                    <form action="{{ route('categories.destroy', compact('category')) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-primary">OK</button>
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
  <nav>
    {{$categories->links('pagination::bootstrap-4')}}
  </nav>
@endsection
