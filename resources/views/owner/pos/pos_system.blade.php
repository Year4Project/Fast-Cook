@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('_massage')

{{-- @foreach ($getFood as $item)        <!-- Page Heading --> --}}
        <h1 class="h3 mb-0 text-gray-800 mb-4 mt-4">POS System</h1>

        <div class="row">
            <div class="col-md-8">
                <!-- Food Items List -->
                <div class="food-list">
                    <!-- Each food item goes here -->
                    <div class="food-item">
                        <span class="item-name">Item 1</span>
                        <span class="item-price">$10.00</span>
                    </div>
                    <!-- Repeat for other items -->
                </div>
            </div>

            <div class="col-md-4">
                <!-- Total Price -->
                <div class="total-price">
                    <h4>Total Price</h4>
                    <span id="total-price-value">$0.00</span>
                </div>
            </div>
        </div>
    </div>
<script>
    // Sample JavaScript to update total price (you can modify based on your needs)
    document.addEventListener('DOMContentLoaded', function() {
        const foodItems = document.querySelectorAll('.food-item');
        const totalPriceElement = document.getElementById('total-price-value');

        let totalPrice = 0;

        foodItems.forEach(item => {
            item.addEventListener('click', function() {
                // Assuming price is stored in the data-price attribute
                const price = parseFloat(item.dataset.price || 0);
                totalPrice += price;

                // Update total price
                totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
            });
        });
    });
</script>

@endsection
