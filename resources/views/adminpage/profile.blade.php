@extends('layouts.mastera')
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
                    <form action="{{url('admin/saveprofile')}}" method="post" enctype="multipart/form-data">
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

                    <!-- Details -->
                        <div class="my-profile">
                            <label>Email</label>
                            <input value="{{$email}}" type="email" id="email" name="email" required>
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
                    <form action="{{url('admin/resetprofile')}}" method="post" enctype="multipart/form-data">
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
