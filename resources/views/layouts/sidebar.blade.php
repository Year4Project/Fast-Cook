<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    @php
    use Illuminate\Support\Facades\Auth;
@endphp


    @if (Auth::user()->user_type == 1)
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin/dashboard') }}">
            <div class="sidebar-brand-text mx-3">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
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
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>
    @elseif(Auth::user()->user_type == 2)
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('owner/dashboard') }}">
            <div class="sidebar-brand-text mx-3">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
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
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('owner/pos/pos_system') }}">
                <i class="fas fa-desktop"></i>
                <span>POS System</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Function
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/category/typeFood') }}">
                <i class="fas fa-layer-group"></i>
                <span>Category</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/food/showFood') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Food Menu</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/order/userOrder/') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Order Food</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Employee</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Employee  Components:</h6>
                    <a class="collapse-item" href="{{ url('owner/staff/listStaff') }}">List Employee</a>
                    <a class="collapse-item" href="cards.html">History Order</a>
                </div>
            </div>
        </li>

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
        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ url('owner/profile/profile') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profile</span></a>
        </li> --}}

        {{-- @elseif(Auth::user()->user_type == 3)
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('user/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider"> --}}
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


</ul>
