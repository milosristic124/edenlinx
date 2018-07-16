<a href="#" class="dashboard-responsive-nav-trigger" style="max-height:59px;"><i class="fa fa-reorder"></i> Navigation</a>
<div class="dashboard-nav">
    <div class="dashboard-nav-inner">

        <ul data-submenu-title="Main">
            @if($title=='Dashboard')
            <li class="active">
            @else
            <li>
            @endif
            <!-- <a href="{{url('customer/dashboard')}}"><i class="sl sl-icon-settings"></i> Dashboard</a></li> -->
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
                    <a href="{{url('customer/projects/0')}}" >New <!-- <span class="nav-tag green">6</span> --> </a></li>
                    @if($title=='Projects' && $status==1)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('customer/projects/1')}}" >Active <!-- <span class="nav-tag green">6</span> --> </a></li>
                    @if($title=='Projects' && $status==2)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('customer/projects/2')}}" >Pending <!-- <span class="nav-tag yellow">1</span> --> </a></li>
                    @if($title=='Projects' && $status==3)
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="{{url('customer/projects/3')}}" >Completed <!-- <span class="nav-tag red">2</span> --> </a></li>
                </ul>
            </li>
            @if($title=='Messages')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('customer/message')}}"><i class="sl sl-icon-envelope-open"></i> Messages <span class="nav-tag messages" id="nav_badge_message" style="display:none"></span></a></li>
        </ul>

        <ul data-submenu-title="Account">
            @if($title=='My Profile')
            <li class="active">
            @else
            <li>
            @endif
            <a href="{{url('customer/profile')}}"><i class="sl sl-icon-user"></i> My Profile</a></li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="sl sl-icon-power"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>

    </div>
</div>

<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{url('/navinfo/customer')}}",
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