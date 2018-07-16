

    <div class="container" style="margin-top:17px; margin-bottom:10px;">

        <!-- Left Side Content -->
        <div class="left-side">

            <!-- Logo -->
            <div id="logo" style="margin-top:-3px">
                <a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" alt=""></a>
            </div>

            <!-- Mobile Navigation -->
            <div class="menu-responsive">
                <i class="fa fa-reorder menu-trigger"></i>
            </div>

            <!-- Main Navigation -->
            <nav id="navigation" class="style-1">
                <ul id="responsive">

                    <li><a  href="{{url('/')}}">Home</a>
                    </li>

                    <li><a href="{{url('categorylist')}}">Categories</a>
                    </li>

                    <li><a href="{{url('/contact')}}">Contact</a>
                    </li>
                    <!--
                    <li>
                        @if(Auth::check())
                            @if(Auth::user()->userrole == 'customer')
                                <a href="{{url('dashboard')}}" class="">My Account</a>
                            @else
                            <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim">Login</a>
                            @endif
                        @else
                            <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim">Login</a>
                        @endif
                    </li>
                    -->
                </ul>
            </nav>
            <div class="clearfix"></div>
            <!-- Main Navigation / End -->

        </div>
        <!-- Left Side Content / End -->


        <!-- Right Side Content / End -->
        <div class="right-side">
            <div class="header-widget">
                <table class="header-widget-table"><tr>
                    <td class="sign-in-td">
                    @if(Auth::check())
                        @if(Auth::user()->userrole == 'customer')
                            <a href="{{url('customer')}}" class="sign-in "><i class="sl sl-icon-user"></i>My Account</a>
                        @elseif(Auth::user()->userrole == 'business')
                            <a href="{{url('business')}}" class="sign-in "><i class="sl sl-icon-user"></i>My Account</a>
                        @elseif(Auth::user()->userrole == 'admin')
                            <a href="{{url('admin')}}" class="sign-in "><i class="sl sl-icon-user"></i>My Account</a>
                        @endif
                    @else
                        <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="sl sl-icon-login"></i>Login</a>
                    @endif
                    </td>
                    <td style="text-align:right;">
                        <a href="#business-sign-in-dialog" class="sign-in popup-with-zoom-anim button border with-icon">Add Your Business</a>
                    </td>
                </tr></table>
            </div>
        </div>
        <!-- Right Side Content / End -->

    </div>
    <!-- Sign In Popup -->
    <div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

        <div class="small-dialog-header">
            <h3>Sign In</h3>
        </div>

        <!--Tabs -->
        <div class="sign-in-form style-1">

            <ul class="tabs-nav">
                <li class=""><a href="#tab1">Log In</a></li>
                <li><a href="#tab2">Register</a></li>
            </ul>

            <div class="tabs-container alt">

                <!-- Login -->
                <div class="tab-content" id="tab1" style="display: none;">
                    <form method="post" class="login" method="POST" action="{{ route('login') }}" id="login_form">
                        {{ csrf_field() }}
                        
                        <div class="form-row form-row-wide">
                            <label for="username">Email:
                                <i class="im im-icon-Male"></i>
                                <input id="login_email" type="email" class="input-text" name="email" value="{{ old('email') }}" onkeypress="return login_returnpressed(event)" required autofocus/>
                            </label>
                        </div>

                        <div class="form-row form-row-wide">
                            <label for="password">Password:
                                <i class="im im-icon-Lock-2"></i>
                                <input class="input-text" type="password" name="password" id="login_password" onkeypress="return login_returnpressed(event)" required/>
                            </label>
                        </div>

                        <span class="help-block">
                            <strong id="login_error" style="color:#f00"></strong>
                        </span>

                        <div class="form-row">
                            <input type="button" class="button border margin-top-5 margin-bottom-15" name="login" value="Login" onclick="checkLogIn()"; />
                            <a href="{{ route('password.request') }}" class="redtext">
                                Forgot Your Password?
                            </a>
                            <div class="checkboxes margin-top-10">
                                <input id="remember-me" type="checkbox" name="check">
                                <label for="remember-me">Remember Me</label>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Register -->
                <div class="tab-content" id="tab2" style="display: none;">

                   <form method="POST" action="{{ route('register') }}" class="register" id="register_form">
                       {{csrf_field()}}
                       <p class="form-row form-row-wide">
                           <label for="username2">Username:
                               <i class="im im-icon-Male"></i>
                               <input type="text" class="input-text" name="name" id="register_name" value="{{ old('name') }}"  onkeypress="return register_returnpressed(event)" required autofocus/>
                           </label>
                       </p>

                       <p class="form-row form-row-wide">
                           <label for="email2">Email Address:
                               <i class="im im-icon-Mail"></i>
                               <input type="email" class="input-text" name="email" id="register_email" value="{{ old('email') }}"  onkeypress="return register_returnpressed(event)" required />
                           </label>
                       </p>
                       <input type="hidden" class="form-control" name="userrole" value="customer">
                       <input type="hidden" class="form-control" name="companyname" value="">
                       <input type="hidden" class="form-control" name="package" value="">

                       <p class="form-row form-row-wide">
                           <label for="password1">Password:
                               <i class="im im-icon-Lock-2"></i>
                               <input class="input-text" type="password" name="password" id="register_password"  onkeypress="return register_returnpressed(event)" required/>
                           </label>
                       </p>

                       <p class="form-row form-row-wide">
                           <label for="password2">Repeat Password:
                               <i class="im im-icon-Lock-2"></i>
                               <input class="input-text" type="password" name="password_confirmation" id="register_password_confirmation"  onkeypress="return register_returnpressed(event)" required/>
                           </label>
                       </p>
                       <span class="help-block">
                            <strong id="register_error" style="color:#f00"></strong>
                        </span>
                        <div class="form-row">
                            <input type="button" class="button border fw margin-top-10" name="register" value="Register" onclick="checkRegisterCustomer();" >
                        </div>

                   </form>
                </div>


            </div>
        </div>
        <!-- Sign In Popup / End -->
    </div>
    <!-- Business Sign In Popup -->
    <div id="business-sign-in-dialog" class="zoom-anim-dialog mfp-hide">

        <div class="small-dialog-header">
            <h3> Add Your Business </h3>
        </div>

        <!--Tabs -->
        <div class="sign-in-form style-1">

            <ul class="tabs-nav">
                {{--<li class=""><a href="#tab11">Log In</a></li>--}}
                {{--<li><a href="#tab22">Register</a></li>--}}
            </ul>

            <div class="tabs-container alt">

                <!-- Login -->
                {{--<div class="tab-content" id="tab11" style="display: none;">--}}
                    {{--<form method="post" class="login" method="POST" action="{{ route('login') }}">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<div class="form-row form-row-wide{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                            {{--<label for="username">Username:--}}
                                {{--<i class="im im-icon-Male"></i>--}}
                                {{--<input id="email" type="email" class="input-text" name="email" value="{{ old('email') }}" required autofocus/>--}}
                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}

                            {{--</label>--}}
                        {{--</div>--}}

                        {{--<div class="form-row form-row-wide{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                            {{--<label for="password">Password:--}}
                                {{--<i class="im im-icon-Lock-2"></i>--}}
                                {{--<input class="input-text" type="password" name="password" id="password" required/>--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</label>--}}
                        {{--</div>--}}

                        {{--<div class="form-row">--}}
                            {{--<input type="submit" class="button border margin-top-5" name="login" value="Login" />--}}
                            {{--<a href="{{ route('password.request') }}" class="redtext">--}}
                                {{--Forgot Your Password?--}}
                            {{--</a>--}}
                            {{--<div class="checkboxes margin-top-10">--}}
                                {{--<input id="remember-me" type="checkbox" name="check">--}}
                                {{--<label for="remember-me">Remember Me</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</form>--}}
                {{--</div>--}}

                <!-- Register -->
                <div class="tab-content" id="tab22" style="display: none;">

                    <form method="POST" action="{{ route('register') }}" class="register" id="biz_register_form">
                        {{csrf_field()}}
                        <p class="form-row form-row-wide">
                            <label for="username2">Username:
                                <i class="im im-icon-Male"></i>
                                <input type="text" class="input-text" name="name" id="biz_register_name" value="{{ old('name') }}" onkeypress="return registerbusiness_returnpressed(event)" required autofocus/>
                            </label>
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="email2">Email Address:
                                <i class="im im-icon-Mail"></i>
                                <input type="email" class="input-text" name="email" id="biz_register_email" value="{{ old('email') }}" onkeypress="return registerbusiness_returnpressed(event)" required />
                            </label>
                        </p>
                        <input type="hidden" class="form-control" name="userrole" value="business">
                        <input type="hidden" class="form-control" name="package" value="free">
                        <p class="form-row form-row-wide">
                            <label for="username2">Company Name:
                                <i class="im im-icon-Book"></i>
                                <input type="text" class="input-text" name="companyname" id="biz_register_companyname" value="" onkeypress="return registerbusiness_returnpressed(event)" />
                            </label>
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="password1">Password:
                                <i class="im im-icon-Lock-2"></i>
                                <input class="input-text" type="password" name="password" id="biz_register_password" onkeypress="return registerbusiness_returnpressed(event)" required/>
                            </label>
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="password2">Repeat Password:
                                <i class="im im-icon-Lock-2"></i>
                                <input class="input-text" type="password" name="password_confirmation" id="biz_register_password_confirmation" onkeypress="return registerbusiness_returnpressed(event)" required/>
                            </label>
                        </p>
                        <span class="help-block">
                            <strong id="biz_register_error" style="color:#f00"></strong>
                        </span>
                        <div class="form-row">
                            <input type="button" class="button border fw margin-top-10" name="register" value="Register" onclick="checkRegisterBusiness()" />
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Business Sign In Popup / End -->

<script>
    function login_returnpressed(e) {
        if (e.keyCode == 13) {
            checkLogIn();
        }
    }

    function register_returnpressed(e) {
        if (e.keyCode == 13) {
            checkRegisterCustomer();
        }
    }

    function registerbusiness_returnpressed(e) {
        if (e.keyCode == 13) {
            checkRegisterBusiness();
        }
    }

    function checkLogIn()
    {
        $.ajax({
            url: "{{url('/check/login')}}",
            type: "GET",
            async : true,
            data: "email="+$("#login_email").val()+"&password="+$("#login_password").val(),
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#login_error").html("Error in login");
            },
            success: function (data) {
                obj = $.parseJSON(data);
                if (obj.res == "success")
                {
                    $("#login_form").submit();
                }
                else
                {
                    $("#login_error").html(obj.status);
                }
            }
        });
    }

    function checkRegisterCustomer()
    {
        username = $("#register_name").val();
        email = $("#register_email").val();
        password = $("#register_password").val();
        password1 = $("#register_password_confirmation").val();

        if (username.length == 0)
        {
            $("#register_error").html("Input Username");
            return;
        }
        if (email.length == 0)
        {
            $("#register_error").html("Input Email");
            return;
        }
        if (password.length < 6)
        {
            $("#register_error").html("Password must be at least 6 characters");
            return;
        }
        if (password != password1)
        {
            $("#register_error").html("Please type password correctly");
            return;
        }

        $.ajax({
            url: "{{url('/check/register')}}",
            type: "GET",
            async : true,
            data: "name="+username+"&email="+email,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#register_error").html("Error in register");
            },
            success: function (data) {
                obj = $.parseJSON(data);
                if (obj.res == "success")
                {
                    $("#register_form").submit();
                }
                else
                {
                    $("#register_error").html(obj.status);
                }
            }
        });
    }

    function checkRegisterBusiness()
    {
        username = $("#biz_register_name").val();
        email = $("#biz_register_email").val();
        companyname = $("#biz_register_companyname").val();
        password = $("#biz_register_password").val();
        password1 = $("#biz_register_password_confirmation").val();

        if (username.length == 0)
        {
            $("#biz_register_error").html("Input Username");
            return;
        }
        if (email.length == 0)
        {
            $("#biz_register_error").html("Input Email");
            return;
        }
        if (companyname.length == 0)
        {
            $("#biz_register_error").html("Input Company name");
            return;
        }
        if (password.length < 6)
        {
            $("#biz_register_error").html("Password must be at least 6 characters");
            return;
        }
        if (password != password1)
        {
            $("#biz_register_error").html("Please type password correctly");
            return;
        }

        $.ajax({
            url: "check/register",
            type: "GET",
            async : true,
            data: "name="+username+"&email="+email,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#biz_register_error").html("Error in register");
            },
            success: function (data) {
                obj = $.parseJSON(data);
                if (obj.res == "success")
                {
                    $("#biz_register_form").submit();
                }
                else
                {
                    $("#biz_register_error").html(obj.status);
                }
            }
        });
    }

</script>
