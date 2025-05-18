@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')

<div class="col-xxl">
    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
                <h4 class="mb-0">All Customer</h4>
                <a href="{{ route('customers.create') }}"class="btn btn-primary mt-4 mb-3 px-4">Add New Customer</a>
            </div>
            @csrf
            <table class="table table-bordered" style="width: 100%;">
                <div class="table-responsive">
                    <div class="col-md-6">
                        <tr>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 10%;">Mobile Number</th>
                        <th style="width: 10%;">City</th>
                            <!-- <th>Country</th>
                            <th>Postal</th> -->
                        <th style="width: 20%;">Organization</th>
                        <!-- <th style="width: 10%;">Dob</th>
                        <th style="width: 10%;">Anniversary Date</th> -->
                        <th style="width: 5%;">Status</th>
                        <th style="width: 5%;">Action</th>
                        </tr>
                        @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->mobile_number }}</td>    
                            <td>{{ $customer->city->city_name  ?? '' }}</td>
                            <!-- <td>{{ $customer->country }}</td> -->
                            <!-- <td>{{ $customer->postal }}</td> -->
                            <td>{{ $customer->organization }}</td>
                            <!-- <td>{{ $customer->dob ?? 'N/A' }}</td>
                            <td>{{ $customer->anniversary_date ?? 'N/A' }}</td> -->
                            <td>{{ $customer->is_active == 1 ? 'Active' : "In-Active" }}</td>
                            <td>
                            <a href="{{ route('customers.edit', $customer->id) }}" title="Edit"><i class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></i></a>
                                
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                 
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')" style="background: none; border: none; padding: 0;" title="Delete">
                                        <i class="bx bx-trash text-danger" style="font-size: 1.2rem;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </div>
                </div>
            </table>
        </div>
    </div>
</div>

@endsection