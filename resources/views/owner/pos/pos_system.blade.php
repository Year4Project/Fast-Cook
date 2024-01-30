@extends('layouts.app')

@section('content')

<style>
    /* Add hover effect */
    .food-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        max-height: 250px;
        width: 100%; /* Each item takes full width */
        max-width: 200px; /* Limiting the maximum width to prevent stretching */
        margin-bottom: 40px;

    }

    .food-item:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .food-item .card-img-top {
        height: 100px; /* Adjust the height of the image */
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .food-item .card-body {
        padding: 15px;
        min-height: 100px; /* Adjust the height of the body */
    }

    .food-item .title {
        height: 20px;
    }

    .food-item .title .card-title {
        font-size: 14px;
        font-weight: bold;
    }

    .food-item .card-text {
        font-size: 14px;
        color: #555;
        margin-top: 20px;
    }

    .food-item .card-price {
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
    }

</style>

    <div class="big-banner">
        <div class="container-fluid">
            @include('_massage')

            <div class="row">
                <div class="col-md-8">
                    <h1 class="mb-4 mt-4">Food Items</h1>
                    <div class="row">
                        @foreach ($restaurant as $item)
                            <div class="col-md-2">
                                <div class="card food-item" data-id="{{ $item->id }}" data-price="{{ $item->price }}"
                                    data-image="{{ $item->image_url }}">
                                    <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}">
                                    <div class="card-body">
                                        <div class="title">
                                            <h6 class="card-title">{{ $item->name }}</h6>
                                        </div>
                                        {{-- <p class="card-text">Description:
                                            @if (strlen($item->description) > 10)
                                                {{ substr($item->description, 0, 10) }} <span
                                                    class="read-more-content">{{ substr($item->description, 10) }}</span>
                                                <a href="#" class="read-more-toggle">Read More</a>
                                            @else
                                                {{ $item->description }}
                                            @endif
                                        </p> --}}
                                        <p class="card-text">Price: ${{ number_format($item->price, 2) }}</p>


                                    </div>
                                    <div class="form-group quantity-buttons p-2 mb-3" id="quantity-buttons{{ $item->id }}">
                                        {{-- <label for="quantity{{ $item->id }}">Quantity:</label> --}}

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary quantity-btn" type="button"
                                                    data-action="subtract">-</button>
                                            </div>
                                            <input type="text" class="form-control quantity-input text-center"
                                                id="quantity{{ $item->id }}" value="1" min="1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary quantity-btn" type="button"
                                                    data-action="add">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="selected-items mt-4">
                        <h2>Cart</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items-list"></tbody>
                        </table>
                        <h4>Total Price: <span id="total-price-value">$0.00</span></h4>
                        <button id="checkout-btn" class="btn btn-primary">Checkout & Print Receipt</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const foodItems = document.querySelectorAll('.food-item');
            const totalPriceElement = document.getElementById('total-price-value');
            const cartItemsList = document.getElementById('cart-items-list');
            let totalPrice = 0;
            let cartItems = {};

            // Function to update the cart
            function updateCart(itemId, quantity) {
                const item = cartItems[itemId];
                const price = parseFloat(foodItems[itemId - 1].dataset.price || 0);
                const totalItemPrice = price * quantity;

                if (item) {
                    const priceDifference = (quantity - item.quantity) * price;
                    item.quantity = quantity;
                    item.totalPrice += priceDifference;
                    item.element.querySelector('.qty').textContent = quantity;
                    item.element.querySelector('.amount').textContent = `$${item.totalPrice.toFixed(2)}`;
                } else {
                    const itemName = foodItems[itemId - 1].querySelector('.card-title').textContent;
                    const newItem = {
                        quantity: quantity,
                        totalPrice: totalItemPrice,
                        element: document.createElement('tr'),
                    };
                    newItem.element.innerHTML = `
                        <td>${itemName}</td>
                        <td class="qty">${newItem.quantity}</td>
                        <td class="amount">$${newItem.totalPrice.toFixed(2)}</td>
                        <td><button class="btn btn-danger delete-btn" type="button" data-action="delete-from-cart" data-id="${itemId}">Delete</button></td>
                    `;
                    cartItems[itemId] = newItem;
                    cartItemsList.appendChild(newItem.element);
                }
            }

            // Event listeners for quantity buttons
            foodItems.forEach(item => {
                const itemId = item.dataset.id;
                const quantityInput = document.getElementById(`quantity${itemId}`);
                const quantityButtons = document.getElementById(`quantity-buttons${itemId}`);

                quantityInput.value = 1;

                quantityButtons.addEventListener('click', function(event) {
                    const action = event.target.dataset.action;
                    if (action && ['subtract', 'add'].includes(action)) {
                        const currentQuantity = parseInt(quantityInput.value) || 1;
                        if (action === 'subtract' && currentQuantity > 1) {
                            quantityInput.value = currentQuantity - 1;
                        } else if (action === 'add') {
                            quantityInput.value = currentQuantity + 1;
                        }
                        updateCart(itemId, parseInt(quantityInput.value));
                        updateTotalPrice();
                    }
                });

                item.addEventListener('click', function() {
                    quantityButtons.style.display = 'block';
                    const quantity = parseInt(quantityInput.value) || 1;
                    updateCart(itemId, quantity);
                    updateTotalPrice();
                });
            });

            // Event listener for deleting items from the cart
            document.addEventListener('click', function(event) {
                const target = event.target;
                const action = target.dataset.action;
                const itemId = target.dataset.id;
                if (action === 'delete-from-cart' && cartItems[itemId]) {
                    const itemPrice = cartItems[itemId].totalPrice;
                    totalPrice -= itemPrice;
                    delete cartItems[itemId];
                    target.closest('tr').remove();
                    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
                }
            });

            // Update the total price displayed
            function updateTotalPrice() {
                totalPrice = Object.values(cartItems).reduce((total, item) => total + item.totalPrice, 0);
                totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
            }

            const readMoreToggleButtons = document.querySelectorAll('.read-more-toggle');
            readMoreToggleButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const content = this.previousElementSibling;
                    content.classList.toggle('show');
                    if (content.classList.contains('show')) {
                        this.textContent = 'Read Less';
                    } else {
                        this.textContent = 'Read More';
                    }
                });
            });
        });

        document.getElementById('checkout-btn').addEventListener('click', function() {
        // Generate the receipt content
        var receiptContent = document.getElementById('receipt-content').innerHTML;

        // Print the receipt
        printReceipt(receiptContent);
    });

        // Function to print the receipt
    function printReceipt(content) {
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Receipt</title></head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
    </script>

@endsection
