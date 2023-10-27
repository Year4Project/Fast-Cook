

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div> --}}

    @if (Auth::user()->user_type == 1)
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
            <a class="nav-link" href="charts.html">
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
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('owner/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Category
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('owner/listMenu') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>List Food</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-book"></i>
            <span>Order Food</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('owner/generateQRCode') }}">
            <i class="fas fa-fw fa-key"></i>
            <span>Generate QR</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-box"></i>
            <span>Chats</span></a>
    </li>
    @elseif(Auth::user()->user_type == 3)
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('user/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
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

