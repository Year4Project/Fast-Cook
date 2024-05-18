<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


    @if (Auth::user()->user_type == 1)
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin/dashboard') }}">
            <img src="{{ asset('admin/img/logo.png') }}" alt="Logo" class="img-fluid sidebar-logo" style="width: 50px"> <!-- Adjust path and class as needed -->
            <div class="sidebar-brand-text mx-2">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/admin/showAdmin') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Admin</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/restaurant/showRestaurant') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Restaurants</span></a>
        </li>
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>
    @elseif(Auth::user()->user_type == 2)
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('owner/dashboard') }}">
            <img src="{{ asset('admin/img/logo.png') }}" alt="Logo" class="img-fluid sidebar-logo" style="width: 50px"> <!-- Adjust path and class as needed -->
            <div class="sidebar-brand-text mx-3">{{ Auth::user()->restaurant->name }}</div>
        </a>
        
        

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('owner/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            POS & ORDER
        </div>
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('owner/cart/index') }}">
                <i class="fas fa-desktop"></i>
                <span>Point Of Sale</span></a>

            {{-- <a class="nav-link" href="{{ url('owner/cart/customerOrder') }}">
                    <i class="fas fa-desktop"></i>
                <span>POS Order</span></a> --}}
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-fw fa-cog"></i>
                <span>Orders</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <h6 class="collapse-header">Employee  Components:</h6> --}}
                    <a class="collapse-item" href="{{ url('owner/cart/customerOrder/') }}">POS Orders</a>
                    <a class="collapse-item" href="{{ url('owner/order/userOrder/') }}">App Orders</a>
                    {{-- <a class="collapse-item" href="#">Pending Orders</a>
                    <a class="collapse-item" href="#">Progress Orders</a>
                    <a class="collapse-item" href="#">Delivered Orders</a>
                    <a class="collapse-item" href="#">Completed Orders</a>
                    <a class="collapse-item" href="#">Cash On Delivery</a> --}}
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Manage Restaurant
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/category/typeFood') }}">
                <i class="fas fa-layer-group"></i>
                <span>Category</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/food/showFood') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Products</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            USER
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/staff/listStaff') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Employee</span></a>
        </li>

        <!-- Divider -->

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/qr/generateQRCode') }}">
                <i class="fas fa-fw fa-key"></i>
                <span>Generate QR</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/chat/chat') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Chats</span></a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-receipt"></i>
                <span>Report</span></a>
        </li>
    @endif



    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ url('logout') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

</ul>
