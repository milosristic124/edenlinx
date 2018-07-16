
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
    <div id="header-container">
        <div id="header">
            @include('includes.header')
        </div>
    </div>
    <div id="content">
        @section('content')
        @show
    </div>

    <div id="footer" class="sticky-footer">
        @include('includes.footer')
    </div>
    @include('includes.foot')
</div>
</body>
</html>