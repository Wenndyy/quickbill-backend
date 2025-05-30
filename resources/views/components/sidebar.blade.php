{{-- sidebar.blade.php --}}
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">QUICKBILL</a>
        </div>
        <div class="sidebar-brand-sm">
            <a href="{{ route('home') }}">QB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item {{ Request::routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('user.*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="nav-link {{ Request::routeIs('user.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>User</span>
                </a>
            </li>
             <li class="nav-item {{ Request::routeIs('categories.*') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link {{ Request::routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags "></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('product.*') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="nav-link {{ Request::routeIs('product.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Product</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('order.*') ? 'active' : '' }}">
                <a href="{{ route('order.index') }}" class="nav-link {{ Request::routeIs('order.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>
               <li class="nav-item {{ Request::routeIs('profile.*') ? 'active' : '' }}">
                <a href="{{ route('profile.index') }}" class="nav-link {{ Request::routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas  fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
    </aside>
</div>

