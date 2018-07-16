
<div class="dashboard-nav">
    <div class="dashboard-nav-inner">

        <ul data-submenu-title="Main">
            <li><a href="{{url('dashboard')}}"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
            <li><a href="{{url('packages')}}"><i class="sl sl-icon-social-dropbox"></i> Packages</a></li>
            <li><a href="{{url('message')}}"><i class="sl sl-icon-envelope-open"></i> Messages <span class="nav-tag messages">2</span></a></li>
        </ul>

        <ul data-submenu-title="Listings">
            <li><a id="nav-listing"><i class="sl sl-icon-layers"></i> My Listings</a>
                <ul>
                    <li><a href="{{url('active')}}">Active <span class="nav-tag green">6</span></a></li>
                    <li><a href="{{url('pending')}}">Pending <span class="nav-tag yellow">1</span></a></li>
                    <li><a href="{{url('completed')}}">Completed <span class="nav-tag red">2</span></a></li>
                </ul>
            </li>
            {{--<li><a href="dashboard-reviews.html"><i class="sl sl-icon-star"></i> Reviews</a></li>--}}
            {{--<li><a href="dashboard-bookmarks.html"><i class="sl sl-icon-heart"></i> Bookmarks</a></li>--}}
            <li><a href="{{url('businesspage')}}"><i class="sl sl-icon-plus"></i> Business Listing</a></li>
        </ul>

        <ul data-submenu-title="Account">
            <li><a href="{{url('profile')}}"><i class="sl sl-icon-user"></i> My Profile</a></li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="sl sl-icon-power"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>

    </div>
</div>