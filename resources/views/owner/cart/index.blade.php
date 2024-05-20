@extends('layouts.app')

@section('title', __('order.title'))

@section('content')
    <div class="row p-4">
        {{-- Ordering Items --}}
        <div class="col-lg-7">
            <div class="card shadow">
                <div class="card-header">
                    <form id="searchForm" method="get" action="">
                        <div class="row">
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" name="query" id="searchInput"
                                        class="form-control bg-write border-1 border-primary small"
                                        placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"
                                        value="{{ request('query') }}">
                                    <button type="button" id="clearSearch" class="btn btn-outline-secondary"
                                        onclick="clearSearch()">Clear</button>
                                </div>
                            </div>
                            <div class="col-4">
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
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary form-control">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Item --}}
                <div class="card-body">
                    <div class="row">
                        @foreach ($restaurant as $item)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100 shadow">
                                    <form method="post" action="{{ route('cart.add') }}" class="card-form">
                                        @csrf
                                        <input type="hidden" name="name" value="{{ $item->name }}">
                                        <input type="hidden" name="price" value="{{ $item->price }}">
                                        <input type="hidden" name="food_id" value="{{ $item->id }}">
                                        <input type="hidden" name="image_url" value="{{ $item->image_url }}">
                                        <input type="hidden" name="description" value="{{ $item->description }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="invisible-btn"></button>
                                    </form>
                                    <div class="card-clickable"
                                        onclick="this.closest('.card').querySelector('.card-form button').click()"
                                        data-toggle="tooltip" data-placement="top" title="Click to add to cart">
                                        <img src="{{ $item->image_url }}" style="height: 200px; object-fit: cover;"
                                            class="card-img-top" alt="{{ $item->name }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="card-title mb-0">{{ $item->name }}</h5>
                                                <span class="badge bg-secondary">${{ $item->price }}</span>
                                            </div>
                                            <p class="card-text description">{{ $item->description }}</p>
                                            @if (strlen($item->description) > 100)
                                                <p class="read-more"><a href="#"
                                                        onclick="toggleDescription(this)">Read more</a></p>
                                            @endif
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
        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="text-center text-primary m-0">Cart Items</h3>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    {{-- <th>ID</th> --}}
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
                                        {{-- <td>{{ $addToCartItem->food_id }}</td> --}}
                                        <td>{{ $addToCartItem->food->name }}</td>
                                        <td class="text-center">${{ $addToCartItem->food->price }}</td>

                                        <td class="text-center">
                                            <div class="input-group align-center justify-content-center">
                                                <form action="{{ route('cart.update') }}" method="post"
                                                    id="updateQuantityForm{{ $addToCartItem->id }}"
                                                    class="d-flex align-items-center">
                                                    @csrf
                                                    <input type="hidden" name="cart_item_id"
                                                        value="{{ $addToCartItem->id }}">

                                                    <!-- Decrease quantity button -->
                                                    <button class="btn btn-sm btn-secondary quantity-btn" type="button"
                                                        onclick="updateQuantity({{ $addToCartItem->id }}, -1)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>

                                                    <!-- Quantity input field -->
                                                    <input type="text" name="quantity"
                                                        value="{{ $addToCartItem->quantity }}" min="1"
                                                        class="form-control text-center quantity-input"
                                                        style="width: 50px;">

                                                    <!-- Increase quantity button -->
                                                    <button class="btn btn-sm btn-secondary quantity-btn" type="button"
                                                        onclick="updateQuantity({{ $addToCartItem->id }}, 1)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>



                                        <td class="text-center">
                                            ${{ $addToCartItem->food->price * $addToCartItem->quantity }}
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('cart.delete', $addToCartItem->id) }}"><i
                                                    class="fas fa-trash-alt"></i></a>
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
                            <!-- Total KHR -->
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Total KHR:</label>
                                </div>
                                <div class="col-3">
                                    <label class="text-danger font-weight-bold" for="" name="total"
                                        id="total-khr">{{ number_format($totalPrice * 4100) }} ៛</label>
                                </div>
                                <div class="col-3">
                                    <label for="">Total USD:</label>
                                </div>
                                <div class="col-3">


                                    <label class="text-danger font-weight-bold" for="" name="total"
                                        id="total-usd">$ {{ $totalPrice }}</label>

                                    <input type="hidden" name="total" value="{{ $totalPrice }}">

                                </div>
                            </div>
                            <!-- Total USD -->
                            <div class="row">
                                <div class="col-4">
                                    <input type="checkbox" id="payment_method_credit_card" name="payment_method[]"
                                        value="credit_card">
                                    <label for="payment_method_credit_card">Credit Card</label>

                                </div>
                                <div class="col-4">
                                    <input type="checkbox" id="payment_method_debit_card" name="payment_method[]"
                                        value="debit_card">
                                    <label for="payment_method_debit_card">Debit Card</label>

                                </div>
                                <div class="col-4">
                                    <input type="checkbox" id="payment_method_cash" name="payment_method[]"
                                        value="cash">
                                    <label for="payment_method_cash">Cash</label>

                                </div>



                                </select>

                            </div>
                            <!-- Payment -->
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Payment:</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" name="payment_amount" id="payment" class="form-control"
                                            oninput="calculateChange()">
                                        <select id="currency-selector" name="currency" onchange="calculateChange()"
                                            class="text-center" style="width: 30%">
                                            <option value="KHR">KHR</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Change -->
                            <div class="row">
                                <div class="col-4">
                                    <label for="">Returning Change:</label>
                                </div>
                                <div class="col-4">
                                    <label for="" id="change-khr">KHR: </label>
                                </div>
                                <div class="col-4">
                                    <label for="" id="change-usd">USD: </label>
                                </div>
                            </div>
                            <hr>
                            <!-- Customer Information -->
                            <div class="row">
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

                // Ensure quantity does not go below 1
                if (newQuantity < 1) {
                    newQuantity = 1;
                }

                quantityField.value = newQuantity;
                form.submit();
            }

            function calculateChange() {
        // Get total amount in KHR
        var totalAmountKHR = parseFloat(document.getElementById("total-khr").textContent.replace(/[^0-9.-]+/g,""));

        // Get total amount in USD
        var totalAmountUSD = parseFloat(document.getElementById("total-usd").textContent.replace(/[^0-9.-]+/g,""));

        // Get payment amount
        var paymentAmount = parseFloat(document.getElementById("payment").value);

        // Get selected currency
        var currency = document.getElementById("currency-selector").value;

        // Define exchange rates (1 USD = 4100 KHR)
        var exchangeRateKHR = 4100;

        // Calculate total amount based on selected currency
        var totalAmount = (currency === "KHR") ? totalAmountKHR : totalAmountUSD;

        // Calculate remaining amount
        var remainingAmount = totalAmount - paymentAmount;

        // Calculate change
        var changeKHR = 0;
        var changeUSD = 0;

        if (currency === "KHR") {
            // Calculate change in KHR
            changeKHR = remainingAmount;
            changeUSD = remainingAmount / exchangeRateKHR;
        } else if (currency === "USD") {
            // Calculate change in USD
            changeUSD = remainingAmount;
            changeKHR = remainingAmount * exchangeRateKHR;
        }

        // Display change
        document.getElementById("change-khr").textContent = "KHR: " + changeKHR.toFixed(2);
        document.getElementById("change-usd").textContent = "USD: " + changeUSD.toFixed(2);
    }
            
        </script>
    </div>
@endsection
