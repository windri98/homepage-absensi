<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <span class="nav-text">Home</span>
    </a>
    
    <a href="{{ route('attendance.clock-in') }}" class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clock"></i>
        <span class="nav-text">Attendance</span>
    </a>
    
    <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tasks"></i>
        <span class="nav-text">Tasks</span>
    </a>
    
    <a href="{{ route('profile.show') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <span class="nav-text">Profile</span>
    </a>
</nav>