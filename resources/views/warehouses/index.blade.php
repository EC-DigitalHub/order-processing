@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
    <div class="card mb-6">
     <div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
        <h4 class="mt-5 ms-5 text-start">Create Warehouse</h4>
        <a href="{{ route('warehouses.create') }}" class="btn btn-primary mt-4 mb-3 px-4">Add Warehouse</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($warehouses as $warehouse)
                <tr>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->code }}</td>
                    <td>
                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this warehouse?')" style="background: none; border: none; padding: 0;" title="Delete">
                                <i class="bx bx-trash text-danger" style="font-size: 1.2rem;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
