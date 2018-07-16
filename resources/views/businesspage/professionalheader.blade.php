@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Professional Header Image</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('business/saveprofessionalheader')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <span><b style="color: #D33"><i>Must be high resolution images larger than 1920 pixels wide.</i></b></span>
                        <!-- Avatar -->
                        <div class="my-profile">
                            <div class="edit-profile-photo">
                                <img src="{{url('/images/business_header.jpg')}}" alt="" id="homepage_img" style="width:auto; height:auto; max-width:100%;">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Image</span>
                                        <input accept="image/*" type="file" class="upload" name="professional_image1" onchange="load_homeimage(event)" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="edit-profile-photo">
                                <img src="{{url('/images/business_header.jpg')}}" alt="" id="contactpage_img" style="width:auto; height:auto; max-width:100%;">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Image</span>
                                        <input accept="image/*" type="file" class="upload" name="professional_image2" onchange="load_contactimage(event)" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="edit-profile-photo">
                                <img src="{{url('/images/business_header.jpg')}}" alt="" id="profile_img" style="width:auto; height:auto; max-width:100%;">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Image</span>
                                        <input accept="image/*" type="file" class="upload" name="professional_image3" onchange="load_profile(event)" required/>
                                    </div>
                                </div>
                            </div>
                            <label>Brief Description</label>
                            <input value="" type="text" id="description" name="description" required>
                            <button class="button margin-top-15" type="submit">Save</button>
                            <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/business/business')}}'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    
    <div class="row">
            <!-- Copyrights -->
            <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>
    </div>

@endsection
