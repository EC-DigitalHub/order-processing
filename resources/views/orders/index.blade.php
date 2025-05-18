@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Analytics')

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="col-xxl">
    <div class="card mb-6">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3 px-4">
            <h4 class="mb-0">Order List</h4>
            <a href="{{ route('order.create') }}" class="btn btn-primary mb-3">Add Order</a>
        </div>
@csrf

<table class="table table-bordered">
        <thead>
            <tr>
                @if(auth()->user()->role->name === 'admin')
                    <th>User</th>
                @endif
                <th width="20%">Order Number</th>
                <th width="20%">Order Date</th>
                <th width="10%">Total Amount</th> 
                <th width="10%">Payment Method</th>
                <th width="10%">Status</th>
                <th width="15%">Delivery Date</th>
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                @if(auth()->user()->role->name === 'admin')
                    <td>{{ $order->user_id }}</td>
                @endif
                <td width="20%">{{ $order->order_number }}</td>
                <td width="20%">{{ $order->order_date }}</td>
                <td width="10%">{{ $order->total_amount }}</td>
                <td width="10%">{{ $order->paymentMethod->name ?? 'N/A' }}</td>
                <td width="10%">{{ $order->status == 1 ? 'Pending' : 'Complete' }}</td>
                <td width="15%">{{ $order->delivery_date }}</td>
                <td width="15%">
                    <a href="{{ route('order.edit', $order->id) }}" title="Edit" class="me-1"><xi class="bx bx-edit-alt text-warning" style="font-size: 1.2rem;"></xi></a>
                   
                    <form action="{{ route('order.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this order?')" style="background: none; border: none; padding: 0;" title="Delete" class="me-1">
                          <i class="bx bx-trash text-danger" style="font-size: 1.2rem;"></i>
                        </button>
                    </form>
                   
                    <a href="{{ route('order.pdf', $order->id) }}" title="Download Invoice"><i class="bx bxs-file-pdf text-danger" style="font-size: 1.2rem;"title="Download Invoice" class="me-1"></i></a>
                    
                    <button type="button" id="shareWhatsapp" onclick="shareOnWhatsapp()" style="background: none; border: none; padding: 0;" title="Share on WhatsApp">
                        <img src="{{ asset('assets/img/avatars/whatsap.jpg') }}" alt="WhatsApp" style="width: 24px; height: 24px; border-radius: 50%;">
                    </button>
                </td>
            </tr>
    @endforeach
    </tbody>
</table>
</div>
</div>

<script>
    
    async function shareOnWhatsapp() {

        const orderId = "{{ $order->id ?? '' }}";
        
        if (!orderId) {
            alert("Order ID not found in session.");
            return;
        }
        
        
        // Fetching the generated PDF URL using AJAX
        const response = await fetch(`{{ route('download.invoice', ['id' => '__ID__']) }}`.replace('__ID__', orderId));
        const data = await response.json();
        const pdfUrl = window.location.origin + data.url; // Full URL of PDF

        // Replace with your actual logic to get the customer phone number
        const customerName = data.username;
        const customerPhone = data.mobile;
        
         // Trigger download
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = `Invoice ${customerName}.pdf`
        link.click();

        // Custom message with customer name
        const message = `Hello ${customerName}, your invoice is ready. Please download it from this link: ${pdfUrl}`;
        const whatsappUrl = `https://wa.me/${customerPhone}?text=${encodeURIComponent(message)}`;

        // Opening WhatsApp Web
        window.open(whatsappUrl, '_blank');
    }
</script>

@endsection