<a href="#" class="dashboard-responsive-nav-trigger" style="max-height:59px;"><i class="fa fa-reorder"></i> Navigation</a>

<div class="dashboard-nav">
    <div class="dashboard-nav-inner">

        <ul data-submenu-title="Main">
            @if($title=='Dashboard')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/dashboard')}}"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
            @if($title=='Admin Users')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/adminusers')}}"><i class="sl sl-icon-user-following"></i> Admin Users</a></li>
            @if($title=='Sales Staff')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/salesstaff')}}"><i class="sl sl-icon-wallet"></i> Sales Staff</a></li>
            @if($title=='Categories')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/categories')}}"><i class="sl sl-icon-notebook"></i> Categories</a></li>
            @if($title=='Package Price')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/packageprice')}}"><i class="sl sl-icon-present"></i> Package Price</a></li>
            @if($title=='Setting')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/setting')}}"><i class="sl sl-icon-settings"></i> Setting</a></li>
        </ul>

        <ul data-submenu-title="Manage">
            @if($title=='Customers')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/customers')}}"><i class="sl sl-icon-user-female"></i> Customers</a></li>
            @if($title=='Business')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/business')}}"><i class="sl sl-icon-briefcase"></i> Business</a></li>
            @if($title=='Reviews')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/review')}}"><i class="sl sl-icon-like"></i> Reviews</a></li>
            @if($title=='Contact Message')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/contact')}}"><i class="sl sl-icon-envelope-open"></i> Contact Message</a></li>
            @if($title=='Professional Header')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/professionalheader')}}"><i class="sl sl-icon-picture"></i> Professional Header</a></li>
        </ul>

        <ul data-submenu-title="Account">
            @if($title=='My Profile')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('admin/profile')}}"><i class="sl sl-icon-user"></i> My Profile</a></li>
            <li>
                <a href="{{ url('admin/logout') }}">
                    <i class="sl sl-icon-power"></i> Logout
                </a>
            </li>
        </ul>

    </div>
</div>