@extends('admin.layouts.app')

@section('title_page', 'Tables Management')
@section('content')
    <div>
        <h1 class="text-center">List of tables</h1>
        <div class="mb-2 d-flex justify-content-end"><a href="{{ route('tables.create') }}" class="btn btn-primary">Add table</a></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Table name</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tables as $table)
                    <tr>
                        <th class="text-center col-md-2">{{ $table->id }}</th>
                        <td>{{ $table->name }}</td>
                        <td class="text-center col-md-2"><a href="{{ route('tables.edit', compact('table')) }}"><i class="bi bi-pencil"></i></a></td>
                        <td class="text-center col-md-2">
                            <a href="" data-bs-toggle="modal" data-bs-target="#i{{ $table->id }}"><i class="bi bi-trash"></i></a>

                            <!-- Modal -->
                            <div class="modal fade" id="i{{ $table->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm delete</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Do you want delete: <span class="text-danger fw-bold">{{ $table->name }}</span> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                                            <form action="{{ route('tables.destroy', compact('table')) }}" method="POST">
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
            {{ $tables->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endsection
