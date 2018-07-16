@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-8 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Review Details</h4>
                <div class="dashboard-list-box-static">
                    
                    <form action="{{url('admin/review/savereview')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="my-profile">
                            <input value="{{$edit_id}}" type="hidden" id="edit_id" name="edit_id">

                            <label>Review</label>
                            <textarea type="text" id="review" name="review" required>{{$review}}</textarea>
                        </div>
                        <button class="button margin-top-15" type="submit">Save Changes</button>
                        <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/admin/review')}}'">Cancel</button>
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
