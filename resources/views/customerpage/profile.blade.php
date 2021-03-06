@extends('layouts.master2')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-6 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Profile Details</h4>
                <div class="dashboard-list-box-static">
                    <p class="">Image Size : 240 x 240</p>
                    <form action="{{url('customer/saveprofile')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <!-- Avatar -->
                        <div class="edit-profile-photo">
                            {{--<img src="images/back1.png" alt="" id="profile_img">--}}
                            @if(isset($profileImage))
                                <img src="{{asset($profileImage)}}" alt="" id="profile_img">
                            @else
                                <img src="{{asset('images/boy-256.png')}}" alt="" id="profile_img">
                            @endif
                            {{--<form action="{{url('profile/uploadfile')}}" method="post" enctype="multipart/form-data">--}}
                                {{--{{csrf_field()}}--}}
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Photo</span>
                                        <input accept="image/*" type="file" class="upload" name="profile_image" onchange="load_profile(event)"/>
                                        {{--<input id="file-upload" type="file" class="upload" name="image"/>--}}
                                        {{--<input id="file-upload-submit" type="submit" style="display: none">--}}
                                    </div>
                                </div>
                            {{--</form>--}}
                        </div>

                    <!-- Details -->
                    {{--<form action="{{url('profile/saveprofile')}}" method="post" enctype="multipart/form-data">--}}
                        {{--{{csrf_field()}}--}}
                        <div class="my-profile">

                            <label>Your Name</label>
                            <input value="{{$name}}" type="text" id="name" name="name" required>

                            <label>Phone</label>
                            <input value="{{$phone}}" type="text" id="phone" name="phone" required>

                            <label>Email</label>
                            <input value="{{$email}}" type="text" id="email" name="email" required>

                            <label>Notes</label>
                            <textarea name="notes" id="notes" cols="30" rows="10">{{$notes}}</textarea>
                            <!--
                            <label><i class="fa fa-twitter"></i> Twitter</label>
                            <input placeholder="https://www.twitter.com/" type="text">

                            <label><i class="fa fa-facebook-square"></i> Facebook</label>
                            <input placeholder="https://www.facebook.com/" type="text">

                            <label><i class="fa fa-google-plus"></i> Google+</label>
                            <input placeholder="https://www.google.com/" type="text">
                            -->
                        </div>

                        <button class="button margin-top-15" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Change Password</h4>
                <div class="dashboard-list-box-static">

                    <!-- Change Password -->
                    <form action="{{url('customer/resetprofile')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="my-profile">
                            <label class="margin-top-0">Current Password</label>
                            <input type="password" id="oldpwd" name="oldpwd" value="{{old('oldpwd')}}" required />
                            <label>New Password</label>
                            <input type="password" id="newpwd" name="newpwd" value="{{old('newpwd')}}" required />
                            @if ($errors->has('newpwd'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('newpwd') }}</strong>
                                    </span>
                            @endif
                            <label>Confirm New Password</label>
                            <input type="password" id="confirmpwd" name="newpwd_confirmation" required />

                            <button class="button margin-top-15" type="submit">Change Password</button>
                        </div>
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
