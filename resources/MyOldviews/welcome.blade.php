@extends('layouts.master')
@section('title', 'HOME')
@section('content')
    <div class="main-search-container" data-background-image="{{asset('images/back1.png')}}">
        <div class="main-search-inner">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{url('category/search')}}" method="POST">
                            {{csrf_field()}}
                            <div class="col-fs-5">
                                <div class="input-with-icon">
                                    <i class="sl sl-icon-magnifier"></i>
                                    <input type="text" placeholder="What are you looking for?" name="categoryName"
                                           value="@if(isset($categoryName)){{$categoryName}}@endif"/>
                                </div>
                            </div>

                            <!-- Main Search Input -->
                            <div class="col-fs-5">
                                <div class="input-with-icon location">

                                    <input type="text" placeholder="Postal code" value="@if(isset($postalCode)){{$postalCode}}@endif" name="postalCode"/>
                                    <a href="#"><i class="fa fa-dot-circle-o"></i></a>
                                </div>
                            </div>
                            <div class="col-fs-2">
                                <input type="submit" class="btn btn-danger" value="Search" style="border-radius: 3px;">
                            </div>

                        </form>
                        {{--<h2>Find Nearby Attractions</h2>--}}
                        {{--<h4>Expolore top-rated attractions, activities and more</h4>--}}
                        {{--<form action="{{url('category/search')}}" method="POST">--}}
                            {{--{{csrf_field()}}--}}
                            {{--<div class="main-search-input">--}}

                                {{--<div class="main-search-input-item">--}}
                                    {{--<input type="text" placeholder="What can we help you with today?" name="categoryName"/>--}}
                                {{--</div>--}}

                                {{--<div class="main-search-input-item location">--}}
                                    {{--<input type="text" placeholder="Your Postcode" name="postalCode"/>--}}
                                {{--</div>--}}
                                {{--<input type="submit" style="font-weight: 500" value="Search">--}}

                            {{--</div>--}}
                        {{--</form>--}}
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h3 class="headline centered margin-top-75">
                    Todays Popular Categories
                    <span>A quick reference to what others have been looking into today... see anything that tickles your fancy?</span>
                </h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="categories-boxes-container margin-top-5 margin-bottom-30 categories1">

                    <!-- Box -->
                    <a class="category-small-box">
                        <i class="im im-icon-Hamburger"></i>
                        <h4>Eat & Drink</h4>
                    </a>

                    <!-- Box -->
                    <a class="category-small-box">
                        <i class="im  im-icon-Sleeping"></i>
                        <h4>Hotels</h4>
                    </a>

                    <!-- Box -->
                    <a class="category-small-box">
                        <i class="im im-icon-Shopping-Bag"></i>
                        <h4>Shops</h4>
                    </a>

                    <!-- Box -->
                    <a class="category-small-box">
                        <i class="im im-icon-Cocktail"></i>
                        <h4>Nightlife</h4>
                    </a>

                    <!-- Box -->
                    <a  class="category-small-box">
                        <i class="im im-icon-Electric-Guitar"></i>
                        <h4>Events</h4>
                    </a>

                    <!-- Box -->
                    <a  class="category-small-box">
                        <i class="im im-icon-Dumbbell"></i>
                        <h4>Fitness</h4>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-md-12 centered-content">
            <a href="{{url('category')}}" class="button border margin-top-10">View All</a>
        </div>
    </div>
    <!-- Fullwidth Section -->
    <section class="fullwidth margin-top-65 padding-top-75 padding-bottom-70" data-background-color="#f8f8f8">

        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <h3 class="headline centered margin-bottom-45">
                        Popular Business
                        <span>These are some of our most loved businesses, is there something they can help you with?</span>
                    </h3>
                </div>

                <div class="col-md-12">
                    <div class="simple-slick-carousel dots-nav">
                        @foreach($businesses as $business)
                            <div class="carousel-item">
                                <a href="{{url('business/info/'.$business->b_id)}}" class="listing-item-container">
                                    <div class="listing-item">
                                        <img src="{{$business->b_image}}" alt="">
                                    </div>
                                    <h3>{{$business->b_title}}</h3>
                                    <span>{{$business->b_category}}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Fullwidth Section / End -->


    <!-- Info Section -->
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="headline centered margin-top-80">
                    Using EDENLINX in <i class="redtext">3 EASY</i> steps
                    <span class="margin-top-25">3 simple steps and you're on your way to a better, faster easier fix.</span>
                </h2>
            </div>
        </div>

        <div class="row icons-container">
            <!-- Stage -->
            <div class="col-md-4">
                <div class="icon-box-2 with-line">
                    {{--<i class="im im-icon-Map2"></i>--}}
                    <a class="button border margin-top-10">1</a>
                    <h3>Search what you need</h3>
                    <p>Something around the house which needs fixing, simply type in what it is you need.</p>
                </div>
            </div>

            <!-- Stage -->
            <div class="col-md-4">
                <div class="icon-box-2 with-line">
                    {{--<i class="im im-icon-Mail-withAtSign"></i>--}}
                    <a class="button border margin-top-10">2</a>
                    <h3>Select a Business to help you</h3>
                    <p>Choose the business which suits your requirements the best.</p>
                </div>
            </div>

            <!-- Stage -->
            <div class="col-md-4">
                <div class="icon-box-2">
                    {{--<i class="im im-icon-Checked-User"></i>--}}
                    <a class="button border margin-top-10">3</a>
                    <h3>Book your preferred Date and Time</h3>
                    <p>Let the business know what day of the week and time of the day suits best.</p>
                </div>
            </div>
        </div>

    </div>
    <!-- Info Section / End -->


    {{--<!-- Recent Blog Posts -->--}}
    {{--<section class="fullwidth border-top margin-top-70 padding-top-75 padding-bottom-75" data-background-color="#fff">--}}
        {{--<div class="container">--}}

            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<h3 class="headline centered margin-bottom-45">--}}
                        {{--From The Blog--}}
                    {{--</h3>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<!-- Blog Post Item -->--}}
                {{--<div class="col-md-4">--}}
                    {{--<a href="pages-blog-post.html" class="blog-compact-item-container">--}}
                        {{--<div class="blog-compact-item">--}}
                            {{--<img src="images/blog-compact-post-01.jpg" alt="">--}}
                            {{--<span class="blog-item-tag">Tips</span>--}}
                            {{--<div class="blog-compact-item-content">--}}
                                {{--<ul class="blog-post-tags">--}}
                                    {{--<li>22 August 2017</li>--}}
                                {{--</ul>--}}
                                {{--<h3>Hotels for All Budgets</h3>--}}
                                {{--<p>Sed sed tristique nibh iam porta volutpat finibus. Donec in aliquet urneget mattis lorem. Pellentesque pellentesque.</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<!-- Blog post Item / End -->--}}

                {{--<!-- Blog Post Item -->--}}
                {{--<div class="col-md-4">--}}
                    {{--<a href="pages-blog-post.html" class="blog-compact-item-container">--}}
                        {{--<div class="blog-compact-item">--}}
                            {{--<img src="images/blog-compact-post-02.jpg" alt="">--}}
                            {{--<span class="blog-item-tag">Tips</span>--}}
                            {{--<div class="blog-compact-item-content">--}}
                                {{--<ul class="blog-post-tags">--}}
                                    {{--<li>18 August 2017</li>--}}
                                {{--</ul>--}}
                                {{--<h3>The 50 Greatest Street Arts In London</h3>--}}
                                {{--<p>Sed sed tristique nibh iam porta volutpat finibus. Donec in aliquet urneget mattis lorem. Pellentesque pellentesque.</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<!-- Blog post Item / End -->--}}

                {{--<!-- Blog Post Item -->--}}
                {{--<div class="col-md-4">--}}
                    {{--<a href="pages-blog-post.html" class="blog-compact-item-container">--}}
                        {{--<div class="blog-compact-item">--}}
                            {{--<img src="images/blog-compact-post-03.jpg" alt="">--}}
                            {{--<span class="blog-item-tag">Tips</span>--}}
                            {{--<div class="blog-compact-item-content">--}}
                                {{--<ul class="blog-post-tags">--}}
                                    {{--<li>10 August 2017</li>--}}
                                {{--</ul>--}}
                                {{--<h3>The Best Cofee Shops In Sydney Neighborhoods</h3>--}}
                                {{--<p>Sed sed tristique nibh iam porta volutpat finibus. Donec in aliquet urneget mattis lorem. Pellentesque pellentesque.</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<!-- Blog post Item / End -->--}}

                {{--<div class="col-md-12 centered-content">--}}
                    {{--<a href="pages-blog.html" class="button border margin-top-10">View Blog</a>--}}
                {{--</div>--}}

            {{--</div>--}}

        {{--</div>--}}
    {{--</section>--}}
@endsection
