
<header id="header-container" class="fixed fullwidth dashboard">

    <!-- Header -->
    <div id="header" class="not-sticky">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" alt=""></a>
                    <a href="{{url('/')}}" class="dashboard-logo"><img src="{{asset('images/dashboard_logo.png')}}" alt=""></a>
                </div>

                <!-- Mobile Navigation -->
                <div class="menu-responsive">
                    <i class="fa fa-reorder menu-trigger"></i>
                </div>
                <div class="clearfix"></div>

            </div>

            <div class="right-side">
                <!-- Header Widget -->
                <div class="header-widget">

                    <!-- User Menu -->
                    <div class="user-menu">
                        <div class="user-name"><span><img src="{{asset(Auth::user()->userprofile)}}" alt=""></span>
                            {{Auth::user()->name}}
                        </div>
                        <ul>

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

                    {{--<a href="dashboard-add-listing.html" class="button border with-icon">Add Listing <i class="sl sl-icon-plus"></i></a>--}}
                </div>
                <!-- Header Widget / End -->
            </div>
            <!-- Right Side Content / End -->

        </div>
    </div>
    <!-- Header / End -->

</header>