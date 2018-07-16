<!DOCTYPE html>

<html>
<head>
<meta name="description" content="Generating more customers to grow your business through convenience and simplicity." />
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106983337-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-106983337-1');
</script>
    <title>EDENLINX - @yield('title')</title>
    @include('includes.head')
</head>

<body>
<div id="wrapper">
    @include('includes.dheader')
    <div id="dashboard">
        @include('includes.anav')
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
        <div style="min-height: 100vh;background-color: #f7f7f7;"></div>
    </div>

    @include('includes.foot')
</div>
</body>
</html>