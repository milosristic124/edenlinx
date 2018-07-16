@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <div class="col-md-12">
            <div class="pricing-container margin-top-30">
                <!-- Plan #1 -->

                @if($package == 'free')
                    <div class="plan featured">
                        <div class="plan-price">
                            <h3>Free Listing</h3>
                            <span class="value">$0</span>
                            <span class="period">Appear in all search results relating to your industry</span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>One Business Listing</li>
                                <li>Non-Featured</li>
                                <li></li>
                                <li></li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" disabled>
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <h3>Free Listing</h3>
                            <span class="value">$0</span>
                            <span class="period">One time fee for one listing, highlighted in the search results</span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>One Listing</li>
                                <li>30 Days Availability</li>
                                <li>Standard Listing</li>
                                <li>Limited Support</li>
                            </ul>
                            <form action="{{url('business/packages/free')}}" method="get">
                            <input class="button" type="submit" value="Get Started" style="background: #717171">
                            </form>
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
                            <h3>Basic Package</h3>
                            <span class="value">$9.99</span>
                            <span class="period">Monthly subscription for unlimited listings and availability</span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>One Listings</li>
                                <li>90 Days Availability</li>
                                <li>Featured In Search Results</li>
                                <li>24/7 Support</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',9.99,'basic')">
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <h3>Basic Package</h3>
                            <span class="value">$9.99</span>
                            <span class="period">One time fee for one listing, highlighted in the search results</span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>One Listings</li>
                                <li>90 Days Availability</li>
                                <li>Featured In Search Results</li>
                                <li>24/7 Support</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',9.99,'basic')" style="background: #717171">
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
                            <h3>Regular Package</h3>
                            <span class="value">$19.99</span>
                            <span class="period">Monthly subscription for unlimited listings and availability</span>
                        </div>

                        <div class="plan-features">
                            <ul>
                                <li>Unlimited Listings</li>
                                <li>Unlimited Availability</li>
                                <li>Featured In Search Results</li>
                                <li>24/7 Support</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',19.99,'regular')">
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <h3>Regular Package</h3>
                            <span class="value">$19.99</span>
                            <span class="period">Monthly subscription for unlimited listings and availability</span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Unlimited Listings</li>
                                <li>Unlimited Availability</li>
                                <li>Featured In Search Results</li>
                                <li>24/7 Support</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',19.99,'regular')" style="background: #717171">
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
                            <h3>Premium Package</h3>
                            <span class="value">$29.99</span>
                            <span class="period">Monthly subscription for unlimited listings and availability</span>
                        </div>

                        <div class="plan-features">
                            <ul>
                                <li>Unlimited Listings</li>
                                <li>Unlimited Availability</li>
                                <li>Featured In Search Results</li>
                                <li>24/7 Support</li>
                            </ul>
                            <input class="button" type="button" value="Get Started" onclick="setpackage('{{url('business/packages')}}',29.99,'premium')">
                        </div>
                    </div>
                @else
                    <div class="plan">
                        <div class="plan-price">
                            <h3>Premium Package</h3>
                            <span class="value">$29.99</span>
                            <span class="period">Monthly subscription for unlimited listings and availability</span>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li>Unlimited Listings</li>
                                <li>Unlimited Availability</li>
                                <li>Featured In Search Results</li>
                                <li>24/7 Support</li>
                            </ul>
                            <input class="button" type="submit" value="Get Started" onclick="setpackage('{{url('business/packages')}}',29.99,'premium')" style="background: #717171">
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <div class="col-md-12">
            <div class="copyrights">� 2017 Listeo. All Rights Reserved.</div>
        </div>
    </div>

    <div class="product">
        <div class="btn">
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1">
                <input type="hidden" name="business" value="secondGao@hotmail.com">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="Edenlinx Payment">
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="notify_url" value="">
                <input type="hidden" name="credits" value="510">
                <input type="hidden" name="userid" value="1">
                <input type="hidden" id="package-amount" name="amount" placeholder="amount">
                <input type="hidden" name="cpp_header_image" value="">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="currency_code" value="AUD">
                <input type="hidden" name="handling" value="0">
                <input type="hidden" id="package-cancel" name="cancel_return" value="{{url('business/cancelpackages')}}">
                <input type="hidden" name="return" id="package-success" value="">
                <input type="submit" id="package-pay-btn" name="submit" style="display: none">
            </form>
        </div>
    </div>
@endsection
