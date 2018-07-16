@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">
        <div class="col-lg-12">

            <div id="add-listing">
            <form action="{{url('business/savebusiness')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <!-- Section -->
                <div class="add-listing-section">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-doc"></i> Basic Informations</h3>
                    </div>

                    <!-- Title -->
                    <div class="row with-forms">
                        <div class="col-md-12">
                            <h5>Listing Title <i class="tip" data-tip-content="Name of your business"></i></h5>
                            <input class="search-field" type="text" name="business_title" value=""/>
                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row with-forms">

                        <!-- Status -->
                        <div class="col-md-6">
                            <h5>Category</h5>
                            <select class="chosen-select-no-single" name="business_category">
                                <option label="blank">Select Category</option>
                                <option>Eat & Drink</option>
                                <option>Shops</option>
                                <option>Hotels</option>
                                <option>Restaurants</option>
                                <option>Fitness</option>
                                <option>Events</option>
                            </select>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <h5>Keywords <i class="tip" data-tip-content="Maximum of 15 keywords related with your business"></i></h5>
                            <input type="text" placeholder="Keywords should be separated by commas" name="business_keywords">
                        </div>

                    </div>
                    <!-- Row / End -->

                </div>
                <!-- Section / End -->

                <!-- Section -->
                <div class="add-listing-section margin-top-45">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-location"></i> Location</h3>
                    </div>

                    <div class="submit-section">

                        <!-- Row -->
                        <div class="row with-forms">

                            <!-- City -->
                            <div class="col-md-6">
                                <h5>City</h5>
                                <select class="chosen-select-no-single" name="business_city">
                                    <option label="blank">Select City</option>
                                    <option>New York</option>
                                    <option>Los Angeles</option>
                                    <option>Chicago</option>
                                    <option>Houston</option>
                                    <option>Phoenix</option>
                                    <option>San Diego</option>
                                    <option>Austin</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <h5>Address</h5>
                                <input type="text" placeholder="e.g. 964 School Street" name="business_address">
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <h5>State</h5>
                                <input type="text" name="business_state">
                            </div>

                            <!-- Zip-Code -->
                            <div class="col-md-6">
                                <h5>Zip-Code</h5>
                                <input type="text" name="business_zipcode">
                            </div>

                        </div>
                        <!-- Row / End -->

                    </div>
                </div>
                <!-- Section / End -->


                <!-- Section -->
                <div class="add-listing-section margin-top-45">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-picture"></i> Business Listing Header Image</h3>
                    </div>

                    <!-- Dropzone -->
                    <div class="edit-profile-photo">
                        {{--<img src="images/back1.png" alt="" id="profile_img">--}}
                        <img alt="" id="business_img">

                            <div class="change-photo-btn">
                                <div class="photoUpload">
                                    <span><i class="fa fa-upload"></i> Upload Photo</span>
                                    <input accept="image/*" type="file" class="upload" name="business_image" onchange="load_business(event)" required/>
                                </div>
                            </div>
                    </div>

                </div>
                <!-- Section / End -->


                <!-- Section -->
                <div class="add-listing-section margin-top-45">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-docs"></i> Details</h3>
                    </div>

                    <!-- Description -->
                    <div class="form">
                        <h5>Description</h5>
                        <textarea class="WYSIWYG" name="business_description" cols="40" rows="3" id="summary" spellcheck="true"></textarea>
                    </div>

                    <!-- Row -->
                    <div class="row with-forms">

                        <!-- Phone -->
                        <div class="col-md-4">
                            <h5>Phone <span>(optional)</span></h5>
                            <input type="text" name="business_phone">
                        </div>

                        <!-- Website -->
                        <div class="col-md-4">
                            <h5>Website <span>(optional)</span></h5>
                            <input type="text" name="business_website">
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-4">
                            <h5>E-mail <span>(optional)</span></h5>
                            <input type="text" name="business_email">
                        </div>

                    </div>
                    <!-- Row / End -->

                </div>
                <!-- Section / End -->


                <!-- Section -->
                <div class="add-listing-section margin-top-45">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-clock"></i> Opening Hours</h3>
                        <!-- Switcher -->
                        <label class="switch"><input type="checkbox" checked><span class="slider round"></span></label>
                    </div>

                    <!-- Switcher ON-OFF Content -->
                    <div class="switcher-content">

                        <!-- Day -->
                        <div class="row opening-day">
                            <div class="col-md-2"><h5>Monday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_monday">
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_monday">
                                    <option label="Closing Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                        <!-- Day -->
                        <div class="row opening-day js-demo-hours">
                            <div class="col-md-2"><h5>Tuesday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_tuesday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_tuesday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                        <!-- Day -->
                        <div class="row opening-day js-demo-hours">
                            <div class="col-md-2"><h5>Wednesday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_wednesday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_wednesday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                        <!-- Day -->
                        <div class="row opening-day js-demo-hours">
                            <div class="col-md-2"><h5>Thursday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_thursday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_thursday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                        <!-- Day -->
                        <div class="row opening-day js-demo-hours">
                            <div class="col-md-2"><h5>Friday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_friday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_friday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                        <!-- Day -->
                        <div class="row opening-day js-demo-hours">
                            <div class="col-md-2"><h5>Saturday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_saturday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_saturday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                        <!-- Day -->
                        <div class="row opening-day js-demo-hours">
                            <div class="col-md-2"><h5>Sunday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_sunday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_sunday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <!-- Day / End -->

                    </div>
                    <!-- Switcher ON-OFF Content / End -->

                </div>
                <!-- Section / End -->
                @if($b_check == 'false')
                    <h1 class="redtext">You already created your business</h1>
                @else
                    <button type="submit" class="button preview" onclick="submit_business">Save</button>
                @endif
            </form>
            </div>
        </div>
        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">� 2017 Listeo. All Rights Reserved.</div>
        </div>

    </div>

@endsection
