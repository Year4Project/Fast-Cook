@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">
        @include('_massage')

        <h1 class="h1 mb-0 text-gray-800 mb-4 mt-4">POS System</h1>

        <div class="row">
            <div class="col-md-8">
                <!-- Food Items List -->
                <div class="row">
                    @foreach ($restaurant as $item)
                        <div class="col-md-2 mb-3">
                            <div class="card food-item" data-id="{{ $item->id }}" data-price="{{ $item->price }}"
                                data-image="{{ $item->image_url }}">
                                <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $item->name }}</h6>
                                    <p class="card-text">Description: {{ $item->description }}</p>
                                    <p class="card-text">Price: ${{ number_format($item->price, 2) }}</p>
                                    <!-- Add more details as needed -->
                                    <div class="form-group" style="display: none;" id="quantity-buttons{{ $item->id }}">
                                        <label for="quantity{{ $item->id }}">Quantity:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary quantity-btn" type="button"
                                                    data-action="subtract">-</button>
                                            </div>
                                            <input type="number" class="form-control quantity-input"
                                                id="quantity{{ $item->id }}" value="1" min="1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary quantity-btn" type="button"
                                                    data-action="add">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <!-- Selected Items -->
                <div class="selected-items">
                    <h4>Selected Items</h4>
                    <div class="row">
                        <div class="col-4">Name</div>
                        <div class="col-4">Qty</div>
                        <div class="col-2">Amount</div>
                        <div class="col-2">Actions</div>
                    </div>
                    <ol id="selected-items-list"></ol>
                </div>

                <!-- Total Price -->
                <div class="total-price">
                    <h4>Total Price</h4>
                    <span id="total-price-value">$0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        /* Add hover effect */
        .food-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            transition: box-shadow 0.3s, transform 0.3s;
        }

        .selected-item {
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            position: relative;
        }

        .selected-item img {
            max-width: 50px;
            /* Set the maximum width for the selected item image */
            margin-right: 10px;
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const foodItems = document.querySelectorAll('.food-item');
            const totalPriceElement = document.getElementById('total-price-value');
            const selectedItemsList = document.getElementById('selected-items-list');
            let totalPrice = 0;
            let selectedItems = {};

            foodItems.forEach(item => {
                const itemId = item.dataset.id;
                const quantityInput = document.getElementById(`quantity${itemId}`);
                const quantityButtons = document.getElementById(`quantity-buttons${itemId}`);

                // Set initial quantity to 1 for each item
                quantityInput.value = 1;

                quantityButtons.addEventListener('click', function(event) {
                    const action = event.target.dataset.action;

                    // Ensure the target is a button with a valid data-action attribute
                    if (action && ['subtract', 'add'].includes(action)) {
                        const currentQuantity = parseInt(quantityInput.value) || 1;

                        // Adjust quantity based on the button action
                        if (action === 'subtract' && currentQuantity > 1) {
                            quantityInput.value = currentQuantity - 1;
                        } else if (action === 'add') {
                            quantityInput.value = currentQuantity + 1;
                        }
                    }
                });

                item.addEventListener('click', function() {
                    // Toggle the display of quantity buttons
                    quantityButtons.style.display = 'block';

                    const itemName = item.querySelector('.card-title').textContent;
                    const itemImage = item.dataset.image;
                    const price = parseFloat(item.dataset.price || 0);

                    // Get quantity from the input field
                    const quantity = parseInt(quantityInput.value) || 1;

                    // Calculate total price for the selected quantity
                    const totalItemPrice = price * quantity;

                    // Check if the item is already selected
                    if (selectedItems[itemId]) {
                        // If selected, update the quantity and total price
                        selectedItems[itemId].quantity += quantity;
                        selectedItems[itemId].totalPrice += totalItemPrice;
                        // Update the displayed quantity
                        selectedItems[itemId].element.innerHTML = `<div class="row">
                                                             <div class="col-4">${itemName}</div>
                                                             <div class="col-2">${selectedItems[itemId].quantity}</div>
                                                             <div class="col-2"><button class="btn btn-outline-secondary quantity-btn" type="button" data-action="subtract-selected" data-id="${itemId}">-</button></div>
                                                             <div class="col-2"><button class="btn btn-outline-secondary quantity-btn" type="button" data-action="add-selected" data-id="${itemId}">+</button></div>
                                                             <div class="col-2">$${selectedItems[itemId].totalPrice.toFixed(2)}</div>
                                                             <div class="col-12 mt-2">
                                                                <button class="btn btn-danger delete-btn" type="button" data-action="delete-selected" data-id="${itemId}">Delete</button>
                                                             </div>
                                                           </div>`;
                    } else {
                        // If not selected, add a new entry
                        selectedItems[itemId] = {
                            quantity: quantity,
                            totalPrice: totalItemPrice,
                            element: document.createElement('li'),
                        };
                        selectedItems[itemId].element.classList.add('selected-item');
                        selectedItems[itemId].element.innerHTML = `<div class="row">
                                                             <div class="col-4">${itemName}</div>
                                                             <div class="col-2">${selectedItems[itemId].quantity}</div>
                                                             <div class="col-2"><button class="btn btn-outline-secondary quantity-btn" type="button" data-action="subtract-selected" data-id="${itemId}">-</button></div>
                                                             <div class="col-2"><button class="btn btn-outline-secondary quantity-btn" type="button" data-action="add-selected" data-id="${itemId}">+</button></div>
                                                             <div class="col-2">$${selectedItems[itemId].totalPrice.toFixed(2)}</div>
                                                             <div class="col-12 mt-2">
                                                                <button class="btn btn-danger delete-btn" type="button" data-action="delete-selected" data-id="${itemId}">Delete</button>
                                                             </div>
                                                           </div>`;
                        selectedItemsList.appendChild(selectedItems[itemId].element);
                    }

                    // Update total price
                    totalPrice += totalItemPrice;
                    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
                });
            });

            // Event delegation for quantity buttons and delete button in selected items list
            selectedItemsList.addEventListener('click', function(event) {
                const target = event.target;
                const action = target.dataset.action;
                const itemId = target.dataset.id;

                if (action === 'subtract-selected') {
                    // Subtract from selected item quantity
                    if (selectedItems[itemId] && selectedItems[itemId].quantity > 1) {
                        selectedItems[itemId].quantity--;
                        selectedItems[itemId].totalPrice -= parseFloat(foodItems[itemId - 1].dataset.price);
                        updateSelectedItems();
                    }
                } else if (action === 'add-selected') {
                    // Add to selected item quantity
                    if (selectedItems[itemId]) {
                        selectedItems[itemId].quantity++;
                        selectedItems[itemId].totalPrice += parseFloat(foodItems[itemId - 1].dataset.price);
                        updateSelectedItems();
                    }
                } else if (action === 'delete-selected') {
                    // Delete selected item
                    if (selectedItems[itemId]) {
                        totalPrice -= selectedItems[itemId].totalPrice;
                        delete selectedItems[itemId];
                        updateSelectedItems();
                    }
                }
            });

            // Function to update the selected items list
            function updateSelectedItems() {
                selectedItemsList.innerHTML = ''; // Clear the list
                for (const itemId in selectedItems) {
                    const item = selectedItems[itemId];
                    item.element.innerHTML = `<div class="row">
                                        <div class="col-4">${foodItems[itemId - 1].querySelector('.card-title').textContent}</div>
                                        <div class="col-2">${item.quantity}</div>
                                        <div class="col-2"><button class="btn btn-outline-secondary quantity-btn" type="button" data-action="subtract-selected" data-id="${itemId}">-</button></div>
                                        <div class="col-2"><button class="btn btn-outline-secondary quantity-btn" type="button" data-action="add-selected" data-id="${itemId}">+</button></div>
                                        <div class="col-2">$${item.totalPrice.toFixed(2)}</div>
                                        <div class="col-12 mt-2">
                                            <button class="btn btn-danger delete-btn" type="button" data-action="delete-selected" data-id="${itemId}">Delete</button>
                                        </div>
                                      </div>`;
                    selectedItemsList.appendChild(item.element);
                }
                // Update total price
                totalPrice = Object.values(selectedItems).reduce((total, item) => total + item.totalPrice, 0);
                totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
            }
        });
    </script>

@endsection
