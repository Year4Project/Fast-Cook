@extends('layouts.app')

@section('title', __('order.title'))

@section('content')
    
    <div class="big-banner">
        <div class="container-fluid">
            <div class="row">
                {{-- Ordering Items --}}
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <form id="searchForm" method="get" action="">
                                <div class="row g-2">
                                    <div class="col-md-5 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" name="query" id="searchInput"
                                                class="form-control bg-white border-1 border-primary small"
                                                placeholder="Search for..." aria-label="Search"
                                                aria-describedby="basic-addon2" value="{{ request('query') }}">
                                            <button type="button" id="clearSearch" class="btn btn-outline-secondary"
                                                onclick="clearSearch()">Clear</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <select class="form-control" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <button type="submit" class="btn btn-primary form-control">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Items --}}
                        <div class="card-body">
                            <div class="row">
                                @foreach ($restaurant as $item)
                                    <div class="col-md-4 col-sm-6 mb-4">
                                        <div class="card h-100 shadow">
                                            <form method="post" action="{{ route('cart.add') }}" class="card-form">
                                                @csrf
                                                <input type="hidden" name="food_id" value="{{ $item->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" name="add_to_cart" class="invisible-btn"></button>
                                            </form>
                                            <div class="card-clickable position-relative"
                                                onclick="this.closest('.card').querySelector('.card-form button').click()"
                                                data-toggle="tooltip" data-placement="top" title="Click to add to cart">
                                                <img src="{{ $item->image_url }}" style="height: 200px; object-fit: cover;"
                                                    class="card-img-top" alt="{{ $item->name }}">
                                                <div class="price-overlay position-absolute top-0 start-0 bg-warning text-black p-2">
                                                    ${{ $item->price }}
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title mb-0">{{ $item->name }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Add Item To Cart --}}
                <div class="col-lg-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h3 class="text-center text-primary m-0">Cart Items</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalPrice = 0; @endphp
                                        @foreach ($addToCart as $addToCartItem)
                                            <tr>
                                                <td>{{ $addToCartItem->food->name }}</td>
                                                <td class="text-center align-middle">${{ $addToCartItem->food->price }}</td>
                                                <td class="text-center align-middle">
                                                    <div class="input-group align-center justify-content-center">
                                                        <form action="{{ route('cart.update') }}" method="post"
                                                            id="updateQuantityForm{{ $addToCartItem->id }}"
                                                            class="d-flex align-items-center">
                                                            @csrf
                                                            <input type="hidden" name="cart_item_id" value="{{ $addToCartItem->id }}">
                                                            <button class="btn btn-sm btn-secondary quantity-btn"
                                                                type="button"
                                                                onclick="updateQuantity({{ $addToCartItem->id }}, -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="text" name="quantity"
                                                                value="{{ $addToCartItem->quantity }}" min="1"
                                                                class="form-control text-center quantity-input"
                                                                style="width: 50px;">
                                                            <button class="btn btn-sm btn-secondary quantity-btn"
                                                                type="button"
                                                                onclick="updateQuantity({{ $addToCartItem->id }}, 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    ${{ $addToCartItem->food->price * $addToCartItem->quantity }}
                                                </td>
                                                <td class="align-middle">
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('cart.delete', $addToCartItem->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $totalPrice += $addToCartItem->food->price * $addToCartItem->quantity; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <form method="post" action="{{ route('order.checkout') }}">
                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-grid gap-2">
                                    <!-- Total KHR and USD -->
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Total KHR:</label>
                                            <label class="text-danger font-weight-bold" for="" name="total"
                                                id="total-khr">{{ number_format($totalPrice * 4100) }} ៛</label>
                                        </div>
                                        <div class="col-6">
                                            <label for="">Total USD:</label>
                                            <label class="text-danger font-weight-bold" for="" name="total"
                                                id="total-usd">$ {{ $totalPrice }}</label>
                                            <input type="hidden" name="total" value="{{ $totalPrice }}">
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="row my-3">
                                        <div class="col-6 text-center">
                                            <input type="checkbox" id="payment_method_credit_card" name="payment_method[]" value="credit_card">
                                            <label for="payment_method_credit_card">Credit Card</label>
                                            <img src="{{ asset('admin/img/credit-card.png') }}" alt="" style="width: 50px; height: 50px;" onclick="toggleCheckbox('payment_method_credit_card', 'payment_method_cash')">
                                        </div>
                                        <div class="col-6 text-center">
                                            <input type="checkbox" id="payment_method_cash" name="payment_method[]" value="cash">
                                            <label for="payment_method_cash">Cash</label>
                                            <img src="{{ asset('admin/img/money.png') }}" alt="" style="width: 50px; height: 50px;" onclick="toggleCheckbox('payment_method_cash', 'payment_method_credit_card')">
                                        </div>
                                    </div>

                                    <!-- Payment -->
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="">Payment:</label>
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" type="number" name="payment" id="payment" oninput="calculateChange()">
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control" name="currency" id="currency-selector" onchange="calculateChange()">
                                                <option value="KHR">KHR</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Change -->
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="">Change KHR:</label>
                                            <label id="change-khr"></label>
                                        </div>
                                        <div class="col-6">
                                            <label for="">Change USD:</label>
                                            <label id="change-usd"></label>
                                        </div>
                                    </div>

                                    <!-- Customer Information -->
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="">Customer Name</label>
                                            <input class="form-control" type="text" name="name" id="">
                                        </div>
                                        <div class="col-6">
                                            <label for="">Customer Phone</label>
                                            <input class="form-control" type="text" name="phone" id="">
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-success btn-block">Place Order</button>
                                        </div>
                                        <div class="col-6">
                                            <a class="btn btn-danger btn-block" href="{{ route('cart.clear') }}">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function updateQuantity(cartItemId, change) {
                        var form = document.getElementById('updateQuantityForm' + cartItemId);
                        var quantityField = form.querySelector('input[name="quantity"]');
                        var currentQuantity = parseInt(quantityField.value);
                        var newQuantity = currentQuantity + change;

                        if (newQuantity < 1) {
                            newQuantity = 1;
                        }

                        quantityField.value = newQuantity;
                        form.submit();
                    }

                    function calculateChange() {
                        var totalAmountKHR = parseFloat(document.getElementById("total-khr").textContent.replace(/[^0-9.-]+/g, ""));
                        var totalAmountUSD = parseFloat(document.getElementById("total-usd").textContent.replace(/[^0-9.-]+/g, ""));
                        var paymentAmount = parseFloat(document.getElementById("payment").value);
                        var currency = document.getElementById("currency-selector").value;
                        var exchangeRateKHR = 4100;
                        var totalAmount = (currency === "KHR") ? totalAmountKHR : totalAmountUSD;
                        var remainingAmount = totalAmount - paymentAmount;
                        var changeKHR = 0;
                        var changeUSD = 0;

                        if (currency === "KHR") {
                            changeKHR = remainingAmount;
                            changeUSD = remainingAmount / exchangeRateKHR;
                        } else if (currency === "USD") {
                            changeUSD = remainingAmount;
                            changeKHR = remainingAmount * exchangeRateKHR;
                        }

                        document.getElementById("change-khr").textContent = "KHR: " + changeKHR.toFixed(2);
                        document.getElementById("change-usd").textContent = "USD: " + changeUSD.toFixed(2);
                    }

                    function toggleCheckbox(checkboxId, otherCheckboxId) {
                        var checkbox = document.getElementById(checkboxId);
                        var otherCheckbox = document.getElementById(otherCheckboxId);

                        checkbox.checked = !checkbox.checked;
                        otherCheckbox.checked = false;
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
