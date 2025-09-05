<div class="md:hidden border-t border-gray-200 dark:border-gray-700">
    <div class="flex justify-around">
        <a href="{{route('customer.dashboard')}}" class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" data-page="dashboard-page">
            <span class="nav-icon"><i class="fas fa-th-large"></i></span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{route('customer.applications')}}" class="nav-item {{ request()->routeIs('customer.applications') ? 'active' : '' }} {{ request()->routeIs('customer.application.detail') ? 'active' : '' }}" data-page="applications-page">
            <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
            <span class="nav-text">Applications</span>
        </a>
        <a href="{{route('customer.transactions')}}" class="nav-item {{ request()->routeIs('customer.transactions') ? 'active' : '' }}" data-page="payments-page">
            <span class="nav-icon"><i class="fas fa-credit-card"></i></span>
            <span class="nav-text">Transactions</span>
        </a>
    </div>
</div>