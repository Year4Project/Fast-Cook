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
                                <div class="card h-100">
                                    <img src="{{ $item->image_url }}" style="height: 100px; object-fit: cover;"
                                        class="card-img-top" alt="{{ $item->name }}">
                                    <div class="card-body">
                                        <div class="div" style="height:40px">
                                            <h6 class="card-title text-center">{{ $item->name }}</h6>
                                        </div>
                                        <p class="card-text text-center">${{ $item->price }}</p>
                                        <form method="post" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="name" value="{{ $item->name }}">
                                            <input type="hidden" name="price" value="{{ $item->price }}">
                                            <input type="hidden" name="food_id" value="{{ $item->id }}">
                                            <input type="hidden" name="image_url" value="{{ $item->image_url }}">
                                            <input type="hidden" name="description" value="{{ $item->description }}">

                                            <div class="d-grid gap-2">
                                                <input type="number" name="quantity" value="1" min="1"
                                                    class="form-control text-center">
                                                <button type="submit" name="add_to_cart"
                                                    class="btn btn-warning btn-block">Add</button>
                                            </div>
                                        </form>
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
                    <h3 class="text-center text-primary m-0">Items Selected</h3>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
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
                                    <td>{{ $addToCartItem->name }}</td>
                                    <td class="text-center">${{ $addToCartItem->price }}</td>
                                    <td class="text-center">
                                        <div class="input-group">
                                            <form action="{{ route('cart.update') }}" method="post"
                                                id="updateQuantityForm{{ $addToCartItem->id }}"
                                                class="d-flex align-items-center">
                                                @csrf
                                                <input type="hidden" name="cart_item_id" value="{{ $addToCartItem->id }}">

                                                <!-- Decrease quantity button -->
                                                <button class="btn btn-sm btn-secondary" type="button"
                                                    onclick="updateQuantity({{ $addToCartItem->id }}, -1)">-</button>

                                                <!-- Quantity input field -->
                                                <input type="text" name="quantity"
                                                    value="{{ $addToCartItem->quantity }}" min="1"
                                                    class="form-control text-center" style="width: 50px;">

                                                <!-- Increase quantity button -->
                                                <button class="btn btn-sm btn-secondary" type="button"
                                                    onclick="updateQuantity({{ $addToCartItem->id }}, 1)">+</button>
                                            </form>

                                        </div>
                                    </td>
                                    <td class="text-center">${{ $addToCartItem->price * $addToCartItem->quantity }}</td>
                                    <td>
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('cart.delete', $addToCartItem->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?')"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @php $totalPrice += $addToCartItem->price * $addToCartItem->quantity; @endphp
                            @endforeach



                        </tbody>
                    </table>

                    <hr>

                    <form method="post" action="{{ route('order.checkout') }}">
                        @csrf
                        <div class="d-grid gap-2">
                            <!-- Total KHR -->
                            <div class="row">
                                <div class="col-3">
                                    <label for="">Total KHR:</label>
                                </div>
                                <div class="col-3">
                                    <label class="text-danger font-weight-bold" for="" name="total"
                                        id="total-khr">{{ $totalPrice * 4100 }}៛</label>
                                </div>
                                <div class="col-3">
                                    <label for="">Total USD:</label>
                                </div>
                                <div class="col-3">
                                    <label class="text-danger font-weight-bold" for="" name="total"
                                        id="total-usd">${{ $totalPrice }}</label>
                                </div>
                            </div>
                            <!-- Total USD -->
                            <div class="row">
                                <div class="col-4">
                                    <input type="checkbox" id="payment_method_credit_card" name="payment_method[]" value="credit_card">
                                <label for="payment_method_credit_card">Credit Card</label>
                                
                                </div>
                                <div class="col-4">
                                    <input type="checkbox" id="payment_method_debit_card" name="payment_method[]" value="debit_card">
                                <label for="payment_method_debit_card">Debit Card</label>
                                
                                </div>
                                <div class="col-4">
                                    <input type="checkbox" id="payment_method_cash" name="payment_method[]" value="cash">
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
                                        <input type="text" name="payment" id="payment" class="form-control"
                                            oninput="calculateChange()">
                                        <select id="currency-selector" name="currency" onchange="calculateChange()" class="text-center" style="width: 30%">
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
                                    <input class="form-control" type="text" name="customername" id="">
                                </div>
                                <div class="col-6">
                                    <label for="">Customer Phone</label>
                                    <input class="form-control" type="text" name="customerphone" id="">
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
                // Get payment value
                let payment = parseFloat(document.getElementById('payment').value);

                // Get currency selection
                let currency = document.getElementById('currency-selector').value;

                // Get total price in USD
                let totalPriceUSD = parseFloat('{{ $totalPrice }}');

                // Calculate change in KHR and USD
                let remainingTotalKHR = parseFloat(document.getElementById('total-khr').innerText.slice(1));
                let remainingTotalUSD = parseFloat(document.getElementById('total-usd').innerText.slice(1));

                let changeKHR = currency === 'USD' ? remainingTotalKHR - payment * 4100 : remainingTotalKHR - payment;
                let changeUSD = currency === 'KHR' ? remainingTotalUSD - payment / 4100 : remainingTotalUSD - payment;

                // Update change labels
                document.getElementById('change-khr').innerText = 'KHR: ' + changeKHR.toFixed(2);
                document.getElementById('change-usd').innerText = 'USD: ' + changeUSD.toFixed(2);
            }
        </script>

    </div>
@endsection
