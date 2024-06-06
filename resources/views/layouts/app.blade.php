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
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.css" /> --}}


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
        @if (Auth::check() && Auth::user()->restaurant)
            var restaurantId = {{ Auth::user()->restaurant->id }};
            // Initialize Pusher and subscribe to the restaurant channel
            var pusher = new Pusher('234577bd0d1513d54647', {
                cluster: 'ap2',
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    }
                }
            });
    
            var channel = pusher.subscribe('restaurant.' + restaurantId);
    
            // Bind to the 'App\\Events\\OrderPlacedEvent' event
            channel.bind('App\\Events\\OrderPlacedEvent', function(data) {
                var soundPath = "{{ asset('sounds/sweet_girl.mp3') }}";
                var orderId = data.order.id;
                var userName = data.user.first_name + ' ' + data.user.last_name;
                var tableNo = data.order.table_no;
    
                var toastContent = `
                    <div>
                        New order received - Order ID: ${orderId}, User: ${userName}, Table No: ${tableNo}
                        <br>
                        <button id="acceptButton" class="btn btn-success btn-sm" style="margin-top: 10px;">Accept</button>
                        <button id="notAcceptButton" class="btn btn-danger btn-sm" style="margin-top: 10px;">Not Accept</button>
                    </div>
                `;
    
                toastr.success(
                    toastContent,
                    '', {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        onShown: function() {
                            var audio = new Audio(soundPath);
                            audio.play();
    
                            document.getElementById('acceptButton').addEventListener('click', function() {
                                toastr.remove();
                                handleOrderAction(orderId, true);
                            });
                            document.getElementById('notAcceptButton').addEventListener('click', function() {
                                toastr.remove();
                                handleOrderAction(orderId, false);
                            });
                        }
                    }
                );
            });
    
            // Function to handle order action (accept or reject)
            function handleOrderAction(orderId, isAccepted) {
                var url = '/api/orders/' + orderId + '/status';
                var data = {
                    status: isAccepted ? 'accepted' : 'rejected'
                };
    
                fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show notification to the user based on the order status
                        var notificationMessage = isAccepted ? 'Your order has been accepted.' : 'Your order has been rejected.';
                        toastr.success(notificationMessage);
                    } else {
                        alert('Error: ' + data.message);
                    }
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
        @else
            console.error('User is not authenticated or has no associated restaurant.');
        @endif
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
    <script src="{{ asset('admin/js/admin.js') }}"></script>

    {{-- sweetalert cdn --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
