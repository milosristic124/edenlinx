@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Home Page</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('admin/setting/save_homepageimage')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <!-- Avatar -->
                        <div class="my-profile">
                            <label>Home Page Image</label>
                            <div class="edit-profile-photo">
                                <img src="{{asset($setting->homepageimage)}}" alt="" id="homepage_img" style="width:auto; height:auto; max-width:100%;">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Image</span>
                                        <input accept="image/*" type="file" class="upload" name="profile_image" onchange="load_homeimage(event)"/>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <label>About Us</label>
                            <textarea name="aboutus" id="aboutus" cols="30" rows="5">{{$setting->aboutus}}</textarea>
                        </div>
                        <button class="button margin-top-15" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row margin-top-50">

        <!-- Profile -->
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Contact Us Page</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('admin/setting/save_contactpageimage')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <!-- Avatar -->
                        <div class="my-profile">
                            <label>Contact Page Image</label>
                            <div class="edit-profile-photo">
                                <img src="{{asset($setting->contactpageimage)}}" alt="" id="contactpage_img" style="width:auto; height:auto; max-width:100%;">
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Image</span>
                                        <input accept="image/*" type="file" class="upload" name="profile_image" onchange="load_contactimage(event)"/>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <label>Contact Us</label>
                            <textarea name="contactus" id="contactus" cols="30" rows="5">{{$setting->contactus}}</textarea>
                        </div>
                        <button class="button margin-top-15" type="submit">Save Changes</button>
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
