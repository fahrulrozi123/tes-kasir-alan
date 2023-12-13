@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-7">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img class="mx-auto d-block" src="{{ asset('foto_produk/' . $product->foto) }}" alt="{{ $product->nama }}" style="max-width: 100%; height: auto;">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->nama }}</h5>
                                <p class="card-text">Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
                                <input type="hidden" class="form-control quantity" value="1" readonly>
                                <button class="btn btn-success add-to-order" 
                                    data-product-id="{{ $product->id }}" 
                                    data-product-name="{{ $product->nama }}" 
                                    data-product-price="{{ $product->harga }}"
                                    data-product-image="{{ asset('foto_produk/' . $product->foto) }}">
                                    Add to Order
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-5">
            <div id="order-list">
                <div class="card">
                    <h6 class="text-center mt-3">Pesanan</h6>
                    <table id="order-items" class="order-table">
                            
                    </table>
                    <button class="m-3 btn btn-outline-danger" id="clear-cart">Clear Cart</button>
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <button class="col-md-12 m-3 btn btn-success btn-save-bill">Save Bill</button>
                        </div>
                        <div class="col-md-6">
                            <button class="col-md-12 m-3 btn btn-success" id="print-bill">Print Bill</button>
                        </div>
                    </div>
                    <button class="m-3 btn btn-primary" onclick="openPaymentModal()">Charge <span id="total-amount">Rp 0</span></button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal payment-->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 150%;">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Detail Pesanan</h5>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="col-md-8">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Foto</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="payment-details"></tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mt-3">
                            <label for="paymentInput">Pembayaran</label>
                            <input type="text" class="form-control" id="paymentInput" placeholder="Jumlah Pembayaran">
                        </div>
                        <div class="">
                            <div id="totalPayment" class="mt-3"></div>
                            <div id="changeAmount" class="mt-3"></div>
                            <button type="button" class="btn btn-success" onclick="payAndShowAlert()">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('.add-to-order').click(function () {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productPrice = $(this).data('product-price');
            var productImage = $(this).data('product-image');
            var quantityInput = $(this).closest('.card-body').find('.quantity');
            var quantity = parseInt(quantityInput.val());

            var existingItem = $('#order-items tr[data-product-id="' + productId + '"]');
            
            if (existingItem.length > 0) {
                quantity = parseInt(existingItem.data('quantity')) + 1;
                existingItem.data('quantity', quantity);
                existingItem.find('.quantity-display').text('x' + quantity);
                existingItem.find('.total-price-display').text(formatCurrency(productPrice * quantity));
            } else {
                var listItem = '<tr data-product-id="' + productId + '" data-quantity="' + quantity + '"> ' +
                                '<td><img src="' + productImage + '" alt="' + productName + '" class="order-item-image mb-2 ms-2" style="width: 50px; height: 50px;"></td>' +
                                '<td class="me-3">' + productName + '</td>' +
                                '<td class="quantity-display me-3">x' + quantity + '</td>' +
                                '<td><span class="total-price-display text-primary">' + formatCurrency(productPrice * quantity) + '</span></td>' +
                                '</tr>';
                $('#order-items').append(listItem);
            }

            quantity++;

            quantityInput.val(quantity);

            updateTotalAmount();
        });

        $('#clear-cart').click(function () {
            $('#order-items').empty();

            updateTotalAmount();

            checkEmptyOrder();
        });

        function checkEmptyOrder() {
            var orderContainer = $('#order-container');
            var emptyOrder = $('#empty-order');

            if ($('#order-items tr').length > 0) {
                orderContainer.show();
                emptyOrder.hide();
            } else {
                orderContainer.hide();
                emptyOrder.show();

                Swal.fire({
                    icon: 'success',
                    title: 'Pesanan Berhasil Dihapus',
                    text: 'Pesanan Anda telah berhasil dihapus.',
                    confirmButtonColor: '#28a745',
                });

                updateTotalAmount();
            }
        }

        function updateTotalAmount() {
            var totalAmount = calculateTotalAmount();

            $('#total-amount').text(formatCurrency(totalAmount));
        }

        function calculateTotalAmount() {
            var totalAmount = 0;

            $('#order-items tr').each(function () {
                var quantity = parseInt($(this).data('quantity'));
                var price = parseFloat($(this).find('.total-price-display').text().replace(/[^\d.]/g, ''));

                totalAmount += price;
            });

            return totalAmount;
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2 }).format(value);
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('.btn-save-bill').click(function () {
            Swal.fire({
                icon: 'success',
                title: 'Bill Berhasil Disimpan',
                text: 'Bill Anda telah berhasil disimpan.',
                confirmButtonColor: '#28a745',
            });
        });

    });
</script>

<script>
    $(document).ready(function () {

        $('#print-bill').click(function () {
            printBill();
        });

        function printBill() {
            window.print();
        }
    });
</script>

<script>
    var orderItems = [];

    function openPaymentModal() {
        $('#payment-details').empty();
        orderItems.forEach(function (item) {
            var tableRow = '<tr>' +
                '<td>' + item.name + ' X' + item.quantity + '</td>' +
                '<td><img src="' + item.image + '" alt="' + item.name + '" style="width: 50px; height: 50px;"></td>' +
                '<td> ' + formatCurrency(item.totalPrice.toFixed(2)) + '</td>' +
                '</tr>';
            $('#payment-details').append(tableRow);
        });

        $('#paymentModal').modal('show');
    }

    function payAndShowAlert() {
        var totalAmount = calculateTotalAmount();
        var paymentAmount = parseFloat($('#paymentInput').val().replace(/[^\d.]/g, ''));

        if (isNaN(paymentAmount)) {
            alert('Masukkan jumlah pembayaran.');
            return;
        }

        var changeAmount = paymentAmount - totalAmount;

        if (changeAmount >= 0) {
            $('#changeAmount').html('<strong>Kembalian:</strong> ' + formatCurrency(changeAmount.toFixed(2)));
            $('#totalPayment').html('<strong>Total Bayar:</strong> ' + formatCurrency(paymentAmount.toFixed(2)));

            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil',
                html: 'Total Bayar: ' + formatCurrency(paymentAmount.toFixed(2)) + '<br>Kembalian: ' + formatCurrency(changeAmount.toFixed(2)),
                confirmButtonColor: '#28a745',
            });

            orderItems = [];
            updateTotalAmount();
            $('#paymentInput').val('');
            $('#payment-details').empty();
        } else {
            alert('Jumlah pembayaran kurang.');
        }
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }

    $('.add-to-order').click(function () {
        var productId = $(this).data('product-id');
        var productName = $(this).data('product-name');
        var productPrice = $(this).data('product-price');
        var productImage = $(this).data('product-image');
        var quantity = 1;

        var existingItemIndex = orderItems.findIndex(function (item) {
            return item.productId === productId;
        });

        if (existingItemIndex !== -1) {
            orderItems[existingItemIndex].quantity++;
            orderItems[existingItemIndex].totalPrice = orderItems[existingItemIndex].quantity * productPrice;
        } else {
            var newItem = {
                productId: productId,
                name: productName,
                image: productImage,
                quantity: quantity,
                totalPrice: productPrice,
            };

            orderItems.push(newItem);
        }

        updateTotalAmount();
    });

    function updateTotalAmount() {
        var totalAmount = calculateTotalAmount();
        $('#total-amount').text('Rp ' + totalAmount.toFixed(2));
    }

    function calculateTotalAmount() {
        var totalAmount = 0;
        orderItems.forEach(function (item) {
            totalAmount += item.totalPrice;
        });
        return totalAmount;
    }
</script>

@endsection
