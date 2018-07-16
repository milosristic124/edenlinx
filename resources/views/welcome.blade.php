@extends('layouts.master')
@section('title', 'HOME')
@section('content')
<style>

#black_div:after {
    content:'\A';
    position:absolute;
    width:100%; height:100%;
    top:0; left:0;
    background:rgba(0,0,0,0.5);
    opacity:1;
}

</style>

    <div class="main-search-container"
    @if($setting->homepageimage != "" && $setting->homepageimage != null)
     data-background-image="{{asset($setting->homepageimage)}}"
    @else
     data-background-image="{{asset('images/back1.jpg')}}"
    @endif
     >
        <div class="main-search-inner">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{url('category/search')}}" method="GET">
                           
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

                                    <input type="text" placeholder="Your Postcode" value="@if(isset($postalCode)){{$postalCode}}@endif" name="postalCode" required/>
                                    <a href="#"><i class="fa fa-dot-circle-o"></i></a>
                                </div>
                            </div>
                            <div class="col-fs-2">
                                <input type="submit" class="btn btn-danger btn-search" value="Search" style="border-radius: 3px;">
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

                    @foreach($categories as $category)
                    <a href="{{url('/category/search?catid='.$category->id)}}" class="category-small-box">
                        <i class="fa {{$category->category_photo}}"></i>
                        <h4>{{$category->categoryname}}</h4>
                    </a>
                    @endforeach

               </div>
           </div>
       </div>
        <div class="col-md-12 centered-content">
           <a href="{{url('categorylist')}}" class="button border margin-top-10">View All</a>
        </div>
    </div>
    <!-- Fullwidth Section -->
    <section class="fullwidth margin-top-65 padding-top-75 padding-bottom-70" data-background-color="#f8f8f8">

       <div class="container">
           <div class="row">

               <div class="col-md-12">
                   <h3 class="headline centered margin-bottom-45">
                       Popular Businesses
                       <span>These are some of our most loved businesses, is there something they can help you with?</span>
                   </h3>
               </div>

               <div class="col-md-12">
                   <div class="simple-slick-carousel dots-nav">
                       @foreach($businesses as $business)
                       <div class="col-lg-6 col-md-6">
                            <a href="{{url('business/info/'.$business->b_id)}}" class="listing-item-container compact" >
                                <div class="listing-item">
                                    
                                    <div id="black_div">
                                    <img src="{{url($business->b_image)}}" alt="" onerror="this.src = '{{url('images/business_search.jpg')}}'">

                                    </div>
                                    <!-- <div class="listing-badge now-open">Now Open</div> -->

                                    <div class="listing-item-content">
                                        <!-- <div class="numerical-rating" data-rating="3.5"></div> -->
                                        <h3>{{$business->b_title}}</h3>
                                        <span>{{$business->b_category}}</span>
                                    </div>
                                    <!-- <span class="like-icon"></span> -->
                                </div>
                            </a>
                        </div>
                       @endforeach
                       
                   </div>
               </div>
           </div>
       </div>

    </section>


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
                <div class="icon-box-2">
                    {{--<i class="im im-icon-Map2"></i>--}}
                    <!-- <a href="#" class="button border margin-top-10">1</a> -->
                    <h3>Search what you need</h3>
                    <p>Something around the house which needs fixing, simply type in what it is you need.</p>
                </div>
            </div>

            <!-- Stage -->
            <div class="col-md-4">
                <div class="icon-box-2">
                    {{--<i class="im im-icon-Mail-withAtSign"></i>--}}
                    <!-- <a href="#" class="button border margin-top-10">2</a> -->
                    <h3>Select a Business to help you</h3>
                    <p>Choose the business which suits your requirements the best.</p>
                </div>
            </div>

            <!-- Stage -->
            <div class="col-md-4">
                <div class="icon-box-2">
                    {{--<i class="im im-icon-Checked-User"></i>--}}
                    <!-- <a href="#" class="button border margin-top-10">3</a> -->
                    <h3>Book your preferred Date and Time</h3>
                    <p>Let the business know what day of the week and time of the day suits best.</p>
                </div>
            </div>
        </div>

    </div>
    <!-- Info Section / End -->


    <!-- Recent Blog Posts -->
    
@endsection
