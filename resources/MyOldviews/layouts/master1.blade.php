<html>
<head>
    <title>@yield('title')</title>
    @include('includes.head')
</head>
<body>
<div id="wrapper">
    @include('includes.dheader')
    <div id="dashboard">
        @include('includes.bnav')
        <div class="dashboard-content">
            <div id="titlebar">
                <div class="row">
                    <div class="col-md-12">
                        <h2>@yield('menuitem')</h2>
                    </div>
                </div>
            </div>
            @section('dashboardcontent')
            @show
        </div>
    </div>

    @include('includes.foot')
</div>
</body>
</html>