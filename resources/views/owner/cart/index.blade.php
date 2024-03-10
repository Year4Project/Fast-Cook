@extends('layouts.app')

@section('title', __('order.title'))

@section('content')

    <div class="container-fluid">
        <div class="cold-md-12">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-center">Ordering Cart Date</h2>

                    <div class="col-md-12">
                        <div class="row">
                            @foreach ($restaurant as $item)
                                <div class="col-md-4">
                                    <form method="post" action="{{ url('owner/cart/add-item') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <img src="{{ $item->image_url }}" style="height: 150px" alt="">
                                        <h5 class="text-center">{{ $item->name }}</h5>
                                        <h5 class="text-center">${{ $item->price }}</h5>
                                        <input type="hidden" name="name" value="{{ $item->name }}">
                                        <input type="hidden" name="price" value="{{ $item->price }}">
                                        <input type="number" name="quantity" value="1" class="form-control">
                                        <input type="submit" name="add_to_cart" class="btn btn-warning btn-block my-2" value="Add To Cart">
                                    </form>
                                </div>
                            @endforeach

                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="text-center">Item Selected</h2>
                </div>
            </div>
        </div>

    </div>

@endsection
