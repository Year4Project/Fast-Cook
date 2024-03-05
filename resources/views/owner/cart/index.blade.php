@extends('layouts.app')

@section('content')
<div class="big-banner">
    <div class="container-fluid">

        {{-- Alert Massage --}}
        @include('_massage')

        <div id="cart"></div>

    </div>
</div>
@endsection
