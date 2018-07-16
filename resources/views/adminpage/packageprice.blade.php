@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-6 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Package Price</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('admin/packageprice/save')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="my-profile">
                            <label>Free</label>
                            <input value="{{$packageprice->free}}" type="text" id="free" name="free" required>

                            <label>Basic</label>
                            <input value="{{$packageprice->basic}}" type="text" id="basic" name="basic" required>

                            <label>Regular</label>
                            <input value="{{$packageprice->regular}}" type="text" id="regular" name="regular" required>

                            <label>Premium</label>
                            <input value="{{$packageprice->premium}}" type="text" id="premium" name="premium" required>
                        </div>

                        <button class="button margin-top-15" type="submit">Save</button>
                        <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/admin/packageprice')}}'">Cancel</button>
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
