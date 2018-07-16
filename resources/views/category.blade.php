@extends('layouts.master')
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

    <div class="fs-container">

        <div class="fs-inner-container content" style="height: 94vh; overflow-y: auto">
            <div class="fs-content">

                <!-- Search -->
                <section class="search">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- Row With Forms -->
                            <div class="row with-forms">

                                <!-- Main Search Input -->
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
                                            <!-- <a href="#"><i class="fa fa-dot-circle-o"></i></a> -->
                                        </div>
                                    </div>
                                    <div class="col-fs-2">
                                        <input type="submit" class="btn btn-danger btn-search" value="Search" style="border-radius: 3px;">
                                    </div>
                                </form>

                                <!-- Filters -->
                                <!-- <div class="col-fs-12"> -->

                                    <!-- Panel Dropdown -->
                                    <!-- <div class="panel-dropdown wide">
                                        <a href="#">More Filters</a>
                                        <div class="panel-dropdown-content checkboxes"> -->

                                            <!-- Checkboxes -->
                                            <!-- <div class="row">
                                                <div class="col-md-6">
                                                    <input id="check-a" type="checkbox" name="check">
                                                    <label for="check-a">Elevator in building</label>

                                                    <input id="check-b" type="checkbox" name="check">
                                                    <label for="check-b">Friendly workspace</label>

                                                    <input id="check-c" type="checkbox" name="check">
                                                    <label for="check-c">Instant Book</label>

                                                    <input id="check-d" type="checkbox" name="check">
                                                    <label for="check-d">Wireless Internet</label>
                                                </div>

                                                <div class="col-md-6">
                                                    <input id="check-e" type="checkbox" name="check" >
                                                    <label for="check-e">Free parking on premises</label>

                                                    <input id="check-f" type="checkbox" name="check" >
                                                    <label for="check-f">Free parking on street</label>

                                                    <input id="check-g" type="checkbox" name="check">
                                                    <label for="check-g">Smoking allowed</label>

                                                    <input id="check-h" type="checkbox" name="check">
                                                    <label for="check-h">Events</label>
                                                </div>
                                            </div> -->

                                            <!-- Buttons -->
                                            <!-- <div class="panel-buttons">
                                                <button class="panel-cancel">Cancel</button>
                                                <button class="panel-apply">Apply</button>
                                            </div>

                                        </div>
                                    </div> -->
                                    <!-- Panel Dropdown / End -->

                                    <!-- Panel Dropdown -->
                                    <!-- <div class="panel-dropdown">
                                        <a href="#">Distance Radius</a>
                                        <div class="panel-dropdown-content">
                                            <input class="distance-radius" type="range" min="1" max="100" step="1" value="50" data-title="Radius around selected destination">
                                            <div class="panel-buttons">
                                                <button class="panel-cancel">Disable</button>
                                                <button class="panel-apply">Apply</button>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- Panel Dropdown / End -->

                                <!-- </div> -->
                                <!-- Filters / End -->

                            </div>
                            <!-- Row With Forms / End -->

                        </div>
                    </div>

                </section>
                <!-- Search / End -->


                <section class="listings-container margin-top-30">

                    <!-- Sorting / Layout Switcher -->
                    <div class="row fs-switcher">

                        <div class="col-md-6">
                            <!-- Showing Results -->
                            <p class="showing-results">{{$totalCount}} Results Found </p>
                        </div>

                    </div>


                    <!-- Listings -->
                    <div class="row fs-listings">
                        <?php $markindex = 1 ?>
                        <!-- Listing Item -->
                        @if(count($business)>0)
                        @foreach($business as $busines)

                        <div class="col-lg-6 col-md-6">
                            <a href="{{url('business/info/'.$busines->b_id)}}" class="listing-item-container compact" data-marker-id={{$markindex++}}>
                                <div class="listing-item">
                                    
                                    <div id="black_div">
                                        <img src="{{asset($busines->b_image)}}" alt="" onerror="this.src = '{{asset('/images/business_search.jpg')}}'">
                                    </div>
                                    <!-- <div class="listing-badge now-open">Now Open</div> -->

                                    <div class="listing-item-content">
                                        <!-- <div class="numerical-rating" data-rating="3.5"></div> -->
                                        <h3>{{$busines->b_title}}</h3>
                                        <!-- <span>{{$busines->postcode.' '.$busines->address.' '.$busines->city}}</span> -->
                                        <span>{{$busines->address.' '.$busines->city}}</span>
                                    </div>
                                    <!-- <span class="like-icon"></span> -->
                                </div>
                            </a>
                        </div>

                            @endforeach
                        <!-- Listing Item / End -->

                        <!-- Listing Item -->
                        @endif
                    </div>
                    <!-- Listings Container / End -->


                    <!-- Pagination Container -->
                    <div class="row fs-listings">
                        <div class="col-md-12">

                            <!-- Pagination -->
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Pagination -->
                                    <div class="pagination-container margin-top-15 margin-bottom-40">
                                        <nav class="pagination">
                                            {!! $business->links() !!}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!-- Pagination / End -->

                        </div>
                    </div>
                    <!-- Pagination Container / End -->
                </section>

            </div>
        </div>
        <div class="fs-inner-container map-fixed" style="position: relative; height: 100%;">

            <!-- Map -->
            <div id="map-container">
                <div id="businessdata" style="display: none;">
                    <?php
                    $mapArray = array();

                    //                var_dump($business);
                    foreach ($business as $item){
                       //  var_dump($item);
                        array_push($mapArray, array(
                            'id' => $item->b_id,
                            'title' => $item->b_title,
                            'postcode' => $item->postcode,
                            'image' => $item->b_image,
                            'headerimage' => $item->b_headerimage,
                            'lat' => $item->latitude,
                            'long' => $item->longitude,
                            'address' => $item->address,
                            'city' => $item->city,
                            'rating'=>$item->rating,
                        ));
                    }
                    echo json_encode($mapArray);
                    ?>

                </div>
                <div id="map" data-map-zoom="13" data-map-scroll="true">
                    <!-- map goes here -->
                </div>
            </div>

        </div>
    </div>
@endsection