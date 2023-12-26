@extends("layouts.app")

@section("content")

<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chats</h1>
    </div>

   
        <div id="app">
            <chat></chat>
        </div>
 



    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

@endsection
