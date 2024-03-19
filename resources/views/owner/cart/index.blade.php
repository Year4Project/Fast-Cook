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
                                <input type="text" name="query" id="searchInput" class="form-control bg-write border-1 border-primary small" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ request('query') }}">
                                <button type="button" id="clearSearch" class="btn btn-outline-secondary" onclick="clearSearch()">Clear</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <select class="form-control" name="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
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
                            <img src="{{ $item->image_url }}" style="height: 100px; object-fit: cover;" class="card-img-top" alt="{{ $item->name }}">
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
                                        <input type="number" name="quantity" value="1" min="1" class="form-control text-center">
                                        <button type="submit" name="add_to_cart" class="btn btn-warning btn-block">Add</button>
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
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach ($addToCart as $addToCartItem)
                            <tr>
                                <td>{{ $addToCartItem->food_id }}</td>
                                <td>{{ $addToCartItem->name }}</td>
                                <td class="text-center">${{ $addToCartItem->price }}</td>
                                <td class="text-center">{{ $addToCartItem->quantity }}</td>
                                <td class="text-center">${{ $addToCartItem->price * $addToCartItem->quantity }}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm" href="{{ route('cart.delete', $addToCartItem->id) }}" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @php $totalPrice += $addToCartItem->price * $addToCartItem->quantity; @endphp
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2" class="text-center align-middle"><b>Total Price</b></td>
                                <td class="text-center align-middle">${{ $totalPrice }}</td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <form method="post" action="{{ route('order.checkout') }}">
                        @csrf
                    <div class="d-grid gap-2">
                                    {{-- <input type="hidden" name="name" value="{{ $addToCartItem->name }}">
                                    <input type="hidden" name="price" value="{{ $addToCartItem->price }}">
                                    <input type="hidden" name="food_id" value="{{ $addToCartItem->id }}">
                                    <input type="hidden" name="quantity" value="{{ $addToCartItem->quantity }}">
                                    <input type="hidden" name="image_url" value="{{ $addToCartItem->image_url }}">
                                    <input type="hidden" name="description" value="{{ $addToCartItem->description }}">
                                    <input type="hidden" name="total" value="{{ $addToCartItem = $totalPrice }}"> --}}

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
                                    <input type="hidden" name="total" value="{{ $totalPrice }}">

                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-success btn-block">Checkout</button>
                                            
                                        </div>
                                        <div class="col-6">
                                           <a class="btn btn-danger btn-block" href="{{ route('cart.clear') }}" >Reset</a>

                                        </div>
                                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection