

    <div class="container">

        <!-- Left Side Content -->
        <div class="left-side">

            <!-- Logo -->
            <div id="logo">
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

                    <li><a href="{{url('category')}}">Categories</a>
                    </li>

                    <li><a href="{{url('/contact')}}">Contact</a>
                    </li>

                    <li>
                        @if(Auth::check())
                            @if(Auth::user()->userrole == 'customer')
                                <a href="{{url('dashboard')}}" class="">My Account</a>
                            @else
                            <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim">Login/Register</a>
                            @endif
                        @else
                            <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim">Login/Register</a>
                        @endif
                    </li>

                </ul>
            </nav>
            <div class="clearfix"></div>
            <!-- Main Navigation / End -->

        </div>
        <!-- Left Side Content / End -->


        <!-- Right Side Content / End -->
        <div class="right-side">
            <div class="header-widget">
                @if(Auth::check())
                    <a href="{{url('business')}}" class="button border with-icon">Add Your Business</a>
                @else
                    <a href="#business-sign-in-dialog" class="sign-in popup-with-zoom-anim button border with-icon">Add Your Business</a>
                @endif
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
                    <form method="post" class="login" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-row form-row-wide{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="username">Username:
                                {{--<i class="im im-icon-Male"></i>--}}
                                <input id="email" type="email" class="input-text" name="email" value="{{ old('email') }}" required autofocus/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </label>
                        </div>

                        <div class="form-row form-row-wide{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password:
                                {{--<i class="im im-icon-Lock-2"></i>--}}
                                <input class="input-text" type="password" name="password" id="password" required/>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </label>

                        </div>

                        <div class="form-row">
                            <input type="submit" class="button border margin-top-5" name="login" value="Login" />
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

                    <form method="POST" action="{{ route('register') }}" class="register">
                        {{csrf_field()}}
                        <p class="form-row form-row-wide{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="username2">Username:
                                {{--<i class="im im-icon-Male"></i>--}}
                                <input type="text" class="input-text" name="name" id="name" value="{{ old('name') }}" required autofocus/>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </p>

                        <p class="form-row form-row-wide{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email2">Email Address:
                                {{--<i class="im im-icon-Mail"></i>--}}
                                <input type="email" class="input-text" name="email" id="email" value="{{ old('email') }}" required />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </p>
                        <input type="hidden" class="form-control" name="userrole" value="customer">
                        <input type="hidden" class="form-control" name="companyname" value="">
                        <input type="hidden" class="form-control" name="package" value="">
                        {{--<p class="form-row form-row-wide">--}}
                        {{--<label for="username2">Company Name:--}}
                        {{--<i class="im im-icon-Male"></i>--}}
                        {{--<input type="text" class="input-text" name="companyname" id="companyname" value="" />--}}
                        {{--</label>--}}
                        {{--</p>--}}

                        <p class="form-row form-row-wide{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password1">Password:
                                {{--<i class="im im-icon-Lock-2"></i>--}}
                                <input class="input-text" type="password" name="password" id="password" required/>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="password2">Repeat Password:
                                {{--<i class="im im-icon-Lock-2"></i>--}}
                                <input class="input-text" type="password" name="password_confirmation" id="password_confirmation" required/>
                            </label>
                        </p>
                        <input type="submit" class="button border fw margin-top-10" name="register" value="Register" />

                    </form>
                </div>

            </div>
        </div>
        <!-- Sign In Popup / End -->
    </div>
    <!-- Business Sign In Popup -->
    <div id="business-sign-in-dialog" class="zoom-anim-dialog mfp-hide">

        <div class="small-dialog-header">
            <h3> Sign Up Business </h3>
        </div>

        <!--Tabs -->
        <div class="sign-in-form style-1">

            <ul class="tabs-nav">
                <!--<li class=""><a href="#tab11">Log In</a></li>-->
                <!--<li><a href="#tab22">Register</a></li>-->
            </ul>

            <div class="tabs-container alt">

                <!-- Login -->
                <!--<div class="tab-content" id="tab11" style="display: none;">-->
                <!--    <form method="post" class="login" method="POST" action="{{ route('login') }}">-->
                <!--        {{ csrf_field() }}-->
                <!--        <div class="form-row form-row-wide{{ $errors->has('email') ? ' has-error' : '' }}">-->
                <!--            <label for="username">Username:-->
                <!--                {{--<i class="im im-icon-Male"></i>--}}-->
                <!--                <input id="email" type="email" class="input-text" name="email" value="{{ old('email') }}" required autofocus/>-->
                <!--                @if ($errors->has('email'))-->
                <!--                    <span class="help-block">-->
                <!--                        <strong>{{ $errors->first('email') }}</strong>-->
                <!--                    </span>-->
                <!--                @endif-->

                <!--            </label>-->
                <!--        </div>-->

                <!--        <div class="form-row form-row-wide{{ $errors->has('password') ? ' has-error' : '' }}">-->
                <!--            <label for="password">Password:-->
                <!--                {{--<i class="im im-icon-Lock-2"></i>--}}-->
                <!--                <input class="input-text" type="password" name="password" id="password" required/>-->

                <!--                @if ($errors->has('password'))-->
                <!--                    <span class="help-block">-->
                <!--                        <strong>{{ $errors->first('password') }}</strong>-->
                <!--                    </span>-->
                <!--                @endif-->
                <!--            </label>-->
                <!--        </div>-->

                <!--        <div class="form-row">-->
                <!--            <input type="submit" class="button border margin-top-5" name="login" value="Login" />-->
                <!--            <a href="{{ route('password.request') }}" class="redtext">-->
                <!--                Forgot Your Password?-->
                <!--            </a>-->
                <!--            <div class="checkboxes margin-top-10">-->
                <!--                <input id="remember-me" type="checkbox" name="check">-->
                <!--                <label for="remember-me">Remember Me</label>-->
                <!--            </div>-->
                <!--        </div>-->

                <!--    </form>-->
                <!--</div>-->

                <!-- Register -->
                <div class="tab-content" id="tab22" style="display: none;">

                    <form method="POST" action="{{ route('register') }}" class="register">
                        {{csrf_field()}}
                        <p class="form-row form-row-wide{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="username2">Username:
                                {{--<i class="im im-icon-Male"></i>--}}
                                <input type="text" class="input-text" name="name" id="name" value="{{ old('name') }}" required autofocus/>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </p>

                        <p class="form-row form-row-wide{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email2">Email Address:
                                {{--<i class="im im-icon-Mail"></i>--}}
                                <input type="email" class="input-text" name="email" id="email" value="{{ old('email') }}" required />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </p>
                        <input type="hidden" class="form-control" name="userrole" value="business">
                        <input type="hidden" class="form-control" name="package" value="free">
                        <p class="form-row form-row-wide">
                            <label for="username2">Company Name:
                                {{--<i class="im im-icon-Male"></i>--}}
                                <input type="text" class="input-text" name="companyname" id="companyname" value="" />
                            </label>
                        </p>

                        <p class="form-row form-row-wide{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password1">Password:
                                {{--<i class="im im-icon-Lock-2"></i>--}}
                                <input class="input-text" type="password" name="password" id="password" required/>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="password2">Repeat Password:
                                {{--<i class="im im-icon-Lock-2"></i>--}}
                                <input class="input-text" type="password" name="password_confirmation" id="password_confirmation" required/>
                            </label>
                        </p>
                        <input type="submit" class="button border fw margin-top-10" name="register" value="Register" />

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Business Sign In Popup / End -->

