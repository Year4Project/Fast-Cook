<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="x-icon" href="{{ asset('admin/img/logo.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ !empty($header_title) ? $header_title : '' }} - Restaurant</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('restaurant/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.css" />

  
    <!-- Include toastr CSS -->

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Pusher and Laravel Echo -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>

    <!-- Include toastr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
    
        // Initialize Pusher with your app key and cluster
        var pusher = new Pusher('234577bd0d1513d54647', {
            cluster: 'ap2'
        });
    
        // Subscribe to the 'restaurant-channel' channel
        var channel = pusher.subscribe('restaurant-channel');
    
        // Bind to the 'App\\Events\\OrderPlacedEvent' event
        channel.bind('App\\Events\\OrderPlacedEvent', function(data) {
            // Generate the URL for the sound file
            var soundPath = "{{ asset('sounds/sweet_girl.mp3') }}";
    
            // Extract order information from the event data
            var orderId = data.order.id;
            var userName = data.user.first_name + ' ' + data.user.last_name;
            var tableNo = data.order.table_no;
    
            // Display a success toast with the order details and play a sound
            toastr.success(
                'New order received - Order ID: ' + orderId + ', User: ' + userName + ', Table No: ' + tableNo, 
                '',
                {
                    timeOut: 5000, // Duration before toast disappears
                    extendedTimeOut: 0, // Time the toast remains after hovering
                    onShown: function() {
                        var audio = new Audio(soundPath);
                        audio.play();
                    }
                }
            );
    
            // Reload the page after 3 seconds (if the mouse is not hovering over the toast)
            setTimeout(function() {
                if (!$('.toast:hover').length) {
                    window.location.reload();
                }
            }, 5000); // Adjust the delay as needed
        });
    </script>
    
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            @include('layouts.topbar', ['class' => 'sticky-top'])

            <!-- Main Content -->
            <div id="content">

                @yield('content')

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <!-- Modal content here -->
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('admin/js/image_preview.js') }}"></script>

       {{-- sweetalert cdn --}}
       <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
