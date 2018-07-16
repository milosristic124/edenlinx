@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-8 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Profile Details</h4>
                <div class="dashboard-list-box-static">
                    <p class="">Image Size : 240 x 240</p>
                    <form action="{{url('admin/customers/saveprofile')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <!-- Avatar -->
                        <div class="edit-profile-photo">
                            @if(isset($profileImage))
                                <img src="{{asset($profileImage)}}" alt="" id="profile_img">
                            @else
                                <img src="{{asset('images/boy-256.png')}}" alt="" id="profile_img">
                            @endif
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Photo</span>
                                        <input accept="image/*" type="file" class="upload" name="profile_image" onchange="load_profile(event)"/>
                                    </div>
                                </div>
                        </div>

                        <div class="my-profile">
                            <input value="{{$edit_id}}" type="hidden" id="edit_id" name="edit_id">

                            <label>Your Name</label>
                            <input value="{{$name}}" type="text" id="name" name="name" required>

                            <label>Phone</label>
                            <input value="{{$phone}}" type="text" id="phone" name="phone" required>

                            <label>Email</label>
                            <input value="{{$email}}" type="text" id="email" name="email" required>

                            <label>Notes</label>
                            <textarea name="notes" id="notes" cols="30" rows="10">{{$notes}}</textarea>

                            <label><i class="fa fa-twitter"></i> Twitter</label>
                            <input placeholder="https://www.twitter.com/" type="text">

                            <label><i class="fa fa-facebook-square"></i> Facebook</label>
                            <input placeholder="https://www.facebook.com/" type="text">

                            <label><i class="fa fa-google-plus"></i> Google+</label>
                            <input placeholder="https://www.google.com/" type="text">
                        </div>

                        <button class="button margin-top-15" type="submit">Save Changes</button>
                        <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/admin/customers')}}'">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>

@endsection
