<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home text-red"></i>
        <p>Home</p>
    </a>
</li>



<li class="nav-item {{ request()->routeIs('gndivisions*','district*','province*','dsdivisions*','hospitals*','advertisements*','shifts*')?'menu-open':'' }}">
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
                <p>User</p>
            </a>
        </li>
    </ul>

</li>
