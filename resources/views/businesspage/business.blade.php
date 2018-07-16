@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')
<style>
    .btn-is-disabled {
        pointer-events: none; /* Disables the button completely. Better than just cursor: default; */
    }
</style>
    <div class="row">
        <div class="col-lg-12">
                @if($b_check == 'false')
                        
                @else
                    <!-- <h2 class="red-text">You have to complete your business details.</h2> -->
                @endif
            <div id="add-listing">
            <form action="{{url('business/savebusiness')}}" method="POST" enctype="multipart/form-data">
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
                            <h5>Business Name <!-- <i class="tip" data-tip-content="Name of your business"></i> --></h5>
                            <input class="search-field" type="text" name="business_title" id="business_title" value="{{$b_res->b_title}}" onfocus="title_focus()" onfocusout="title_focusout()" required/>
                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row with-forms">

                        <!-- Status -->
                        <div class="col-md-6">
                            <h5>Category</h5>
                            <select class="chosen-select-no-single" name="business_category" required>
                                <option label="blank" value = "0">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                @if($b_res->b_catid==$category->id)
                                selected
                                @endif
                                >
                                {{$category->categoryname}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <h5>Keywords<!--<i class="tip" data-tip-content="Maximum of 15 keywords related with your business"></i>--></h5>
                            <input type="text" placeholder="Keywords should be separated by commas" name="business_keywords" id="business_keywords" value="{{$b_res->b_keyword}}" onfocus="keywords_focus()" onfocusout="keywords_focusout()" required>
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
                                <input type="text" name="business_city" value="{{$b_res->city}}" required>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <h5>Address</h5>
                                <input type="text" name="business_address" value="{{$b_res->address}}" required>
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <h5>State</h5>
                                <input type="text" name="business_state" value="{{$b_res->state}}" required>
                            </div>

                            <!-- Zip-Code -->
                            <div class="col-md-6">
                                <h5>PostCode</h5>
                                <input type="text" name="business_zipcode" value="{{$b_res->postcode}}" required>
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
                            <h3><i class="sl sl-icon-picture"></i> Business Search Image</h3>
                        </div>
                        <div>
                            <span><b style="color: #D33"><i>Images only, no text within images.</i></b></span>&nbsp;&nbsp;&nbsp;&nbsp;(<a href="{{url('images/business_search.jpg')}}" download style="color: #090">Download search image template here</a>)<br/>
                            <a href="#business_main_img_dialog" class="popup-with-zoom-anim">
                                <span><i class="fa fa-upload"></i> Upload Photo</span><span class="gray-text"> : Image Size : 468 x 265</span><br>
                                <img id="business_main_img_show" src="{{asset($b_res->b_image)}}">
                                <input id="imageDataUploading" name="imgData" value="" style="display: none;">
                            </a>
                        </div>
                        <div id="business_main_img_dialog" class="zoom-anim-dialog mfp-hide">
                            <div class="small-dialog-header">
                                <h3>Need Fixed Image</h3>
                            </div>
                            <div class="form-group">
                                <div id="mainupload"
                                     style="background:#a0a0a0;width:312px;padding:1px;height:176px;margin-top:10px;border:1px solid darkgray;"></div>
                            </div>
                            <div class="form-group" style="padding-top:10px;">
                                <button onclick="$('#business-main-img').click();">select file</button>
                                <input type="file" id="business-main-img" name="business-main-img" style="display:none;"/>
                                <br><br>

                            </div>

                            <div class="row form-inline text-center">
                                <div class="form-group">
                                    <div id="main-upload1"></div>
                                </div>
                            </div>
                            <button class="btn btn-primary form-control" id="upload-complete-main">upload</button>
                        </div>
                        {{--<!-- Dropzone -->--}}
                        {{--<div class="edit-profile-photo">--}}
                            {{--<img src="images/back1.png" alt="" id="profile_img">--}}
                            {{--<img alt="" id="business_img">--}}

                            {{--<div class="change-photo-btn">--}}
                                {{--<div class="photoUpload">--}}
                                    {{--<span><i class="fa fa-upload"></i> Upload Photo</span>--}}
                                    {{--<input accept="image/*" type="file" class="upload" name="business_image" onchange="load_business(event)" required/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    </div>
                    <!-- Section / End -->
                    <!-- Section -->
                    <div class="add-listing-section margin-top-45">
                        <!-- Headline -->
                        <div class="add-listing-headline">
                            <h3><i class="sl sl-icon-picture"></i> Business Listing Header Image
                            <a href="#small-dialog" class="send-message-to-owner popup-with-zoom-anim"> <button type="button" class="button" style="padding: 8px 15px; border-radius: 3px; background-color: #09f; float:right; margin-top:-8px;"><i class="fa fa-plus"></i>&nbsp;Get A Professional Header Image</button> </a>
                            </h3>
                        </div>

                        <div>
                            <span><b style="color: #D33"><i>Images only, no text within images.</i></b></span>&nbsp;&nbsp;&nbsp;&nbsp;(<a href="{{url('images/business_header.jpg')}}" download style="color: #090">Download header image template here</a>)<br/>
                            <a href="#business_listing_img_dialog" class="popup-with-zoom-anim">
                                <span><i class="fa fa-upload"></i> Upload Photo</span><span class="gray-text"> : Image Size : 1920 x 300</span><br>
                                <img id="business_listing_img_show" src="{{asset($b_res->b_headerimage)}}" style="width: 100%; height: auto;">
                                <input id="imageDataUploading1" name="imgData1" value="" style="display: none;">
                            </a>
                        </div>
                    </div>
                    <!-- Section / End -->
                    <div id="business_listing_img_dialog" class="zoom-anim-dialog mfp-hide">
                        <div class="small-dialog-header">
                            <h3>Need Fixed Image</h3>
                        </div>
                        <div class="form-group">
                            <div id="listingupload"
                                 style="background:#a0a0a0;width:480px;padding:1px;height:75px;margin-top:10px;border:1px solid darkgray;"></div>
                        </div>
                        <div class="form-group" style="padding-top:10px;">
                            <button onclick="$('#business-listing-img').click();">select file</button>
                            <input type="file" id="business-listing-img" name="business-listing-img" style="display:none;"/>
                            <br><br>

                        </div>

                        <div class="row form-inline text-center">
                            <div class="form-group">
                                <div id="listing-upload1"></div>
                            </div>
                        </div>
                        <button class="btn btn-primary form-control" id="listing-upload-complete">upload</button>
                    </div>
                <!-- Section -->
                <div class="add-listing-section margin-top-45">

                    <!-- Headline -->
                    <div class="add-listing-headline">
                        <h3><i class="sl sl-icon-docs"></i> Details</h3>
                    </div>

                    <!-- Description -->
                    <div class="form">
                        <h5>Description</h5>
                        <textarea class="WYSIWYG" name="business_description" cols="40" rows="3" id="summary" spellcheck="true" required>{{$b_res->b_description}}</textarea>
                    </div>

                    <!-- Row -->
                    <div class="row with-forms">

                        <!-- Phone -->
                        <div class="col-md-4">
                            <h5>Phone <span>(optional)</span></h5>
                            <input type="text" name="business_phone" value="{{$b_res->b_phone}}">
                        </div>

                        <!-- Website -->
                        <div class="col-md-4">
                            <h5>Website <span>(optional)</span></h5>
                            <input type="text" name="business_website" value="{{$b_res->b_website}}">
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-4">
                            <h5>E-mail <span>(optional)</span></h5>
                            <input type="text" name="business_email" value="{{$b_res->b_email}}">
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
                        <label class="switch hidden"><input type="checkbox" checked><span class="slider round"></span></label>
                    </div>

                    <!-- Switcher ON-OFF Content -->
                     <div class="switcher-content">

                        <!-- Day -->
                        <div class="row opening-day">
                            <?php
                                $openinghours = array();
                            if(isset($b_res)){
                                $openinghour = $b_res->openinghours;
                                $openinghours = explode(', ',$openinghour);

                            	$hours = array();

                            foreach($openinghours as $openhour){
	                            $arr = explode('=',$openhour);
                            	$hours[]=count($arr)==2?$arr[1]:'';
                            }
                            }
                            ?>
                            <div class="col-md-2"><h5>Monday</h5></div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Opening Time" name="o_monday">
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[0]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[0]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM'==$hours[0]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_monday">
                                    <option label="Closing Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[1]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[1]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[1]) selected @endif>{{$i}} PM</option>
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
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[2]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[2]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[2]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_tuesday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[3]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[3]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM'== $hours[3]) selected @endif>{{$i}} PM</option>
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
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[4]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[4]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[4]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_wednesday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[5]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[5]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[5]) selected @endif>{{$i}} PM</option>
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
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[6]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[6]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[6]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_thursday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[7]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[7]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[7]) selected @endif>{{$i}} PM</option>
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
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[8]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[8]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[8]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_friday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[9]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[9]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[9]) selected @endif>{{$i}} PM</option>
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
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[10]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[10]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[10]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_saturday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[11]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[11]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[11]) selected @endif>{{$i}} PM</option>
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
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[12]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[12]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[12]) selected @endif>{{$i}} PM</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="chosen-select" data-placeholder="Closing Time" name="c_sunday">
                                    <!-- Hours added via JS (this is only for demo purpose) -->
                                    <option label="Opening Time"></option>
                                    <option @if(isset($b_res)&&count($hours)==14&&$hours[13]=='') selected @endif>Closed</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' AM' == $hours[13]) selected @endif>{{$i}} AM</option>
                                    @endfor
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option @if(isset($b_res)&&count($hours)==14&&$i.' PM' == $hours[13]) selected @endif>{{$i}} PM</option>
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
                        <button type="submit" class="button preview" onclick="submit_business">Save Changes</button>
                @else
                    <button type="submit" class="button preview" onclick="submit_business">Save</button>
                @endif
            </form>
            </div>
        </div>
        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>

    <!-- Reply to review popup -->
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
        <div class="small-dialog-header">
            <h3>Professional Header Image</h3>
        </div>
        <div class="message-reply margin-top-0">
            <h4>Get a professional banner design for only $99.<br/><br/>Simply send us 3 images and a brief description of what you’d like and we’ll get it sorted for you</h4>
            <br/>
            <button class="button" onclick="$('#package-pay-btn').click()">Pay Now</button>
            <br/>
        </div>
    </div>


    <div class="product">
        <div class="btn">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1">
                <input type="hidden" name="business" value="info@georgestechnology.com.au">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="Edenlinx Payment">
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="notify_url" value="">
                <input type="hidden" name="credits" value="510">
                <input type="hidden" name="userid" value="1">
                <input type="hidden" name="amount" id="package-amount" placeholder="amount" value="99">
                <input type="hidden" name="cpp_header_image" value="">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="currency_code" value="AUD">
                <input type="hidden" name="handling" value="0">
                <input type="hidden" name="cancel_return" id="package-cancel" value="{{url('business/business')}}">
                <input type="hidden" name="return" id="package-success" value="{{url('business/professionalheader')}}">
                <input type="submit" name="submit" id="package-pay-btn" style="display: none">
            </form>
        </div>
    </div>


<script>
    $(function(){
        @if($b_check == 'true')
            $('#alertDlg').show();
        @endif
    });

    function title_focus()
    {
        if ($("#business_title").val() == "Default Business")
            $("#business_title").val("");
    }

    function title_focusout()
    {
        if ($("#business_title").val() == "")
            $("#business_title").val("Default Business");
    }

    function keywords_focus()
    {
        if ($("#business_keywords").val() == "Default")
            $("#business_keywords").val("");
    }

    function keywords_focusout()
    {
        if ($("#business_keywords").val() == "")
            $("#business_keywords").val("Default");
    }
</script>
@endsection
