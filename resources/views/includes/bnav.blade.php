<a href="#" class="dashboard-responsive-nav-trigger" style="max-height:59px;"><i class="fa fa-reorder"></i> Navigation</a>

<div class="dashboard-nav">
    <div class="dashboard-nav-inner">

        <ul data-submenu-title="Main">
            <!--<li><a href="{{url('business/dashboard')}}"><i class="sl sl-icon-settings"></i> Dashboard</a></li>-->
            @if(Auth::user()->package != "free" && Auth::user()->package != "basic")
            @if($title=='Dashboard')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('business/dashboard')}}" class="grey-text"><i class="sl sl-icon-settings"></i> Dashboard</a></li>
            @endif
            @if($title=='Listing Packages')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('business/packages')}}"><i class="sl sl-icon-social-dropbox"></i> Packages</a></li>
            @if($title=='Messages')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('business/message')}}"><i class="sl sl-icon-envelope-open"></i> Messages <span class="nav-tag messages" id="nav_badge_message" style="display:none"></span></a></li>

            @if(Auth::user()->package != "free" && Auth::user()->package != "basic")
            @if($title=='Projects')
            <li class="active">
            @else
            <li>
            @endif
            <a id="nav-listing" class="grey-text"><i class="sl sl-icon-layers"></i> Projects</a>
                <ul>
                    @if($title=='Projects' && $status==0)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('business/projects/0')}}" >Pending <!-- <span class="nav-tag green">6</span> --> </a></li>
                    @if($title=='Projects' && $status==1)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('business/projects/1')}}" >Active <!-- <span class="nav-tag green">6</span> --> </a></li>
                    @if($title=='Projects' && $status==2)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('business/projects/2')}}" >Completed <!-- <span class="nav-tag yellow">1</span> --> </a></li>
                    @if($title=='Projects' && $status==3)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('business/projects/3')}}" >Approved <!-- <span class="nav-tag red">2</span> --> </a></li>
                </ul>
            </li>
            @endif
            {{--<li><a href="dashboard-reviews.html"><i class="sl sl-icon-star"></i> Reviews</a></li>--}}
            {{--<li><a href="dashboard-bookmarks.html"><i class="sl sl-icon-heart"></i> Bookmarks</a></li>--}}
            @if($title=='Business Listing')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('business/business')}}"><i class="sl sl-icon-plus"></i> Business Listing</a></li>
            {{--<li><a href="{{url('business/weeklyemail')}}"><i class="sl sl-icon-plus"></i> Weekly Email Report</a></li>--}}
            {{--<li><a style="color: grey;"><i class="sl sl-icon-target"></i> Advertising</a></li>--}}
        </ul>

        <ul data-submenu-title="Account">
            @if($title=='My Profile')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('business/profile')}}"><i class="sl sl-icon-user"></i> My Profile</a></li>
            <li>
                <a href="{{ url('business/logout') }}">
                    <i class="sl sl-icon-power"></i> Logout
                </a>
            </li>
        </ul>

    </div>
</div>


<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{url('/navinfo/business')}}",
            type: "GET",
            async : true,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#nav_badge_message").html();
                $("#nav_badge_message").hide();
            },
            success: function (data) {
                obj = $.parseJSON(data);
                console.log(obj);
                if (obj.res == "success")
                {
                    if (obj.unreadmessage > 0)
                    {
                        $("#nav_badge_message").html(obj.unreadmessage);
                        $("#nav_badge_message").show();
                    }
                    else
                    {
                        $("#nav_badge_message").html();
                        $("#nav_badge_message").hide();
                    }
                }
            }
        });
    });
</script>