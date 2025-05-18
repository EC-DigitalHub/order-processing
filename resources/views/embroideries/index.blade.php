@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
<div class="card mb-6">
<div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
    <h4 class="mb-0">Embroidery List</h4>
    <a href="{{ route('embroideries.create') }}" class="btn btn-primary mt-4 mb-3 px-4">Add Embroidery</a>
</div>
@csrf
<br>
<table class="table mt-3">
<thead>
    <tr>
            <th>id</th>
            <th>Embroidery Name</th>
            <th>Additional Cost</th>
            <th>Base Price</th>
            <th>Status</th>
            <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($embroideries as $embroidery)
    <tr>
        <td>{{ $embroidery->id }}</td>
        <td>{{ $embroidery ->embroidery_name }}</td>
        <td>{{ $embroidery->additional_cost }}</td>
        <td>{{ $embroidery->base_price }}</td>
        <td>{{ $embroidery->status == 'Y' ? 'Active' : "In-Active" }}</td>
            <td>
             <a href="{{ route('embroideries.edit', $embroidery->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                
                <form action="{{ route('embroideries.destroy', $embroidery->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this embroidery?')" style="background: none; border: none; padding: 0;" title="Delete">
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