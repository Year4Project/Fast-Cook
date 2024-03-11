@extends('layouts.app')

@section('title', __('order.title'))

@section('content')
<div class="row mt-2">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="text-center text-primary m-0">Ordering Cart Date</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($restaurant as $item)
                    <div class="col-md-2 mb-4">
                        <div class="card h-100">
                            <img src="{{ $item->image_url }}" style="height: 100px; object-fit: cover;" class="card-img-top" alt="{{ $item->name }}">
                            <div class="card-body">
                                <div class="div" style="height:40px">
                                    <h6 class="card-title text-center">{{ $item->name }}</h6>
                                </div>
                                <p class="card-text text-center">${{ $item->price }}</p>
                                <form method="post" action="{{ url('owner/cart/add-item') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $item->name }}">
                                    <input type="hidden" name="price" value="{{ $item->price }}">
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

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h3 class="text-center text-primary m-0">Items Selected</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ url('owner/cart/checkout') }}" enctype="multipart/form-data">
                    @csrf
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $addToCartItem->name }}</td>
                                <td class="text-center">${{ $addToCartItem->price }}</td>
                                <td class="text-center">{{ $addToCartItem->quantity }}</td>
                                <td class="text-center">${{ $addToCartItem->price * $addToCartItem->quantity }}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm" href="{{ url('owner/cart/delete-item/' . $addToCartItem->id) }}" onclick="return confirm('Are you Sure?')"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @php $totalPrice += $addToCartItem->price * $addToCartItem->quantity; @endphp
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2" class="text-center align-middle"><b>Total Price</b></td>
                                <td class="text-center align-middle">${{ $totalPrice }}</td>

                            </tr>

                            <tr>
                                <td colspan="6" class="text-center">
                                    <button type="submit" class="btn btn-warning btn-block">Checkout</button>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
