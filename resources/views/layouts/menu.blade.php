<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home text-red"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('patient_requests.pendingapprove','patient_requests.pendingDeposit')?'menu-open':'' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-briefcase text-green"></i>
        <p>
            Job Mgt
            <i class="right fas fa-angle-left text-green"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('patient_requests.pendingapprove')}}" class="nav-link
            {{ request()->routeIs('patient_requests.pendingapprove')?'active':'' }}">
                <i class="far fa-circle nav-icon text-green"></i>
                <p>Pending Payments</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('patient_requests.pending_service')}}" class="nav-link
            {{ request()->routeIs('patient_requests.pending_service')?'active':'' }}">
                <i class="far fa-circle nav-icon text-green"></i>
                <p>Pending Service</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('patient_requests.pendingDeposit')}}" class="nav-link
            {{ request()->routeIs('patient_requests.pendingDeposit')?'active':'' }}">
                <i class="far fa-circle nav-icon text-green"></i>
                <p>Pending Deposit</p>
            </a>
        </li>
    </ul>
</li>



<li class="nav-item {{ request()->routeIs('gndivisions*','district*','province*',
                    'dsdivisions*','hospitals*','advertisements*','shifts*','languages*','payment_methods*',
                    'relations*')?'menu-open':'' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cogs text-blue"></i>
        <p>
            Master Data
            <i class="right fas fa-angle-left text-blue"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('province.index')}}" class="nav-link
            {{ request()->routeIs('province*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Province</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('district.index')}}" class="nav-link
            {{ request()->routeIs('district*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>District</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('dsdivisions.index')}}" class="nav-link
            {{ request()->routeIs('dsdivisions*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>DS Division</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('gndivisions.index')}}" class="nav-link
            {{ request()->routeIs('gndivisions*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>GN Division</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('hospitals.index')}}" class="nav-link
            {{ request()->routeIs('hospitals*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Hospital</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('advertisements.index')}}" class="nav-link
            {{ request()->routeIs('advertisements*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Advertisements</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('shifts.index')}}" class="nav-link
            {{ request()->routeIs('shifts*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Shift</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('languages.index')}}" class="nav-link
            {{ request()->routeIs('languages*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Language</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('payment_methods.index')}}" class="nav-link
            {{ request()->routeIs('payment_methods*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Payment Method</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('relations.index')}}" class="nav-link
            {{ request()->routeIs('relations*')?'active':'' }}">
                <i class="far fa-circle nav-icon text-blue"></i>
                <p>Relation</p>
            </a>
        </li>
    </ul>

</li>


<li class="nav-item {{ request()->routeIs('users*', 'roles*','logindetails.index')?'menu-open':'' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt text-purple"></i>
        <p>
            System Management
            <i class="right fas fa-angle-left text-purple"></i>
        </p>
    </a>


    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('roles.index')}}" class="nav-link
            {{ request()->routeIs('roles.edit','roles.index')?'active':'' }}">
                <i class="far fa-circle nav-icon text-purple"></i>
                <p>User Roles</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link
            {{ request()->routeIs('users.index','users.edit')?'active':'' }}">
                <i class="far fa-circle nav-icon text-purple"></i>
                <p>Admin User</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('users.patient')}}" class="nav-link
            {{ request()->routeIs('users.patient')?'active':'' }}">
                <i class="far fa-circle nav-icon text-purple"></i>
                <p>Patient User</p>
            </a>
        </li>
    </ul>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('users.care_taker')}}" class="nav-link
            {{ request()->routeIs('users.care_taker')?'active':'' }}">
                <i class="far fa-circle nav-icon text-purple"></i>
                <p>Care Taker User</p>
            </a>
        </li>
    </ul>

</li>
