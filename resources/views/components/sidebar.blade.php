<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">WISATA KODENET</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('dashboard-general-dashboard') }}">General Dashboard</a>
                    </li>
                    <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'users' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('users') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}">All Users</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'categories' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Categories</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('categories') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('categories.index') }}">All category</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'products' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('products') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('products.index') }}">All product</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
