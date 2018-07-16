@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<div class="row">
    <div class="col-lg-8">
                <!-- Section -->
                <div class="add-listing-section margin-top-45">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="fa fa-money"></i> Sales Staff</h3>
                    </div>

                    <div class="submit-section">
                        <!-- Row -->
                        <div class="row with-forms">

                            <!-- City -->
                            <div class="col-md-6">
                                <h5>Coupon Code</h5>
                                <input type="text" id="couponcode" name="couponcode" value="{{$couponcode}}" required>
                            </div>

                            <!-- Address -->
                            <div class="col-md-4">
                                <h5>&nbsp;</h5>
                                <input type="button" value="Set Coupon Code" onclick="CheckCouponCode()">
                            </div>

                            <div class="col-md-12">
                                <span class="help-block">
                                    <strong id="register_error" style="color:#f00;"></strong>
                                    <strong id="register_error1" style="color:#0a0;"></strong>
                                </span>
                            </div>
                        </div>
                        <!-- Row / End -->

                    </div>
                </div>
                <!-- Section / End -->
    </div>
</div>
    
    <div class="row">

        <div class="col-md-12">
            <div class="pricing-container margin-top-80">
                <!-- Plan #1 -->

                @if($package == 'free')
                    <div class="plan featured">
                        <div class="plan-price">
                            <span class="value">${{$packageprice->free}}</span>
                            <h3 style="margin-top:30px;">Free for life<br/></h3>
                            <span class="period"></span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Free Business Listing on</li>
                                <li> the Edenlinx website</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                            </ul>
                            <input class="button" type="button" value="Active" style="background: #717171; width:121px; margin-bottom:0px;" disabeld>
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <span class="value">${{$packageprice->free}}</span>
                            <h3 style="margin-top:30px;">Free for life<br/>&nbsp;</h3>
                            <span class="period"></span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Free Business Listing on</li>
                                <li>the Edenlinx website</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                            </ul>
                            <!-- <form action="{{url('business/packages/free')}}" method="get" style="margin:0px;"> -->
                            <input class="button" type="button" value="Get Started" style="width:121px;" onclick="SetFreePackage()">
                            <!-- </form> -->
                        </div>
                    </div>
                @endif

                <!-- Plan #2 -->
                @if($package == 'basic')
                    <div class="plan featured">
                        <div class="listing-badge">
                            <span class="featured">Featured</span>
                        </div>
                        <div class="plan-price">
                            <span class="value">${{$packageprice->basic}}</span>
                            <h3 style="margin-top:30px;">Monthly<br/>Subscription</h3>
                            <span class="period"></span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Everything you get with the</li>
                                <li>Free Package. Also</li>
                                <li>includes Message feature</li>
                                <li>to reply to Potential</li>
                                <li>Customer Messages</li>
                                <li>&nbsp;</li>
                            </ul>
                            <input class="button" type="button" value="Active" style="background: #717171; width:121px; margin-bottom:0px;" disabeld>
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <span class="value">${{$packageprice->basic}}</span>
                            <h3 style="margin-top:30px;">Monthly<br/>Subscription</h3>
                            <span class="period"></span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Everything you get with the</li>
                                <li>Free Package. Also</li>
                                <li>includes Message feature</li>
                                <li>to reply to Potential</li>
                                <li>Customer Messages</li>
                                <li>&nbsp;</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',{{$packageprice->basic}},'basic')" style="width:121px; ;">
                        </div>
                    </div>
                @endif

                <!-- Plan #3 -->
                @if($package == 'regular')
                    <div class="plan featured">
                        <div class="listing-badge">
                            <span class="featured">Featured</span>
                        </div>
                        <div class="plan-price">
                            <span class="value">${{$packageprice->regular}}</span>
                            <h3 style="margin-top:30px;">Monthly<br/>Subscription</h3>
                            <span class="period"></span>
                        </div>

                        <div class="plan-features">
                            <ul>
                                <li>Everything you get with the</li>
                                <li>Basic Package as well as</li>
                                <li>The Ability to Create</li>
                                <li>Projects</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                            </ul>
                            <input class="button" type="button" value="Active" style="background: #717171; width:121px;  margin-bottom:0px;" disabled>
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <span class="value">${{$packageprice->regular}}</span>
                            <h3 style="margin-top:30px;">Monthly<br/>Subscription</h3>
                            <span class="period"></span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Everything you get with the</li>
                                <li>Basic Package as well as</li>
                                <li>The Ability to Create</li>
                                <li>Projects</li>
                                <li>&nbsp;</li>
                                <li>&nbsp;</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',{{$packageprice->regular}},'regular')" style="width:121px; ;">
                        </div>
                    </div>
                @endif
                <!-- Plan #4 -->
                @if($package == 'premium')
                    <div class="plan featured">
                        <div class="listing-badge">
                            <span class="featured">Featured</span>
                        </div>
                        <div class="plan-price">
                            <span class="value">${{$packageprice->premium}}</span>
                            <h3 style="margin-top:30px;">Monthly<br/>Subscription</h3>
                            <span class="period"></span>
                        </div>

                        <div class="plan-features">
                            <ul>
                                <li>Everything you've come to</li>
                                <li>love in the Regular</li>
                                <li>Package including Priority</li>
                                <li>Listings and your Business</li>
                                <li>Listed on the home page</li>
                                <li>of Edenlinx</li>
                            </ul>
                            <input class="button" type="button" value="Active" style="background: #717171; width:121px; margin-bottom:0px;" disabled>
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <span class="value">${{$packageprice->premium}}</span>
                            <h3 style="margin-top:30px;">Monthly<br/>Subscription</h3>
                            <span class="period"></span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Everything you've come to</li>
                                <li>love in the Regular</li>
                                <li>Package including Priority</li>
                                <li>Listings and your Business</li>
                                <li>Listed on the home page</li>
                                <li>of Edenlinx</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',{{$packageprice->premium}},'premium')" style="width:121px; ;">
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>
    </div>
    
    <form action="https://www.paypal.com/cgi-bin/webscr" method="get" name="frmPayPal2">
        <input type="hidden" name="cmd" value="_subscr-find">
        <input type="hidden" name="alias" value="F6UUUH4PEQVG8">
        <input type="hidden" name="switch_classic" value="true">
        <input type="submit" name="submit1" id="package-pay-btn1" style="display: none">
    </form>

    <div class="product">
        <div class="btn">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1">
                <input type="hidden" name="business" value="info@georgestechnology.com.au">
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="item_name" value="Edenlinx Payment">
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="currency_code" value="AUD">
                <input type="hidden" name="a3" id="monthly-amount">
                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="t3" value="M">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="amount" id="package-amount" placeholder="amount">
                <input type="hidden" name="cancel_return" id="package-cancel" value="{{url('business/cancelpackages')}}">
                <input type="hidden" name="return" id="package-success" value="">
                <input type="submit" name="submit" id="package-pay-btn" style="display: none">
            </form>

            <!--
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1">
                <input type="hidden" name="business" value="info@georgestechnology.com.au">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="Edenlinx Payment">
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="notify_url" value="">
                <input type="hidden" name="credits" value="510">
                <input type="hidden" name="userid" value="1">
                <input type="hidden" name="amount" id="package-amount" placeholder="amount">
                <input type="hidden" name="cpp_header_image" value="">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="currency_code" value="AUD">
                <input type="hidden" name="handling" value="0">
                <input type="hidden" name="cancel_return" id="package-cancel" value="{{url('business/cancelpackages')}}">
                <input type="hidden" name="return" id="package-success" value="">
                <input type="submit" name="submit" id="package-pay-btn" style="display: none">
            </form>
            -->
        </div>
    </div>


<script>
    function SetFreePackage()
    {
        $.ajax({
            url: "{{url('/business/packages/free')}}",
            type: "GET",
            async : true,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            },
            success: function (data) {
                $("#package-pay-btn1").click();
            }
        });
    }
    function CheckCouponCode()
    {
        couponcode = $("#couponcode").val();
        $("#register_error").html("");
        $("#register_error1").html("");
        
        $.ajax({
            url: "{{url('/business/checkcouponcode')}}",
            type: "GET",
            async : true,
            data: "couponcode="+couponcode,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#register_error").html("Set failed.");
            },
            success: function (data) {
                obj = $.parseJSON(data);
                if (obj.res == "true")
                {
                    $("#register_error1").html("<i class=\"fa fa-check\"></i> Set Coupon Code successfully.");
                    window.location = "/business/packages";
                }
                else
                {
                    $("#register_error").html("<i class=\"fa fa-close\"></i> This is wrong Coupon Code. Input correct Coupon Code.");
                }
            }
        });
    }
</script>

@endsection
