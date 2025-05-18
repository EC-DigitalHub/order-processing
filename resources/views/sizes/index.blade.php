@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
<div class="card mb-6">
<div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
    <h4 class="mb-0">Sizes List</h4>
    <a href="{{ route('sizes.create') }}" class="btn btn-primary mt-4 mb-3 px-4">Add New Size</a>
</div>
@csrf
<br>
<table class="table mt-3">
<thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Code</th>
        <th>Description</th>
        <th>Base Price</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($allSizes as $size)
    <tr>
        <td>{{ $size->id }}</td>
        <td>{{ $size->name }}</td>
        <td>{{ $size->code }}</td>
        <td>{{ $size->description }}</td>
        <td>{{ $size->base_price }}</td>
        <td>{{ $size->status == 'Y' ? 'Active' : "In-Active" }}</td>
            <td>
             <a href="{{ route('sizes.edit', $size->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>

                <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this size?')" style="background: none; border: none; padding: 0;" title="Delete">
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
