
<div class="dashboard-nav">
    <div class="dashboard-nav-inner">

        <ul data-submenu-title="Main">
            <li><a href="{{url('business/dashboard')}}"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
            <li><a href="{{url('business/packages')}}"><i class="sl sl-icon-social-dropbox"></i> Packages</a></li>
            <li><a href="" style="color: grey;"><i class="sl sl-icon-envelope-open"></i> Messages <span class="nav-tag messages">2</span></a></li>
        </ul>

        <ul data-submenu-title="Listings">
            <li><a id="nav-listing" style="color: grey;"><i class="sl sl-icon-layers"></i> My Projects</a>
                <ul>
                    <li><a href="" style="color: grey;">Active <span class="nav-tag green">6</span></a></li>
                    <li><a href="" style="color: grey;">Pending <span class="nav-tag yellow">1</span></a></li>
                    <li><a href="" style="color: grey;">Completed <span class="nav-tag red">2</span></a></li>
                </ul>
            </li>
            {{--<li><a href="dashboard-reviews.html"><i class="sl sl-icon-star"></i> Reviews</a></li>--}}
            {{--<li><a href="dashboard-bookmarks.html"><i class="sl sl-icon-heart"></i> Bookmarks</a></li>--}}
            <li><a href="{{url('business')}}"><i class="sl sl-icon-plus"></i> Business Listing</a></li>
            <!--<li><a href="{{url('business/weeklyemail')}}"><i class="sl sl-icon-plus"></i> Weekly Email Report</a></li>-->
            <li><a href="" style="color: grey;"><i class="sl sl-icon-target"></i> Advertising</a></li>
        </ul>

        <ul data-submenu-title="Account">
            <li><a href="{{url('business/profile')}}"><i class="sl sl-icon-user"></i> My Profile</a></li>
            <li>
                <a href="{{ url('business/logout') }}">
                    <i class="sl sl-icon-power"></i> Logout
                </a>
            </li>
        </ul>

    </div>
</div>