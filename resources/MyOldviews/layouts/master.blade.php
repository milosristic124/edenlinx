
<html>
<head>
    <title>@yield('title')</title>
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