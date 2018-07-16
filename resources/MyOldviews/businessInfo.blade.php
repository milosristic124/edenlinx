@extends('layouts.master')
@section('title', $business->b_title)
@section('content')
        <!-- Slider
================================================== -->
{{--<div class="listing-slider mfp-gallery-container margin-bottom-0">--}}
    {{--<a href="" data-background-image="" class="item mfp-gallery" title="Title 1"></a>--}}
    {{--<a href="" data-background-image="" class="item mfp-gallery" title="Title 3"></a>--}}
    {{--<a href="" data-background-image="" class="item mfp-gallery" title="Title 2"></a>--}}
    {{--<a href="" data-background-image="" class="item mfp-gallery" title="Title 4"></a>--}}
{{--</div>--}}
<div class="business-header-image container">
    <img src="{{url($business->b_image)}}">
    {{--<img src="{{url('images/5.png')}}">--}}
</div>


<!-- Content
================================================== -->
<div class="container">
    <div class="row sticky-wrapper">
        <div class="col-lg-8 col-md-8 padding-right-30">

            <!-- Titlebar -->
            <div id="titlebar" class="listing-titlebar">
                <div class="listing-titlebar-title">
                    <h2>{{$business->b_title}} <span class="listing-tag">{{$business->b_category}}</span></h2>
					<span>
						<a href="#listing-location" class="listing-address">
                            <i class="fa fa-map-marker"></i>
                            {{$business->address}}, {{$business->city}}
                        </a>
					</span>
                    <div class="star-rating" data-rating="{{$avgReview}}">
                        <div class="rating-counter"><a href="#listing-reviews">({{$countReview}} reviews)</a></div>
                    </div>
                </div>
            </div>

            <!-- Listing Nav -->
            <div id="listing-nav" class="listing-nav-container">
                <ul class="listing-nav">
                    <li><a href="#listing-overview" class="active">Overview</a></li>
                    {{--<li><a href="#listing-pricing-list">Pricing</a></li>--}}
                    <li><a href="#listing-location">Location</a></li>
                    <li><a href="#listing-reviews">Reviews</a></li>
                    <li><a href="#add-review">Add Review</a></li>
                </ul>
            </div>

            <!-- Overview -->
            <div id="listing-overview" class="listing-section">
                <p>{{$business->b_description}}</p>
            </div>
            <!-- Location -->
            <div id="listing-location" class="listing-section">
                <h3 class="listing-desc-headline margin-top-60 margin-bottom-30">Location</h3>

                <div id="singleListingMap-container">
                    <div id="singleListingMap" data-latitude="{{$lat}}" data-longitude="{{$long}}" data-map-icon="{{$mapText}}"></div>
                    <a href="#" id="streetView">Street View</a>
                </div>
            </div>

            <!-- Reviews -->
            <div id="listing-reviews" class="listing-section">
                <h3 class="listing-desc-headline margin-top-75 margin-bottom-20">Reviews <span>({{sizeof($ratings)}})</span></h3>

                <div class="clearfix"></div>

                <!-- Reviews -->
                <section class="comments listing-reviews">

                    <ul id="myRatingLists">
                        @foreach($ratings as $rating)
                            <li>
                                @if($rating->r_image == null)
                                    <div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&amp;s=70" alt="" /></div>
                                @else
                                    <div class="avatar"><img src="{{url($rating->r_image)}}" alt="" /></div>
                                @endif
                                <div class="comment-content"><div class="arrow-comment"></div>
                                    <div class="comment-by">{{$rating->r_name}}<span class="date">{{$rating->r_created_at}}</span>
                                        <div class="star-rating" data-rating="{{$rating->r_rating}}"></div>
                                    </div>
                                    <p>{{$rating->r_review}}</p>
                                    <a href="#" class="rate-review"><i class="sl sl-icon-like"></i> Helpful Review <span>12</span></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Pagination -->
                        <div class="pagination-container margin-top-30">
                            <nav class="pagination">
                                <ul>
                                    <li><input type="button" class="current-page" id="ratingsLoadMore" value="Load More"></li>
                                    <li><input type="button" class="current-page" id="ratingsShowLess" value="Show Less"></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- Pagination / End -->
            </div>


            <!-- Add Review Box -->
            <div id="add-review" class="add-review-box">

                <!-- Add Review -->
                <h3 class="listing-desc-headline margin-bottom-20">Add Review</h3>

                <span class="leave-rating-title">Your rating for this listing</span>

                <!-- Rating / Upload Button -->
                <form id="add-comment" action="{{url('business/postReview')}}" method="post" class="add-comment">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Leave Rating -->
                            <div class="clearfix"></div>
                            <div class="leave-rating margin-bottom-30">
                                <input type="radio" name="rating" id="rating-1" value="1"/>
                                <label for="rating-1" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating-2" value="2"/>
                                <label for="rating-2" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating-3" value="3"/>
                                <label for="rating-3" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating-4" value="4"/>
                                <label for="rating-4" class="fa fa-star"></label>
                                <input type="radio" name="rating" id="rating-5" value="5"/>
                                <label for="rating-5" class="fa fa-star"></label>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <input name="r_bid" type="text" style="display: none" value="{{$business->b_id}}"/>
                    @if(Auth::check())
                        <input name="r_image" type="text" style="display: none" value="{{Auth::user()->userprofile}}"/>
                    @else
                        <input name="r_image" type="text" style="display: none" value=""/>
                    @endif


                <!-- Review Comment -->

                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name:</label>
                                <input type="text" name="r_name" value="" required/>
                            </div>
                            <div class="col-md-6">
                                <label>Email:</label>
                                <input type="email" name="r_email" value="" required/>
                            </div>
                        </div>
                        <div>
                            <label>Review:</label>
                            <textarea name="r_review" cols="40" rows="3" required></textarea>
                        </div>
                    </fieldset>
                    <button class="button" type="submit">Submit Review</button>
                    <div class="clearfix"></div>
                </form>

            </div>
            <!-- Add Review Box / End -->


        </div>


        <!-- Sidebar
        ================================================== -->
        <div class="col-lg-4 col-md-4 margin-top-75 sticky">
            <!-- Book Now -->
            <div class="boxed-widget">
                <h3><i class="fa fa-calendar-check-o "></i> CONSULTATION BOOKING</h3>
                <div class="row with-forms  margin-top-0">
                <form>
                    {{csrf_field()}}
                    <textarea name="booking-message" cols="40" rows="5" required></textarea>
                    <ul class="listing-details-sidebar">
                        <li><i class="sl sl-icon-phone"></i> 0424 646 929</li>
                        <li><i class="sl sl-icon-globe"></i> <a href="#">info@edenlinx.com</a></li>
                        <li><i class="fa fa-envelope-o"></i> <a href="#">info@edenlinx.com</a></li>
                    </ul>

                    <ul class="listing-details-sidebar social-profiles">
                        <li><a href="http://www.facebook.com/" class="facebook-profile" target="_blank"><i class="fa fa-facebook-square"></i> Facebook</a></li>
                        <li><a href="http://www.twitter.com/" class="twitter-profile" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>
                        <!-- <li><a href="#" class="gplus-profile"><i class="fa fa-google-plus"></i> Google Plus</a></li> -->
                    </ul>

                    <!-- Reply to review popup -->
                    <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                        <div class="small-dialog-header">
                            <h3>Send Message</h3>
                        </div>
                        <div class="message-reply margin-top-0">
                            <h4>Please Login on this site.</h4>
                            <h4>You can send message to this business.</h4>
                        </div>
                    </div>
                    @if(Auth::check())
                        <input class="fullwidth margin-top-5" type="submit" value="Send Message">
                    @else
                        <a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> Send Message</a>
                    @endif
                </form>
                </div>

                <!-- progress button animation handled via custom.js -->

            </div>
            <!-- Opening Hours -->
            <div class="boxed-widget opening-hours margin-top-35">
                <div class="listing-badge now-open">Now Open</div>
                <h3><i class="sl sl-icon-clock"></i> Opening Hours</h3>
                <ul>
                    <li>Monday <span>{{$openinghours[0]}} - {{$openinghours[1]}}</span></li>
                    <li>Tuesday <span>{{$openinghours[2]}} - {{$openinghours[3]}}</span></li>
                    <li>Wednesday <span>{{$openinghours[4]}} - {{$openinghours[5]}}</span></li>
                    <li>Thursday <span>{{$openinghours[6]}} - {{$openinghours[7]}}</span></li>
                    <li>Friday <span>{{$openinghours[8]}} - {{$openinghours[9]}}</span></li>
                    <li>Saturday <span>{{$openinghours[10]}} - {{$openinghours[11]}}</span></li>
                    <li>Sunday <span>{{$openinghours[12]}} - {{$openinghours[13]}}</span></li>
                </ul>
            </div>
            <!-- Opening Hours / End -->
        </div>
        <!-- Sidebar / End -->

    </div>
</div>

@endsection