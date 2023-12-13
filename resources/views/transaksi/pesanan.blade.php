<div class="col-md-6">
    <div class="card">
        <div class="card-header">Pesanan</div>
        <div class="card-body" id="order-container">
            @if (!is_null($orderItems) && count($orderItems) > 0)
    <h3>Pesanan Anda:</h3>
    <ul>
        @foreach ($orderItems as $orderItem)
            <li>{{ $orderItem->nama }} - Harga: {{ $orderItem->harga }}</li>
        @endforeach
    </ul>
@else
    <p>Belum ada pesanan.</p>
@endif
        </div>
    </div>
</div>